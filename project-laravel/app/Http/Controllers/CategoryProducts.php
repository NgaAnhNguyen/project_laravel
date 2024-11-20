<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

session_start();
class CategoryProducts extends Controller
{
    public function category_by_id(Request $request,$category_id,) {
       

        $cate_product = Category::orderBy('category_id','desc')->get();
        $branch_product = Brand::orderBy('branch_id','desc')->get();
        $category_by_id = Product::join('tbl_category_product','tbl_product.category_id','=','tbl_category_product.category_id')
        ->where('tbl_category_product.category_id', $category_id)->get();
        
       
        $category_name = Category::find($category_id)->limit(1)->get();
        
        foreach($category_name as $key => $val) {
             // seo meta
             $meta_title = $val->category_name;
            $meta_desc = $val->category_desc;
            $meta_keywords = $val->category_product_keywords;
            $meta_canonical = $request->url();
            $image_og = "";
            
            // end seo meta
        }
        return view('pages.category.category_by_id')->with('category_product',$cate_product)->with('branch_product',$branch_product)
        ->with('category_by_id',$category_by_id)->with('category_name',$category_name)
        ->with('meta_title',$meta_title)
        ->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_canonical',$meta_canonical)
        ->with('image_og',$image_og);
    }
}