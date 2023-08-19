<?php

namespace App\Http\Controllers\Website\MyAccount;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyAccountController extends Controller
{
    public function Login(){
        return view('Website.Authentication.Login');
    }
}
