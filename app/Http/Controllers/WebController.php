<?php

namespace App\Http\Controllers;

use App\Events\NewHelpMeResponse;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class WebController extends Controller
{

    public function helpMeRequest(Request $request){


        $logId =  substr($request->logId, 0, -8);

        $logId = "ALR".$logId;

        $date = substr ($request->logId, -8);

        $userId =  substr($request->userId, 0, -6);

        $userId = "WOMUSR".$userId;

        $time = substr ($request->userId, -6);

        $finalTime = \DateTime::createFromFormat('His', $time)->format('h:i:s a');

        $finalDate = \DateTime::createFromFormat('Ydm', $date)->format('d F Y');


        $helpMeResponse = DB::table('help_me_responses')
            ->join('users as watcher', 'watcher.person_id', '=', 'response_to')
            ->select('help_me_responses.id', 'help_me_responses.alert_log_id', 'help_me_responses.response_from', 'help_me_responses.response_to' ,'help_me_responses.send_text', 'help_me_responses.send_date', 'help_me_responses.send_time', 'help_me_responses.response_type',
                'help_me_responses.response_status', 'help_me_responses.reply_text', 'help_me_responses.reply_date', 'help_me_responses.reply_time',
                'watcher.person_id as watcherId', 'watcher.f_name as watcherFName', 'watcher.l_name as watcherLName', 'watcher.full_name as watcherFullName',
                'watcher.email as watcherEmail', 'watcher.phone as watcherPhone')
            ->where('alert_log_id', '=', $logId)
            ->where('response_to', '=', $userId)
            ->where('send_date', '=', $finalDate)
            ->where('send_time', '=', $finalTime)
            ->get()->first();

//        dd($helpMeResponse);

        if ($helpMeResponse){

            $helpMeResponseList = DB::table('help_me_responses')
                ->join('users as watcher', 'watcher.person_id', '=', 'response_to')
                ->select('help_me_responses.id', 'help_me_responses.alert_log_id', 'help_me_responses.response_from', 'help_me_responses.response_to' ,'help_me_responses.send_text', 'help_me_responses.send_date', 'help_me_responses.send_time', 'help_me_responses.response_type',
                    'help_me_responses.response_status', 'help_me_responses.reply_text', 'help_me_responses.reply_date', 'help_me_responses.reply_time',
                    'watcher.person_id as watcherId', 'watcher.f_name as watcherFName', 'watcher.l_name as watcherLName', 'watcher.full_name as watcherFullName',
                    'watcher.email as watcherEmail', 'watcher.phone as watcherPhone')
                ->where('alert_log_id', '=', $logId)
                ->get();

            $logDetails = DB::table('logs')
                ->where('log_id', '=', $logId)
                ->get()->first();


            $serviceId = $logDetails->service_id;

            $serviceDetails = DB::table('services')
                ->join('users as wearer', 'wearer.person_id', '=', 'services.wearer_id')
                ->select('services.service_id', 'services.wearer_id', 'services.wom_num', 'services.no_of_watchers',
                    'wearer.person_id as wearerId', 'wearer.f_name as wearerFName', 'wearer.l_name as wearerLName', 'wearer.full_name as wearerFullName',
                    'wearer.email as wearerEmail', 'wearer.phone as wearerPhone')
                ->where('services.service_id', '=', $serviceId)
                ->get()->first();



            $data = array(
                'helpMeResponse' => $helpMeResponse,
                'helpMeResponseList' => $helpMeResponseList,
                'serviceDetails' => $serviceDetails,
                'logDetails' => $logDetails
            );

            return view('helpMeRequest')->with($data);

        } else {

            dd("Page not found");

        }

    }

    public function helpMeRespond(Request $request){

        $userId = $request->userId;
        $serviceId = $request->serviceId;
        $logId = $request->logId;
        $response = $request->response;
        $sentDate = $request->sentDate;
        $sentTime = $request->sentTime;
        $responderName = $request->responderName;

        $responseDate = date("d F Y");
        $responseTime = date("h:i:s a");


        $logDetails = DB::table('logs')
            ->where('log_id', '=', $logId)
            ->where('service_id', '=', $serviceId)
            ->get()->first();

        if($logDetails->response_status  == 'false') {

            if ($response == 'Yes') {

                $updateLog = DB::table('logs')
                    ->where('log_id', '=', $logId)
                    ->where('service_id', '=', $serviceId)
                    ->update([
                        'response_status' => 'true',
                        'responded_by_id' => $userId,
                        'responded_by_name' => $responderName,
                    ]);


                $updateResponse = DB::table('help_me_responses')
                    ->where('alert_log_id', '=', $logId)
                    ->where('response_to', '=', $userId)
                    ->where('send_date', '=', $sentDate)
                    ->where('send_time', '=', $sentTime)
                    ->update([
                        'response_type' => $response,
                        'response_status' => 'true',
                        'reply_text' => 'Help request accepted',
                        'reply_date' => $responseDate,
                        'reply_time' => $responseTime,
                    ]);

            } else {

                $updateResponse = DB::table('help_me_responses')
                    ->where('alert_log_id', '=', $logId)
                    ->where('response_to', '=', $userId)
                    ->where('send_date', '=', $sentDate)
                    ->where('send_time', '=', $sentTime)
                    ->update([
                        'response_type' => $response,
                        'response_status' => 'true',
                        'reply_text' => 'Refused to help',
                        'reply_date' => $responseDate,
                        'reply_time' => $responseTime,
                    ]);

            }

        }

        event(new NewHelpMeResponse($serviceId,$logId));

        return response()->json("done");


    }

    public function userVerification(Request $request){

        $userId =  substr($request->code, 0, -14);

        $userId = "WOMUSR00".$userId;

        $code = substr ($request->code, -14);

//        dd($code);

//        dd($userId);

        if (DB::table('users')
            ->where('person_id', '=', $userId)
            ->where('verification_code', '=', $code)
            ->exists()) {


            $verifyUser = DB::table('users')
                ->where('person_id', '=', $userId)
                ->where('verification_code', '=', $code)
                ->update([
                    'verification_status' => 'true'
                ]);


            DB::table('services')
                ->orWhere('wearer_id', '=', $userId)
                ->orWhere('customer_id', '=', $userId)
                ->select('service_id')
                ->get();

            DB::table('watcher_relations')
                ->where('watcher_id', '=', 'svc_id')
                ->select('svc_id')
                ->get();


            dd("User Verified");

        } else {
            dd("Invalid link");
        }




    }

}
