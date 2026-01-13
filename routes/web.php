<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\{
    AdminController,
    ProductController,
    DanhmucController,
    OrderController
};

use App\Http\Controllers\{
    HomeController,
    AuthController,
    OrderViewController,
    CartController
};

// =======================
// FRONTEND
// =======================
Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/sanpham/detail/{id}', [HomeController::class, 'detail'])->name('detail');
    Route::get('/congiong', [HomeController::class, 'congiong'])->name('congiong');
    Route::get('/search', [HomeController::class, 'search'])->name('search');
    Route::get('/viewAll', [HomeController::class, 'viewAll'])->name('viewAll');
    Route::get('/services', [HomeController::class, 'services'])->name('services');
});

// =======================
// AUTH (USER)
// =======================
Route::get('/login', [AuthController::class, 'index'])->name('login.form');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login');

Route::get('/register', [AuthController::class, 'register'])->name('register.form');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register');

Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');

// =======================
// CART
// =======================
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'cart'])->name('cart');
    Route::get('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('add_to_cart');
    Route::get('/add-go-to-cart/{id}', [CartController::class, 'addGoToCart'])->name('add_go_to_cart');
    Route::patch('/update-cart', [CartController::class, 'update'])->name('update_cart');
    Route::delete('/remove-from-cart', [CartController::class, 'remove'])->name('remove_from_cart');
});

// Checkout & Payment (bắt buộc đăng nhập)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');

    // COD
    Route::post('/dathang', [CartController::class, 'dathang'])->name('dathang');

    // VNPAY: tạo link thanh toán
    Route::post('/vnpay', [CartController::class, 'vnpay'])->name('vnpay');
});

// VNPAY return URL (để ngoài auth cho chắc, vì VNPAY redirect về là GET)
Route::get('/thongbaodathang', [CartController::class, 'thongbaodathang'])->name('thongbaodathang');
// (khuyến nghị thêm POST để phòng trường hợp trả về POST)
Route::post('/thongbaodathang', [CartController::class, 'thongbaodathang'])->name('thongbaodathang.post');
// =======================
// VNPAY FAKE (DEMO NỘP BÀI khi sandbox bị code=71)
// =======================
Route::middleware('auth')->group(function () {
    // Trang demo sau khi tạo đơn VNPay
    Route::get('/vnpay/demo/{orderId}', [CartController::class, 'vnpayDemo'])->name('vnpay.demo');

    // Giả lập thanh toán thành công
    Route::get('/vnpay/fake-success/{orderId}', [CartController::class, 'vnpayFakeSuccess'])->name('vnpay.fake_success');

    // Giả lập thanh toán thất bại
    Route::get('/vnpay/fake-fail/{orderId}', [CartController::class, 'vnpayFakeFail'])->name('vnpay.fake_fail');
});


// =======================
// ORDER VIEW (USER)
// =======================
Route::get('/donhang', [OrderViewController::class, 'donhang'])
    ->name('donhang.index')
    ->middleware('auth');

Route::prefix('/')->middleware(['auth', 'orderview'])->group(function () {
    Route::get('/donhang/edit/{id}', [OrderViewController::class, 'edit'])->name('donhang.edit');
});


// =======================
// ADMIN AUTH
// =======================
Route::prefix('/')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.login.form');
    Route::post('/signinDashboard', [AdminController::class, 'signin_dashboard'])->name('admin.login');
});

// =======================
// ADMIN PANEL
// =======================
Route::prefix('/')->middleware('admin.login')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/admin_logout', [AdminController::class, 'admin_logout'])->name('admin.logout');

    // PRODUCT
    Route::get('/admin/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/admin/product/search', [AdminController::class, 'search'])->name('adminSearch');
    Route::get('/admin/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/admin/product', [ProductController::class, 'store'])->name('product.store');
    Route::get('/admin/product/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/admin/product/update/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/admin/product/{product}/destroy', [ProductController::class, 'destroy'])->name('product.destroy');

    // DANH MUC
    Route::get('/admin/danhmuc', [DanhmucController::class, 'index'])->name('danhmuc.index');
    Route::get('/admin/danhmuc/create', [DanhmucController::class, 'create'])->name('danhmuc.create');
    Route::post('/admin/danhmuc', [DanhmucController::class, 'store'])->name('danhmuc.store');
    Route::get('/admin/danhmuc/edit/{danhmuc}', [DanhmucController::class, 'edit'])->name('danhmuc.edit');
    Route::put('/admin/danhmuc/update/{danhmuc}', [DanhmucController::class, 'update'])->name('danhmuc.update');
    Route::delete('/admin/danhmuc/{danhmuc}/destroy', [DanhmucController::class, 'destroy'])->name('danhmuc.destroy');

    // ORDERS (ADMIN)
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/admin/orders/edit/{orders}', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/admin/orders/update/{orders}', [OrderController::class, 'update'])->name('orders.update');
});
