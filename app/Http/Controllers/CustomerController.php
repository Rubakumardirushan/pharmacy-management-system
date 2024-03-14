<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;
use Illuminate\Support\Facades\Gate;
class CustomerController extends Controller
{
    public function Addcustomer(Request $request)
    {
        if(Gate::allows('owner')){
        $validator= validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phonenumber' => 'required',
            'address' => 'required',
            'age' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 400);
        }
        try{  
            $data=$request->all();
            $customer=Customer::create($data);
            return response()->json(['response' => "customer added success"], 200);}
      catch(\Exception $e){
        return response()->json(['error' => "customer already exist"], 400);
      }

    }else{
        return response()->json(['error' => "unauthorized"], 400);
    }


    }

public function GetupdatecustomerView($email){

    if(Gate::allows('manager')){
$customer=Customer::where('email', $email)->first();
if(!$customer){return response()->json(['error' => "customer not found"], 400);}
return response()->json(['response' => $customer], 200);
    }
    else{
        return response()->json(['error' => "unauthorized"], 400);
    }

}


    public function Updatecustomer(Request $request ,$email)
    {
        if(Gate::allows('manager')){
        $validator= validator::make($request->all(), [
            'name' => 'required',
            'phonenumber' => 'required',
            'address' => 'required',
            'age' => 'required',
            'email' => 'required|email'
        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 400);
        }
        
        $data=$request->all();
        $customer=Customer::where('email', $email)->first();
        if(!$customer){return response()->json(['error' => "customer not found"], 400);}
        $customer->name=$data['name'];
        $customer->phonenumber=$data['phonenumber'];
        $customer->address=$data['address'];
        $customer->age=$data['age'];
        $customer->save();
        return response()->json(['response' => "customer updated success"], 200);
    }
    else{
        return response()->json(['error' => "unauthorized"], 400);}
        
    }
    







    public function Deletecustomer($email)
    {
        if(Gate::allows('manager')){
            $customer=Customer::where('email', $email)->first();
            if($customer){$customer->delete();
                return response()->json(['response' => "customer deleted success"], 200);}
            else{
                return response()->json(['error' => "customer not found"], 400);
            }
            
        }
        else{
            return response()->json(['error' => "unauthorized"], 400);
        }
    
        
    }
    
}
