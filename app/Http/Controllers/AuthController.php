<?php
 
namespace App\Http\Controllers;

use App\Models\ApiToken;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Register a new user
     * 
     * @return RedirectResponse
     */
    public function register(Request $request): RedirectResponse
    {
        $input = $request->all();

        Validator::make($input, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', Password::default()],
        ])->validate();


        $user = User::create([
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        Auth::login($user);
        
        return redirect('/quotes');
    }

    /**
     * Attempt user login
     * 
     * @return RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            return redirect()->intended('/quotes');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    
    /**
     * Logout current user
     * 
     * @return RedirectResponse
     */
    public function logOut(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
 
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Return token is user logged in
     *
     * @return JsonResponse
     */
    public function getToken(): JsonResponse
    {
        if (Auth::check()) {
            $token = ApiToken::generateToken();
            return response()->json(['token' => $token]);
        }
        
        return response()->json('Unauthorized', 401);
    }
}
