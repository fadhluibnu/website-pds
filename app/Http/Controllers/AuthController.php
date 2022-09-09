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
        session()->forget(['token']);
        return redirect()->route('overview');
    }
    public function login(Request $request)
    {
        // echo env("URL_API") . "login"
        $response = Http::post(env("URL_API_LOGIN"), [
            'id' => $request->id,
            'password' => $request->password,
        ]);
        $json = $response->json();
        // dd($json);
        // return $json;
        if ($json["success"] == true) {
            $user = Http::get(env("URL_API_GET_USER") . $request->id);
            $user = $user->json();
            session(['auth' => $user]);
            session(['token' => $json['token']]);
            return redirect()->route('overview');
        }
        session()->flash('status', 'Gagal Masuk');
        return redirect()->route('login');
    }
}
