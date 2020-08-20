<?php

namespace App\Http\Controllers;

use App\Events\HourlyLogCreated;
use App\Events\NewLog;
use App\Service;
use App\User;
use App\WatcherRelation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Log;
use Dotenv\Result\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    protected $deviceToken = 'cEOmixJOTaO82NK5rzIACh:APA91bEFSBzw9Ei5uxwTnafvSeFl2zkovVsOAghrsQ3Tl-goZU5-i1GsieLmUAepiPSzPLO-lGEpCEVEL7H2tr9Ayd8O7x_0wHOTEHlDEwh69DOMSFslRw3ryVJwtdGzq1_xtEm1asn';

    protected $firebaseUrl = "https://fcm.googleapis.com/fcm/send";
    protected $serverApiKey = 'AAAAOag5k6Q:APA91bGWiOFxRiKvtRJXrVUdX0pMKqPygeFQD3uJaQykRq7Si_IFbzksVHTbtJZEBt3ZpozNb6NfA_4TK8TA3p0o3UFg5PVpEKj4G3iMbSw98zFbkralNOXJ4F_W_3OmabB2qWqxmfr3';

    public function testConnection()
    {
        return response()->json("Connection Okay", 200);
    }

    public function wearerLoginProcessing(Request $request)
    {
        $wearerPhone = $request->wearerPhone;
        $wearerPassword = $request->wearerPassword;


        if (DB::table('users')->where('phone', '=', $wearerPhone)->exists()) {

            $user = DB::table('users')->where('phone', '=', $wearerPhone)->first();

            if (Hash::check($wearerPassword, $user->password)) {

                //user name and password matched

                if (DB::table('services')->where('wearer_id', '=', $user->person_id)->where('wom_num', '=', $wearerPhone)->exists()) {

                    // service exists

                    if (DB::table('services')->where('wearer_id', '=', $user->person_id)->where('service_status', '=', 'Active')->exists()) {

                        $service = DB::table('services')->where('wearer_id', '=', $user->person_id)->where('service_status', '=', 'Active')->first();

                        // login sucessfull
                        $data = array(
                            'wearerId' => $user->person_id,
                            'serviceId' => $service->service_id,
                            'wearerFirstName' => $user->f_name,
                            'wearerLastName' => $user->l_name,
                            'wearerEmail' => $user->email,
                            'wearerPhone' => $user->phone
                        );

                        $res = array(
                            'connection' => true,
                            'queryStatus' => true,
                            'message' => "Login Successful",
                            'data' => $data
                        );

                        return response()->json($res, 200);
                    } else {
                        // service is not active

                        $data = array(
                            'wearerId' => "",
                            'serviceId' => "",
                            'wearerFirstName' => "",
                            'wearerLastName' => "",
                            'wearerEmail' => "",
                            'wearerPhone' => ""
                        );

                        $res = array(
                            'connection' => true,
                            'queryStatus' => false,
                            'message' => "Service is not yet active",
                            'data' => $data
                        );
                        return response()->json($res, 200);
                    }
                } else {

                    $data = "something";
                    // service does not exist
                    $data = array(
                        'wearerId' => "",
                        'serviceId' => "",
                        'wearerFirstName' => "",
                        'wearerLastName' => "",
                        'wearerEmail' => "",
                        'wearerPhone' => ""
                    );

                    $res = array(
                        'connection' => true,
                        'queryStatus' => false,
                        'message' => "User is not a wearer",
                        'data' => $data
                    );

                    return response()->json($res, 200);
                }
            } else {

                $data = array(
                    'wearerId' => "",
                    'serviceId' => "",
                    'wearerFirstName' => "",
                    'wearerLastName' => "",
                    'wearerEmail' => "",
                    'wearerPhone' => ""
                );
                $res = array(
                    'connection' => true,
                    'queryStatus' => false,
                    'message' => "Incorrect password",
                    'data' => $data
                );

                return response()->json($res, 200);
            }
        } else {

            $data = array(
                'wearerId' => "",
                'serviceId' => "",
                'wearerFirstName' => "",
                'wearerLastName' => "",
                'wearerEmail' => "",
                'wearerPhone' => ""
            );

            $res = array(
                'connection' => true,
                'queryStatus' => false,
                'message' => "User does not exits",
                'data' => $data
            );

            return response()->json($res, 200);
        }

        $data = array(
            'wearerId' => "",
            'serviceId' => "",
            'wearerFirstName' => "",
            'wearerLastName' => "",
            'wearerEmail' => "",
            'wearerPhone' => ""
        );

        $res = array(
            'connection' => false,
            'queryStatus' => false,
            'message' => "Connection Error",
            'data' => $data
        );

        return response()->json($res, 500);
    }

    public function checkLoginStatus(Request $request)
    {


        $service = DB::table('services')->where('service_id', '=', $request->serviceId)->first();

        return response()->json($service->wearer_logged_in);
    }


    public function setLoginStatus(Request $request)
    {
        $serviceId = $request->serviceId;
        $status = $request->status;

        $update = DB::table('services')
            ->where('service_id', '=', $serviceId)
            ->update(['wearer_logged_in' => $status]);


        return response()->json("done");
    }

    public function getWatchers(Request $request)
    {
        $watchers = DB::table('users')
            ->join('watcher_relations', 'watcher_relations.watcher_id', '=', 'users.person_id')
            ->where('watcher_relations.svc_id', '=', $request->serviceId)
            ->where('watcher_relations.watcher_status', '=', 'Responding')
            ->orderBy('watcher_relations.priority_num', 'asc')
            ->select('users.person_id', 'users.f_name', 'users.l_name', 'users.phone', 'watcher_relations.priority_num')
            ->get();

        if ($watchers != null) {
            $res = array(
                'connection' => true,
                'queryStatus' => true,
                'message' => "Watchers retrieved",
                'data' => $watchers
            );
        } else {
            $res = array(
                'connection' => false,
                'queryStatus' => false,
                'message' => "Error retrieving watchers",
                'data' => $watchers
            );
        }

        return response()->json($res);
    }

    public function helpmeRequest(Request $request)
    {

        $service = DB::table('services')
            ->where('service_id', '=', $request->serviceId)
            ->get()->first();


        if ($service) {

            $data = [
                "to" => $service->wearer_device_token,
                "data" =>
                [
                    "title" => $request->logType,
                    "body" => $request->logText
                ],
                "priority" => "high"
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


            return response()->json(curl_exec($ch));
        }
    }

    public function helpMeRequestInitiate(Request $request)
    {
        $alertLog = new Log();


        $alertLog->battery_percentage = $request->batteryLevel;
        $alertLog->location_latitude = $request->locationLatitude;
        $alertLog->location_longitude = $request->locationLongitude;
        $alertLog->log_text = $request->logText;
        $alertLog->log_date = $request->logDate;
        $alertLog->log_time = $request->logTime;
        $alertLog->log_type = $request->logType;
        $alertLog->service_id = $request->serviceId;



        $alertSaved = $alertLog->save();

        $watchers = DB::table('users')
            ->join('watcher_relations', 'watcher_relations.watcher_id', '=', 'users.person_id')
            ->where('watcher_relations.svc_id', '=', $request->serviceId)
            ->where('watcher_relations.watcher_status', '=', 'Responding')
            ->orderBy('watcher_relations.priority_num', 'asc')
            ->select('users.person_id', 'users.f_name', 'users.l_name', 'users.phone', 'watcher_relations.priority_num')
            ->get();


        if ($watchers != null) {

            $service = DB::table('services')
                ->where('service_id', '=', $request->serviceId)
                ->get()->first();

            $data = [
                "to" => $service->wearer_device_token,
                "data" =>
                [
                    "title" => $request->logType,
                    "body" => $request->logText
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

            $notify = curl_exec($ch);

            $update = DB::table('services')
                ->where('service_id', '=', $request->serviceId)
                ->update(['alert_request_status' => "active"]);


            $res = array(
                'connection' => true,
                'queryStatus' => true,
                'message' => $notify,
                'data' => $watchers
            );
        } else {
            $res = array(
                'connection' => false,
                'queryStatus' => false,
                'message' => "Error in request initiation",
                'data' => $watchers
            );
        }

        event(new NewLog($request->serviceId));

        return response()->json($res);
    }

    public function verifyHelpMeRequest(Request $request)
    {

        if (DB::table('services')
            ->where('service_id', '=', $request->serviceId)
            ->where('alert_request_status', '=', 'active')
            ->exists()
        ) {
            return response()->json('active');
        }
        return response()->json("inactive");
    }

    public function deactivateHelpMeRequest(Request $request)
    {
        $update = DB::table('services')
            ->where('service_id', '=', $request->serviceId)
            ->update(['alert_request_status' => "inactive"]);
    }

    public function updateDeviceToken(Request $request)
    {

<<<<<<< HEAD
        $update = DB::table('services')
            ->where('service_id', '=', $request->serviceId)
            ->update(['wearer_device_token' => $request->deviceToken]);
=======
        //new addition

        $notificationData = array(
            'serviceId' => $request->serviceId,
            'wearerId' => $request->wearerId,
            'wearerName' => $request->wearerName,
            'watcherId' => $request->watcherId,
            'createdAt' => $request->createdAt,
>>>>>>> 2b7c49da109f50ee72671a597dad60ad24caa4a9

        if ($update) {
            return response()->json("Token updated");
        } else {
            return response()->json("Token updation failed");
        }
    }

    public function createHourlyLog(Request $request)
    {

        $serviceId = $request->serviceId;

        return response()->json($serviceId);
    }
}



    // public function sendNotification($token, $message, $title)
    // {
    //     $data = [
    //         "to" => $token,
    //         "notification" =>
    //         [
    //             "title" => $title,
    //             "body" => $message
    //         ],
    //     ];

    //     $dataString = json_encode($data);

    //     $headers = [
    //         'Authorization: key=' . $this->serverApiKey,
    //         'Content-Type: application/json',
    //     ];


    //     $ch = curl_init();

    //     curl_setopt($ch, CURLOPT_URL, $this->firebaseUrl);
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

    //     curl_exec($ch);
    // }
