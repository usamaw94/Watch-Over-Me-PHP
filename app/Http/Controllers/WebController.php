<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebController extends Controller
{

    public function helpMeRequest(Request $request){

        return view('helpMeRequest');
    }

}
