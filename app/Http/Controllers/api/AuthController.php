<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
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
        return 'Login successful ';
    }

    public function logout(){
        return response()->json("This is my logout method");
    }
}
