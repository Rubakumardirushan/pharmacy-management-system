<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\Inventory;
use Illuminate\Support\Facades\Validator;
class InventoryController extends Controller
{
    public function Additems(Request $request){
        if(Gate::allows('owner')){
$validators=validator::make($request->all(), [
'name' => 'required',
'price' => 'required',
'quantity' => 'required',
'description' => 'required',
'expiry_date' => 'required'


]);

if($validators->fails()){
    return response()->json(['error' => $validators->errors()], 400);
}
try{$data=$request->all();
    $inventory=Inventory::create($data);
    return response()->json(['response' => "item added success"], 200);}
    catch(\Exception $e){
        return response()->json(['error' => "Item already exist"], 400);
      }
    }
    else{
        return response()->json(['error' => "unauthorized"], 400);
    }
    }



    public function GetEdititems($name){
        if(Gate::allows('cashier')){
        $inventory=Inventory::where('name', $name)->first();
        if(!$inventory){return response()->json(['error' => "item not found"], 400);}
        return response()->json(['response' => $inventory], 200);
    }
    else{
        return response()->json(['error' => "unauthorized"], 400);

    }}

    public function Edititems(Request $request ,$name){
        if(Gate::allows('cashier')){
        $validators=validator::make($request->all(), [
            'price' => 'required',
            'quantity' => 'required',
            'description' => 'required',
            'expiry_date' => 'required'
        ]);
        
        if($validators->fails()){
            return response()->json(['error' => $validators->errors()], 400);
        }
        
            $data=$request->all();
            $inventory=Inventory::where('name', $name)->first();
            if(!$inventory){return response()->json(['error' => "item not found"], 400);}
            $inventory->price=$data['price'];
            $inventory->quantity=$data['quantity'];
            $inventory->description=$data['description'];
            $inventory->expiry_date=$data['expiry_date'];
            $inventory->save();
            return response()->json(['response' => "item updated success"], 200);
    }
    else{
        return response()->json(['error' => "unauthorized"], 400);}

    }

    
    public function Removeitems($name){
        if(Gate::allows('cashier')){
            $inventory=Inventory::where('name', $name)->first();
            if(!$inventory){return response()->json(['error' => "item not found"], 400);}
            $inventory->delete();
            return response()->json(['response' => "item removed success"], 200);
        

    } else{
        return response()->json(['error' => "unauthorized"], 400);
    }

}



}
