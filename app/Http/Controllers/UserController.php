<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;

class UserController extends Controller
{
     public function das()
    {
        $countUser=Customer::count();
        return view('user.home.home',['countUser'=>$countUser]);
    }

     public function dasad()
    {
        $countUser=Customer::count();
        return view('user.home.home',['countUser'=>$countUser]);
    }
}
