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

        $finalTime = \DateTime::createFromFormat('His', $time)->format('H:i:s a');

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

            dd($logDetails);

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

}
