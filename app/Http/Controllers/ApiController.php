<?php

namespace App\Http\Controllers;

use App\Events\HourlyLogCreated;
use App\Events\NewLog;
use App\Service;
use App\User;
use App\WatcherRelation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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

        $data = [
            "to" => 'c-20ad9SQ4SNurTQHqnWAc:APA91bGajpXu10Y8tPNEAL1GduL-G-Sxsq4KdDXT4DOwzye0JQw1ycQpG3qexM00FrvlSkvVfZPkRONe7VE52zRf6Ulg_VIh1siVxwTKYXhfwn_8jY6N6o1uz0Al98SGIfuGZ4oboPKA',
            "notification" =>
            [
                "title" => "New Notification",
                "body" => "This is a test"
            ],
        ];

        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . 'AAAAOag5k6Q:APA91bGWiOFxRiKvtRJXrVUdX0pMKqPygeFQD3uJaQykRq7Si_IFbzksVHTbtJZEBt3ZpozNb6NfA_4TK8TA3p0o3UFg5PVpEKj4G3iMbSw98zFbkralNOXJ4F_W_3OmabB2qWqxmfr3',
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

    public function helpMeRequestInitiate(Request $request){

    }

    public function updateDeviceToken(Request $request){

    }

    public function createHourlyLog(Request $request){

        $serviceId = $request->serviceId;

        event(new NewLog($serviceId));

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

