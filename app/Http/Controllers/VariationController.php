<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VariationController extends Controller
{
    public function Variation()
    {
        return view('Admin.Variation');
    }

    public function VariationShow()
    {
        $data = DB::table('variations')->get();
        // dd($data);
        return response()->json($data);
    }


    public function VariationStore(Request $req)
    {
        $variation_id = $req->input('variation_id');
        $data = $req->input();
        unset($data['_token']);
        $validator = Validator::make($req->all(), [
            'variation_name' => 'required',
            'variation_description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(["validate" => true, "message" => $validator->errors()->all()[0]]);
        }

        try {
            $variation_store = DB::table('variations')->updateOrInsert(['variation_id' => $variation_id], $data);
            return response()->json(["success" => true, "message" => true ? "Variation Detail Create Successfully" : "Variation Detail Updated Successfully"]);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "message" => "Oops an Error Ocurred", "err" => $th->getMessage()]);
        }
    }

    public function VariationEdit(Request $req)
    {
        return response()->json(["data" => DB::table('variations')->where('variation_id', $req->input('variation_id'))->get()]);
    }

    public function VariationRemove(Request $req)
    {
        if (DB::table('variations')->where('variation_id', $req->input('variation_id'))->delete()) {
            return response()->json(['success' => true, 'message' => "variation Delete"]);
        } else {
            return response()->json(['success' => true, 'message' => "variation Delete failed"]);
        }
    }
}
