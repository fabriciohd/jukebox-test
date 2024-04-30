<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Requests\AuthLoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function register(AuthRegisterRequest $request) : JsonResponse
    {
        $data = $request->all();
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        
        User::create($data);
        $newUser = Auth::attempt([
            'email' => $data['email'],
            'password' => $request->password,
        ]);

        return  response()->json($newUser, 201);
    }

    public function login(AuthLoginRequest $request) : JsonResponse
    {
        $credenciais = [
            "email" =>  $request->get("email"),
            "password" =>  $request->get("password")
        ];

        if (Auth::attempt($credenciais)) {
            $user = Auth::user();

            if(!$user->active){
                throw ValidationException::withMessages(['credentials'=>'Acesso bloqueado!']);
            }

            return response()->json($user, 200);
        }

        throw ValidationException::withMessages(['error' => 'Email e/ou senha incorretos']);
    }

    public function logout() : JsonResponse
    {
        Auth::logout();

        return  response()->json([], 200);
    }

    public function verifyUserByEmail($email) : JsonResponse
    {
        return response()->json(User::where('email', $email)->exists());
    }

}
