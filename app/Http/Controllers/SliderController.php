<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Str;
use DB;

class SliderController extends Controller
{
    function Slider()
    {
        return view('Admin.Slider');
    }

    function SliderShow()
    {
        return response()->json(DB::table('home__sliders')->get());
    }

    function SliderStore(Request $req)
    {
        $id = $req->input('home_slider_id');
        $data = $req->input();
        $folder = 'public/Files/Home-Slider/';
        unset($data['_token']);
        $validator = Validator::make($req->all(), [
            'home_slider_title' =>  'required',
            'home_slider_description' => 'required|min:3|max:1000',
            'slider_image' => $id ? 'mimes:jpeg,jpg,png|max:2048' : 'required|image|mimes:jpeg,jpg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(["validate" => true, "message" => $validator->errors()->all()[0]]);
        }
        try {
            if ($req->hasFile('slider_image')) {
                $image = $req->file('slider_image');
                $data['home_slider_path'] = Str::random(20) . '.' . $image->getClientOriginalExtension();
                file_put_contents(base_path($folder . $data['home_slider_path']), file_get_contents($image));
                if ($id) {
                    $findImage = DB::table('home__sliders')->where('home_slider_id', $id)->first();
                    if (file_exists($folder.$findImage->home_slider_path) and !empty($findImage->home_slider_path)) {
                        unlink($folder.$findImage->home_slider_path);
                    }
                }
            } else {
                $old = DB::table('home__sliders')->where('home_slider_id', $id)->get();
                $data['home_slider_path'] = $old[0]->home_slider_path;
            }
            $Slider = DB::table('home__sliders')->updateOrInsert(['home_slider_id' => $id], $data);
            return response()->json(["success" => true, "message" => !$id ? "Slider Create Successfully" : "Slider Updated Successfully"]);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "message" => "Opps an Error Occured", "err" => $th->getMessage()]);
        }
    }
    public function SliderEdit(Request $req)
    {
        return response()->json(['data' => DB::table('home__sliders')->where('home_slider_id',$req->input('slider_id'))->get()]);
    }
    public function SliderDelete(Request $req)
    {
        $findImage = DB::table('home__sliders')->where('home_slider_id', $req->input('slider_id'))->first();

        // return $findImage;
        $folder = 'public/Files/Home-Slider/';
        if (file_exists($folder.$findImage->home_slider_path) and !empty($findImage->home_slider_path)) {
            unlink($folder.$findImage->home_slider_path);
        }
        if(DB::table('home__sliders')->where('home_slider_id',$req->input('slider_id'))->delete()){
            return response()->json(["succes" => true, "message" => "Slider Remove Successfully"]);
        }else{
            return response()->json(["success" => false, "message" => "Oops An Error Ocurred"]);
        }

    }
}
