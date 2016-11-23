<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegistered;
use App\Providers\AuthServiceProvider;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'verify']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $confirmation_code = str_random(30);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'confirmation_code' => $confirmation_code
        ]);
        
        event(new UserRegistered($user));
        return $user;
    }

    protected function verify(Request $request)
    {
        
        if($request->isMethod('get') && !$request->input('confirmation_code'))
            return view('auth.verify_account');

        $this->validate($request, [
            'confirmation_code' => 'required|max:30|alpha-num',
        ]);

        $code = $request->input('confirmation_code');
        $result = $this->confirm($code);

        if($result == true)
        {
            if(Auth::check()) return redirect('home')->with('message', 'Your account is now verified!');
            else return redirect('login')->with('message', 'Your account is now verified! Login and enjoy!');
        }
        else
        {
            return redirect('register/verify')->withErrors(['confirmation_code' => 'Invalid confirmation code']);
        }
    }

    protected function confirm($confirmation_code)
    {
        if( ! $confirmation_code)
        {
            return false;
        }

        $user = User::where('confirmation_code', $confirmation_code)->first();

        if ( ! $user)
        {
            return false;
        }
        else
        {
            $user->confirmed = 1;
            $user->confirmation_code = null;
            $user->save();

            return true;
        }
    }
}
