<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
     public function das()
    {
        $countUser=Auth::user()->customers()->count();
        return view('user.home.home',['countUser'=>$countUser]);
    }

     public function dasad()
    {
        $countUser=Customer::count();
        return view('admin.home.home',['countUser'=>$countUser]);
    }
}
