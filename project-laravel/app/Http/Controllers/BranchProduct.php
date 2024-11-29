<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\Controller;
use Carbon\Carbon;

class BranchProduct extends Controller
{
    public function brand_by_id($brand_id, Request $request) 
    {
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $branch_product = DB::table('tbl_branch_product')->where('branch_status','1')->orderby('branch_id','desc')->get();

        $brand_by_id = DB::table('tbl_product')->join('tbl_branch_product','tbl_product.branch_id','=','tbl_branch_product.branch_id')
        ->where('tbl_branch_product.branch_id', $brand_id)->get();

        $brand_name = DB::table('tbl_branch_product')->where('branch_id', $brand_id)->limit(1)->get();

        foreach($brand_name as $key => $val) {
            // seo meta
            $meta_title = $val->branch_name;
            $meta_desc = $val->branch_desc;
            $meta_keywords = $val->branch_product_keywords ?? 'Default keyword';
            $meta_canonical = $request->url();
            $image_og = "";
            // end seo meta
        }

        return view('pages.brand.brand_by_id')->with([
            'category_product' => $cate_product,
            'branch_product' => $branch_product,
            'brand_by_id' => $brand_by_id,
            'brand_name' => $brand_name,
            'meta_title' => $meta_title,
            'meta_desc' => $meta_desc,
            'meta_keywords' => $meta_keywords,
            'meta_canonical' => $meta_canonical,
            'image_og' => $image_og
        ]);
    }

    // Hiển thị danh sách các thương hiệu
    public function index()
    {
        $all_branch_product = Brand::paginate(10);
        return view('admin.all_branch_product')->with('all_branch_product', $all_branch_product);
    }

    // Hiển thị form để thêm thương hiệu mới
    public function createBranch()
    {
        return view('admin.add_branch_product');
    }

    // Lưu thương hiệu mới vào cơ sở dữ liệu
    public function saveBranch(Request $request)
    {
        $request->validate([
            'branch_name' => 'required|string|max:255',
            'branch_desc' => 'required|string',
            'branch_product_keywords' => 'required|string',
            'branch_status' => 'required|integer',
        ]);

        try {
            $branch = new Brand();
            $branch->branch_name = $request->branch_name;
            $branch->branch_desc = $request->branch_desc;
            $branch->branch_product_keywords = $request->branch_product_keywords;
            $branch->branch_status = $request->branch_status;
            $branch->created_at = Carbon::now();
            $branch->updated_at = Carbon::now();
            $branch->save();

            return redirect()->route('branches.create')->with('message', 'Thương hiệu đã được thêm thành công!');
        } catch (\Exception $e) {
            return redirect()->route('branches.create')->with('message', 'Không thể thêm thương hiệu mới!');
        }
    }

    // Hiển thị form chỉnh sửa thương hiệu
    public function editBranch($branch_id)
    {
        $branch = Brand::findOrFail($branch_id);
        return view('admin.edit_branch_product', compact('branch'));
    }

    // Cập nhật thương hiệu
    public function updateBranch(Request $request, $branch_id)
    {
        $request->validate([
            'branch_name' => 'required|string|max:255',
            'branch_desc' => 'required|string',
            'branch_product_keywords' => 'required|string',
            'branch_status' => 'required|integer',
        ]);

        try {
            $branch = Brand::findOrFail($branch_id);
            $branch->update([
                'branch_name' => $request->branch_name,
                'branch_desc' => $request->branch_desc,
                'branch_product_keywords' => $request->branch_product_keywords,
                'branch_status' => $request->branch_status,
            ]);
            return redirect()->route('branches.edit', ['branch_id' => $branch_id])
                             ->with('message', 'Cập nhật thương hiệu thành công!');
        } catch (\Exception $e) {
            
            return redirect()->route('branches.edit', ['branch_id' => $branch_id])
                             ->with('message', 'Không thể cập nhật!');
        }
    }

    // Xóa thương hiệu
    public function deleteBranch($branch_id)
    {
        $brand = Brand::findOrFail($branch_id);
        $brand->delete();

        return redirect()->route('all-branch')->with('message', 'Xóa thương hiệu thành công!');
    }

    public function searchBranch(Request $request)
{
    $query = $request->input('query');

    // Tìm kiếm theo tên thương hiệu hoặc từ khóa thương hiệu
    $all_branch_product = Brand::where('branch_name', 'LIKE', "%{$query}%")
                    ->orWhere('branch_product_keywords', 'LIKE', "%{$query}%")
                    ->paginate(10);

    return view('admin.all_branch_product')->with('all_branch_product',$all_branch_product);
}

}
