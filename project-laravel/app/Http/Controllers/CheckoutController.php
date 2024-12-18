<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\City;
use App\Models\Feeship;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\User;
use App\Models\UserVerify;
use App\Models\Wards;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Darryldecode\Cart\Facades\CartFacade as Cart;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Rules\Captcha;
use Exception;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

session_start();

class CheckoutController extends Controller
{
    public function showLogin()
    {
        $category_product = Category::all();
        $branch_product = Brand::all();
        $products = Product::all();  // Retrieve products
        $meta_desc = "Welcome to our shop, where you can find a variety of products!";
        $meta_title = "Shop Homepage";
        $meta_keywords = "shop, products, online store, ecommerce";
        $meta_canonical = url()->current();  // Current URL for canonical link
        $image_og = "images/og-image.jpg";   // Example image path for Open Graph
        return view('login', compact('meta_desc', 'meta_title', 'meta_keywords', 'meta_canonical', 'image_og', 'products', 'category_product', 'branch_product'));
    }
    public function redirectToGoogle()
{
    return Socialite::driver('google')->redirect();
}

public function handleGoogleCallback()
{
    try {
        // Lấy thông tin người dùng từ Google
        $googleUser = Socialite::driver('google')->user(); // Dùng stateless nếu là API
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // Nếu người dùng chưa tồn tại, tạo mới
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => bcrypt(Str::random(16)), // Tạo mật khẩu ngẫu nhiên
            ]);
        }

        // Đăng nhập người dùng
        Auth::login($user);
        session(['customer_id' => $user->id, 'customer_name' => $user->name]);

        return Redirect::to('/welcome')->with('success', 'Đăng nhập thành công!');
        
    } catch (Exception $e) {
        // Xử lý lỗi
        Log::error('Google Login Error: ' . $e->getMessage());
        return redirect()->route('login')->with('error', 'Đăng nhập bằng Google thất bại. Vui lòng thử lại.');
    }
}

