<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login', [
            'title' => "Login"
        ]);
    }
    public function logout()
    {
        return redirect()->route('login');
    }
    public function login(Request $request){
        $response = Http::post('https://pds-api-example.000webhostapp.com/api/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);
        if($response['message']=='success'){
            session(['auth' => $response]);
            return redirect()->route('overview');
        }
        session()->flash('status', 'Gagal Masuk');
        return redirect()->route('login');
    }
}
