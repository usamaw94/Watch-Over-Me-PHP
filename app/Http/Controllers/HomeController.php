<?php

namespace App\Http\Controllers;

use App\User;
use App\WatcherRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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

        $userId = Auth::user()->person_id;

        $alertNotifications= DB::table('alert_notifications')
            ->where('watcher_id', '=', $userId)
            ->get();

        if($alertNotifications == null){
            $aNCount = 0;
        } else {
            $aNCount = $alertNotifications->count();
        }

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

//        dd($serviceAsWatcher);

        $data = array(
            'alertNotifications' => $alertNotifications,
            'aNCount' => $aNCount,
            'userDetails' => $userDetails,
            'serviceAsWearer' => $serviceAsWearer,
            'countServiceAsWearer' => $countServiceAsWearer,
            'serviceAsCustomer' => $serviceAsCustomer,
            'countServiceAsCustomer' => $countServiceAsCustomer,
            'serviceAsWatcher' => $serviceAsWatcher,
            'countServiceAsWatcher' => $countServiceAsWatcher
        );

        return view('home')->with($data);

    }

    public function personDetails(Request $request){

        $id =  $request->personId;

        $personDetails = DB::table('users')->where('person_id', '=', $id)
            ->select('person_id', 'full_name', 'email', 'phone', 'verification_status')
            ->get()->first();

        return response()->json($personDetails);

    }

    public function getWatchersList(Request $request){

        $serviceId = $request->serviceId;

        $watcherDetails = DB::table('users')
            ->join('watcher_relations', 'watcher_relations.watcher_id', '=', 'users.person_id')
            ->where('watcher_relations.svc_id', '=', $serviceId)
            ->orderBy('watcher_relations.priority_num', 'asc')
            ->select('users.person_id', 'users.full_name', 'users.email', 'users.phone', 'users.verification_status',
                'watcher_relations.priority_num')
            ->get();

        return response()->json($watcherDetails);
    }

    public function userAsWatcherService(Request $request){

        $userId = Auth::user()->person_id;

        $serviceId = $request->id;

        $alertNotifications= DB::table('alert_notifications')
            ->where('watcher_id', '=', $userId)
            ->get();

        if($alertNotifications == null){
            $aNCount = 0;
        } else {
            $aNCount = $alertNotifications->count();
        }

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
            ->select('users.person_id', 'users.full_name', 'users.email', 'users.phone', 'users.verification_status',
                'watcher_relations.priority_num', 'watcher_relations.watcher_status')
            ->get();


        $data = array(
            'alertNotifications' => $alertNotifications,
            'aNCount' => $aNCount,
            'serviceDetails' => $serviceDetails,
            'wearerDetails' => $wearerDetails,
            'customerDetails' => $customerDetails,
            'watchersList' => $watchersList,
        );

        return view('userAsWatcherService')->with($data);


    }

    public function userAsCustomerService(Request $request){

        $userId = Auth::user()->person_id;

        $serviceId = $request->id;

        $alertNotifications= DB::table('alert_notifications')
            ->where('watcher_id', '=', $userId)
            ->get();

        if($alertNotifications == null){
            $aNCount = 0;
        } else {
            $aNCount = $alertNotifications->count();
        }

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
            ->select('users.person_id', 'users.full_name', 'users.email', 'users.phone', 'users.verification_status',
                'watcher_relations.priority_num', 'watcher_relations.watcher_status')
            ->get();


        $data = array(
            'alertNotifications' => $alertNotifications,
            'aNCount' => $aNCount,
            'serviceDetails' => $serviceDetails,
            'wearerDetails' => $wearerDetails,
            'customerDetails' => $customerDetails,
            'watchersList' => $watchersList,
        );

        return view('userAsCustomerService')->with($data);

    }

    public function userAsWearer(){

        $wearerId = Auth::user()->person_id;
        $serviceExist = false;

        $alertNotifications= DB::table('alert_notifications')
            ->where('watcher_id', '=', $wearerId)
            ->get();

        if($alertNotifications == null){
            $aNCount = 0;
        } else {
            $aNCount = $alertNotifications->count();
        }

        $serviceDetails = DB::table('services')
            ->where('wearer_id', '=', $wearerId)
            ->get()->first();


        if ($serviceDetails != null){

            $serviceExist = true;

            $serviceId = $serviceDetails->service_id;
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
                ->select('users.person_id', 'users.f_name', 'users.l_name', 'users.full_name' ,'users.email', 'users.phone', 'users.verification_status',
                    'watcher_relations.priority_num', 'watcher_relations.watcher_status')
                ->get();

            $data = array(
                'serviceExist' => $serviceExist,
                'alertNotifications' => $alertNotifications,
                'aNCount' => $aNCount,
                'serviceDetails' => $serviceDetails,
                'wearerDetails' => $wearerDetails,
                'customerDetails' => $customerDetails,
                'watchersList' => $watchersList,
            );

        } else {

            $serviceExist = false;

            $data = array(
                'serviceExist' => $serviceExist,
                'alertNotifications' => $alertNotifications,
                'aNCount' => $aNCount,

            );

        }

        return view('userAsWearer')->with($data);
    }

    public function userAsWatcher(){

        $userId = Auth::user()->person_id;

        $alertNotifications= DB::table('alert_notifications')
            ->where('watcher_id', '=', $userId)
            ->get();

        if($alertNotifications == null){
            $aNCount = 0;
        } else {
            $aNCount = $alertNotifications->count();
        }

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

        if ($serviceAsWatcher == null){
            $countServiceAsWatcher = 0;
        } else {
            $countServiceAsWatcher = count($serviceAsWatcher);
        }

//        dd($serviceAsWatcher);

        $data = array(
            'alertNotifications' => $alertNotifications,
            'aNCount' => $aNCount,
            'serviceAsWatcher' => $serviceAsWatcher,
            'countServiceAsWatcher' => $countServiceAsWatcher
        );

        return view('userAsWatcher')->with($data);

    }

    public function userAsCustomer(){

        $userId = Auth::user()->person_id;

        $alertNotifications= DB::table('alert_notifications')
            ->where('watcher_id', '=', $userId)
            ->get();

        if($alertNotifications == null){
            $aNCount = 0;
        } else {
            $aNCount = $alertNotifications->count();
        }

        $serviceAsCustomer = DB::table('services')
            ->join('users as wearer', 'wearer.person_id', '=', 'services.wearer_id')
            ->join('users as customer', 'customer.person_id', '=', 'services.customer_id')
            ->select('services.service_id', 'services.wearer_id', 'services.customer_id', 'services.wom_num', 'services.service_status', 'services.no_of_watchers', 'services.created_at',
                'wearer.person_id as wearerId', 'wearer.f_name as wearerFName', 'wearer.l_name as wearerLName', 'wearer.full_name as wearerFullName',
                'customer.person_id as customerId', 'customer.f_name as customerFName', 'customer.l_name as customerLName', 'customer.full_name as customerFullName')
            ->where('customer.person_id', '=', $userId)
            ->orderBy('services.created_at', 'desc')
            ->get();

        if ($serviceAsCustomer == null){
            $countServiceAsCustomer = 0;
        } else {
            $countServiceAsCustomer = count($serviceAsCustomer);
        }


//        dd($serviceAsCustomer);

        $data = array(
            'alertNotifications' => $alertNotifications,
            'aNCount' => $aNCount,
            'serviceAsCustomer' => $serviceAsCustomer,
            'countServiceAsCustomer' => $countServiceAsCustomer
        );

        return view('userAsCustomer')->with($data);

    }

    public function verifyServiceWatcherPhone(Request $request){
        $watcherNum = $request->watcherNum;
        $serviceId = $request->serviceId;

        if(DB::table('users')->where('phone', '=', $watcherNum)->exists()) {

            $personDetails = DB::table('users')->where('phone', '=', $watcherNum)->get()->first();

            $watcherId = $personDetails->person_id;

            if(DB::table('services')->where('wearer_id', '=', $watcherId)->where('service_id','=',$serviceId)->exists()) {

                $watcherType = "";
                $existStatus = "wearer";

            } elseif (DB::table('watcher_relations')->where('watcher_id', '=', $watcherId)->where('svc_id','=',$serviceId)->exists()){
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

    public function addNewWatcher(Request $request){

        $serviceId = $request->serviceId;
        $watcherPhone = $request->watcherStorePhone;
        $watcherId = $request->watcherId;
        $watcherEmail = $request->watcherEmail;
        $watcherNewEmail = $request->watcherNewEmail;
        $watcherFirstName = $request->watcherFirstName;
        $watcherLastName = $request->watcherLastName;
        $watcherType = $request->watcherType;

        if($watcherId == null){

            $dbName = 'uawdevst_watchoverme';
            $tableNameUser = 'users';

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
            $wT->email = $watcherNewEmail;
            $wT->phone = $watcherPhone;
            $wT->verification_code = $watcherCode;
            $wT->verification_status = 'false';
            $wT->password = bcrypt("womperson");
            $wTSaved = $wT->save();

            $watcherVerificationLink = "http://127.0.0.1:8000/userVerification/".$autoIncUser.$watcherCode;

            $userVerificationEmailData = array(

                'serviceId' => $serviceId,

                'userId' => $watcherId,
                'userFName' => $watcherFirstName,
                'userLName' => $watcherLastName,
                'userFullName' => $watcherFirstName. " " .$watcherLastName,
                'userEmail' => $watcherNewEmail,
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


    public function wearerServiceLogs(Request $request){

        $userId = Auth::user()->person_id;

        $alertNotifications= DB::table('alert_notifications')
            ->where('watcher_id', '=', $userId)
            ->get();

        if($alertNotifications == null){
            $aNCount = 0;
        } else {
            $aNCount = $alertNotifications->count();
        }

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
            'alertNotifications' => $alertNotifications,
            'aNCount' => $aNCount,
            'wearerDetails' => $wearerDetails,
            'serviceDetails' => $serviceDetails,
            'logs' => $logs
        );


        return view('wearerServiceLogs')->with($data);

    }


    public function watcherServiceLogs(Request $request){

        $userId = Auth::user()->person_id;

        $alertNotifications= DB::table('alert_notifications')
            ->where('watcher_id', '=', $userId)
            ->get();

        if($alertNotifications == null){
            $aNCount = 0;
        } else {
            $aNCount = $alertNotifications->count();
        }

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
            'alertNotifications' => $alertNotifications,
            'aNCount' => $aNCount,
            'wearerDetails' => $wearerDetails,
            'serviceDetails' => $serviceDetails,
            'logs' => $logs
        );


        return view('watcherServiceLogs')->with($data);

    }

    public function customerServiceLogs(Request $request){

        $userId = Auth::user()->person_id;

        $alertNotifications= DB::table('alert_notifications')
            ->where('watcher_id', '=', $userId)
            ->get();

        if($alertNotifications == null){
            $aNCount = 0;
        } else {
            $aNCount = $alertNotifications->count();
        }

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
            'alertNotifications' => $alertNotifications,
            'aNCount' => $aNCount,
            'wearerDetails' => $wearerDetails,
            'serviceDetails' => $serviceDetails,
            'logs' => $logs
        );


        return view('customerServiceLogs')->with($data);

    }

    public function wearerServiceLogHistory(Request $request){

        $serviceId = $request->serviceId;
        $date = $request->date;
        $type = $request->type;

        $userId = Auth::user()->person_id;

        $alertNotifications= DB::table('alert_notifications')
            ->where('watcher_id', '=', $userId)
            ->get();

        if($alertNotifications == null){
            $aNCount = 0;
        } else {
            $aNCount = $alertNotifications->count();
        }



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
            'alertNotifications' => $alertNotifications,
            'aNCount' => $aNCount,
            'serviceId' => $serviceId,
            'wearerDetails' => $wearerDetails,
            'serviceDetails' => $serviceDetails,
            'date' => $date,
            'type' => $type,
            'logs' => $logs
        );

        return view('wearerServiceLogHistory')->with($data);


    }

    public function watcherServiceLogHistory(Request $request){

        $serviceId = $request->serviceId;
        $date = $request->date;
        $type = $request->type;

        $userId = Auth::user()->person_id;

        $alertNotifications= DB::table('alert_notifications')
            ->where('watcher_id', '=', $userId)
            ->get();

        if($alertNotifications == null){
            $aNCount = 0;
        } else {
            $aNCount = $alertNotifications->count();
        }



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
            'alertNotifications' => $alertNotifications,
            'aNCount' => $aNCount,
            'serviceId' => $serviceId,
            'wearerDetails' => $wearerDetails,
            'serviceDetails' => $serviceDetails,
            'date' => $date,
            'type' => $type,
            'logs' => $logs
        );

        return view('watcherServiceLogHistory')->with($data);


    }

    public function customerServiceLogHistory(Request $request){

        $serviceId = $request->serviceId;
        $date = $request->date;
        $type = $request->type;

        $userId = Auth::user()->person_id;

        $alertNotifications= DB::table('alert_notifications')
            ->where('watcher_id', '=', $userId)
            ->get();

        if($alertNotifications == null){
            $aNCount = 0;
        } else {
            $aNCount = $alertNotifications->count();
        }



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
            'alertNotifications' => $alertNotifications,
            'aNCount' => $aNCount,
            'serviceId' => $serviceId,
            'wearerDetails' => $wearerDetails,
            'serviceDetails' => $serviceDetails,
            'date' => $date,
            'type' => $type,
            'logs' => $logs
        );

        return view('customerServiceLogHistory')->with($data);


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
