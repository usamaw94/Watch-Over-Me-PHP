<?php

namespace App\Http\Controllers;

use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebController extends Controller
{

    public function helpMeRequest(Request $request){


        $logId =  substr($request->logId, 0, -8);

        $logId = "ALR".$logId;

        $date = substr ($request->logId, -8);

        $userId =  substr($request->userId, 0, -6);

        $userId = "WOMUSR".$userId;

        $time = substr ($request->userId, -6);

        $finalTime = \DateTime::createFromFormat('His', $time)->format('H:i:s');

        $finalDate = \DateTime::createFromFormat('Ydm', $date)->format('d F Y');



        $logDetails = DB::table('logs')
            ->where('log_id', '=', $logId)
            ->get()->first();

        if($logDetails){

            $serviceId = $logDetails->service_id;

            $serviceDetails = DB::table('services')
                ->join('users as wearer', 'wearer.person_id', '=', 'services.wearer_id')
                ->select('services.service_id', 'services.wearer_id', 'services.wom_num', 'services.no_of_watchers',
                    'wearer.person_id as wearerId', 'wearer.f_name as wearerFName', 'wearer.l_name as wearerLName', 'wearer.full_name as wearerFullName',
                    'wearer.email as wearerEmail', 'wearer.phone as wearerPhone')
                ->where('services.service_id', '=', $serviceId)
                ->get()->first();

//        dd($logDetails);

            ////

            if ($serviceDetails) {

                $data = array(
                    'userId' => $userId,
                    'serviceDetails' => $serviceDetails,
                    'logDetails' => $logDetails
                );


                return view('helpMeRequest')->with($data);

            }

        }
    }

}