public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
    
            // Ensure the user has an email
            if (!$user->email) {
                return redirect()->route('login')->withErrors('Facebook account không có email!');
            }
    
            // Check if the user already exists
            $findUser = User::where('facebook_id', $user->id)->first();
    
            if ($findUser) {
                Auth::login($findUser);
                session(['customer_id' => $user->id, 'customer_name' => $user->name]);
                return Redirect::to('/welcome');
            } else {
                // Create new user with encrypted dummy password
                $newUser = User::updateOrCreate(
                    ['email' => $user->email],
                    [
                        'name' => $user->name,
                        'facebook_id' => $user->id,
                        'password' => bcrypt(Str::random(16))  // Generate a secure random password
                    ]
                );
    
                Auth::login($newUser);
                session(['customer_id' => $user->id, 'customer_name' => $user->name]);
                return Redirect::to('/welcome')->with('success', 'Đăng nhập thành công!');
            }
    
        } catch (Exception $e) {
            Log::error('Facebook login error: ' . $e->getMessage());
            return Redirect::to('/login')->withErrors('Có lỗi xảy ra trong quá trình đăng nhập với Facebook.');
        }
    }
    

    public function store(Request $request)
    {
        // Lấy shipping_id từ session
        $shipping_id = Session::get('shipping_id');
    
        // Kiểm tra nếu shipping_id không tồn tại
        if (!$shipping_id) {
            return redirect()->back()->with('error', 'Thông tin giao hàng chưa được xác nhận.');
        }
    
        // Thêm thông tin thanh toán
        $data = array();
        $data['payment_method'] = $request->payment_select; // Lấy phương thức thanh toán
        $data['payment_status'] = "Đang chờ xử lý"; // Trạng thái thanh toán
        $payment_id = DB::table('tbl_payment')->insertGetId($data); // Lưu vào bảng thanh toán
    
        // Thêm thông tin đơn hàng
        $data_order = array();
        $data_order['customer_id'] = Session::get('customer_id'); // Lấy customer_id từ session
        $data_order['shipping_id'] = $shipping_id; // Đảm bảo giá trị này không null
        $data_order['payment_id'] = $payment_id; // Lấy payment_id vừa tạo
        $data_order['order_total'] = Cart::getTotal(); // Lấy tổng tiền từ giỏ hàng
        $data_order['order_status'] = 'Đang chờ xử lý'; // Trạng thái đơn hàng
    
        // Lưu đơn hàng vào cơ sở dữ liệu và lấy order_id
        $order_id = DB::table('tbl_order')->insertGetId($data_order);
    
        // Thêm thông tin chi tiết đơn hàng
        $content = Cart::content(); // Lấy nội dung giỏ hàng
        foreach ($content as $v_content) {
            $data_detail_order = array();
            $data_detail_order['order_id'] = $order_id; // Gán order_id cho chi tiết đơn hàng
            $data_detail_order['product_id'] = $v_content->id; // Gán product_id
            $data_detail_order['product_name'] = $v_content->name; // Gán tên sản phẩm
            $data_detail_order['product_price'] = $v_content->price; // Gán giá sản phẩm
            $data_detail_order['product_sales_quanlity'] = $v_content->qty; // Gán số lượng bán
    
            // Lưu chi tiết đơn hàng vào cơ sở dữ liệu
            DB::table('tbl_order_detail')->insert($data_detail_order);
        }
    
        // Xử lý thanh toán
        switch ($data['payment_method']) {
            case 1: // Thẻ ATM
                Cart::destroy(); // Xóa giỏ hàng
                return redirect()->route('order.success')->with('message', 'Đơn này trả bằng Thẻ ATM');
            case 2: // Tiền mặt
                Cart::destroy(); // Xóa giỏ hàng
                return view('pages.checkout.handcash')->with('message', 'Đơn hàng đã được đặt thành công.');
            default:
                return redirect()->back()->with('error', 'Phương thức thanh toán không hợp lệ.');
        }
    }
    

    // Hàm tính tổng giá trị đơn hàng
    private function calculateTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['product_price'] * $item['product_qty'];  // Tổng tiền = giá * số lượng
        }
        return $total;
    }

    public function success()
    {
        return view('pages.checkout.checkout_success');
    }

    public function confirm_order(Request $request)
    {
        $data = $request->all();
    
        // Tạo đối tượng Shipping
        $shipping = new Shipping();
        $shipping->shipping_name = $data['shipping_name'];
        $shipping->shipping_address = $data['shipping_address'];
        $shipping->shipping_phone = $data['shipping_phone'];
        $shipping->shipping_email = $data['shipping_email'];
        $shipping->shipping_note = $data['shipping_note'];
        $shipping->shipping_method = $data['payment_select'];
    
        // Lưu Shipping và kiểm tra
        if ($shipping->save()) {
            $shipping_id = $shipping->id; // Lấy ID tự động sau khi lưu
            Session::put('shipping_id', $shipping_id); // Lưu vào session
        } else {
            return response()->json(['error' => 'Không thể tạo thông tin giao hàng. Vui lòng thử lại.'], 500);
        }
    
        // Tạo mã đơn hàng
        $order_code = substr(md5(microtime()), rand(0, 26), 5);
    
        // Tạo đối tượng Order
        $order = new Order();
        $order->shipping_id = $shipping_id;
        $order->customer_id = Session::get('customer_id');
        $order->order_code = $order_code;
        $order->order_status = 1; // Trạng thái mặc định: Đang xử lý
        $order->created_at = now();
        $order->save();
    
        // Thêm thông tin chi tiết đơn hàng
       if (Session::has('cart') && !empty(Session::get('cart'))) {
    foreach (Session::get('cart') as $key => $cart) {
        $orderDetail = new OrderDetail();
        $orderDetail->order_code = $order_code; // The order code must be the same
        $orderDetail->product_id = $cart['product_id'];
        $orderDetail->product_name = $cart['product_name'];
        $orderDetail->product_price = $cart['product_price'];
        $orderDetail->product_sales_quantity = $cart['product_qty']; // Correct field name (fix typo if needed)
        $orderDetail->order_feeship = $data['feeship'] ?? 0; // Default to 0 if no fee is provided
        $orderDetail->order_coupon = $data['coupon'] ?? null; // Null if no coupon
        $orderDetail->save();
    }
} else {
    return response()->json(['error' => 'Giỏ hàng trống hoặc không hợp lệ.'], 400);
}
    
        // Xóa session không cần thiết sau khi xử lý xong
        Session::forget('fee');
        Session::forget('cart');
        Session::forget('coupon');
    
        return response()->json(['success' => 'Đặt hàng thành công.'], 200);
    }
    

    public function delete_fee_home()
    {
        if (Session::get('fee')) {
            Session::forget('fee');
        }
        return redirect()->back();
    }

    public function calculate_fee(Request $request)
    {
        $data = $request->all();
        $feeship = Feeship::where('fee_matp', $data['cityId'])->where('fee_maqh', $data['provinceId'])->where('fee_xaid', $data['wardId'])->get();

        if ($feeship) {
            if ($feeship->count() > 0) {
                foreach ($feeship as $key => $fee) {
                    Session::put('fee', $fee->fee_feeship);
                    Session::save();
                }
            } else {
                Session::put('fee', 10000);
                Session::save();
            }
        }
    }

    public function get_delivery_home(Request $request)
    {
        $data = $request->all();
        $output = '';

        if ($data['action'] == 'nameCity') {
            $selectProvince = Province::where('matp', $data['ma_id'])->orderBy('maqh', 'ASC')->get();
            $output .= "<option value='0'>---Chọn quận huyện---</option>";
            foreach ($selectProvince as $key => $qh) {
                $output .= "<option value='" . $qh->maqh . "'>" . $qh->name . "</option>";
            }
            echo $output;
        } elseif ($data['action'] == 'nameProvince') {
            $selectWard = Wards::where('maqh', $data['provinceId'])->orderBy('xaid', 'ASC')->get();
            $output .= "<option value='0'>---Chọn xã phường---</option>";
            foreach ($selectWard as $key => $ward) {
                $output .= "<option value='" . $ward->xaid . "'>" . $ward->name . "</option>";
            }
            echo $output;
        }
    }

    public function AuthLogin()
    {
        if (Session::get('admin_id') != null) {
            return Redirect::to('admin.dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }



    public function add_customer(Request $request) {
        // Validate request data
        $validated = $request->validate([
            'customer_name' => 'required|min:5',
            'customer_email' => 'required|email|unique:users,email', // Kiểm tra trùng lặp email
            'customer_phone' => 'required|numeric|min:9',
            'customer_password' => 'required|min:6',
            'g-recaptcha-response' => new Captcha(),
        ]);
    
        // Hash mật khẩu người dùng
        $password = Hash::make($request->customer_password);
    
        // Bước 1: Lưu vào bảng 'users' nhưng chưa kích hoạt tài khoản
        $user = User::create([
            'name' => $request->customer_name,
            'email' => $request->customer_email,
            'password' => $password,
            'is_active' => false, // Tài khoản chưa được kích hoạt
        ]);
    
        // Bước 2: Tạo token xác thực email
        $token = Str::random(64);
        UserVerify::create([
            'user_id' => $user->id,
            'token' => $token,
        ]);
    
        // Bước 3: Gửi email xác thực
        Mail::send('email.emailVerificationEmail', ['token' => $token], function ($message) use ($request) {
            $message->to($request->customer_email);
            $message->subject('Verify Your Email Address');
        });
    
        // Lưu thông tin khách hàng vào bảng tbl_customers
        DB::table('tbl_customers')->insert([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'customer_password' => $password,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        // Chuyển hướng đến trang thông báo và yêu cầu người dùng xác nhận email
        return redirect()->route('email.verify.notice')->with('info', 'Please verify your email before proceeding to checkout.');
    }
    public function verify_email($token) {
        // Tìm token xác thực trong bảng UserVerify
        $verifyUser = UserVerify::where('token', $token)->first();
    
        // Nếu không tìm thấy token, thông báo lỗi
        if (!$verifyUser) {
            return redirect('/login')->with('error', 'Invalid verification link.');
        }
    
        // Lấy thông tin người dùng
        $user = $verifyUser->user;
    
        // Kiểm tra nếu người dùng không tồn tại
        if (!$user) {
            return redirect('/login')->with('error', 'User not found.');
        }
    
        // Nếu tài khoản đã được kích hoạt, thông báo
        if ($user->is_active) {
            return redirect('/login')->with('info', 'Your email is already verified.');
        }
    
        // Kích hoạt tài khoản người dùng
        $user->is_active = true;
        $user->save();
    
        // Xóa token xác thực
        $verifyUser->delete();
    
        // Chuyển hướng đến trang checkout
        return Redirect::to('/welcome')->with('success', 'Your email has been verified. You can now proceed to checkout.');
    }
    
    
    public function checkout_(Request $request) {
        $meta_title = "Thông tin giao hàng";
        $meta_desc = "Trang nhập thông tin giao hàng của bạn";
        $meta_keywords = "giao hàng checkout";
        $meta_canonical = $request->url();
        $image_og = "";
      $cartItems = Cart::getContent();
        $totalcartPrice = Cart::getTotal();
        $city = City::orderBy('matp')->get();
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $branch_product = DB::table('tbl_branch_product')->where('branch_status','1')->orderby('branch_id','desc')->get();
        return view('pages.checkout.view_checkout')->with('category_product',$cate_product)->with('branch_product',$branch_product)
        ->with('meta_title',$meta_title)
        ->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_canonical',$meta_canonical)
        ->with('image_og',$image_og)->with('cityData',$city)
        ->with('totalcartPrice', $totalcartPrice);
    }

    public function save_checkout_customer(Request $request)
    {

        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_address'] = $request->shipping_address;
        $data['shipping_note'] = $request->shipping_note;
    
        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);
    
        // Kiểm tra nếu lưu shipping_id vào cơ sở dữ liệu thành công
        if ($shipping_id) {
            Session::put('shipping_id', $shipping_id);
        } else {
            return redirect()->back()->with('error', 'Lưu thông tin giao hàng thất bại.');
        }
    
        return Redirect::to('/payment');
    }
    public function save_order(Request $request) {
        // insert payment method
          $data = array();
          $data['payment_method'] = $request->payment_value;
          $data['payment_status'] = "Đang chờ xử lý";
  
          $payment_id = DB::table('tbl_payment')->insertGetId($data);
  
          $data_order = array();
          $data_order['customer_id'] = Session::get('customer_id');
          $data_order['shipping_id'] = Session::get('shipping_id', 0);
          $data_order['payment_id'] = $payment_id;
          $data_order['order_total'] = Cart::getTotal();
          $data_order['order_status'] = 'Đang chờ xử lý';
          $order_id = DB::table('tbl_order')->insertGetId($data_order);
  
          $data_detail_order = array();
          $content = Cart::getContent();
          
          foreach($content as $v_content) {
              $data_detail_order['order_id'] = $order_id;
              $data_detail_order['product_id'] = $v_content->id;
              $data_detail_order['product_name'] = $v_content->name;
              $data_detail_order['product_price'] = $v_content->price;
              $data_detail_order['product_sales_quanlity'] =  $v_content->qty;
              DB::table('tbl_order_detail')->insert($data_detail_order);
          }
          if($data['payment_method'] == 1) {
            Cart::clear() ;
              echo "Đơn này trả Thẻ ATM";
          }elseif($data['payment_method'] == 2) {
            Cart::clear() ;
              $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
              $branch_product = DB::table('tbl_branch_product')->where('branch_status','1')->orderby('branch_id','desc')->get();
              
              $meta_title = "Đặt hàng thành công";
              $meta_desc = "";
              $meta_keywords = "";
              $meta_canonical = $request->url();
              $image_og = "";
  
              return view('pages.checkout.handcash')->with('category_product',$cate_product)->with('branch_product',$branch_product)
              ->with('meta_title',$meta_title)
              ->with('meta_desc',$meta_desc)
              ->with('meta_keywords',$meta_keywords)
              ->with('meta_canonical',$meta_canonical)
              ->with('image_og',$image_og);
          }elseif($data['payment_method'] == 3) {
            Cart::clear() ;
              echo "Đơn này trả Thẻ ATM";
          }
      }
      public function payment(Request $request)
      {
          $meta_title = "Chọn phương thức thanh toán";
          $meta_desc = "Trang Chọn phương thức thanh toán của bạn";
          $meta_keywords = "thanh toán payment";
          $meta_canonical = $request->url();
          $image_og = "";
  
          $cart = Session::get('cart', []);
          Session::put('cart', $cart); // Lưu giỏ hàng vào session
          
          // Tính tổng tiền của đơn hàng
          $totalAmount = $this->calculateTotal($cart);
  
          // Lấy phí ship từ session
          $shippingFee = Session::get('fee', 0);
  
          // Tính tổng số tiền bao gồm phí ship
          $totalAmountWithShipping = $totalAmount + $shippingFee;
  
          
          $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get();
          $branch_product = DB::table('tbl_branch_product')->where('branch_status', '1')->orderby('branch_id', 'desc')->get();
          return view('pages.checkout.payment')->with('category_product', $cate_product)->with('branch_product', $branch_product)
               ->with('category_product', $cate_product)
              ->with('branch_product', $branch_product)
              ->with('meta_title', $meta_title)
              ->with('meta_desc', $meta_desc)
              ->with('meta_keywords', $meta_keywords)
              ->with('meta_canonical', $meta_canonical)
              ->with('image_og', $image_og)
              ->with('cart', $cart)  // Truyền giỏ hàng vào view
              ->with('totalAmount', $totalAmount)  // Truyền tổng tiền vào view
              ->with('shippingFee', $shippingFee)  // Truyền phí ship vào view
              ->with('totalAmountWithShipping', $totalAmountWithShipping);
              
      }

    public function logout_checkout() {
        Session::put('shipping_id',null);
        Session::put('customer_id',null);
        Session::put('customer_name',null);
        return Redirect::to('/login');
    }
    public function login_customer(Request $request) {
        $email = $request->email_account;
        $password = $request->password_account;
    
        // Lấy thông tin khách hàng từ cơ sở dữ liệu
        $result = DB::table('tbl_customers')->where('customer_email', $email)->first();
        
        if ($result && Hash::check($password, $result->customer_password)) {
            // Nếu mật khẩu đúng, lưu thông tin vào session và chuyển hướng
            Auth::loginUsingId($result->customer_id);
            
            Session::put('customer_id', $result->customer_id);
            Session::put('customer_name', $result->customer_name);
            return Redirect::to('/welcome');
        } else {
            // Nếu thông tin đăng nhập sai, hiển thị thông báo lỗi
            Session::put('message', 'Mật khẩu hoặc tài khoản không đúng, vui lòng nhập lại!');
            return Redirect::to('/login');
        }
    }
    
    public function logout(Request $request)
{
    Auth::logout(); // Gọi logout từ facade Auth

    $request->session()->invalidate(); // Xóa session
    $request->session()->regenerateToken(); // Tạo lại CSRF token mới

    return redirect('/'); // Điều hướng sau khi đăng xuất
}

        

    
    public function manage_order()
    {

        $this->AuthLogin();
        $all_order = DB::table('tbl_order')->join('tbl_customers', 'tbl_order.customer_id', '=', 'tbl_customers.customer_id')
            ->select('tbl_order.*', 'tbl_customers.customer_name')
            ->orderby('tbl_order.order_id', 'desc')->get();

        return view('admin.manage_order')->with('all_order', $all_order);
    }
    public function view_order_detail($order_id)
    {
        $this->AuthLogin();
        $order_by_id = DB::table('tbl_order')
            ->join('tbl_customers', 'tbl_customers.customer_id', '=', 'tbl_order.customer_id')
            ->join('tbl_shipping', 'tbl_shipping.id', '=', 'tbl_order.shipping_id')
            ->join('tbl_order_detail', 'tbl_order_detail.order_id', '=', 'tbl_order.order_id')
            ->where('tbl_order.order_id', $order_id)
            ->select('tbl_order.*', 'tbl_customers.*', 'tbl_shipping.*', 'tbl_order_detail.*')->first();
           
        $products = DB::table('tbl_order_detail')->where('tbl_order_detail.order_id', $order_id)->get();
        return view('admin.view_order')->with('order_by_id', $order_by_id)->with('order_list', $products);
    }
    public function delete_order($order_id)
    {
        $this->AuthLogin();
        DB::table('tbl_order_detail')->where('order_id', $order_id)->delete();
        DB::table('tbl_order')->where('order_id', $order_id)->delete();
        Session::put('message', 'Xóa đơn hàng thành công');
        return Redirect::to('/manage-order');
    }

    public function checkout(Request $request)
    {
        // Khai báo các meta thông tin cho SEO
        $meta_title = "Thông tin giao hàng";
        $meta_desc = "Trang nhập thông tin giao hàng của bạn";
        $meta_keywords = "giao hàng checkout";
        $meta_canonical = $request->url();
        $image_og = "";

        // Lấy các dữ liệu liên quan đến địa phương và sản phẩm
        $city = City::orderBy('matp')->get();
        $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get();
        $branch_product = DB::table('tbl_branch_product')->where('branch_status', '1')->orderby('branch_id', 'desc')->get();

        // Lấy giỏ hàng từ session, nếu không có thì trả về mảng rỗng
        $cart = Session::get('cart', []);
       // Thêm sản phẩm mới
        Session::put('cart', $cart); // Lưu giỏ hàng vào session
        // Tính tổng tiền của đơn hàng
        $totalAmount = $this->calculateTotal($cart);

        // Lấy phí ship từ session
        $shippingFee = Session::get('fee', 0);

        // Tính tổng số tiền bao gồm phí ship
        $totalAmountWithShipping = $totalAmount + $shippingFee;

        // Truyền giỏ hàng và tổng tiền vào view
        return view('pages.checkout.view_checkout')
            ->with('category_product', $cate_product)
            ->with('branch_product', $branch_product)
            ->with('meta_title', $meta_title)
            ->with('meta_desc', $meta_desc)
            ->with('meta_keywords', $meta_keywords)
            ->with('meta_canonical', $meta_canonical)
            ->with('image_og', $image_og)
            ->with('cityData', $city)
            ->with('cart', $cart)  // Truyền giỏ hàng vào view
            ->with('totalAmount', $totalAmount)  // Truyền tổng tiền vào view
            ->with('shippingFee', $shippingFee)  // Truyền phí ship vào view
            ->with('totalAmountWithShipping', $totalAmountWithShipping);  // Truyền tổng tiền có phí ship vào view
    }
}
