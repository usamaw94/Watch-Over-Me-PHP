<?php

namespace App\Http\Controllers;

use App\Service;
use App\User;
use App\WatcherRelation;
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

        $services = DB::table('services')
            ->join('users as wearer', 'wearer.person_id', '=', 'services.wearer_id')
            ->join('users as customer', 'customer.person_id', '=', 'services.customer_id')
            ->select('services.service_id', 'services.wearer_id', 'services.customer_id', 'services.wom_num', 'services.service_status', 'services.no_of_watchers',
                'wearer.person_id as wearerId', 'wearer.f_name as wearerFName', 'wearer.l_name as wearerLName',
                'customer.person_id as customerId', 'customer.f_name as customerFName', 'customer.l_name as customerLName')
            ->get();

        $data = array(
            'services' => $services,
        );

        return view('adminServices')->with($data);
    }


    public function getPerson(Request $request) {
        $id =  $request->personId;

        $personDetails = DB::table('users')->where('person_id', '=', $id)->get()->first();

        return response()->json($personDetails);
    }

    public function getWatchersList(Request $request){

        $serviceId = $request->serviceId;

        $watcherDetails = DB::table('users')
            ->join('watcher_relations', 'watcher_relations.watcher_id', '=', 'users.person_id')
            ->where('watcher_relations.svc_id', '=', $serviceId)
            ->orderBy('watcher_relations.priority_num', 'desc')
            ->select('users.person_id', 'users.f_name', 'users.l_name', 'users.email', 'users.phone',
            'watcher_relations.priority_num')
            ->get();

        return response()->json($watcherDetails);
    }

    public function serviceDetails(Request $request){
        $serviceId = $request->id;

        $serviceDetails = DB::table('services')
            ->where('service_id', '=', $serviceId)
            ->get()->first();

        $wearerId = $serviceDetails->wearer_id;
        $customerId = $serviceDetails->customer_id;

        $wearerDetails = DB::table('users')
            ->where('person_id', '=', $wearerId)
            ->get()->first();


        $customerDetails = DB::table('users')
            ->where('person_id', '=', $customerId)
            ->get()->first();

        $watchersList = DB::table('users')
            ->join('watcher_relations', 'watcher_relations.watcher_id', '=', 'users.person_id')
            ->where('watcher_relations.svc_id', '=', $serviceId)
            ->orderBy('watcher_relations.priority_num', 'desc')
            ->select('users.person_id', 'users.f_name', 'users.l_name', 'users.email', 'users.phone',
                'watcher_relations.priority_num', 'watcher_relations.watcher_status')
            ->get();


        $data = array(
            'serviceDetails' => $serviceDetails,
            'wearerDetails' => $wearerDetails,
            'customerDetails' => $customerDetails,
            'watchersList' => $watchersList,
        );

        return view('adminServiceDetails')->with($data);


    }

    public function serviceLogs(Request $request){
        $serviceId = $request->id;

        $serviceDetails = DB::table('services')
            ->where('service_id', '=', $serviceId)
            ->get()->first();

        $data = array(
            'serviceDetails' => $serviceDetails,
        );


        return view('adminServiceLogs')->with($data);


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

    public function processNewService(Request $request){

        $wearerPhone = $request->wearerStorePhoneNum;
        $wearerExistStatus = $request->wearerExistStatus;
        $wearerId = $request->wearerId;
        $wearerEmail = $request->wearerEmail;
        $wearerFName = $request->wearerFirstName;
        $wearerLName = $request->wearerLastName;

        $watcherPhone = $request->watcherStorePhoneNum;
        $watcherExistStatus = $request->watcherExistStatus;
        $watcherId = $request->watcherId;
        $watcherEmail = $request->watcherEmail;
        $watcherFName = $request->watcherFirstName;
        $watcherLName = $request->watcherLastName;

        $customerType = $request->customerTypeRadio;
        $customerPhone = $request->customerStorePhoneNum;
        $customerExistStatus = $request->customerExistStatus;
        $customerId = $request->customerId;
        $customerEmail = $request->customerEmail;
        $customerFName = $request->customerFirstName;
        $customerLName = $request->customerLastName;


        $dbName = 'watchoverme';
        $tableNameUser = 'users';
        $tableNameService = 'services';
        $tableNameWatcherRelation = 'watcher_relations';

        $infoUser = DB::select('SELECT `AUTO_INCREMENT`FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ? AND   TABLE_NAME   = ?',[$dbName,$tableNameUser]);
        $infoService = DB::select('SELECT `AUTO_INCREMENT`FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ? AND   TABLE_NAME   = ?',[$dbName,$tableNameService]);
        $infoWatcherRelation = DB::select('SELECT `AUTO_INCREMENT`FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ? AND   TABLE_NAME   = ?',[$dbName,$tableNameWatcherRelation]);

        $autoIncUser = $infoUser[0]->AUTO_INCREMENT;
        $autoIncService = $infoService[0]->AUTO_INCREMENT;
        $autoIncWatcherRelation = $infoWatcherRelation[0]->AUTO_INCREMENT;

        $userId = 'WOMUSR00'. $autoIncUser;
        $serviceId = 'WOM00'.$autoIncService;
        $watcherRelationId = 'WOM00'.$autoIncWatcherRelation;


        if($wearerExistStatus != "wearer") {

            if ($wearerExistStatus == "not exist") {

                // Wearer Not Exist

                $infoUser = DB::select('SELECT `AUTO_INCREMENT`FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ? AND   TABLE_NAME   = ?',[$dbName,$tableNameUser]);
                $autoIncUser = $infoUser[0]->AUTO_INCREMENT;
                $wearerId = 'WOMUSR00'. $autoIncUser;

                $wR =new User();
                $wR->person_id = $wearerId;
                $wR->f_name = $wearerFName;
                $wR->l_name = $wearerLName;
                $wR->email = $wearerEmail;
                $wR->phone = $wearerPhone;
                $wR->password = bcrypt("womperson");
                $wRSaved = $wR->save();

                error_log('New wearer');
            }

            if ($watcherExistStatus == "not exist") {

                // Watcher Not Exist

                $infoUser = DB::select('SELECT `AUTO_INCREMENT`FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ? AND   TABLE_NAME   = ?',[$dbName,$tableNameUser]);
                $autoIncUser = $infoUser[0]->AUTO_INCREMENT;
                $watcherId = 'WOMUSR00'. $autoIncUser;

                $wT =new User();
                $wT->person_id = $watcherId;
                $wT->f_name = $watcherFName;
                $wT->l_name = $watcherLName;
                $wT->email = $watcherEmail;
                $wT->phone = $watcherPhone;
                $wT->password = bcrypt("womperson");
                $wTSaved = $wT->save();

                error_log('New watcher');

            }

            if ($customerExistStatus == "not exist") {

                // Customer Not Exist

                $infoUser = DB::select('SELECT `AUTO_INCREMENT`FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ? AND   TABLE_NAME   = ?',[$dbName,$tableNameUser]);
                $autoIncUser = $infoUser[0]->AUTO_INCREMENT;
                $customerId = 'WOMUSR00'. $autoIncUser;

                $c =new User();
                $c->person_id = $customerId;
                $c->f_name = $customerFName;
                $c->l_name = $customerLName;
                $c->email = $customerEmail;
                $c->phone = $customerPhone;
                $c->password = bcrypt("womperson");
                $cSaved = $c->save();

                error_log('New customer');

            }

            if ($customerType == "wearer") {

                $customerId = $wearerId;

                error_log('Wearer is customer');

            } elseif ($customerType == "watcher") {

                $customerId = $watcherId;

                error_log('Watcher is customer');

            }


            $tableNameService = 'services';
            $infoService = DB::select('SELECT `AUTO_INCREMENT`FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ? AND   TABLE_NAME   = ?',[$dbName,$tableNameService]);
            $autoIncService = $infoService[0]->AUTO_INCREMENT;
            $serviceId = 'WOM00'.$autoIncService;

            $s =new Service();
            $s->service_id = $serviceId;
            $s->wearer_id = $wearerId;
            $s->customer_id = $customerId;
            $s->wom_num = $wearerPhone;
            $s->service_status = "Pending";
            $s->no_of_watchers = 1;
            $sSaved = $s->save();

            $wR =new WatcherRelation();
            $wR->svc_id = $serviceId;
            $wR->watcher_id = $watcherId;
            $wR->priority_num = 1;
            $wR->watcher_status = "Responding";
            $wRSaved = $wR->save();

            error_log('New service created');

            $msg = array(
                'message' => "New service created successfully",
            );

            return redirect('/adminServices')->with($msg);

        } else {

            dd("Error!!. Service can't be created. Wearer already exist as wearer for another service");
        }

    }

}

