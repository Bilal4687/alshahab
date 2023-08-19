<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
{
    public function Discount(){
        return view('Admin.Discount');
    }
    public function DiscountShow()
    {
        $Discount_Data = DB::table('discounts')->get();
        return response()->json($Discount_Data);
    }
    public function DiscountStore(Request $req){

        $Discount_id = $req->input('discount_id');
        $data = $req->input();
        unset($data['_token']);

        $validator = Validator::make($req->all(),[
            'discount_coupon' => 'required',
            'discount_type' => 'required',
            'discount_value' => 'required',
            'discount_threshold' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(["validate" => true, "message" => $validator->errors()->all()[0]]);
        }

        try{
            $DiscountStore = DB::table('discounts')->updateOrInsert(['discount_id' => $Discount_id],$data);
            return response()->json(["success" => true, "message" => true ? "Discount Detail Create Successfully" : "Discount Detail Updated Successfully"]);
        }catch(\Throwable $th){
            return response()->json(["success" => false, "message" => "Oops An Error Ocurred", "err" => $th->getMessage()]);
        }
    }
    public function DiscountEdit(Request $req)
    {
        return response()->json(["data" => DB::table('discounts')->where('discount_id',$req->input('discount_id'))->get()]);
    }
    public function DiscountRemove(Request $req)
    {
        if(DB::table('discounts')->where('discount_id',$req->input('discount_id'))->delete()){
            return response()->json(["succes" => true, "message" => "Discounts Detail Remove Successfully"]);
        }else{
            return response()->json(["success" => false, "message" => "Oops An Error Ocurred"]);
        }

    }
}
