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
        $token = session('auth');
        $response = Http::withToken($token['token'])->get('https://pds-api-example.000webhostapp.com/api/logout');
        if ($response['status'] == 200) {
            session()->forget(['auth']);
            return redirect()->route('login');
        }
        return redirect()->route('overview');
    }
    public function login(Request $request)
    {
        $response = Http::post('https://pds-api-example.000webhostapp.com/api/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);
        $json = $response->json();
        if ($json['message'] == 'success' & $json['status'] == 200) {
            session(['auth' => $json]);
            return redirect()->route('overview');
        }
        session()->flash('status', 'Gagal Masuk');
        return redirect()->route('login');
    }
}
