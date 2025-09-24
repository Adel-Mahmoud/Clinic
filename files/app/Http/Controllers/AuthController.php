<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Session;

class AuthController extends Controller
{
    public function user(Request $request)
    {
          $response = Http::post('http://192.168.1.219/agaza/api/check', [
              'phone' => '01091119111',
              'password' => '22222222222222',
          ]);
          if ($response->successful()) {
              dd([$response->json(),'function successful']);  
          } else {
              dd([
                  'status_code' => $response->status(),
                  'reason_phrase' => $response->reason(),
                  //'body' => $response->body()
              ]);
          }
    }
}

