<?php

namespace App\Http\Controllers;

use App\Models\MainJob;
use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseWithHttpSTatus;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    use ApiResponseWithHttpSTatus;
    public function index()
    {
        $data['categories'] = Category::where([['status','active']])->take(8)->get();
        $data['featured_job'] = MainJob::where([['status','active'],['is_featured',true]])->get();
        $data['latest'] = MainJob::where('status','active')->latest('created_at')->get();
        return $this->apiResponse('success',$data,Response::HTTP_OK,true);
    }
    public function getALlJobs()
    {
        $data['job'] = MainJob::where([['status','active']])->get();
        return $this->apiResponse('success',$data,Response::HTTP_OK,true);
    }

    public function getSingleJobDetails($slug)
    {
        $data['job'] = MainJob::where([['slug',$slug]])->with('category')->first();
        $data['similar'] = MainJob::where([['status','active'],['cat_id',$data['job']->cat_id]])->get()->random(3);
        return $this->apiResponse('success',$data,Response::HTTP_OK,true);
    }
   
    
    public function create(Request $request)
    {
        
        // $request->validate([
        //     'title' => 'required',
        //     'slug' => 'required',
        //     'count' => 'required',
        //     'company' => 'required',
        //     'location' => 'required',
        //     'email' => 'required|email',
        //     'tag' => 'required',
        //     'salary' => 'required',
        //     'close_date' => 'required|date',
        //     'cat_id' => 'required|integer',
        //     'icon' => 'required',
        //     'description' => 'required',
        // ]);

        // Ensure user is authenticated
            $user = Auth::user();
           $token = $request->header('Authorization');
         $token = str_replace('Bearer ', '', $token); 
            // Retrieve the user ID using the token
         $user = DB::table('users')->where('token', $token)->first();
        if (!$user) {
            return $this->apiResponse('User not authenticated', null, Response::HTTP_UNAUTHORIZED, false);
        }

        // Create the job
        $job = MainJob::create([
            'title' => $request->title, 
            'company' => $request->company,
            'salary' => $request->salary,
            'description' => $request->description,
            'status' => 'active', // Assuming the status is always 'actif' for new jobs
            'profil' => json_encode($request->profil ?? []), // Assuming this is an array
            'job_description' => 'not now 
            ',
            'profile_description' => $request->profile_description ?? '', // Providing a default value
            'experience' => $request->experience ?? false, // Providing a default value
            'other_information' => $request->other_information ?? '', // Providing a default value
            'languages' => json_encode($request->languages ?? []), // Assuming this is an array
            'working_hours' => $request->working_hours ?? '', // Providing a default value
            'email' => $request->email,
            'site' => $request->site ?? '', // Providing a default value
            'user_id' => $user->id,
        
        ]);
        
        

        return $this->apiResponse('Job created successfully', $job, Response::HTTP_CREATED, true);
        }
        public function logout(Request $request)
{
    try {
        // Revoke the current user's token
        auth()->logout();

        // Return a JSON response indicating success
        return response()->json([
            'status' => true,
            'message' => 'Logout successful',
        ], Response::HTTP_OK);
    } catch (\Exception $e) {
        // Return a JSON response indicating error
        return response()->json([
            'status' => false,
            'message' => 'Failed to logout',
            'error' => $e->getMessage(),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

}
