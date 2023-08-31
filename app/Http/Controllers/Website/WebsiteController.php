<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
class WebsiteController extends Controller
{

    public function SortProductByNumber(Request $req)
{
    $productsPerPage = $req->input('productsPerPage', 3);

    $sortBy = $req->input('sortBy', 'id'); // Default to sorting by product ID
    $sortDirection = $req->input('sortDirection', 'asc'); // Default to ascending order

    $product_data = DB::table('products')
        ->orderBy($sortBy, $sortDirection)
        ->take($productsPerPage)
        ->get();

    return response()->json(['success' => true, 'product' => $product_data]);
}

public function GetProducts(Request $req)
{
    $productsPerPage = $req->input('productsPerPage', 3);

    $products = DB::table('products')
    ->limit($productsPerPage)
    ->get();
    return view('Website.Product', ['products' => $products]);
}

public function ListView(Request $req){

    dd($req->all());
    return false;
    $ids = $this->getCategoriesIds($slug);

    dd($Ids);
    return false;

    // $productsPerPage = $req->input('productsPerPage', 3); // Default value is 3
    $categories = DB::table('categories')->get()->toArray();

    $categoryTree = $this->buildTree($categories);

    $products = DB::table('products')
        ->whereIn("category_id", $ids)
        ->limit(8)
        ->get();
    return view('Website.ListView');
}

public function Home()
{
        $customer_id = Session::get('id');
        $CartItem = DB::table('cart')->where('customer_id', $customer_id)->count();

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
        return view('Website.Home', ['blogs' => $blog, 'categories' => $categories, 'sliders' => $slider, 'NewArrivals' => $NewArrivals, 'Weekly' => $Weekly, 'productpricing' => $productpricing, 'CartItem' => $CartItem]);
}

public function products(Request $req, $slug)
{

        $ids = $this->getCategoriesIds($slug);

        // $productsPerPage = $req->input('productsPerPage', 3); // Default value is 3
        $categories = DB::table('categories')->get()->toArray();

        $categoryTree = $this->buildTree($categories);

        $products = DB::table('products')
            ->whereIn("category_id", $ids)
            ->limit(8)
            ->get();

        return view('Website.Product', ['products' => $products,'categoryTree' => $categoryTree]);
}

function getCategoriesIds($slug) {
    $category = DB::table('categories')->where('slug', $slug)->first();

    if (!empty($category)) {
        $categories = DB::table('categories')->where('parent_id', $category->category_id)->get();

        $ids = array();

        array_push($ids, $category->category_id);
        foreach ($categories as $cat) {
            array_push($ids, $cat->category_id);
        }

        return $ids;
    }

    return []; // Return an empty array if no category found
}



    // function getCategoriesIds($slug){

    //     $category = DB::table('categories')->where('slug', $slug)->get();
    //     $categories = DB::table('categories')->where('parent_id', $category[0]->category_id)->get();

    //     $ids = array();

    //     array_push($ids, $category[0]->category_id);
    //     foreach($categories as $cat){
    //         array_push($ids, $cat->category_id);
    //     }

    //     return $ids;
    // }

    function buildTree(array $elements, $parentId = 0) {
        $branch = array();

        foreach ($elements as $element) {
            if ($element->parent_id == $parentId) {
                $children = $this->buildTree($elements, $element->category_id); // Use $this->buildTree
                if ($children) {
                    $element->children = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }

    public function productdetails($productSlug){

        $product = DB::table('products')->where('product_slug', $productSlug)->first();



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
          return view('Website.ProductDtails', ['productdetail' => $product, 'relatedproduct' => $related]);
    }
}
