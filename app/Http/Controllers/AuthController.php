<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 15.02.2017
 * Time: 20:56
 */

namespace App\Http\Controllers;

use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
  public function signup(Request $request)
  {
    $newUser = new User([
      'name' => $request->name ?? '',
      'email' => $request->email ?? 'user@example.com'
    ]);
    $newUser->password = password_hash($request->password, PASSWORD_BCRYPT);
    $newUser->save();
    return new Response('ok', 200, ['Content-Type' => 'text/plain']);
  }

  public function login(Request $request)
  {
    $user = User::where('email', $request->email)->first();

    if (!is_null($user)) {
      if (password_verify($request->password, $user->password)) {
        $key = 'pawifjopawiejfpoaiwejfpoji';
        $token = [
          'iss' => 'http://jwt-test.dev.local',
          'name' => $user->name,
          'email' => $user->email,
          'admin' => $user->id === 2
        ];

        $jwt = JWT::encode($token, $key);

        return new Response($jwt, 200, ['Content-Type' => 'text/plain']);
      }
      return 'wrong password';
    }
    return 'user not found';
  }
}
