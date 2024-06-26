<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function user(Request $request) {
        return $request->user();
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'pseudo' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $request['password'] = Hash::make($request['password']);

        $info = $request->toArray();
        $info += [
            'avatar' => "https://api.dicebear.com/8.x/adventurer-neutral/svg?seed=". $request->pseudo ."&flip=true",
            'secret_key' => Str::random(40),
        ];
        
        $user = User::create($info);

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token];

        return response($response, 200);
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token, 'user' => $user];
                return response($response, 200);
            } 
            else {
                $response = "Password missmatch";
                return response($response, 422);
            }
        } 
        else {
            $response = 'User does not exist';
            return response($response, 422);
        }
    }

    public function logout (Request $request)
    {
        $token = $request->user()->token();
        $token->each(function($token, $key) {
            $token->delete();
        });

        $response = 'You have been succesfully logged out!';
        return response($response, 200);
    }
}
