<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //tampilkan tampilan auth

    //tampilann login pendaftar
    public function authpendaftar() {
        return view("auth.login-pendaftar");
    }

    //tampilan login admin
    public function authadmin() {
        return view("auth.login-admin");
    }

    //store auth pendatar
    

    //store auth admin

}
