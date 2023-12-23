<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Faker\Core\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class WebsiteController extends Controller
{

    public function Home()
    {
        // session::flush('cart');
        // dd(session::get('cart'));
        // return false;
        $customer_id = Session::get('customer_id');
        $CartItem = DB::table('cart')->where('customer_id', $customer_id)->count();

        $blog = DB::table('blogs')->get();
        $slider = DB::table('home__sliders')->get();
        $categories = DB::table('categories')->get();
        // $products = DB::table('products')->get();
        $products = DB::table('products')
        ->join('products__pricing', 'products.product_id', '=', 'products__pricing.product_id')
        ->join('brands', 'products.brand_id', '=', 'brands.brand_id')
        ->orderBy('products__pricing.sale_price', 'asc')
        ->limit(8)
        ->get();

        $productpricing = DB::table('products__pricing')->get();

        $NewArrivals = DB::table('products')
            ->where('products.product_status', '2')
            ->get();

        $Weekly = DB::table('products')
            ->where('products.product_status', '1')
            ->get();

        // dd($categories);
        // return false;

        foreach ($NewArrivals as $item) {
            $item->pricing = [];
            foreach ($productpricing as $price) {
                if ($item->product_id === $price->product_id) {
                    $item->pricing[] = $price;
                }
            }
        }
        // return $NewArrivals[1]->pricing[0]->mrp_price;
        return view('Website.Home', ['blogs' => $blog, 'categories' => $categories, 'sliders' => $slider, 'NewArrivals' => $NewArrivals, 'Weekly' => $Weekly, 'productpricing' => $productpricing, 'CartItem' => $CartItem, 'products' => $products]);
    }
    public function GetSalePrice(Request $req){

        $variation_id = $req->input('variation_id');

        $product_id = $req->input('product_id');

        $productPrice = DB::table('products__pricing')
        ->where('product_id', $product_id)
        ->where('variation_id', $variation_id)
        ->get();

        $attributeData = DB::table('products__attributes')
                            ->where('attribute_id', $productPrice[0]->attribute_id)
                            ->where('product_id', $product_id)->get();

        // dd($productPrice);
        // return false;

        return response()->json(['success' => true, 'productData' => $productPrice, 'attributeData' => $attributeData]);
    }


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

public function products($slugOrId, $id = null)
{
    $ids = is_numeric($slugOrId) ? intval($slugOrId) : $this->getCategoriesIds($slugOrId)->toArray();

    $products = DB::table('products')
        ->join('products__pricing', 'products.product_id', '=', 'products__pricing.product_id')
        ->join('brands', 'products.brand_id', '=', 'brands.brand_id')
        ->when(is_numeric($slugOrId), function ($query) use ($ids) {
            return $query->where('products.brand_id', $ids);
        }, function ($query) use ($ids) {
            return $query->whereIn('category_id', $ids);
        })
        ->orderBy('products__pricing.sale_price', 'asc')
        ->limit(8)
        ->get();

    // Fetch the category name for the first product
    $firstProductCategory = null;
    if (isset($products[0])) {
        $firstProductCategory = DB::table('categories')
            ->where('category_id', $products[0]->category_id)
            ->value('category_name');
    }
    $firstProductBrand = null;
    if (isset($products[0])) {
        $firstProductBrand = DB::table('brands')
            ->where('brand_id', $products[0]->brand_id)
            ->value('brand_name');
    }

    $categories = DB::table('categories')->get()->toArray();
    $categoryTree = $this->buildTree($categories);
    $categoriesData = DB::table('categories')->get();
    $brands = DB::table('brands')->get();

    return view('Website.Product', compact('products', 'firstProductCategory', 'categoryTree', 'categoriesData', 'brands', 'firstProductBrand'));
}




function getCategoriesIds($categorySlug, $subcategorySlug = null)
{
    $category = DB::table('categories')->where('slug', $categorySlug)->first();

    if (!empty($category)) {
        $ids = collect([$category->category_id]);

        if ($subcategorySlug) {
            $subcategory = DB::table('categories')
                ->where('parent_id', $category->category_id)
                ->where('slug', $subcategorySlug)
                ->first();

            if ($subcategory) {
                $ids->push($subcategory->category_id);

            }
        }

        return $ids;
    }

    return collect(); // Return an empty collection if no category found
}




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
        // dd($product->category_id);
        $categoryInfo = DB::table('categories as child')
        ->join('categories as parent', 'child.parent_id', '=', 'parent.category_id')
        ->where('child.category_id', $product->category_id)
        ->select('child.*', 'parent.category_name as parent_category_name', 'parent.slug as parent_category_slug')
        ->first();

        // dd($categoryInfo);
        $childCategories = DB::table('categories')
        ->where('parent_id', $categoryInfo->parent_id)
        ->get();
        // dd($childCategories);
        // dd($childCategories);
        // $result = [
        //     'categoryInfo' => $categoryInfo,
        //     'childCategories' => $childCategories,
        // ];

        // dd($result);

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
        // dd($product);
        // return false;
          return view('Website.ProductDtails', ['productdetail' => $product, 'relatedproduct' => $related, 'categoryInfo' => $categoryInfo,'childCategories' => $childCategories, ]);
    }
}
