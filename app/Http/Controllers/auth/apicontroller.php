<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
class apicontroller extends Controller
{
    public function register(request $request){
        $validator= validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);
if($validator->fails()){
    return response()->json(['error' => $validator->errors()], 400);

    }
        $data=$request->all();
        $data['password']=bcrypt($data['password']);
        $user=User::create($data);
    $response['token']=$user->createToken('myapp');
    $response['name']=$user->name;
    return response()->json(['response' => $response], 200);

}

    public function login(Request $request){
        if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])){
            $user=Auth::user();
            $response['token']=$user->createToken('myapp');
            $response['name']=$user->name;
            return response()->json(['response' => $response], 200);

        }else{
            return response()->json(['error' => "invalid "], 400);
        }

    }
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json(['message' => 'Successfully logged out']);
    }


    

   
}
