<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/set-session', function (Request $request) {
    $remember = true;
    $request->session()->invalidate();
 
    $request->session()->regenerateToken();
    if(Auth::attempt(['email' => 'test@example.com', 'password' => '123456', ], $remember))
    {
        $request->session()->regenerate();
        //dd('done');
        //dd(Auth::check());
    }
    //Session::put('test_key', 'This is a test value');
    return 'Session value set';
});

Route::get('/get-session', function (Request $request) {
    //dd(Auth::check(), $request->user());
    //$value = Session::get('test_key', 'Default value');
    if (Auth::check())
        return "Session value: $value";
    return "Session value: false";
});

Route::get('/del-session', function (Request $request) {
    //dd(Auth::check(), $request->user());
    Auth::logout();
 
    //$request->session()->invalidate();
 
    //$request->session()->regenerateToken();
    return "Session value: out";
});