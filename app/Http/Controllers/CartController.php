<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Sanpham;
use App\Models\Dathang;
use App\Models\ChitietDonhang;

class CartController extends Controller
{
    public function index()
    {
        $products = Sanpham::all();
        return view('products', compact('products'));
    }

    public function cart()
    {
        return view('pages.cart');
    }

    public function addToCart($id)
    {
        $product = Sanpham::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "id_sanpham" => $product->id_sanpham,
                "tensp" => $product->tensp,
                "anhsp" => $product->anhsp,
                "giasp" => $product->giasp,
                "giamgia" => $product->giamgia,
                "giakhuyenmai" => $product->giakhuyenmai,
                "quantity" => 1
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Thêm vào giỏ hàng thành công!');
    }

    public function addGoToCart($id)
    {
        $product = Sanpham::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "id_sanpham" => $product->id_sanpham,
                "tensp" => $product->tensp,
                "anhsp" => $product->anhsp,
                "giasp" => $product->giasp,
                "giamgia" => $product->giamgia,
                "giakhuyenmai" => $product->giakhuyenmai,
                "quantity" => 1
            ];
        }

        session()->put('cart', $cart);
        return redirect('/cart');
    }

    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart', []);
            if (isset($cart[$request->id])) {
                $cart[$request->id]["quantity"] = (int)$request->quantity;
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Cập nhật giỏ hàng thành công!');
        }
    }

    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart', []);
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Xóa sản phẩm trong giỏ hàng thành công');
        }
    }

    public function checkout()
    {
        if (!Auth::check()) return redirect('/login');

        // Bạn đang join với dathang -> nếu user chưa có đơn thì có thể không ra dữ liệu.
        // Mình đổi sang lấy thông tin khách hàng trực tiếp cho chắc.
        $showusers = DB::table('khachhang')
            ->where('id_kh', Auth::user()->id_kh)
            ->get();

        return view('pages.checkout', ['showusers' => $showusers]);
    }

    /**
     * ĐẶT HÀNG COD (Thanh toán khi nhận hàng)
     */
    public function dathang(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Vui lòng đăng nhập để đặt hàng.');
        }

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect('/cart')->with('error', 'Giỏ hàng trống.');
        }

        // Validate tối thiểu
        $request->validate([
            'diachigiaohang' => 'required|string|max:255',
            'tongtien' => 'required|numeric|min:1',
        ]);

        try {
            DB::beginTransaction();

            $order = Dathang::create([
                'ngaydathang' => Carbon::now(),
                'ngaygiaohang' => null,
                'tongtien' => $request->tongtien,
                'phuongthucthanhtoan' => 'cod',
                'diachigiaohang' => $request->diachigiaohang,
                'trangthai' => 'đang xử lý',
                'id_kh' => Auth::user()->id_kh,
            ]);

            foreach ($cart as $item) {
                ChitietDonhang::create([
                    'tensp' => $item['tensp'],
                    'soluong' => $item['quantity'],
                    'giamgia' => $item['giamgia'],
                    'giatien' => $item['giasp'],
                    'giakhuyenmai' => $item['giakhuyenmai'],
                    'id_sanpham' => $item['id_sanpham'],
                    'id_dathang' => $order->id_dathang,
                    'id_kh' => Auth::user()->id_kh,
                ]);
            }

            DB::commit();

            session()->forget('cart');
            return view('pages.thongbaodathang');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error in dathang(COD): ' . $e->getMessage());
            return redirect('/cart')->with('error', 'Có lỗi xảy ra khi đặt hàng: ' . $e->getMessage());
        }
    }

    /**
     * TẠO LINK THANH TOÁN VNPAY (tạo đơn trước)
     */
    public function vnpay(Request $request)
    {
        if (!Auth::check()) return redirect('/login');

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect('/cart')->with('error', 'Giỏ hàng trống.');
        }

        $request->validate([
            'diachigiaohang' => 'required|string|max:255',
            'tongtien' => 'required|numeric|min:1',
        ]);

        // --- VNPay config ---
        $vnp_TmnCode = "GHHNT2HB";
        $vnp_HashSecret = "BAGAOHAPRHKQZASKQZASVPRSAKPXNYXS";
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000/thongbaodathang";

        try {
            DB::beginTransaction();

            // 1) tạo đơn trước: chờ thanh toán
            $order = Dathang::create([
                'ngaydathang' => Carbon::now(),
                'ngaygiaohang' => null,
                'tongtien' => $request->tongtien,
                'phuongthucthanhtoan' => 'vnpay',
                'diachigiaohang' => $request->diachigiaohang,
                'trangthai' => 'chờ thanh toán',
                'id_kh' => Auth::user()->id_kh,
            ]);

            foreach ($cart as $item) {
                ChitietDonhang::create([
                    'tensp' => $item['tensp'],
                    'soluong' => $item['quantity'],
                    'giamgia' => $item['giamgia'],
                    'giatien' => $item['giasp'],
                    'giakhuyenmai' => $item['giakhuyenmai'],
                    'id_sanpham' => $item['id_sanpham'],
                    'id_dathang' => $order->id_dathang,
                    'id_kh' => Auth::user()->id_kh,
                ]);
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error create order VNPay: ' . $e->getMessage());
            return redirect('/cart')->with('error', 'Không tạo được đơn để thanh toán: ' . $e->getMessage());
        }

        // 2) build dữ liệu gửi vnpay
        $vnp_TxnRef = (string)$order->id_dathang; // dùng ID đơn thật
        $vnp_OrderInfo = "Thanh toan don hang #" . $order->id_dathang;
        $vnp_OrderType = "billpayment";
        $vnp_Amount = (int)$request->tongtien * 100;
        $vnp_IpAddr = $request->ip();

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => "vn",
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        ksort($inputData);

        $hashData = "";
        $query = "";
        $i = 0;
        foreach ($inputData as $key => $value) {
            $hashData .= ($i ? '&' : '') . $key . "=" . $value;
            $query .= urlencode($key) . "=" . urlencode($value) . "&";
            $i = 1;
        }

 $vnpSecureHash = hash_hmac('sha256', $hashData, $vnp_HashSecret);
$vnp_Url = $vnp_Url . "?" . $query . "vnp_SecureHash=" . $vnpSecureHash;


// DEMO: không chuyển qua VNPay sandbox (bị code=71), chuyển sang trang demo
return redirect()->route('vnpay.demo', $order->id_dathang);

    }

    /**
     * VNPAY RETURN URL: verify chữ ký + update trạng thái
     */
    public function thongbaodathang(Request $request)
    {
        $vnp_HashSecret = "BAGAOHAPRHKQZASKQZASVPRSAKPXNYXS";

        // Lấy tất cả tham số bắt đầu bằng vnp_
        $inputData = $request->all();
        $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';
        unset($inputData['vnp_SecureHash'], $inputData['vnp_SecureHashType']);

        ksort($inputData);

        $hashData = "";
        $i = 0;
        foreach ($inputData as $key => $value) {
            if (strpos($key, 'vnp_') === 0) {
                $hashData .= ($i ? '&' : '') . $key . "=" . $value;
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha256', $hashData, $vnp_HashSecret);

        // 1) Sai chữ ký => reject
        if ($secureHash !== $vnp_SecureHash) {
            \Log::error('VNPay invalid signature', ['calc' => $secureHash, 'return' => $vnp_SecureHash]);
            return redirect('/cart')->with('error', 'Sai chữ ký VNPay!');
        }

        $orderId = $request->input('vnp_TxnRef');      // id_dathang
        $responseCode = $request->input('vnp_ResponseCode'); // 00 = OK

        $order = Dathang::find($orderId);
        if (!$order) {
            return redirect('/cart')->with('error', 'Không tìm thấy đơn hàng!');
        }

        // 2) Success
        if ($responseCode === '00') {
            $order->trangthai = 'đã thanh toán';
            $order->save();

            session()->forget('cart'); // chỉ xóa khi OK
            return view('pages.thongbaodathang');
        }

        // 3) Fail
        $order->trangthai = 'thanh toán thất bại';
        $order->save();

        return redirect('/cart')->with('error', 'Thanh toán thất bại! Mã lỗi: ' . $responseCode);
        
    }
public function vnpayDemo($orderId)
{
    $order = Dathang::find($orderId);
    if (!$order) return redirect('/cart')->with('error', 'Không tìm thấy đơn hàng!');

    // Link này sẽ được encode thành QR
    $payUrl = route('vnpay.fake_success', $order->id_dathang);

    return view('pages.vnpay_demo', compact('order', 'payUrl'));
}


public function vnpayFakeSuccess($orderId)
{
    $order = Dathang::find($orderId);
    if (!$order) return redirect('/cart')->with('error', 'Không tìm thấy đơn hàng!');

    $order->trangthai = 'đã thanh toán';
    $order->save();

    session()->forget('cart');
    return view('pages.thongbaodathang');
}

public function vnpayFakeFail($orderId)
{
    $order = Dathang::find($orderId);
    if (!$order) return redirect('/cart')->with('error', 'Không tìm thấy đơn hàng!');

    $order->trangthai = 'thanh toán thất bại (fake)';
    $order->save();

    return redirect('/cart')->with('error', 'Thanh toán thất bại (fake) để demo.');
}

}
