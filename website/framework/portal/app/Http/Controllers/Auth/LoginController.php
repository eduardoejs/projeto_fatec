<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
{
    return view('auth.login');
}

    public function login(Request $request)
    {
        // Valida as informações recebidas pelo Request
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        $username = $request->email;
        $password = $request->password;
        // Checa a tentativa de login do usuário. Só será aceito, se além das informações estiverem corretas,
        // o status do usuário for true (1).
        if(\Auth::attempt(['email' => $username, 'password' => $password, 'ativo' => 'S'])){
            return redirect()->route('admin');
        } else {
            return redirect()->to('/login')
                    ->withErrors(['email' => 'Credenciais inválidas!'])
                    ->withInput(['email' => $username]);
        }
    }
    public function logout()
    {   
        Auth::guard('web')->logout(); 
        Auth::logout();
        Session::flush(); 
        return redirect(\URL::previous());
    } 
}
