<?php

namespace App\Http\Controllers;

use App\Events\NewHelpMeResponse;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class WebController extends Controller
{

    protected $firebaseUrl = "https://fcm.googleapis.com/fcm/send";
    protected $serverApiKey = 'AAAAOag5k6Q:APA91bGWiOFxRiKvtRJXrVUdX0pMKqPygeFQD3uJaQykRq7Si_IFbzksVHTbtJZEBt3ZpozNb6NfA_4TK8TA3p0o3UFg5PVpEKj4G3iMbSw98zFbkralNOXJ4F_W_3OmabB2qWqxmfr3';


    public function sendDataNotificationToWearer($serviceId, $title, $message)
    {

        $service = DB::table('services')
            ->where('service_id', '=', $serviceId)
            ->get()->first();



        $data = [
            "to" => $service->wearer_device_token,
            "data" =>
                [
                    "title" => $title,
                    "body" => $message
                ],
        ];

        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $this->serverApiKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->firebaseUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_exec($ch);
    }


    public function sendNotificationToWearer($serviceId, $title, $message)
    {

        $service = DB::table('services')
            ->where('service_id', '=', $serviceId)
            ->get()->first();



        $data = [
            "to" => $service->wearer_device_token,
            "notification" =>
                [
                    "title" => $title,
                    "body" => $message
                ],
        ];

        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $this->serverApiKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->firebaseUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_exec($ch);
    }

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

                $this->sendNotificationToWearer($serviceId,$responderName, $responderName." is coming to help you");

                $this->sendDataNotificationToWearer($serviceId,$responderName, $responderName." is coming to help you");

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

                $this->sendNotificationToWearer($serviceId,$responderName, $responderName." cannot come to help you");

                $this->sendDataNotificationToWearer($serviceId,$responderName, $responderName." cannot come to help you");

            }

        }

        event(new NewHelpMeResponse($serviceId,$logId,$userId,$responderName,$response));

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


            $wearerServiceID = DB::table('services')
                ->where('service_status', '=', 'User Verification Required')
                ->where('wearer_id', '=', $userId)
                ->select('services.service_id')
                ->get()->first();

            $customerServices = DB::table('services')
                ->where('service_status', '=', 'User Verification Required')
                ->where('customer_id', '=', $userId)
                ->select('service_id')
                ->get();

            $watcherServices = DB::table('watcher_relations')
                ->join('services', 'services.service_id', '=', 'watcher_relations.svc_id')
                ->where('watcher_relations.watcher_id', '=', $userId)
                ->where('services.service_status', '=', 'User Verification Required')
                ->select('watcher_relations.svc_id')
                ->get();



//            dd($wearerServiceID);

            if ($wearerServiceID){

            $wRServiceId = $wearerServiceID->service_id;

                if(DB::table('services')
                    ->join('users as wearer', 'wearer.person_id', '=', 'services.wearer_id')
                    ->join('users as customer', 'customer.person_id', '=', 'services.customer_id')
                    ->where('services.service_id', '=', $wRServiceId)
                    ->where('services.service_status', '=', 'User Verification Required')
                    ->where('wearer.verification_status', '=', 'true')
                    ->where('customer.verification_status', '=', 'true')
                    ->exists()) {

                    if(DB::table('watcher_relations')
                            ->join('users as watchers', 'watchers.person_id', '=', 'watcher_relations.watcher_id')
                            ->where('watcher_relations.svc_id', '=', $wRServiceId)
                            ->where('watchers.verification_status', '=', 'true')
                            ->count() > 0) {


                        $changeServiceStatus = DB::table('services')
                            ->where('service_id', '=', $wRServiceId)
                            ->where('service_status', '=', 'User Verification Required')
                            ->update([
                                'service_status' => 'Pending'
                            ]);

                    }

                }
            }


            if ($customerServices){

                foreach ($customerServices as $cS) {
                    $cServiceId = $cS->service_id;

                    if(DB::table('services')
                        ->join('users as wearer', 'wearer.person_id', '=', 'services.wearer_id')
                        ->join('users as customer', 'customer.person_id', '=', 'services.customer_id')
                        ->where('services.service_id', '=', $cServiceId)
                        ->where('services.service_status', '=', 'User Verification Required')
                        ->where('wearer.verification_status', '=', 'true')
                        ->where('customer.verification_status', '=', 'true')
                        ->exists()) {

                        if(DB::table('watcher_relations')
                                ->join('users as watchers', 'watchers.person_id', '=', 'watcher_relations.watcher_id')
                                ->where('watcher_relations.svc_id', '=', $cServiceId)
                                ->where('watchers.verification_status', '=', 'true')
                                ->count() > 0) {


                            $changeServiceStatus = DB::table('services')
                                ->where('service_id', '=', $cServiceId)
                                ->where('service_status', '=', 'User Verification Required')
                                ->update([
                                    'service_status' => 'Pending'
                                ]);

                        }

                    }

                }
            }

            if ($watcherServices){

                foreach ($watcherServices as $wTS) {
                    $wTServiceId = $wTS->svc_id;

                    if(DB::table('services')
                        ->join('users as wearer', 'wearer.person_id', '=', 'services.wearer_id')
                        ->join('users as customer', 'customer.person_id', '=', 'services.customer_id')
                        ->where('services.service_id', '=', $wTServiceId)
                        ->where('services.service_status', '=', 'User Verification Required')
                        ->where('wearer.verification_status', '=', 'true')
                        ->where('customer.verification_status', '=', 'true')
                        ->exists()) {

                        if(DB::table('watcher_relations')
                                ->join('users as watchers', 'watchers.person_id', '=', 'watcher_relations.watcher_id')
                                ->where('watcher_relations.svc_id', '=', $wTServiceId)
                                ->where('watchers.verification_status', '=', 'true')
                                ->count() > 0) {


                            $changeServiceStatus = DB::table('services')
                                ->where('service_id', '=', $wTServiceId)
                                ->where('service_status', '=', 'User Verification Required')
                                ->update([
                                    'service_status' => 'Pending'
                                ]);

                        }

                    }

                }

            }

            dd("User Verified");

        } else {

            dd("Invalid link");

        }




    }

}
