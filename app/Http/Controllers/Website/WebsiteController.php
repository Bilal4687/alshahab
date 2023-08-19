<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebsiteController extends Controller
{
    public function Home()
    {
        $blog = DB::table('blogs')->get();
        $slider = DB::table('home__sliders')->get();
        $categories = DB::table('categories')->get();
        $products = DB::table('products')->get();
        $productpricing = DB::table('products__pricing')->get();

        $NewArrivals = DB::table('products')
            ->where('products.product_status', '2')
            ->get();

        $Weekly = DB::table('products')
            ->where('products.product_status', '1')
            ->get();

        foreach ($NewArrivals as $item) {
            $item->pricing = [];
            foreach ($productpricing as $price) {
                if ($item->product_id === $price->product_id) {
                    $item->pricing[] = $price;
                }
            }
        }
        // return $NewArrivals[1]->pricing[0]->mrp_price;
        return view('Website.Home', ['blogs' => $blog, 'categories' => $categories, 'sliders' => $slider, 'NewArrivals' => $NewArrivals, 'Weekly' => $Weekly, 'productpricing' => $productpricing]);
    }

    public function products(Request $req, $slug)
    {
        $ids = $this->getCategoriesIds($slug);

        $products = DB::table('products')
        ->whereIn("category_id", $ids)->get();
        // return $product;
        return view('Website.Product', ['products' => $products]);
    }
    function getCategoriesIds($slug){
        $category = DB::table('categories')->where('slug', $slug)->get();
        $categories = DB::table('categories')->where('parent_id', $category[0]->category_id)->get();
        $ids = array();
        array_push($ids, $category[0]->category_id);
        foreach($categories as $cat){
            array_push($ids, $cat->category_id);
        }
        return $ids;
    }
    public function productdetails(Request $req, $slug)
    {
        $product = DB::table('products')->where('product_slug', $slug)->first();
        $productpricing = DB::table('products__pricing')->where('product_id', '=', $product->product_id)->get();
        $attributes = DB::table('products__attributes')->where('product_id', '=', $product->product_id)->get();
        $variations = DB::table('products__variations')->where('product_id', '=', $product->product_id)->get();
        $products__images = DB::table('products__images')->where('product_id', '=', $product->product_id)->get();

        $product->pricing = $productpricing;
        $product->attributes = $attributes;
        $product->variation = $variations;
        $product->images = $products__images;


        $related = DB::table('products')
            ->where('products.category_id', $product->category_id)
            ->get();

        foreach ($related as $item) {
            $item->pricing = [];
            foreach ($productpricing as $pricing) {
                if ($item->product_id == $pricing->product_id) {
                    $item->pricing[] = $pricing;
                }
            }
        }

        // return $product;
        return view('Website.ProductDtails', ['productdetail' => $product, 'relatedproduct' => $related]);
    }
}
