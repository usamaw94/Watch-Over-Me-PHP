<?php

namespace App\Http\Controllers;

use App\Events\HourlyLogCreated;
use App\Events\NewAlertLog;
use App\Events\NewLog;
use App\Events\WearerLocation;
use App\HelpMeResponse;
use App\Service;
use App\User;
use App\WatcherRelation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Log;
use Dotenv\Result\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ApiController extends Controller
{
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

        if ($service->wearer_logged_in == null || $service->wearer_logged_in != "true") {
            return response()->json("false");
        }
        return response()->json("true");
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

    public function wearerNotification(Request $request)
    {
        $this->sendNotificationToWearer($request->serviceId, $request->notificationTitle, $request->notificationText);

        return response()->json("Done");
    }

    public function sendNotificationToWearer($serviceId, $title, $message)
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

    public function helpMeRequestInitiate(Request $request)
    {
        $dbName = 'watchoverme';
        $tableNameLogs = 'logs';

        $infoLog = DB::select('SELECT `AUTO_INCREMENT`FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ? AND   TABLE_NAME   = ?', [$dbName, $tableNameLogs]);
        $autoIncLog = $infoLog[0]->AUTO_INCREMENT;
        $logId = 'ALR' . $autoIncLog;

        $alertLog = new Log();

        $alertLog->log_id = $logId;
        $alertLog->battery_percentage = $request->batteryLevel;
        $alertLog->location_latitude = $request->locationLatitude;
        $alertLog->location_longitude = $request->locationLongitude;
        $alertLog->locality = $request->locality;
        $alertLog->log_text = $request->logText;
        $alertLog->log_date = $request->logDate;
        $alertLog->log_time = $request->logTime;
        $alertLog->log_type = $request->logType;
        $alertLog->service_id = $request->serviceId;
        $alertLog->response_status = "false";



        $alertSaved = $alertLog->save();

        $watchers = DB::table('users')
            ->join('watcher_relations', 'watcher_relations.watcher_id', '=', 'users.person_id')
            ->where('watcher_relations.svc_id', '=', $request->serviceId)
            ->where('watcher_relations.watcher_status', '=', 'Responding')
            ->orderBy('watcher_relations.priority_num', 'asc')
            ->select('users.person_id', 'users.f_name', 'users.l_name', 'users.phone', 'watcher_relations.priority_num')
            ->get();


        if ($watchers != null) {

            $this->sendNotificationToWearer($request->serviceId, $request->logType, $request->logText);

            $update = DB::table('services')
                ->where('service_id', '=', $request->serviceId)
                ->update(['alert_request_status' => "active"]);


            $res = array(
                'connection' => true,
                'queryStatus' => true,
                'message' => $logId,
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

    public function deactivateHelpMeRequest(Request $request)
    {
        $this->sendNotificationToWearer($request->serviceId, "HelpMeResponse", "Help Me service is now available");

        $update = DB::table('services')
            ->where('service_id', '=', $request->serviceId)
            ->update(['alert_request_status' => "inactive"]);


        if ($update) {
            return response()->json("done");
        }
        return response()->json("error");
    }

    public function updateDeviceToken(Request $request)
    {

        $update = DB::table('services')
            ->where('service_id', '=', $request->serviceId)
            ->update(['wearer_device_token' => $request->deviceToken]);

        if ($update) {
            return response()->json("Token updated");
        } else {
            return response()->json("Token updation failed");
        }
    }

    public function regularLog(Request $request)
    {

        $dbName = 'watchoverme';
        $tableNameLogs = 'logs';

        $infoLog = DB::select('SELECT `AUTO_INCREMENT`FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ? AND   TABLE_NAME   = ?', [$dbName, $tableNameLogs]);
        $autoIncLog = $infoLog[0]->AUTO_INCREMENT;
        $logId = 'REG' . $autoIncLog;

        $regularLog = new Log();

        $regularLog->log_id = $logId;
        $regularLog->battery_percentage = $request->batteryLevel;
        $regularLog->location_latitude = $request->locationLatitude;
        $regularLog->location_longitude = $request->locationLongitude;
        $regularLog->locality = $request->locality;
        $regularLog->log_text = $request->logText;
        $regularLog->log_date = $request->logDate;
        $regularLog->log_time = $request->logTime;
        $regularLog->log_type = $request->logType;
        $regularLog->service_id = $request->serviceId;



        $regularLogSaved = $regularLog->save();

        event(new NewLog($request->serviceId));

        if ($regularLogSaved) {
            return response()->json("Saved");
        } else {
            return response()->json("Error");
        }
    }


    public function contactWatcher(Request $request)
    {


        $positiveResponder = DB::table('help_me_responses')
            ->where('alert_log_id', '=', $request->alertLogId)
            ->where('response_status', '=', "true")
            ->where('response_type', '=', 'Yes')
            ->select('response_to')
            ->first();

        if ($positiveResponder) {
            $res = array(
                'connection' => true,
                'queryStatus' => true,
                'message' => "Responded",
                'data' => $positiveResponder->response_to
            );

            return response()->json($res);
        }

        $negativeResponse = DB::table('help_me_responses')
            ->where('alert_log_id', '=', $request->alertLogId)
            ->where('response_status', '=', "true")
            ->where('response_type', '=', 'No')
            ->where('response_to', '=', $request->watcherId)
            ->select('response_to')
            ->first();

        if ($negativeResponse) {
            $res = array(
                'connection' => true,
                'queryStatus' => false,
                'message' => "Skip",
                'data' => $negativeResponse->response_to
            );
            return response()->json($res);
        }

        if ($request->cycle == "0") {

            $watcherResponses = new HelpMeResponse();

            $watcherResponses->alert_log_id = $request->alertLogId;
            $watcherResponses->response_from = $request->wearerId;
            $watcherResponses->response_to = $request->watcherId;
            $watcherResponses->send_text = "Requested for help";
            $watcherResponses->send_date = $request->sendDate;
            $watcherResponses->send_time = $request->sendTime;
            $watcherResponses->response_type = "No";
            $watcherResponses->response_status = "false";
            $watcherResponses->reply_text = "";
            $watcherResponses->reply_date = "";
            $watcherResponses->reply_time = "";
            $watcherResponses->response_link = $request->responseLink;


            $watcherResponses->save();

            $this->sendNotificationToWearer($request->serviceId, $request->responseTitle, $request->responseText);

            $createdAt = $request->sendDate . "-" . $request->sendTime;
            event(new NewAlertLog($request->serviceId, $request->wearerId, $request->wearerFullName, $request->watcherId, $request->responseLink, $createdAt));


            $data = array(
                'serviceId' => $request->serviceId,
                'wearerId' => $request->wearerId,
                'wearerFullNme' => $request->wearerFullName,
                'watcherId' => $request->watcherId,
                'watcherEmail' => $request->watcherEmail,
                'watcherFullName' => $request->watcherFirstName . " " . $request->watcherLastName,
                'watcherFName' => $request->watcherFirstName,
                'respondingLink' => $request->responseLink
            );

            Mail::send('emails.contactWatcher', $data, function ($message) use ($data) {
                $message->from('mailtest2194@gmail.com', 'Watch Over Me');
                $message->to($data['watcherEmail']);
                $message->subject('Watch Over Me - Help Me Request');
            });
        } else {
            //call function will be called here

        }

        $res = array(
            'connection' => false,
            'queryStatus' => false,
            'message' => "Continue",
            'data' => "Continue"
        );
        return response()->json($res);
    }

    public function sendLocation(Request $request)
    {

        $serviceId = $request->serviceId;
        $receiverId = $request->receiverId;
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $address = $request->address;

        event(new WearerLocation($receiverId, $serviceId, $latitude, $longitude, $address));

        return response()->json("done");
    }
}
