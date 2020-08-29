<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Dotenv\Exception\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout', 'userLogout');
    }

    protected function attemptLogin(Request $request)
    {
        return Auth::attempt(
            $this->credentials($request) + ["verification_status" => 'true'],
            $request->filled('remember')
        );
    }

    protected function sendFailedLoginResponse(Request $request)
    {

        $errors = [$this->username() => trans('auth.failed')];

        $user = DB::table('users')
            ->where('email', '=', $request->{$this->username()})
            ->get()->first();


        // Check if user was successfully loaded, that the password matches
        // and active is not 1. If so, override the default error message.
        if ($user && \Hash::check($request->password, $user->password) && $user->verification_status != 'true') {
            $errors = [$this->username() => 'Your account is not verified. <br>Please verify your email address to activate your account'];
        }

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

    public function userLogout(Request $request){

        Auth::guard('web')->logout();

        return redirect('/');

    }
}
