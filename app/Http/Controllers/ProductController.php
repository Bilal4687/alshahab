<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function GetChildrenCategory(Request $req)
    {
        $subcategories = DB::table('categories')->where('parent_id', $req->input('parentCategoryId'))->get();
        // Retur    n subcategories as JSON
        return response()->json($subcategories);
    }
    function Product()
    {
        return view('Admin.Product');
    }
    function ProductShow()
    {
        return response()->json(
            DB::table('products')->get()
        );
    }
    function ProductData($id)
    {
        $attribute = DB::table('attributes')->get();
        // $attributesData = DB::table('products__attributes')
        //     ->join('attributes', 'products__attributes.attribute_id', '=', 'attributes.attribute_id')
        //     ->where('product_id', $id)->get();

        $attributesData = DB::table('products__attributes')
            ->select('products__attributes.*', 'products__variations.*', 'attributes.*')
            ->leftJoin('products__variations', 'products__variations.product_variation_id', '=', 'products__attributes.variation_id')
            ->leftJoin('attributes', 'attributes.attribute_id', '=', 'products__attributes.attribute_id')
            ->where('products__attributes.product_id', $id)
            ->get();

            // dd($attributesData);
            // return false;

        $product = DB::table('products')->where('product_id', $id)->get();
        $variation = DB::table('variations')->get();
        $variationsData = DB::table('products__variations')
            ->leftjoin('variations', 'products__variations.variation_id', '=', 'variations.variation_id')
            ->leftjoin('products__pricing', 'products__variations.product_variation_id', '=', 'products__pricing.variation_id')
            ->where('products__variations.product_id', $id)->get();
        // return $variationsData;
        $imagesData = DB::table('products__images')
            ->where('product_id', $id)
            ->orderBy('product_image_id', 'DESC')
            ->get();
        // return $variationsData;
        return view('Admin.ProductData', [
            'id' => $id,
            'attributes' => $attribute, 'attributesData' => $attributesData,
            'variations' => $variation, 'variationsData' => $variationsData,
            'imagesData' => $imagesData, 'product' => $product
        ]);
    }
    function ProductStore(Request $req)
    {
        $id = $req->input('product_id');
        $data = $req->input();

        if (array_key_exists('category', $data)) {
            unset($data['category']);
        }

        $data['product_slug'] = str_replace(" ", "-", strtolower($data['product_name']));
        $folder = 'public/Files/Products/';
        unset($data['_token']);
        $validator = Validator::make($req->all(), [
            'product_name' =>  'required',
            'brand_id' =>  'required',
            'product_description' => 'required|min:3',
            'product_thumbnail' => $id ? 'mimes:jpeg,jpg,png|max:2048' : 'required|image|mimes:jpeg,jpg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(["validate" => true, "message" => $validator->errors()->all()[0]]);
        }

        try {
            if ($req->hasFile('product_thumbnail')) {
                $image = $req->file('product_thumbnail');
                $data['product_thumbnail'] = Str::random(20) . '.' . $image->getClientOriginalExtension();
                file_put_contents(base_path($folder . $data['product_thumbnail']), file_get_contents($image));
                if ($id) {
                    $findImage = DB::table('products')->where('product_id', $id)->first();
                    if (file_exists($folder . $findImage->slider_img) and !empty($findImage->slider_img)) {
                        unlink($folder . $findImage->slider_img);
                    }
                }
            } else {
                $old = DB::table('products')->where('product_id', $id)->get();
                $data['product_thumbnail'] = $old[0]->product_thumbnail;
            }
            $Product = DB::table('products')->updateOrInsert(['product_id' => $id], $data);
            return response()->json(["success" => true, "message" => !$id ? "Product Create Successfully" : "Product Updated Successfully"]);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "message" => "Opps an Error Occured", "err" => $th->getMessage()]);
        }
    }

    function UpdateProductThambnail(Request $req)
    {
        $data = DB::table('products')->where('product_id', $req->input('product_id'))->first();

        $sourceFilePath = base_path('public/Files/Products-Images/') . $req->input('thumbnail_path');
        $destinationFilePath = base_path('public/Files/Products/') . $req->input('thumbnail_path');
        // return $destinationFilePath;
        try {
            file_put_contents($destinationFilePath, file_get_contents($sourceFilePath));
            DB::table('products')->where('product_id', $req->input('product_id'))->update(['products.product_thumbnail' => $req->input('thumbnail_path')]);
            unlink(base_path('public/Files/Products/' . $data->product_thumbnail));
            return response()->json(["success" => true, "message" => "Thambnail Update Successfully"]);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "message" => "Thambnail Update Failed", "err" => $th->getMessage()]);
        }

        // return $req->input('product_id');
    }

    public function ProductEdit(Request $req)
    {
        return response()->json(['data' => DB::table('products')->where('product_id', $req->input('slider_id'))->get()]);
    }

    function ProductForm()
    {
        $brands = DB::table('brands')->get();
        $categories = DB::table('categories')->get();
        return view('Admin.ProductForm', ['brands' => $brands, 'categories' => $categories]);
    }
    function ProductAttributeAdd(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'product_id' => 'required',
            'attribute_id' => 'required',
            'variation_id' => 'required',
            'attribute_value' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => $validator->errors()->all()[0]]);
        }

        try {
            DB::table('products__attributes')->insert(
                [
                    'product_id' => $req->input('product_id'),
                    "attribute_id" => $req->input('attribute_id'),
                    "variation_id" => $req->input('variation_id'),
                    "attribute_value" => $req->input('attribute_value')
                ]
            );
            return response()->json(["success" => true, "message" => "Attribute Added Successfully"]);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "message" => "Opps an Error Occured", "err" => $th->getMessage()]);
        }
    }
    function ProductAttributeRemove(Request $req)
    {
        if (!$req->input('id')) {
            return response()->json(["success" => false, "message" => "Product Attribute Id is required"]);
        }
        try {
            DB::table('products__attributes')->where('product_attribute_id', $req->input('id'))->delete();;
            return response()->json(["success" => true, "message" => "Attribute Added Successfully"]);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "message" => "Opps an Error Occured", "err" => $th->getMessage()]);
        }
    }
    function ProductVariationAdd(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'product_id' => 'required',
            'variation_id' => 'required',
            'variation_value' => 'required',
            'sale_price' => 'required',
            'mrp_price' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(["validate" => true, "message" => $validator->errors()->all()[0]]);
        }
        try {

            $data = $req->input();
            // return $data;
            if ($data['sale_price'] > $data['mrp_price']) {
                return response()->json(["success" => false, "message" => "Sale Price need be to less than MRP Price"]);
            }

            $data['discount_percentage'] = (((int)$data['sale_price'] - (int)$data['mrp_price']) / (int)$data['sale_price']) * 100;

            DB::table('products__variations')->insert([
                'product_id' => $data['product_id'],
                'variation_id' => $data['variation_id'],
                'variation_value' => $data['variation_value']
            ]);
            $id = DB::getPdo()->lastInsertId();
            DB::table('products__pricing')->insert([
                'product_id' => $data['product_id'],
                'variation_id' => $id,
                'attribute_id' => 0,
                'sale_price' => $data['sale_price'],
                'mrp_price' => $data['mrp_price'],
                'discount_percentage' => $data['discount_percentage']
            ]);

            return response()->json(["success" => true, "message" => "Variation Added Successfully"]);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "message" => "Opps an Error Occured", "err" => $th->getMessage()]);
        }
    }
    function ProductVariationRemove(Request $req)
    {

        if (!$req->input('id')) {
            return response()->json(["success" => false, "message" => "Product Variation Id is required"]);
        }

        try {
            DB::table('products__variations')->where('product_variation_id', $req->input('id'))->delete();;
            DB::table('products__pricing')->where('variation_id', $req->input('id'))->delete();;
            return response()->json(["success" => true, "message" => "Variation Added Successfully"]);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "message" => "Opps an Error Occured", "err" => $th->getMessage()]);
        }
    }
    function ProductImageAdd(Request $req)
    {
        try {
            $data = $req->input();
            unset($data['_token']);
            $image = $req->file('product_image');
            $data['product_image_path'] = Str::random(20) . '.jpg';
            file_put_contents(base_path("public/Files/Products-Images/" . $data['product_image_path']), file_get_contents($image));
            DB::table('products__images')->insert($data);
            return response()->json(["success" => true, "message" => "Image Added Successfully"]);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "message" => "Opps an Error Occured", "err" => $th->getMessage()]);
        }
    }
    function ProductImageRemove(Request $req)
    {
        if (!$req->input('id')) {
            return response()->json(["success" => false, "message" => "Product Image Id is required"]);
        }
        try {
            DB::table('products__images')->where('product_image_id', $req->input('id'))->delete();;
            return response()->json(["success" => true, "message" => "Image Deleted Successfully"]);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "message" => "Opps an Error Occured", "err" => $th->getMessage()]);
        }
    }
}
