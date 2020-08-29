<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $userId = Auth::user()->person_id;

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

        return view('home')->with($data);

    }
}
