<?php

namespace App\Http\Controllers;

use App\Models\Text;
use App\Models\MailParam;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RdvAttribute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TextController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register','accountVerify','forgotPassword','updatePassword']]);
    }
    public function mailing(){

        $mails=Text::all()->where('user_id',1);
        if ($mails->isNotEmpty()) {
            return response()->json([
                'Email_Convocation' => $mails->first()->Email_Convocation,
                'Email_Injoinable'=>$mails->first()->Email_Injoinable,
                'Email_Proposition'=>$mails->first()->Email_Proposition,
            ]);
        } else {
            return response()->json([
                'Email_Convocation' => null,
            ]);
        }

    }
    public function upMailing(Request $request)
    {
        {
            
            $text = Text::firstOrNew(['user_id' => Auth::id()]);
        
            if ($request->has('Email_Injoinable')) {
                $text->Email_Injoinable = $request->input('Email_Injoinable');
            }
            if ($request->has('Email_Convocation')) {
                $text->Email_Convocation = $request->input('Email_Convocation');
            }
            if ($request->has('Email_Proposition')) {
                $text->Email_Proposition = $request->input('Email_Proposition');
            }
        
            // Save the Text record
            $text->save();
        
            return response()->json(['message' => 'Email parameters updated successfully']);
        }
        }

        public function mailIngoin( $id)
        {
            $candid = Application::find($id);
            
            // Fetch the template content
            $template = MailParam::
                                 where('user_id', Auth()->user()->id)
                                 ->value('Email_Injoinable'); // Assuming 'template' is the column where the email template is stored
        
            if (!$template) {
                return response()->json(['error' => 'Email template not found'], 404);
            }
        
            // Data to replace in the template
            $data = [
                '__PRENOM__' => $candid->nom,

                
            ];
        
            // Replace placeholders in the template
            foreach ($data as $key => $value) {
                $template = str_replace($key, $value, $template);
            }
        
            // Send the email
            Mail::send([], [], function ($message) use ($template, $candid) {
                $message->to($candid->email)
                        ->subject('Votre Candidature')
                        ->setBody($template, 'text/html'); 
            });
        
        
            return$candid->email;
        }
        

        public function mailConvo($id){
            $candid = Application::find($id);
            
            // Fetch the template content
            $template = MailParam::
                                 where('user_id', Auth()->user()->id)
                                 ->value('Email_Convocation'); 
        
            if (!$template) {
                return response()->json(['error' => 'Email template not found'], 404);
            }
            $rdvDT = RdvAttribute::where('app_id', $id)->first(); // Assuming you want to fetch the first result

            $data = [
                '__PRENOM__' => $candid->nom,
                '__ADRESSE__' => 'casa',
                '__GOOGLEMAPS__' => 'mahitel',
                '__DATE_RDV__' => $rdvDT->appointment_date, // Assuming 'appointment_date' is the field name
                '__HEURE_RDV__' => $rdvDT->appointment_time, // Assuming 'appointment_time' is the field name
                '__TEL_UTILISATEUR__' => '0898070' // Assuming this is a placeholder for user's telephone number
            ];
            
            foreach ($data as $key => $value) {
                $template = str_replace($key, $value, $template);
            }
        
            // Send the email
            Mail::send([], [], function ($message) use ($template, $candid) {
                $message->to($candid->email)
                        ->subject('Votre Candidature')
                        ->setBody($template, 'text/html'); 
            });
        
        
            return$candid->email;
        }
        
      
    
    
}
