<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function __construct()
    {
        // Bắt buộc người dùng phải đăng nhập để sử dụng các chức năng trong CartController
        $this->middleware('auth');
    }

    public function save_cart(Request $request)
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem giỏ hàng.');
        }

        // Xác thực dữ liệu yêu cầu
        $validatedData = $request->validate([
            'productID' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $validatedData['productID'];
        $quantity = $validatedData['quantity']; // Lấy số lượng từ dữ liệu đã xác thực
        $product = DB::table('tbl_product')->where('product_id', $productId)->first();

        if (!$product) {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại!');
        }

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $cartItem = Cart::get($productId);

        if ($cartItem) {
            // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng
            Cart::update($productId, [
                'qty' => $cartItem->quantity + $quantity
            ]);
        } else {
            // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới
            $data = [
                'id' => $productId,
                'qty' => $quantity,
                'name' => $product->product_name,
                'price' => $product->product_price,
                'weight' => $product->product_price, // Trọng lượng tạm thời
                'options' => ['image' => $product->product_image],
            ];

            Cart::add($data);
        }

        return Redirect::to('view-cart')->with('message', 'Sản phẩm đã được thêm vào giỏ hàng');
    }   
    

    public function view_cart(Request $request)
    {
        $meta_title = "Thông tin giỏ hàng";
        $meta_desc = "Trang Thông tin giỏ hàng của bạn";
        $meta_keywords = "giỏ hàng xwatch247, xwatch247 cart";
        $meta_canonical = $request->url();
        $image_og = "";

        $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get();
        $branch_product = DB::table('tbl_branch_product')->where('branch_status', '1')->orderby('branch_id', 'desc')->get();
        return view('pages.cart.view_cart')->with('category_product', $cate_product)->with('branch_product', $branch_product)
            ->with('meta_title', $meta_title)
            ->with('meta_desc', $meta_desc)
            ->with('meta_keywords', $meta_keywords)
            ->with('meta_canonical', $meta_canonical)
            ->with('image_og', $image_og);
    }
    
    public function delete_row_cart($rowId)
    {
        Cart::update($rowId, 0);
        return Redirect::to('/view-cart');
    }

    public function update_cart_quanlity(Request $request)
    {
        $rowId = $request->rowIDChangeQty;
        $qty = $request->quantity_change;
        Cart::update($rowId, $qty);
        return Redirect::to('/view-cart');
    }
 
    public function add_cart_ajax(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.',
                'redirect' => route('login'),
            ]);
        }
        
        $validator = Validator::make($request->all(), [
            'cart_product_id' => 'required|integer',
            'cart_product_name' => 'required|string|max:255',
            'cart_product_image' => 'required|string',
            'cart_product_price' => 'required|numeric|min:0',
            'cart_product_qty' => 'required|integer|min:1',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid product data',
                'errors' => $validator->errors(),
            ], 400);
        }
    
        $data = $request->all();
        $cart = Session::get('cart', []); 
        $isAvailable = false;
    
        foreach ($cart as $key => $item) {
            if ($item['product_id'] == $data['cart_product_id']) {
                $cart[$key]['product_qty'] += $data['cart_product_qty'];
                $isAvailable = true;
                break; // No need to check further once found
            }
        }
    
        if (!$isAvailable) {
            $session_id = substr(md5(microtime()), rand(0, 26), 5);
            $cart[] = [
                'session_id' => $session_id,
                'product_id' => $data['cart_product_id'],
                'product_name' => $data['cart_product_name'],
                'product_image' => $data['cart_product_image'],
                'product_price' => $data['cart_product_price'],
                'product_qty' => $data['cart_product_qty'],
            ];
        }
    
        Session::put('cart', $cart);
        Session::save();
    
        return response()->json([
            'status' => 'success',
            'message' => 'Product added to cart',
            'cart' => $cart,
        ]);
    }
    
    
    public function gio_hang(Request $request)
    {
        $cart = Session::get('cart');
        if (!$cart || count($cart) == 0) {
            return redirect('/')->with('error', 'Giỏ hàng của bạn đang trống!');
        }
        $meta_title = "Thông tin giỏ hàng";
        $meta_desc = "Trang Thông tin giỏ hàng của bạn";
        $meta_keywords = "giỏ hàng";
        $meta_canonical = $request->url();
        $image_og = "";

        $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get();
        $branch_product = DB::table('tbl_branch_product')->where('branch_status', '1')->orderby('branch_id', 'desc')->get();
        return view('pages.cart.view_cart_ajax')->with('category_product', $cate_product)->with('branch_product', $branch_product)
            ->with('meta_title', $meta_title)
            ->with('meta_desc', $meta_desc)
            ->with('meta_keywords', $meta_keywords)
            ->with('meta_canonical', $meta_canonical)
            ->with('image_og', $image_og);
    }
    public function del_cart($session_id)
    {
        $cart = Session::get('cart', []); 
        if ($cart) {
            foreach ($cart as $key => $val) {
                if ($val['session_id'] == $session_id) {
                    unset($cart[$key]); 
                }
            }
            Session::put('cart', $cart);
            Session::save(); 
        }
    
        return redirect()->back()->with('message', 'Xóa sản phẩm thành công');
    }
    
    public function update_cart(Request $request)
    {
        $data = $request->all();
        $cart = Session::get('cart', []);
    
        if ($cart) {
            foreach ($data['quantity_change'] as $sessionId => $quantityValue) {
                foreach ($cart as $key => $val) {
                    if ($sessionId == $val['session_id']) {
                        $cart[$key]['product_qty'] = $quantityValue; 
                    }
                }
            }
            Session::put('cart', $cart); 
            Session::save(); 
        }
    
        return redirect()->back()->with('message', 'Cập nhật số lượng thành công');
    }
    
    public function delete_cart()
    {
        if (Session::has('cart')) {
            Session::forget('cart'); 
            Session::forget('coupon'); 
            Session::save(); 
        }
    
        return redirect()->back()->with('message', 'Xóa hết giỏ hàng thành công');
    }    

    public function check_coupon(Request $request)
    {
        $data = $request->all();
        $coupon = Coupon::where('coupon_code', $data['coupon_code'])->first();

        if (!$coupon) {
            Log::warning('Invalid coupon code: ' . $data['coupon_code']);
            return redirect()->back()->with('message', 'Mã giảm giá không đúng');
        }

        $coupon_session = Session::get('coupon') ?? [];
        $coupons[] = [
            'coupon_code' => $coupon->coupon_code,
            'coupon_condition' => $coupon->coupon_condition,
            'coupon_number' => $coupon->coupon_number,
        ];
        Session::put('coupon', $coupons);
        Session::save();

        return redirect()->back()->with('message', 'Áp dụng mã giảm giá thành công');
    }
}
