<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SecretController extends Controller
{
  public function index(Request $request)
  {
    return new Request('Hello ' . $request->user()->name,
      200, ['Content-Type', 'text/plain']);
  }

  public function pub()
  {
    return new Request('Hello World', 200, ['Content-Type', 'text/plain']);
  }
}
