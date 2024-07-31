<?php

namespace App\Http\Controllers;

use UnitEnum;
use Carbon\Carbon;
use App\Models\User;

use App\Models\Status;
use App\Models\MainJob;
use App\Models\Application;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\RdvAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\InjoignableAttribute;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use App\Http\Requests\ApplicationRequest;
use App\Models\EnattenteAttribute;
use App\Models\NegatifAttribute;
use App\Models\NonInteresseAttribute;
use App\Traits\ApiResponseWithHttpSTatus;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ApplicationController extends Controller
{
    use ApiResponseWithHttpSTatus;
    
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register','accountVerify','forgotPassword','updatePassword']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'success';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApplicationRequest $request)
    {
        if($request->hasFile('cv')){
            $file = $request->file('cv');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('files/applications'), $fileName);
        }else{
            $fileName = null;
        }
        $data['apply'] = Application::create([
            'email' => $request->email,
            'cv' => $fileName,
            'job_id' => $request->job_id,
           
        ]);

        if($data){
            $job = MainJob::find($request->job_id);
            $job->update([
                'count' => $job->count + 1,
            ]);
            return $this->apiResponse('success',$data,Response::HTTP_OK,true);
        }else{
            return $this->apiResponse('error',null,Response::HTTP_BAD_REQUEST,false);
        }
    }

    public function application(Request $request)
    {
        echo($request->token);
        // Get the token from the Authorization header
        $token = $request->header('Authorization');
    
        // Remove the 'Bearer ' part from the token
        $token = str_replace('Bearer ', '', $token);
    
        // Retrieve the user using the token
       
        // Check if the user is authenticated
      
        // Calculate total applications for the authenticated user's jobs
        $totalApplications = Application::where('user_id', auth()->user()->id)->count();
    
        // Return the total applications and user information as JSON response
        return response()->json([
            'totalApplications' => $totalApplications,
            
        ], Response::HTTP_OK);
    }
    //applicationDaily
    public function     applicationDaily(Request $request){
        // Retrieve token from Authorization header
            $token = $request->header('Authorization');
            
            // Check if the token is provided
      

            // Remove the 'Bearer ' part from the token 
            $token = str_replace('Bearer ', '', $token);
            
            // Retrieve the user using the token
            $user = DB::table('users')->where('token', $token)->value('id');
    
        // Check if the user is found
       
    
        // Count the total applications created today by the user
        $totalApplicationsDaily = Application::where('user_id', auth()->user()->id)
            ->whereDate('created_at', Carbon::today())
            ->count();
    
        // Return the total applications as a JSON response
        return response()->json([
            'totalApplicationsDaily' => $totalApplicationsDaily,
        ], Response::HTTP_OK);
    }

    //unreachable
    public function applicationUnreachable(Request $request)
    {
        // Retrieve the token from the Authorization header
        $token = $request->header('Authorization');
      
        // Remove the 'Bearer ' part from the token
        $token = str_replace('Bearer ', '', $token);
    
        // Retrieve the user using the token
             $user = DB::table('users')->where('token', $token)->value('id');
    
       
    
        // Use Eloquent relationships to count the applications with the specifie
        $countUnreachable = Application::where('user_id', auth()->user()->id)
        ->where('status_id', 2)
        ->count();
    
        $countRdv = Application::where('user_id', auth()->user()->id)
        ->where('status_id', 1)
        ->whereDate('created_at', Carbon::today())
        ->count();
    
        // Return the total applications and user information as JSON response
        return response()->json([
            'applicationUnreachable' => $countUnreachable,
            'applicationRdv'=>$countRdv,
        ], Response::HTTP_OK);
    }
    //appdetail
    public function appdetail(Request $request){
        $token = $request->header('Authorization');
        // if (!$token) {
        //     return $this->apiResponse('Token not provided', null, Response::HTTP_UNAUTHORIZED, false);
        // }
    
        // Remove the 'Bearer ' part from the token
        $token = str_replace('Bearer ', '', $token);
    
        // Retrieve the user using the token
             $user = DB::table('users')->where('token', $token)->value('id');
    
        // if (!$user) {
        //     return $this->apiResponse('User not authenticated', null, Response::HTTP_UNAUTHORIZED, false);
        // }
       // Fetch application details along with the related job
       $jobs = MainJob::leftJoin('applications', 'main_jobs.id', '=', 'applications.job_id')
       ->select(
           'main_jobs.id',
           'main_jobs.title',
           'main_jobs.created_at',
        //    'main_jobs.id',
           DB::raw('COUNT(CASE WHEN applications.status_id = 6 THEN applications.id END) AS Nbr_candidatures_non_traitees'),
           DB::raw('COUNT(CASE WHEN applications.status_id > 0 THEN applications.id END) AS recu')
       )->groupBy('main_jobs.id','main_jobs.title', 'main_jobs.created_at')->get();

   return response()->json($jobs, 200);

 }




