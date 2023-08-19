<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class CategoryController extends Controller
{
    public function Category()
    {
        $Category_data = DB::table('categories')->get();
        return view('Admin.Category', ['data' => $Category_data]);
    }
    public function CategoryShow()
    {

        $CategoryData = DB::table('categories')->get();
        return response()->json($CategoryData);
    }

    public function CategoryStore(Request $req)
    {
        $Category_id = $req->input('category_id');
        $data = $req->input();
        unset($data['_token']);
        $validator = Validator::make($req->all(), [
            'category_name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(["validate" => true, "message" => $validator->errors()->all()[0]]);
        }

        $data['slug'] = strtolower(str_replace(" ", "-", $data['category_name']));

        try {
            $CategoryStore = DB::table('categories')->updateOrInsert(['category_id' => $Category_id], $data);
            return response()->json(["success" => true, "message" => true ? "Category Detail Create Successfully" : "Category Detail Updated Successfully"]);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "message" => "Oops an Error Ocurred", "err" => $th->getMessage()]);
        }
    }

    public function CategoryEdit(Request $req)
    {
        return response()->json(["data" => DB::table('categories')->where('category_id', $req->input('category_id'))->get()]);
    }

    public function CategoryRemove(Request $req)
    {
        if (DB::table('categories')->where('category_id', $req->input('category_id'))->delete()) {
            return response()->json(["success" => true, "message" => "Category Deleted Successfully"]);
        } else {
            return response()->json(["success" => false, "message" => "Category Remove Failed...!"]);
        }
    }
}
