<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function Brand(){
        return view('Admin.Brand');
    }

    public function BrandShow(){
        $brands_Data = DB::table('brands')->get();
        return response()->json($brands_Data);
    }

    public function BrandStore(Request $req){
        // dd($req);
        $brand_id = $req->input('brand_id');
        $data = $req->input();
        $folder = 'public/Files/Brands/';
        unset($data['_token']);

        $validator = Validator::make($req->all(),[
            'brand_name' => 'required',
            'brand_image' => $brand_id ? 'mimes:jpeg,jpg,png|max:2048' : 'required|image|mimes:jpeg,jpg,png|max:2048',
            'lang' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(["validate" => true, "message" => $validator->errors()->all()[0]]);
        }

        // try{

            if ($req->hasFile('brand_image')) {
                $image = $req->file('brand_image');
                $data['brand_image'] = Str::random(20) . '.' . $image->getClientOriginalExtension();
                file_put_contents(base_path($folder . $data['brand_image']), file_get_contents($image));
                if ($brand_id) {
                    $findImage = DB::table('brands')->where('brand_id', $brand_id)->first();
                    if (file_exists($folder.$findImage->brand_image) and !empty($findImage->brand_image)) {
                        unlink($folder.$findImage->brand_image);
                    }
                }
            } else {
                $old = DB::table('brands')->where('brand_id', $brand_id)->get();
                $data['brand_image'] = $old[0]->brand_image;
            }

            $BrandStore = DB::table('brands')->updateOrInsert(['brand_id' => $brand_id],$data);
            return response()->json(["success" => true, "message" => true ? "Brand Detail Create Successfully" : "Brand Detail Updated Successfully"]);
        // }catch(\Throwable $th){
        //     return response()->json(["success" => false, "message" => "Opps An Error Occured", "err" => $th->getMessage()]);
        // }
    }

    public function BrandEdit(Request $req)
    {
        return response()->json(["data" => DB::table('brands')->where('brand_id',$req->input('brand_id'))->get()]);
    }

    public function BrandRemove(Request $req)
    {
        if(DB::table('brands')->where('brand_id',$req->input('brand_id'))->delete()){
            return response()->json(["succes" => true, "message" => "Brand Detail Remove Successfully"]);
        }else{
            return response()->json(["success" => false, "message" => "Opps An Error Occured"]);
        }

    }
}
