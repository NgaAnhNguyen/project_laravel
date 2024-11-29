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
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
class ProductController extends Controller
{

    public function detail_product($product_id, Request $request) {
            

        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $branch_product = DB::table('tbl_branch_product')->where('branch_status','1')->orderby('branch_id','desc')->get();

        $product_by_id = DB::table('tbl_product')->join('tbl_branch_product','tbl_product.branch_id','=','tbl_branch_product.branch_id')
        ->join('tbl_category_product','tbl_product.category_id','=','tbl_category_product.category_id')->where('tbl_product.product_id',$product_id)->get();
    
        foreach($product_by_id as $key => $product) {
            $category_id = $product->category_id;
        }
        
        $relate_product = DB::table('tbl_product')->join('tbl_branch_product','tbl_product.branch_id','=','tbl_branch_product.branch_id')
        ->join('tbl_category_product','tbl_product.category_id','=','tbl_category_product.category_id')
        ->where('tbl_product.category_id',$category_id)->whereNotIn('tbl_product.product_id',[$product_id])->get();
    
        foreach($product_by_id as $key => $val) {
            // seo meta
            $meta_title = $val->product_name;
           $meta_desc = $val->product_desc;
           $meta_keywords = isset($val->product_keywords) ? $val->product_keywords : 'Default keywords';
           $meta_canonical = $request->url();
           $image_og = url('/').'/upload/product/'.$val->product_image;
           // end seo meta
       }

        return view('pages.product.detail-product')->with('category_product',$cate_product)->with('branch_product',$branch_product)
        ->with('product_by_id',$product_by_id)
        ->with('relate_product',$relate_product)
        ->with('meta_title',$meta_title)
        ->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_canonical',$meta_canonical)
        ->with('image_og',$image_og);
    }

    // Hiển thị danh sách sản phẩm
    public function index()
    {
        $all_product = Product::with(['category', 'brand'])->paginate(10);
        return view('admin.all_product')->with('all_product', $all_product);
    }

    //Hiển thị một sản phẩm
    public function showProduct($id)
    {
        $product = Product::findOrFail($id);
        $category_product = Category::all();
        $branch_product = Brand::all();  
        return view('admin.detail_product', compact('product', 'category_product', 'branch_product'));
    }
        public function showAddProductForm() {
        $category_product = Category::all();
        $branch_product = Brand::all(); 
        return view('admin.add_product', compact('category_product', 'branch_product'));
    }
    
    

    // Hiển thị form thêm sản phẩm mới
    public function createProduct()
    {
        return view('admin.add_product');
    }

    // Lưu sản phẩm mới
    public function saveProduct(Request $request)
{
    $request->validate([
        'selectCategory' => 'required|integer',
        'selectBranch' => 'required|integer',
        'product_content' => 'required',
        'product_desc' => 'required',
        'product_name' => 'required',
        'product_price' => 'required',
        'product_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'product_status' => 'required|integer',
    ]);

    try {
        $product = new Product();
        $product->category_id = $request->selectCategory;
        $product->branch_id = $request->selectBranch;
        $product->product_content = $request->product_content;
        $product->product_desc = $request->product_desc;
        $product->product_name = $request->product_name;
        $product->product_price = $request->product_price;
        $product->product_status = $request->product_status;

        // Lưu hình ảnh
        if ($request->hasFile('product_image')) {
            $imagePath = $request->file('product_image')->store('upload/product', 'public'); // Lưu ảnh trong 'storage/app/public/upload/product'
            $product->product_image = $imagePath;
        }

        $product->created_at = Carbon::now();
        $product->updated_at = Carbon::now();
        $product->save();

        return redirect()->route('products.create')->with('message', 'Sản phẩm đã được thêm thành công!');
    } catch (\Exception $e) {
        Log::error('Error saving product: ' . $e->getMessage());
        return redirect()->route('products.create')->with('message', 'Không thể thêm sản phẩm mới!');
    }
}


    //cập nhật sản phẩm
    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $category_product = Category::all();
        $branch_product = Brand::all(); 
    
        return view('admin.edit_product', compact('product', 'category_product', 'branch_product'));
    }

    public function updateProduct(Request $request, $id)
{
    $request->validate([
        'category_id' => 'required|integer',
        'branch_id' => 'required|integer',
        'product_content' => 'required',
        'product_desc' => 'required',
        'product_name' => 'required',
        'product_price' => 'required',
        'product_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'product_status' => 'required|integer',
    ]);

    $product = Product::findOrFail($id);

    if ($request->hasFile('product_image')) {
        // Nếu có ảnh mới, xóa ảnh cũ (nếu có)
        if ($product->product_image) {
            $oldImagePath = public_path('storage/' . $product->product_image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        // Lưu ảnh mới vào thư mục 'public/upload/product' trong public storage
        $imagePath = $request->file('product_image')->store('upload/product', 'public'); // Lưu ảnh trong 'storage/app/public/upload/product'
        $product->product_image = $imagePath;  // Lưu đường dẫn ảnh mới vào cơ sở dữ liệu
    }

    $product->category_id = $request->input('category_id');
    $product->branch_id = $request->input('branch_id');
    $product->product_content = $request->input('product_content');
    $product->product_desc = $request->input('product_desc');
    $product->product_name = $request->input('product_name');
    $product->product_price = $request->input('product_price');
    $product->product_status = $request->input('product_status');

    $product->save();

    return redirect()->route('products.index')->with('message', 'Cập nhật thành công.');
}


    // Xóa sản phẩm
    public function deleteProduct($product_id)
    {
        $product = Product::findOrFail($product_id);
        $product->delete();

        return redirect()->route('products.index');
    }

    
    public function searchProduct(Request $request)
{
    $query = $request->input('query');

    $all_product = Product::where('product_name', 'LIKE', "%{$query}%")
        ->orWhereHas('brand', function ($q) use ($query) {
            $q->where('branch_name', 'LIKE', "%{$query}%");
        })
        ->orWhereHas('category', function ($q) use ($query) {
            $q->where('category_name', 'LIKE', "%{$query}%");
        })
        ->paginate(10);

    return view('admin.all_product')->with('all_product', $all_product);
}



}


