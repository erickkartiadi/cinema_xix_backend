<?php

namespace App\Http\Controllers;

use App\LoginToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request){
        $validation = Validator::make($request->all(),[
            'username' => 'required',
            'password' => 'required',
        ]);
        $token = bcrypt($request->username.$request->password);
        if(!$validation->fails()){
            if(Auth::attempt(['username'=>$request->username,'password'=>$request->password])){
                $user = Auth::user();
                $newToken = new LoginToken(['token'=>$token]);
                $user->token()->save($newToken);
                return response()->json(['token'=>$token,'role'=>$user->role],200);
            };
        }
        return response()->json(['message'=>'invalid login'],401);
    }

    public function logout(Request $request){
        LoginToken::where('token',$request->header('token'))->delete();
        return response()->json(['message'=>'logout success']);
    }
}
