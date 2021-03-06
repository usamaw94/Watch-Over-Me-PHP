<?php

namespace App\Http\Controllers;

use App\Service;
use App\User;
use App\WatcherRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

    protected $firebaseUrl = "https://fcm.googleapis.com/fcm/send";
    protected $serverApiKey = 'AAAAOag5k6Q:APA91bGWiOFxRiKvtRJXrVUdX0pMKqPygeFQD3uJaQykRq7Si_IFbzksVHTbtJZEBt3ZpozNb6NfA_4TK8TA3p0o3UFg5PVpEKj4G3iMbSw98zFbkralNOXJ4F_W_3OmabB2qWqxmfr3';

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
            ->paginate(2);

            $data = array(
                'services' => $services,
            );

            return view('adminServices')->with($data);

    }

    public function searchServices(Request $request){

        $searchText = $request->searchText;


        $services = DB::table('services')
            ->join('users as wearer', 'wearer.person_id', '=', 'services.wearer_id')
            ->join('users as customer', 'customer.person_id', '=', 'services.customer_id')
            ->select('services.service_id', 'services.wearer_id', 'services.customer_id', 'services.wom_num', 'services.service_status', 'services.no_of_watchers',
                'wearer.person_id as wearerId', 'wearer.f_name as wearerFName', 'wearer.l_name as wearerLName', 'wearer.full_name as wearerFullName',
                'customer.person_id as customerId', 'customer.f_name as customerFName', 'customer.l_name as customerLName', 'customer.full_name as customerFullName')
                    ->orwhere('services.service_id', 'like', '%'.$searchText.'%')
                    ->orWhere('services.wearer_id', 'like', '%'.$searchText.'%')
                    ->orWhere('services.customer_id', 'like', '%'.$searchText.'%')
                    ->orWhere('services.wom_num', 'like', '%'.$searchText.'%')
                    ->orWhere('services.service_status', 'like', '%'.$searchText.'%')
                    ->orWhere('services.no_of_watchers', 'like', '%'.$searchText.'%')
                    ->orWhere('wearer.person_id', 'like', '%'.$searchText.'%')
                    ->orWhere('wearer.f_name', 'like', '%'.$searchText.'%')
                    ->orWhere('wearer.l_name', 'like', '%'.$searchText.'%')
                    ->orWhere('wearer.full_name', 'like', '%'.$searchText.'%')
                    ->orWhere('customer.person_id', 'like', '%'.$searchText.'%')
                    ->orWhere('customer.f_name', 'like', '%'.$searchText.'%')
                    ->orWhere('customer.l_name', 'like', '%'.$searchText.'%')
                    ->orWhere('customer.full_name', 'like', '%'.$searchText.'%')
                    ->get();


        $data = array(
            'services' => $services,
        );

        return response()->json($services);

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
            ->orderBy('watcher_relations.priority_num', 'asc')
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
            ->orderBy('watcher_relations.priority_num', 'asc')
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

    public function activateService(Request $request){
        $serviceId = $request->serviceId;

        $update = DB::table('services')
            ->where('service_id', '=',  $serviceId)
            ->update(['service_status' => 'Active']);


        $response = "success";

        return response()->json($response);
    }

    public function deactivateService(Request $request){
        $serviceId = $request->serviceId;

        $update = DB::table('services')
            ->where('service_id', '=',  $serviceId)
            ->update(['service_status' => 'Inactive']);


        $response = "success";

        return response()->json($response);
    }

    public function serviceLogs(Request $request){
        $serviceId = $request->id;

//        dd($serviceId);

        $serviceDetails = DB::table('services')
            ->where('service_id', '=', $serviceId)
            ->get()->first();

        $wearerId = $serviceDetails->wearer_id;

        $wearerDetails = DB::table('users')
            ->where('person_id', '=', $wearerId)
            ->select('person_id', 'f_name' , 'l_name', 'full_name', 'email', 'phone')
            ->get()->first();

        $logs = DB::table('logs')
            ->where('service_id', '=', $serviceId)
            ->orderBy('created_at', 'desc')
//            ->orderBy('log_time', 'desc')
            ->take(50)->get();

        $data = array(
            'wearerDetails' => $wearerDetails,
            'serviceDetails' => $serviceDetails,
            'logs' => $logs
        );


        return view('adminServiceLogs')->with($data);


    }

    public function verifyServiceWatcherPhone(Request $request){
        $watcherNum = $request->watcherNum;
        $serviceId = $request->serviceId;

        if(DB::table('users')->where('phone', '=', $watcherNum)->exists()) {

            $personDetails = DB::table('users')->where('phone', '=', $watcherNum)->get()->first();

            $watcherId = $personDetails->person_id;

            if (DB::table('watcher_relations')->where('watcher_id', '=', $watcherId)->where('svc_id','=',$serviceId)->exists()){
                $watcherRelation = DB::table('watcher_relations')->where('watcher_id', '=', $watcherId)->where('svc_id','=',$serviceId)->get()->first();
                $watcherType = $watcherRelation->watcher_status;
                $existStatus = "watcher";
            } else {
                $watcherType = "";
                $existStatus = "exist";
            }

            $data = array(
                'watcherType' => $watcherType,
                'existStatus' => $existStatus,
                'personDetails' => $personDetails,
            );

            return response()->json($data);
        } else {

            $data = array(
                'existStatus' => "new",
            );

            return response()->json($data);

        }

    }

    public function addNewWatcher(Request $request){
        $serviceId = $request->serviceId;
        $watcherPhone = $request->watcherStorePhone;
        $watcherId = $request->watcherId;
        $watcherEmail = $request->watcherEmail;
        $watcherFirstName = $request->watcherFirstName;
        $watcherLastName = $request->watcherLastName;
        $watcherType = $request->watcherType;

        if($watcherId == null){

            $dbName = 'uawdevst_watchoverme';
            $tableNameUser = 'users';
            $tableNameService = 'services';
            $tableNameWatcherRelation = 'watcher_relations';

            $newWatcher = true;

            $watcherCode = date("dYmhis");

            $infoUser = DB::select('SELECT `AUTO_INCREMENT`FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ? AND   TABLE_NAME   = ?',[$dbName,$tableNameUser]);
            $autoIncUser = $infoUser[0]->AUTO_INCREMENT;
            $watcherId = 'WOMUSR00'. $autoIncUser;

            $wT =new User();
            $wT->person_id = $watcherId;
            $wT->f_name = $watcherFirstName;
            $wT->l_name = $watcherLastName;
            $wT->full_name = $watcherFirstName. " " .$watcherLastName;
            $wT->email = $watcherEmail;
            $wT->phone = $watcherPhone;
            $wT->verification_code = $watcherCode;
            $wT->password = bcrypt("womperson");
            $wTSaved = $wT->save();

            $watcherVerificationLink = "http://127.0.0.1:8000/userVerification/".$autoIncUser.$watcherCode;

            $userVerificationEmailData = array(

                'serviceId' => $serviceId,

                'userId' => $watcherId,
                'userFName' => $watcherFirstName,
                'userLName' => $watcherLastName,
                'userFullName' => $watcherFirstName. " " .$watcherLastName,
                'userEmail' => $watcherEmail,
                'userPhone' => $watcherPhone,
                'verificationLink' => $watcherVerificationLink


            );

            Mail::send('emails.userVerification', $userVerificationEmailData ,function ($message) use ($userVerificationEmailData){
                $message->from('mailtest2194@gmail.com', 'Watch Over Me');
                $message->to($userVerificationEmailData['userEmail']);
                $message->subject('Watcher Over Me - User Verification');
            });

        }

        $serviceDetails = DB::table('services')
            ->where('service_id', '=', $serviceId)
            ->get()->first();

        $watcherNum = $serviceDetails->no_of_watchers;

        $watcherNum = $watcherNum + 1;

        $update = DB::table('services')
            ->where('service_id', '=',  $serviceId)
            ->update(['no_of_watchers' => $watcherNum]);


        $wR =new WatcherRelation();
        $wR->svc_id = $serviceId;
        $wR->watcher_id = $watcherId;
        $wR->priority_num = $watcherNum;
        $wR->watcher_status = $watcherType;
        $wRSaved = $wR->save();

        return response()->json("success");

    }

    public function updatePriorityOrder(Request $request){

        $serviceId = $request->serviceId;

        $length = count($request->priorityChanges);


        for ($i = 0; $i<$length; $i++){
            $watcherId = $request->priorityChanges[$i][0];
            $priorityNum = $request->priorityChanges[$i][1];

            $update = DB::table('watcher_relations')
                ->where('svc_id', '=',  $serviceId)
                ->where('watcher_id', '=', $watcherId)
                ->update(['priority_num' => $priorityNum]);


        }

        return response()->json("success");
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
        $newWearer = false;

        $watcherPhone = $request->watcherStorePhoneNum;
        $watcherExistStatus = $request->watcherExistStatus;
        $watcherId = $request->watcherId;
        $watcherEmail = $request->watcherEmail;
        $watcherFName = $request->watcherFirstName;
        $watcherLName = $request->watcherLastName;
        $newWatcher = false;

        $customerType = $request->customerTypeRadio;
        $customerPhone = $request->customerStorePhoneNum;
        $customerExistStatus = $request->customerExistStatus;
        $customerId = $request->customerId;
        $customerEmail = $request->customerEmail;
        $customerFName = $request->customerFirstName;
        $customerLName = $request->customerLastName;
        $newCustomer = false;


        $dbName = 'uawdevst_watchoverme';
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

                $wearerCode = date("dYmhis");

                $newWearer = true;


                $infoUser = DB::select('SELECT `AUTO_INCREMENT`FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ? AND   TABLE_NAME   = ?',[$dbName,$tableNameUser]);
                $autoIncUser = $infoUser[0]->AUTO_INCREMENT;
                $wearerId = 'WOMUSR00'. $autoIncUser;

                $wR =new User();
                $wR->person_id = $wearerId;
                $wR->f_name = $wearerFName;
                $wR->l_name = $wearerLName;
                $wR->full_name = $wearerFName. " " .$wearerLName;
                $wR->email = $wearerEmail;
                $wR->phone = $wearerPhone;
                $wR->verification_status = "false";
                $wR->verification_code = $wearerCode;
                $wR->password = bcrypt("womperson");
                $wRSaved = $wR->save();

                $wearerVerificationLink = "http://127.0.0.1:8000/userVerification/".$autoIncUser.$wearerCode;

//                $data = array(
//                    'wearerId' => $wearerId,
//                    'wearerFName' => $wearerFName,
//                    'wearerLName' => $wearerLName,
//                    'wearerFullName' => $wearerFName. " " .$wearerLName,
//                    'role' => "Wearer",
//                    'wearerEmail' => $wearerEmail,
//                    'wearerPhone' => $wearerPhone,
//                    'serviceId' => $serviceId,
//                    'wearerPhone' => $wearerPhone,
//            );
//
//            Mail::send('emails.userVerification', $data ,function ($message) use ($data){
//                $message->from('watchoverme@uawdevstudios.com', 'Watch Over Me');
//                $message->to($data['wearerEmail']);
//                $message->subject('Watcher Over Me - Service Creation');
//            });

                error_log('New wearer');
            }

            if ($watcherExistStatus == "not exist") {

                // Watcher Not Exist

                $newWatcher = true;

                $watcherCode = date("dYmhis");

                $infoUser = DB::select('SELECT `AUTO_INCREMENT`FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ? AND   TABLE_NAME   = ?',[$dbName,$tableNameUser]);
                $autoIncUser = $infoUser[0]->AUTO_INCREMENT;
                $watcherId = 'WOMUSR00'. $autoIncUser;

                $wT =new User();
                $wT->person_id = $watcherId;
                $wT->f_name = $watcherFName;
                $wT->l_name = $watcherLName;
                $wT->full_name = $watcherFName. " " .$watcherLName;
                $wT->email = $watcherEmail;
                $wT->phone = $watcherPhone;
                $wT->verification_status = "false";
                $wT->verification_code = $watcherCode;
                $wT->password = bcrypt("womperson");
                $wTSaved = $wT->save();

                $watcherVerificationLink = "http://127.0.0.1:8000/userVerification/".$autoIncUser.$watcherCode;

                error_log('New watcher');

            }

            if ($customerExistStatus == "not exist") {

                // Customer Not Exist

                $newCustomer = true;

                $customerCode = date("dYmhis");

                $infoUser = DB::select('SELECT `AUTO_INCREMENT`FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ? AND   TABLE_NAME   = ?',[$dbName,$tableNameUser]);
                $autoIncUser = $infoUser[0]->AUTO_INCREMENT;
                $customerId = 'WOMUSR00'. $autoIncUser;

                $c =new User();
                $c->person_id = $customerId;
                $c->f_name = $customerFName;
                $c->l_name = $customerLName;
                $c->full_name = $customerFName. " " .$customerLName;
                $c->email = $customerEmail;
                $c->phone = $customerPhone;
                $c->verification_status = "false";
                $c->verification_code = $customerCode;
                $c->password = bcrypt("womperson");
                $cSaved = $c->save();

                $customerVerificationLink = "http://127.0.0.1:8000/userVerification/".$autoIncUser.$customerCode;

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
            $s->service_status = "User Verification Required";
            $s->no_of_watchers = 1;
            $s->alert_request_status = "inactive";
            $sSaved = $s->save();

            $wR =new WatcherRelation();
            $wR->svc_id = $serviceId;
            $wR->watcher_id = $watcherId;
            $wR->priority_num = 1;
            $wR->watcher_status = "Responding";
            $wRSaved = $wR->save();

            error_log('New service created');

            ////////////////////////////////////

            $newServiceEmailData = array(
                'contactName' => $wearerFName,

                'serviceId' => $serviceId,
                'wearerId' => $wearerId,
                'wearerFName' => $wearerFName,
                'wearerLName' => $wearerLName,
                'wearerFullName' => $wearerFName. " " .$wearerLName,
                'wearerEmail' => $wearerEmail,
                'wearerPhone' => $wearerPhone,


                'watcherId' => $watcherId,
                'watcherFName' => $watcherFName,
                'watcherLName' => $watcherLName,
                'watcherFullName' => $watcherFName. " " .$watcherLName,
                'watcherEmail' => $watcherEmail,
                'watcherPhone' => $watcherPhone,


                'customerType' => $customerType,

                'customerId' => $customerId,
                'customerFName' => $customerFName,
                'customerLName' => $customerLName,
                'customerFullName' => $customerFName. " " .$customerLName,
                'customerEmail' => $customerEmail,
                'customerPhone' => $customerPhone,

            );

            Mail::send('emails.newService', $newServiceEmailData ,function ($message) use ($wearerEmail){
                $message->from('mailtest2194@gmail.com', 'Watch Over Me');
                $message->to($wearerEmail);
                $message->subject('Watcher Over Me - Service Creation');
            });


            $newServiceEmailData['contactName'] = $watcherFName;

            Mail::send('emails.newService', $newServiceEmailData ,function ($message) use ($watcherEmail){
                $message->from('mailtest2194@gmail.com', 'Watch Over Me');
                $message->to($watcherEmail);
                $message->subject('Watcher Over Me - Service Creation');
            });


            if($customerType != "wearer" && $customerType != "watcher"){

                $newServiceEmailData['contactName'] = $customerFName;

                Mail::send('emails.newService', $newServiceEmailData ,function ($message) use ($customerEmail){
                    $message->from('mailtest2194@gmail.com', 'Watch Over Me');
                    $message->to($customerEmail);
                    $message->subject('Watcher Over Me - Service Creation');
                });

            }

            if ($newWearer == true){

                $userVerificationEmailData = array(

                    'serviceId' => $serviceId,

                    'userId' => $wearerId,
                    'userFName' => $wearerFName,
                    'userLName' => $wearerLName,
                    'userFullName' => $wearerFName. " " .$wearerLName,
                    'userEmail' => $wearerEmail,
                    'userPhone' => $wearerPhone,
                    'verificationLink' => $wearerVerificationLink


                );

                Mail::send('emails.userVerification', $userVerificationEmailData ,function ($message) use ($userVerificationEmailData){
                    $message->from('mailtest2194@gmail.com', 'Watch Over Me');
                    $message->to($userVerificationEmailData['userEmail']);
                    $message->subject('Watcher Over Me - User Verification');
                });
            }

            if ($newWatcher == true){

                $userVerificationEmailData = array(

                    'serviceId' => $serviceId,

                    'userId' => $watcherId,
                    'userFName' => $watcherFName,
                    'userLName' => $watcherLName,
                    'userFullName' => $watcherFName. " " .$watcherLName,
                    'userEmail' => $watcherEmail,
                    'userPhone' => $watcherPhone,
                    'verificationLink' => $watcherVerificationLink


                );

                Mail::send('emails.userVerification', $userVerificationEmailData ,function ($message) use ($userVerificationEmailData){
                    $message->from('mailtest2194@gmail.com', 'Watch Over Me');
                    $message->to($userVerificationEmailData['userEmail']);
                    $message->subject('Watcher Over Me - User Verification');
                });

            }

            if ($newCustomer == true){

                $userVerificationEmailData = array(

                    'serviceId' => $serviceId,

                    'userId' => $customerId,
                    'userFName' => $customerFName,
                    'userLName' => $customerLName,
                    'userFullName' => $customerFName. " " .$customerLName,
                    'userEmail' => $customerEmail,
                    'userPhone' => $customerPhone,
                    'verificationLink' => $customerVerificationLink


                );

                Mail::send('emails.userVerification', $userVerificationEmailData ,function ($message) use ($userVerificationEmailData){
                    $message->from('mailtest2194@gmail.com', 'Watch Over Me');
                    $message->to($userVerificationEmailData['userEmail']);
                    $message->subject('Watcher Over Me - User Verification');
                });

            }

//            $msg = array(
//                'newService' => "New service created successfully",
//            );


            return redirect('/adminServices')->with('message', 'service created');

        } else {

            dd("Error!!. Service can't be created. Wearer already exist as wearer for another service");
        }

    }






    public function users(Request $request){

        $users = DB::table('users')
            ->paginate(2);

        $data = array(
            'users' => $users,
        );

        return view('adminUsers')->with($data);
    }

    public function searchUsers(Request $request){

        $searchText = $request->searchText;


        $users = DB::table('users')
            ->orwhere('person_id', 'like', '%'.$searchText.'%')
            ->orWhere('f_name', 'like', '%'.$searchText.'%')
            ->orWhere('l_name', 'like', '%'.$searchText.'%')
            ->orWhere('full_name', 'like', '%'.$searchText.'%')
            ->orWhere('email', 'like', '%'.$searchText.'%')
            ->orWhere('phone', 'like', '%'.$searchText.'%')
            ->orWhere('created_at', 'like', '%'.$searchText.'%')
            ->get();


        $data = array(
            'users' => $users,
        );

        return response()->json($users);

    }

    public function userDetails(Request $request){

        $userId = $request->id;

        $userDetails = DB::table('users')
            ->where('person_id', '=', $userId)
            ->get()->first();

        $serviceAsWearer = DB::table('services')
            ->join('users as wearer', 'wearer.person_id', '=', 'services.wearer_id')
            ->join('users as customer', 'customer.person_id', '=', 'services.customer_id')
            ->select('services.service_id', 'services.wearer_id', 'services.customer_id', 'services.wom_num', 'services.service_status', 'services.no_of_watchers', 'services.created_at',
                'wearer.person_id as wearerId', 'wearer.f_name as wearerFName', 'wearer.l_name as wearerLName', 'wearer.full_name as wearerFullName',
                'customer.person_id as customerId', 'customer.f_name as customerFName', 'customer.l_name as customerLName', 'customer.full_name as customerFullName')
            ->where('wearer.person_id', '=', $userId)
            ->get()->first();

        $serviceAsCustomer = DB::table('services')
            ->join('users as wearer', 'wearer.person_id', '=', 'services.wearer_id')
            ->join('users as customer', 'customer.person_id', '=', 'services.customer_id')
            ->select('services.service_id', 'services.wearer_id', 'services.customer_id', 'services.wom_num', 'services.service_status', 'services.no_of_watchers', 'services.created_at',
                'wearer.person_id as wearerId', 'wearer.f_name as wearerFName', 'wearer.l_name as wearerLName', 'wearer.full_name as wearerFullName',
                'customer.person_id as customerId', 'customer.f_name as customerFName', 'customer.l_name as customerLName', 'customer.full_name as customerFullName')
            ->where('customer.person_id', '=', $userId)
            ->orderBy('services.created_at', 'desc')
            ->get();

        $serviceAsWatcher = DB::table('services')
            ->join('watcher_relations', 'watcher_relations.svc_id', '=', 'services.service_id')
            ->join('users as wearer', 'wearer.person_id', '=', 'services.wearer_id')
            ->join('users as customer', 'customer.person_id', '=', 'services.customer_id')
            ->select('services.service_id', 'services.wearer_id', 'services.customer_id', 'services.wom_num', 'services.service_status', 'services.no_of_watchers', 'services.created_at',
                'wearer.person_id as wearerId', 'wearer.f_name as wearerFName', 'wearer.l_name as wearerLName', 'wearer.full_name as wearerFullName',
                'customer.person_id as customerId', 'customer.f_name as customerFName', 'customer.l_name as customerLName', 'customer.full_name as customerFullName')
            ->where('watcher_relations.watcher_id', '=', $userId)
            ->orderBy('services.created_at', 'desc')
            ->get();



        if ($serviceAsWearer == null){
            $countServiceAsWearer = 0;
        } else {
            $countServiceAsWearer = 1;
        }


        if ($serviceAsCustomer == null){
            $countServiceAsCustomer = 0;
        } else {
            $countServiceAsCustomer = count($serviceAsCustomer);
        }

        if ($serviceAsWatcher == null){
            $countServiceAsWatcher = 0;
        } else {
            $countServiceAsWatcher = count($serviceAsWatcher);
        }

        $data = array(
            'userDetails' => $userDetails,
            'serviceAsWearer' => $serviceAsWearer,
            'countServiceAsWearer' => $countServiceAsWearer,
            'serviceAsCustomer' => $serviceAsCustomer,
            'countServiceAsCustomer' => $countServiceAsCustomer,
            'serviceAsWatcher' => $serviceAsWatcher,
            'countServiceAsWatcher' => $countServiceAsWatcher
        );

        return view('adminUserDetails')->with($data);

    }


    public function applyLogFilters(Request $request){
        $serviceId = $request->serviceId;
        $logsType = $request->logsType;
        $lodsDate = $request->logsDate;

        if ($logsType == "All") {

        } else {

        }
    }

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

        return curl_exec($ch);

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
            "android" =>
                [
                "priority"=>"high"
                ]
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

        return curl_exec($ch);

    }

    public function trackWearer(Request $request){
        $serviceId = $request->serviceId;
        $userName = $request->userName;
        $userId = $request->userId;

        $result1 = $this->sendNotificationToWearer($serviceId, "Location".$userId, $userName." requested your location");

        $result = $this->sendDataNotificationToWearer($serviceId, "Location".$userId, $userName." requested your location");

        if ($result){
            return response()->json("success");

        } else {
            return response()->json("fail");

        }
    }

    public function alertLogDetails(Request $request){
        $logId = $request->logId;

        $logDetails = DB::table('logs')
            ->where('log_id', '=', $logId)
            ->get()->first();

        $logResponses = DB::table('help_me_responses')
            ->join('users as watcher', 'watcher.person_id', '=', 'help_me_responses.response_to')
            ->where('alert_log_id', '=', $logId)
            ->select('help_me_responses.alert_log_id', 'help_me_responses.response_from', 'help_me_responses.response_to', 'help_me_responses.send_text', 'help_me_responses.send_date', 'help_me_responses.send_time', 'help_me_responses.response_type',
                'help_me_responses.response_status', 'help_me_responses.reply_text', 'help_me_responses.reply_date', 'help_me_responses.reply_time', 'help_me_responses.response_link',
                'watcher.person_id', 'watcher.f_name', 'watcher.l_name', 'watcher.full_name',  'watcher.email', 'watcher.phone')
            ->orderBy('help_me_responses.created_at', 'asc')
            ->get();

        $data = array(
            'logDetails' => $logDetails,
            'logResponses' => $logResponses
        );

        return response()->json($data);

    }

    public function logHistory(Request $request){
        $serviceId = $request->serviceId;
        $date = $request->date;
        $type = $request->type;

        if($date == 'all'){
            $date = "";
        }

        if ($date != ''){
            $date = \DateTime::createFromFormat('d-m-Y', $date)->format('d F Y');
        }

        if ($type == 'all'){
            $type = "";
        } elseif ($type == 'alert'){
            $type = "Alert Log";
        } elseif ($type == 'hourly'){
            $type = "Hourly Log";
        }

        $serviceDetails = DB::table('services')
            ->where('service_id', '=', $serviceId)
            ->get()->first();

        $wearerId = $serviceDetails->wearer_id;

        $wearerDetails = DB::table('users')
            ->where('person_id', '=', $wearerId)
            ->select('person_id', 'f_name' , 'l_name', 'full_name', 'email', 'phone')
            ->get()->first();



        $logs = DB::table('logs')
            ->where('service_id', '=', $serviceId)
            ->where('log_date', 'like', '%'.$date.'%' )
            ->where('log_type', 'like', '%'.$type.'%' )
            ->orderBy('created_at', 'desc')
            ->paginate(10);


        $data = array(
            'serviceId' => $serviceId,
            'wearerDetails' => $wearerDetails,
            'serviceDetails' => $serviceDetails,
            'date' => $date,
            'type' => $type,
            'logs' => $logs
        );

        return view('adminLogHistory')->with($data);

    }

    public function getLastLocation(Request $request){

        $serviceId = $request->serviceId;
        $userName = $request->userName;
        $userId = $request->userId;

        $lastlog = DB::table('logs')
            ->where('service_id', '=', $serviceId)
            ->select('log_id','location_latitude','location_longitude','locality', 'log_date', 'log_time')
            ->orderBy('created_at', 'desc')
            ->get()->first();

        return response()->json($lastlog);


    }


}

