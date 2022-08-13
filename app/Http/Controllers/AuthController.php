<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signup(Request $request){

//        $request->validate([
//            'email'=>'unique:users,email'.Auth::id(),
//        ]);

        $user = User::query()->create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone_number'=>$request->phone_number,
            'facebook_url'=>$request->facebook_url,
            'password'=>Hash::make($request->password),
        ]);

        $token = $user->createToken('user');
        $data['user']=$user;
        $data['type']='Bearer';
        $data['token']=$token->accessToken;

        return response()->json($data,200);
    }

    public function login(Request $request){
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)){
            throw new AuthenticationException();
        }

        $user = $request->user();


        $token=$user->createToken('user');

        $data['user']=$user;
        $data['type']='Bearer';
        $data['token']=$token->accessToken;

        return response()->json($data, 200);
    }
    public function logout(Request $request){
        $request->user()->token()->delete();
    }
    public function deleteUser(User $user){
        if ($user->id == Auth::id()) {
            $user->delete();
        }
    }
}
