<?php

namespace App\Http\Controllers\Auth;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
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
            // here we check if the user email is previously pesent and verified
            // so that we can give them to re register in case if the user 
            // does not verifies and delete the email or exits from the website 
            // during password entry
            'email' => 'required|email|max:255|unique:users,email,NULL,id,status,"'.User::VERIFIED.'"',
            'name' => 'required|max:255',
        ]);
    }

    /**
     * Validate the password for an incoming request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function passwordValidator(array $data)
    {
        return Validator::make($data, [
            // here we check if the user email is previously pesent and verified
            // so that we can give them to re register in case if the user 
            // does not verifies and delete the email or exits from the website 
            // during password entry
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

        // incase the user does not enter the password and exits, then 
        // we give give them to re register into the website, so 
        // a new email is sent for verification and the old token is regenerated
        if($user = User::where('email', '=', $data['email'])->first()){

            $user->verification_token = str_random(30);
            $user->status = User::NOT_VERIFIED;
            $user->save();

            return $user;
        }

        return User::create([
            'email' => $data['email'],
            'name' => $data['name'],
            'verification_token' => str_random(30)
        ]);
    }


    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        //validate the input from the user
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()
                    ->back()
                    ->withErrors($validator->errors());
        }

        if($user = $this->create($request->all())){

            \Mail::send('auth.emails.verify', ['user' => $user], function ($m) use ($user) {
                $m->from(env('MAIL_FROM'), env('MAIL_FROM_NAME'));
                $m->to($user->email)->subject('Please verify your account');
            });

            return redirect()
                    ->back()
                    ->with(['emailsent' => 'An E-mail has been sent, please verify the E-mail to continue the account registration']);
        }

        // other error 
        return redirect()
                ->back()
                ->with(['error' => 'An error occurred, please contact Admin']);
    }


    /**
     * verify the token from the url
     * @param  [type] $token [description]
     * @return [type]        [description]
     */
    public function verifyToken($token)
    {
        $user = User::where('verification_token', '=', $token)->where('status', '=', 'NV')->first();
        
        if($user) return $user;

        return view('auth.accountVerification')->with(['invalid_token' => 'Invalid Token']);

    }

    /**
     * verify the token and show the password entry form 
     * else if token is invalid show the user errors
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function verifyTokenAndShowConfirmationForm(Request $request, $token)
    {
        $this->verifyToken($token);
        return view('auth.accountVerification')->with(['token' => $token]);
    }

    /**
     * validate the token and password and then login the user
     * @param  Request $request [description]
     * @param  [type]  $token   [description]
     * @return [type]           [description]
     */
    public function completeUserRegistrationAndLogin(Request $request, $token)
    {
        $user = $this->verifyToken($token);
        
        //validate the input from the user
        $validator = $this->passwordValidator($request->all());

        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()
                    ->back()
                    ->withErrors($validator->errors());
        }

        $user->status = User::VERIFIED;
        $user->password = bcrypt($request->input('password'));
        $user->save();

        Auth::guard($this->getGuard())->login($user);
        
        return redirect($this->redirectPath());

    }

}
