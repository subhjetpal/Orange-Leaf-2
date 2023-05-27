<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;


class UserController extends Controller
{
    function register(Request $req)
    {
        $user = User::where(['Username' => $req->username])->first();
    }
    function login(Request $req)
    {
        $user = User::where(['Username' => $req->username])->first();
        // return model_name::type_sql(['DB_field'=>$req->form_name])->first(); --- forst row of data based on where
        // return $req->input();
        // check password
        if ($user && Hash::check($req->password, $user->Password)) {
            $req->session()->put('user', $user);
            return redirect('/home');
        } else {
            $msg="user name or Password not matched";
            return Redirect::route('/login')->with('alert',$msg);
        }
    }
    function logout(Request $req)
    {
        if ($req->session()->has('user')) {
            session()->flush();
            return redirect('/index');
        } else {
            return redirect('/login');
        }
    }
}
