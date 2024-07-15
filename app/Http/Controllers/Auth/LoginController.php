<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index(){
        
       // dd(Hash::make('123123123'));

       if(!empty(Auth::check())){
        return redirect()->route('admin.home');
       }
       return view('login');
    }

    public function login(Request $request){
        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])){

            if(Auth::user()->role == 1)
            {
                return redirect()->route('admin.home');
            }
            elseif(Auth::user()->role == 2)
            {
                return redirect()->route('teacher.home');
            }       
        }
        else{
            return redirect()->back()->withErrors('Invalidate email and password');
        }
        
    }

    public function logout(){
        Auth::logout();

        return redirect()->route('login');
    }
}
