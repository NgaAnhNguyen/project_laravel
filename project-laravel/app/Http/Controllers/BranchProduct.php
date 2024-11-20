<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\Login;
use App\Models\Social;
use App\Rules\Captcha;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Routing\Controller;
session_start();
class BranchProduct extends Controller
{
   
    public function brand_by_id($brand_id, Request $request) {
        

        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $branch_product = DB::table('tbl_branch_product')->where('branch_status','1')->orderby('branch_id','desc')->get();

        $brand_by_id = DB::table('tbl_product')->join('tbl_branch_product','tbl_product.branch_id','=','tbl_branch_product.branch_id')
        ->where('tbl_branch_product.branch_id', $brand_id)->get();


        $brand_name = DB::table('tbl_branch_product')->where('branch_id',$brand_id)->limit(1)->get();

        foreach($brand_name as $key => $val) {
            // seo meta
            $meta_title = $val->branch_name;
           $meta_desc = $val->branch_desc;
           $meta_keywords = $brand_name->branch_product_keywords ?? 'Default keyword';

           $meta_canonical = $request->url();
           $image_og = "";
           // end seo meta
       }

        return view('pages.brand.brand_by_id')->with('category_product',$cate_product)->with('branch_product',$branch_product)
        ->with('brand_by_id',$brand_by_id)->with('brand_name',$brand_name)
        ->with('meta_title',$meta_title)
        ->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_canonical',$meta_canonical)
        ->with('image_og',$image_og);
    }
}