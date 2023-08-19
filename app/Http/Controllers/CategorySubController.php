<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategorySubController extends Controller
{
    public function CategorySub()
    {
        $category = DB::table('Categories')->get();
        return view('Admin.CategorySub', ['categories' => $category]);
    }

    public function CategorySubFetch()
    {
        $data = DB::table('categories__sub')
            ->leftJoin('Categories', 'Categories.category_id', '=', 'categories__sub.categories_sub_id')
            ->select('categories__sub.*', 'Categories.*')
            ->get();
        // return $data;
        return response()->json($data);
    }

    public function CategorySubStore(Request $req)
    {
        $category_sub = $req->input('categories_sub_id');
        $data = $req->input();
        unset($data['_token']);

        $validator = Validator::make($req->all(), [
            'categories_sub_name' => 'required',
            'category_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(["validate" => true, "message" => $validator->errors()->all()[0]]);
        }

        $data['categories_sub_slug'] = strtolower(str_replace(" ", "-", $data['categories_sub_name']));

        try {
            $categoryStore = DB::table('categories__sub')->updateOrInsert(['categories_sub_id' => $category_sub], $data);
            return response()->json(["success" => true, "message" => true ? "Category Detail Create Successfully" : "Category Detail Updated Successfully"]);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "message" => "Oops an Error Ocurred", "err" => $th->getMessage()]);
        }
    }

    public function CategorySubEdit(Request $req)
    {
        return response()->json(["data" => DB::table('categories__sub')->where('categories_sub_id', $req->input('categories_sub_id'))->get()]);
    }

    public function SubCategoryDelete(Request $req)
    {
        if (DB::table('categories__sub')->where('categories_sub_id', $req->input('categories_sub_id'))->delete()) {
            return response()->json(["success" => true, "message" => "Category Deleted Successfully"]);
        } else {
            return response()->json(["success" => false, "message" => "Category Remove Failed...!"]);
        }
    }
}
