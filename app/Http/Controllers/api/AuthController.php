<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // using the traits we created
    use HttpResponse;



    public function register(StoreUserRequest $req){
        $req->validated($req->all());
        $user=User::create([
            'name'=>$req->name,
            'email'=>$req->email,
            'password'=>Hash::make($req->password)
        ]);
        return $this->success([
            'user'=>$user,
            'token'=>$user->createToken('API Token of' .$user->name)->plainTextToken
        ]);
    }

    public function login(LoginRequest $req){
        $req->validated($req->all());
        if(!Auth::attempt($req->only(['email','password']))){
            return $this->error('','Credential do not match',401);
        }
        $user=User::where("email",$req->email)->first();
        return $this->success([
            'user'=>$user,
            'token'=>$user->createToken('API Token of'.$user->name)->plainTextToken
        ]);

    }

    public function logout(){
        Auth::user()->currentAccessToken()->delete();
        return $this->success([
            'message'=>'You have successfully logged out and your token has been deleted'
        ]);
    }
}