public function offDetail(Request $request, $id)
{
    // Retrieve the token from the Authorization header
    $token = $request->header('Authorization');


    // Remove the 'Bearer ' part from the token
    $token = str_replace('Bearer ', '', $token);
    
    // Retrieve the user using the token
         $user = DB::table('users')->where('token', $token)->value('id');

if($id==0){
    $applications = Application::with('job', 'status')
    ->where('job_id','>',$id)
    ->whereHas('status', function ($query) {
        $query->whereColumn('id', 'applications.status_id');
    })
    ->get(['id','updated_at','created_at', 'cv', 'nom', 'prenom', 'job_id', 'email', 'status_id']);
}
else{
    $applications = Application::with('job', 'status')
    ->where('job_id', $id)
    ->whereHas('status', function ($query) {
        $query->whereColumn('id', 'applications.status_id');
    })
    ->get(['id','updated_at','created_at', 'cv', 'nom', 'prenom', 'job_id', 'email', 'status_id']);

}

$applicationsData = $applications->map(function ($application) {
    return [
        'id'=>$application->id,
        'updated_at' => $application->updated_at,
        'cv' => $application->cv,
        'nom' => $application->nom,
        'prenom' => $application->prenom,
        'title' => $application->job->title,
        'email' => $application->email,
        'status_name' => $application->status->status_name
    ];
});

return response()->json([
    'applications' => $applicationsData
], 200);

}

public function decisionDetail(Request $request, $id){
    // Retrieve the token from the Authorization header
    $token = $request->header('Authorization');
   


    // Remove the 'Bearer ' part from the token
    $token = str_replace('Bearer ', '', $token);
    
    // Retrieve the user using the token
         $user = DB::table('users')->where('token', $token)->value('id');



    // Fetch the application with its related status


    $decisionDetail = Application::with('job')
    ->where('id', $id)
    ->whereHas('job', function ($query) {
        $query->whereColumn('job_id', 'main_jobs.id');
    })


    ->first([
        'id',
        'prenom',
        'nom',
        'sexe',
        'telephone',
        'ville',
        'experience',
        'status_id',
        'slug',
        'email',
        'cv',
        'job_id',
        'user_id',
        'created_at',
        'updated_at'
    ]);

if (!$decisionDetail) {
    return response()->json([
        'message' => 'Application not found',
    ], Response::HTTP_NOT_FOUND);
}

$applications = [
    'id'=>$decisionDetail->id,
    'updated_at' => $decisionDetail->updated_at,
    'cv' => $decisionDetail->cv,
    'nom' => $decisionDetail->nom,
    'prenom' => $decisionDetail->prenom,
    'title' => $decisionDetail->job->title,
    'email' => $decisionDetail->email,
    'ville'=>$decisionDetail->ville,
    'sexe'=>$decisionDetail->sexe,
    'telephone'=> $decisionDetail->telephone
    
];
$application = Application::with('status')->find($id);
    
// Check if the application and status exist before accessing status_name
if ($application && $application->status) {
    $statusName = $application->status->status_name;
   
}

return response()->json([
    'decisionDetail' => $applications,
    'statusName'=>$statusName,
]);
        
    

}


    public function setStatus(Request $request, $id)
    
   
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Retrieve the application
        $application = Application::findOrFail($id);
        $currentStatus = $application->status_id;
        $newStatus = $request->input('status_id');

        // If status has changed, handle the attributes accordingly
        if ($currentStatus != $newStatus) {
            $this->handleStatusChange($application, $currentStatus);
        }

        // Update the application's status
        $application->update([
            'status_id' => $newStatus,
            'updated_at' => now()
        ]);

        // Handle the new status attributes
        $this->createStatusAttributes($application, $request);

        return response()->json(['message' => 'Status updated successfully.']);
    }

    protected function handleStatusChange($application, $currentStatus)
    {
        // Delete existing attributes based on the old status
        if ($currentStatus == 1 || $currentStatus == 4) {
            RdvAttribute::where('app_id', $application->id)->delete();
        } else {
            InjoignableAttribute::where('app_id', $application->id)->delete();
        }
    }

    protected function createStatusAttributes($application, $request)
    {
        $statusId = $request->input('status_id');

        switch ($statusId) {
            case 1:
                RdvAttribute::updateOrCreate(
                    ['app_id' => $application->id],
                    [
                        'appointment_date' => $request->input('appointment_date'),
                        'appointment_time' => $request->input('appointment_time'),
                        'motif'=> $request->input('motif'),
                    ]
                );
                break;

            case 4:
                EnattenteAttribute::updateOrCreate(
                    ['app_id' => $application->id],
                    [
                        'follow_up_date' => $request->input('follow_up_date'),
                        'appointment_time' => $request->input('appointment_time'),
                        'motif'=>$request->input('motif')
                    
                    ]
                );
                break;

            case 5:
                NegatifAttribute::updateOrCreate(
                    ['app_id' => $application->id],
                    ['reason' => $request->input('reason')]
                );
                break;

            case 3:
                NonInteresseAttribute::updateOrCreate(
                    ['app_id' => $application->id],
                    ['feedback' => $request->input('reason')]
                );
                break;

            default:
                InjoignableAttribute::updateOrCreate(
                    ['app_id' => $application->id],
                    ['reason' => $request->input('reason')]
                );
                break;
        }
    
    }



