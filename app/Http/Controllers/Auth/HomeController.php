<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function RoleToHome(){
        if(Auth::user()->role == 1){
            return view('forms.admin.home');
        }
        elseif(Auth::user()->role == 2 ){
            return view('forms.teacher.home');
        }
        else{
            return redirect()->route('login');
        }
    }
}
