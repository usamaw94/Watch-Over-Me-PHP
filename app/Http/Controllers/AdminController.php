<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin');
    }

    public function services(){
        return view('adminServices');
    }

    public function createService(){
        return view('adminCreateService');
    }

    public function checkWearerPhone(Request $request){
        $phoneNum = $request->phone;

        if(DB::table('users')->where('phone', '=', $phoneNum)->exists()){

            $personDetails = DB::table('users')->where('phone', '=', $phoneNum)->get()->first();

            if (DB::table('services')->where('wom_num', '=', $phoneNum)->exists()) {
                $existStatus = 'wearer';

            } else {
                $existStatus = 'exist';
            }

            $data = array(
                'existStatus' => $existStatus,
                'personDetails' => $personDetails,
            );

            return response()->json($data);

        } else {

            $existStatus = 'not exist';

            $data = array(
                'existStatus' => $existStatus,
            );

            return response()->json($data);
        }

    }

    public function checkWatcherPhone(Request $request){
        $phoneNum = $request->phone;

        if(DB::table('users')->where('phone', '=', $phoneNum)->exists()){

            $personDetails = DB::table('users')->where('phone', '=', $phoneNum)->get()->first();

            $existStatus = 'exist';
            $data = array(
                'existStatus' => $existStatus,
                'personDetails' => $personDetails,
            );

            return response()->json($data);

        } else {

            $existStatus = 'not exist';

            $data = array(
                'existStatus' => $existStatus,
            );

            return response()->json($data);
        }

    }

    public function checkCustomerPhone(Request $request){
        $phoneNum = $request->phone;

        if(DB::table('users')->where('phone', '=', $phoneNum)->exists()){

            $personDetails = DB::table('users')->where('phone', '=', $phoneNum)->get()->first();

            $existStatus = 'exist';
            $data = array(
                'existStatus' => $existStatus,
                'personDetails' => $personDetails,
            );

            return response()->json($data);

        } else {

            $existStatus = 'not exist';

            $data = array(
                'existStatus' => $existStatus,
            );

            return response()->json($data);
        }
    }

    public function checkEmail(Request $request){
        $email = $request->checkEmail;

        if(DB::table('users')->where('email', '=', $email)->exists()){

            $existStatus = 'exist';

            $data = array(
                'existStatus' => $existStatus,
            );

            return response()->json($data);

        } else {

            $existStatus = 'not exist';

            $data = array(
                'existStatus' => $existStatus,
            );

            return response()->json($data);

        }
    }

}