public function calRdv(){
    $calRdv = RdvAttribute::all();

    $listRdv = [];
    
    foreach ($calRdv as $rdv) {
        $id = $rdv['app_id'];
        $dat = $rdv['appointment_date'];
        $time=$rdv['appointment_time'];
    
        $nomRdv = Application::find($id);
    
        if ($nomRdv) {
            $listRdv[] = [
                'id' => $nomRdv->id,
                'title' => $nomRdv->nom,
                'date' => $dat,
                'time'=>$time
            ];
        }
    }
    
    return response()->json($listRdv);
    
    
   
    
}

public function dailyApplications(){
    

    $user_id = Auth::user()->id;

    $applications = Application::selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->where('user_id', $user_id)
        ->groupBy(DB::raw('DATE(created_at)'))
        ->selectRaw('"application" as type');
    
    $main_jobs = MainJob::selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->where('user_id', $user_id)
        ->groupBy(DB::raw('DATE(created_at)'))
        ->selectRaw('"main_job" as type');
    
    $results = $applications->unionAll($main_jobs)
        ->orderBy('date')
        ->get();

    
        $resultsRdv = DB::table('applications')
        ->select(DB::raw('DATE(created_at) AS date'), DB::raw('COUNT(*) AS application_status'))
        ->where('user_id', $user_id)
        ->where('status_id', 1)
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy('date')
        ->get();

        $resultsRdvMonthly = DB::table('applications')
    ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') AS month"), DB::raw('COUNT(*) AS application_count'), DB::raw("'application' AS type"))
    ->where('user_id',$user_id )
    ->where('status_id', 1)
    ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
    ->get();

    $statusCounts = Status::withCount(['application' => function ($query) use ($user_id) {
        $query->where('user_id', $user_id);
    }])
    ->get();
    return response()->json(
        [
            "result"=>$results,
            "resultRdv"=>$resultsRdv,
            "resultsRdvMonthly"=>$resultsRdvMonthly,
            "statusCounts"=>$statusCounts,


        ]


    );
}

public function history($id)
{
    // Fetch application with relationships
    $application = Application::with([
        'status',
        'job',
        'rdvAttributes',
        'injoignableAttributes',
        'nonInteresseAttributes',
        'enattenteAttributes',
        'negatifAttributes'
    ])->find($id);

    // Prepare the result array
    $result = [];

    if ($application) {
        $result['nom'] = $application->nom;
        $result['prenom'] = $application->prenom;
        $result['created_at'] = $application->created_at;
        $result['last_status'] = $application->status ? $application->status->status_name : 'No Status Found';
        $result['job_title'] = $application->job ? $application->job->title : 'No Job Found';
        $result['motif'] = $application->motif; // Access the custom attribute
    }

    // Return the result
    return response()->json($result);
}
}