<?php

namespace App\Http\Controllers;

use App\Service;
use App\User;
use App\WatcherRelation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function testConnection() {
        return response()->json("Connection Okay", 200);
    }

    public function wearerLoginProcessing(Request $request) {
        $wearerPhone = $request->wearerPhone;
        $wearerPassword = $request->wearerPassword;


        if(DB::table('users')->where('phone', '=', $wearerPhone)->exists()){

            $user = DB::table('users')->where('phone', '=', $wearerPhone)->first();

            if(Hash::check($wearerPassword, $user->password)){

                //user name and password matched

                if(DB::table('services')->where('wearer_id', '=', $user->person_id)->where('wom_num', '=', $wearerPhone)->exists()){

                    // service exists

                    if(DB::table('services')->where('wearer_id', '=', $user->person_id)->where('service_status', '=', 'Active')->exists()){

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

                        $res = array (
                            'connection' => true,
                            'queryStatus' => true,
                            'message' => "Login Successful",
                            'data' => $data
                        );

                        return response()->json($res,200);


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

                        $res = array (
                            'connection' => true,
                            'queryStatus' => false,
                            'message' => "Service is not yet active",
                            'data' => $data
                        );
                        return response()->json($res,200);
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

                    $res = array (
                        'connection' => true,
                        'queryStatus' => false,
                        'message' => "User is not a wearer",
                        'data' => $data
                    );

                    return response()->json($res,200);
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
                $res = array (
                    'connection' => true,
                    'queryStatus' => false,
                    'message' => "Incorrect password",
                    'data' => $data
                );

                return response()->json($res,200);
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

            $res = array (
                'connection' => true,
                'queryStatus' => false,
                'message' => "User does not exits",
                'data' => $data
            );

            return response()->json($res,200);

        }

        $data = array(
            'wearerId' => "",
            'serviceId' => "",
            'wearerFirstName' => "",
            'wearerLastName' => "",
            'wearerEmail' => "",
            'wearerPhone' => ""
        );

        $res = array (
            'connection' => false,
            'queryStatus' => false,
            'message' => "Connection Error",
            'data' => $data
        );

        return response()->json($res,500);

    }
}
