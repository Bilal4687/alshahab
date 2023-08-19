<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AttributeController extends Controller
{
    public function Attribute(){
        return view('Admin.Attribute');
    }
    public function AttributeShow()
    {
        $Attribute_Data = DB::table('attributes')->get();
        return response()->json($Attribute_Data);
    }
    public function AttributeStore(Request $req){

        $Attribute_id = $req->input('attribute_id');
        $data = $req->input();
        unset($data['_token']);

        $validator = Validator::make($req->all(),[
            'attribute_name' => 'required',
            'attribute_type' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(["validate" => true, "message" => $validator->errors()->all()[0]]);
        }

        try{
            $AttributeStore = DB::table('attributes')->updateOrInsert(['attribute_id' => $Attribute_id],$data);
            return response()->json(["success" => true, "message" => true ? "Attribute Detail Create Successfully" : "Attribute Detail Updated Successfully"]);
        }catch(\Throwable $th){
            return response()->json(["success" => false, "message" => "Opps An Error Occured", "err" => $th->getMessage()]);
        }
    }
    public function AttributeEdit(Request $req)
    {
        return response()->json(["data" => DB::table('attributes')->where('attribute_id',$req->input('attribute_id'))->get()]);
    }
    public function AttributeRemove(Request $req)
    {
        if(DB::table('attributes')->where('attribute_id',$req->input('attribute_id'))->delete()){
            return response()->json(["succes" => true, "message" => "Attributes Detail Remove Successfully"]);
        }else{
            return response()->json(["success" => false, "message" => "Opps An Error Occured"]);
        }

    }
}
