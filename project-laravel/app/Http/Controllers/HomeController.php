<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;


class HomeController extends Controller
{
   
    public function index()
    {   $category_product = Category::all();
        $branch_product = Brand::all();
        $products = Product::all();  // Retrieve products
        $meta_desc = "Welcome to our shop, where you can find a variety of products!";
        $meta_title = "Shop Homepage";
        $meta_keywords = "shop, products, online store, ecommerce";
        $meta_canonical = url()->current();  // Current URL for canonical link
        $image_og = "images/og-image.jpg";   // Example image path for Open Graph
    return view('pages.home', compact('meta_desc', 'meta_title', 'meta_keywords', 'meta_canonical', 'image_og','products','category_product','branch_product'));
    }
    public function search(Request $request) {
        

        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $branch_product = DB::table('tbl_branch_product')->where('branch_status','1')->orderby('branch_id','desc')->get();
       
        $keywords = $request->keywordsubmit;
        $search_product = DB::table('tbl_product')->where('product_name','like','%'.$keywords.'%')->get();
        // seo meta
        
        $meta_title = "Tìm '$keywords' trong N";
        $meta_desc = "Trang tìm kiếm sản phẩm của shop";
        $meta_keywords = "search .., tìm kiếm ..";
        $meta_canonical = $request->url();
        $image_og = "";

        // end seo meta
        return view('pages.product.search')->with('category_product',$cate_product)->with('branch_product',$branch_product)->with('search_product',$search_product)
        ->with('meta_title',$meta_title)
        ->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_canonical',$meta_canonical)
        ->with('image_og',$image_og);    
    }
}
