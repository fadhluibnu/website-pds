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
        // $token = session('auth');
        // $response = Http::withToken($token['token'])->get('https://pds-api-example.000webhostapp.com/api/logout');
        // if ($response['status'] == 200) {
        //     session()->forget(['auth']);
        //     return redirect()->route('login');
        // }
        session()->forget(['auth']);
        return redirect()->route('overview');
    }
    public function login(Request $request)
    {
        $response = Http::post('http://127.0.0.1:9009/api/login', [
            'name' => $request->name,
            'email' => $request->email,
        ]);
        $json = $response->json();
        // return $json['success'];
        if ($json["success"] == true) {
            $user = Http::get("http://127.0.0.1:9009/api/user/" . $request->email);
            $user = $user->json();
            session(['auth' => $user]);
            return redirect()->route('overview');
        }
        session()->flash('status', 'Gagal Masuk');
        return redirect()->route('login');
    }
}
