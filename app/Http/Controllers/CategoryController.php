<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    // public function Category(Request $req, $categoryId = null)
    // {
    //     if($categoryId !== null){
    //         $Category_data = DB::table('categories')->where('parent_id', $categoryId)->get();
    //     }else{
    //         $Category_data = DB::table('categories')->where('parent_id', 0)->get();
    //    }
    //     return view('Admin.Category', ['data' => $Category_data]);
    // }
    public function Category(Request $req, $categoryId = null)
    {
        $parentCategoryData = DB::table('categories')->where('parent_id', 0)->get();
        $SelectedCategory = DB::table('categories')->where('category_id', $categoryId)->get();

        $subCategoryData = null;
        if ($categoryId !== null) {
            $subCategoryData = DB::table('categories')->where('parent_id', $categoryId)->get();
        }
        // dd('data', compact('parentCategoryData', 'subCategoryData'));
        return view('Admin.Category', [
            'parentData' => $parentCategoryData,
            'subData' => $subCategoryData,
            'SelectedCategory' => $SelectedCategory
        ]);
    }

    public function CategoryShow(Request $req, $categoryId = null)
    {
        // dd($categoryId);
        if ($categoryId !== null) {
            // Fetch subcategories when a category ID is provided
            $subCategoryData = DB::table('categories')->where('parent_id', $categoryId)->get();
            // dd('sub',$subCategoryData);
            return response()->json($subCategoryData);
        } else {
            // Fetch parent categories when no category ID is provided
            $CategoryData = DB::table('categories')->where('parent_id', 0)->get();
            // dd('par',$CategoryData);
            return response()->json($CategoryData);
        }
    }

    // public function CategoryShow(Request $req)
    // {
    //     // dd($req);
    //     $CategoryData = DB::table('categories')->where('parent_id', 0)->get();

    //     return response()->json($CategoryData);
    // }
    // public function SubCategoryShow($categoryId)
    // {
    //     $subCategoryData = DB::table('categories')->where('parent_id', $categoryId)->get();

    //     // return view('Admin.Category', compact('subCategoryData'));

    //     return response()->json($subCategoryData);
    // }
    public function SubCategoryShowMore($categoryId)
    {
        $subCategoryData = DB::table('categories')->where('parent_id', $categoryId)->get();
        // dd($subCategoryData);

        return response()->json($subCategoryData);
    }

    // public function fetchSubCategory($slug)
    // {
    //     $subCategories = DB::table('categories')->where('parent_id', function($query) use ($slug) {
    //         $query->select('category_id')->from('categories')->where('slug', $slug);
    //     })->get();

    //     return response()->json($subCategories);
    // }

    // public function CategoryShow()
    // {

    //     $CategoryData = DB::table('categories')->get();

    //     return response()->json($CategoryData);
    // }

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
