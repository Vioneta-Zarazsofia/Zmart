<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DiscountCodeController;
use App\Http\Controllers\Admin\ShippingChargeController;
use App\Http\Controllers\Admin\CourierController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController as ProductFront;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\SupplierController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('admin', [AuthController::class, 'login_admin']);
Route::post('admin', [AuthController::class, 'auth_login_admin']);
Route::get('admin/logout', [AuthController::class, 'logout_admin']);

Route::group(['middleware' => ['user']], function () {
    Route::get('user/dashboard', [UserController::class, 'dashboard']);
    Route::get('user/orders', [UserController::class, 'orders']);
    Route::get('user/orders/detail/{id}', [UserController::class, 'orders_detail']);
    Route::post('user/orders/mark-done/{id}', [UserController::class, 'markOrderDone'])->name('user.orders.mark_done');
    Route::post('user/orders/cancel/{id}', [UserController::class, 'cancelOrder'])->name('user.orders.cancel');
    Route::get('user/edit-profile', [UserController::class, 'edit_profile']);
    Route::post('user/update-profile', [UserController::class, 'update_profile'])->name('user.updateProfile');
    Route::get('user/change-password', [UserController::class, 'change_password']);
    Route::post('user/change-password', [UserController::class, 'update_password']);
    Route::post('add_to_wishlist', [UserController::class, 'add_to_wishlist']);
    Route::get('my-wishlist', [ProductFront::class, 'my_wishlist']);
    Route::post('user/make-review', [UserController::class, 'submit_review']);

});

Route::group(['middleware' => ['admin']], function () {

    Route::get('admin/dashboard', [DashboardController::class, 'dashboard']);
    Route::get('admin/admin/list', [AdminController::class, 'list']);
    Route::get('admin/admin/add', [AdminController::class, 'add']);
    Route::post('admin/admin/add', [AdminController::class, 'insert']);
    Route::get('admin/admin/edit/{id}', [AdminController::class, 'edit']);
    Route::post('admin/admin/edit/{id}', [AdminController::class, 'update']);
    Route::get('admin/admin/delete/{id}', [AdminController::class, 'delete']);

    Route::get('admin/customer/list', [AdminController::class, 'customer_list']);
    Route::get('admin/customer/delete/{id}', [AdminController::class, 'customer_delete']);

    Route::get('admin/order/list', [OrderController::class, 'list']);
    Route::get('admin/order/detail/{id}', [OrderController::class, 'order_detail']);
    Route::post('/admin/orders/mark-done/{id}', [OrderController::class, 'markDone']);
    Route::post('/admin/orders/cancel-order/{id}', [OrderController::class, 'cancelOrder']);

    Route::get('admin/category/list', [CategoryController::class, 'list']);
    Route::get('admin/category/add', [CategoryController::class, 'add']);
    Route::post('admin/category/add', [CategoryController::class, 'insert']);
    Route::get('admin/category/edit/{id}', [CategoryController::class, 'edit']);
    Route::post('admin/category/edit/{id}', [CategoryController::class, 'update']);
    Route::get('admin/category/delete/{id}', [CategoryController::class, 'delete']);

    Route::get('admin/sub_category/list', [SubCategoryController::class, 'list']);
    Route::get('admin/sub_category/add', [SubCategoryController::class, 'add']);
    Route::post('admin/sub_category/add', [SubCategoryController::class, 'insert']);
    Route::get('admin/sub_category/edit/{id}', [SubCategoryController::class, 'edit']);
    Route::post('admin/sub_category/edit/{id}', [SubCategoryController::class, 'update']);
    Route::get('admin/sub_category/delete/{id}', [SubCategoryController::class, 'delete']);

    Route::post('admin/get_sub_category', [SubCategoryController::class, 'get_sub_category']);

    Route::get('admin/brand/list', [BrandController::class, 'list']);
    Route::get('admin/brand/add', [BrandController::class, 'add']);
    Route::post('admin/brand/add', [BrandController::class, 'insert']);
    Route::get('admin/brand/edit/{id}', [BrandController::class, 'edit']);
    Route::post('admin/brand/edit/{id}', [BrandController::class, 'update']);
    Route::get('admin/brand/delete/{id}', [BrandController::class, 'delete']);

    Route::get('admin/product/list', [ProductController::class, 'list']);
    Route::get('admin/product/add', [ProductController::class, 'add']);
    Route::post('admin/product/add', [ProductController::class, 'insert']);
    Route::get('admin/product/edit/{id}', [ProductController::class, 'edit']);
    Route::post('admin/product/edit/{id}', [ProductController::class, 'update']);
    Route::get('admin/product/delete/{id}', [ProductController::class, 'delete']);

    Route::get('admin/product/image_delete/{id}', [ProductController::class, 'image_delete']);
    Route::post('admin/product_image_sortable', [ProductController::class, 'product_image_sortable']);
    Route::get('/product/{slug}', [ProductController::class, 'getCategory'])->name('product.detail');
    Route::get('kategori/{slug}', [ProductController::class, 'getCategory']);


    Route::get('admin/discountcode/list', [DiscountCodeController::class, 'list']);
    Route::get('admin/discountcode/add', [DiscountCodeController::class, 'add']);
    Route::post('admin/discountcode/add', [DiscountCodeController::class, 'insert']);
    Route::get('admin/discountcode/edit/{id}' , [DiscountCodeController::class, 'edit']);
    Route::post('admin/discountcode/edit/{id}', [DiscountCodeController::class, 'update']);
    Route::get('admin/discountcode/delete/{id}', [DiscountCodeController::class, 'delete']);

    Route::get('admin/shipping_charge/list', [ShippingChargeController::class, 'list']);
    Route::get('admin/shipping_charge/add', [ShippingChargeController::class, 'add']);
    Route::post('admin/shipping_charge/add', [ShippingChargeController::class, 'insert']);
    Route::get('admin/shipping_charge/edit/{id}', [ShippingChargeController::class, 'edit']);
    Route::post('admin/shipping_charge/edit/{id}', [ShippingChargeController::class, 'update']);
    Route::get('admin/shipping_charge/delete/{id}', [ShippingChargeController::class, 'delete']);

    Route::get('admin/courier/list', [CourierController::class, 'list']);
    Route::get('admin/courier/add', [CourierController::class, 'add']);
    Route::post('admin/courier/add', [CourierController::class, 'insert']);
    Route::get('admin/courier/edit/{id}', [CourierController::class, 'edit']);
    Route::post('admin/courier/edit/{id}', [CourierController::class, 'update']);
    Route::get('admin/courier/delete/{id}', [CourierController::class, 'delete']);

    Route::get('admin/supplier/list', [SupplierController::class, 'list']);
    Route::get('admin/supplier/add', [SupplierController::class, 'add']);
    Route::post('admin/supplier/add', [SupplierController::class, 'insert']);
    Route::get('admin/supplier/edit/{id}', [SupplierController::class, 'edit']);
    Route::post('admin/supplier/edit/{id}', [SupplierController::class, 'update']);
    Route::get('admin/supplier/delete/{id}', [SupplierController::class, 'delete']);

    // Route::get('admin/purchase', [PurchaseController::class, 'index']);
    // Route::post('admin/purchase/fetch-products', [PurchaseController::class, 'fetchProducts']);
    // Route::post('admin/purchase/submit', [PurchaseController::class, 'store']);
    // Route::get('admin/purchase/pdf/{id}', [PurchaseController::class, 'generatePDF']);

    Route::get('admin/purchase', [PurchaseController::class, 'index'])->name('purchase.index');
    Route::post('admin/purchase/export-pdf', [PurchaseController::class, 'exportPdf'])->name('purchase.exportPdf');


Route::get('/', [HomeController::class, 'home']);
Route::get('metode-pembayaran', [HomeController::class, 'payment_methods']);
Route::get('pengembalian', [HomeController::class, 'returns']);
Route::get('pengiriman', [HomeController::class, 'shipping']);
Route::get('syarat-ketentuan', [HomeController::class, 'terms_conditions']);
Route::get('kebijakan-privasi', [HomeController::class, 'privacy_policy']);



// FAQ Admin
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::get('faq', [FaqController::class, 'index'])->name('faq.index');
    Route::get('faq/create', [FaqController::class, 'create'])->name('faq.create');
    Route::post('faq', [FaqController::class, 'store'])->name('faq.store');
    Route::get('faq/{faq}/edit', [FaqController::class, 'edit'])->name('faq.edit');
    Route::put('faq/{faq}', [FaqController::class, 'update'])->name('faq.update');
    Route::delete('faq/{faq}', [FaqController::class, 'destroy'])->name('faq.destroy');

});
// FAQ Customer
Route::get('/faq', [PageController::class, 'faq'])->name('page.faq');
Route::get('admin/system-setting', [PageController::class, 'system_setting']);
Route::post('admin/system-setting', [PageController::class, 'update_system_setting']);
Route::get('contact', [PageController::class, 'contact']);
Route::post('contact', [PageController::class, 'submit_contact']);
Route::get('admin/contactus', [PageController::class, 'contactus']);
Route::get('admin/contactus/delete/{id}', [PageController::class, 'contactus_delete']);

});


Route::post('auth_register', [AuthController::class, 'auth_register']);
Route::post('auth_login', [AuthController::class, 'auth_login']);
Route::get('logout_customer', [AuthController::class, 'logout_customer']);
Route::get('forgot-password', [AuthController::class, 'forgot_password']);
Route::post('forgot-password', [AuthController::class, 'auth_forgot_password']);
Route::get('reset/{token}', [AuthController::class, 'reset']);
Route::post('reset/{token}', [AuthController::class, 'auth_reset']);
Route::get('activate/{id}', [AuthController::class, 'activate_email']);


Route::get('cart', [PaymentController::class, 'cart']);
Route::post('update_cart', [PaymentController::class, 'update_cart']);
Route::get('cart/delete/{id}', [PaymentController::class, 'cart_delete']);

Route::get('checkout', [PaymentController::class, 'checkout']);
Route::post('checkout/apply_discount_code', [PaymentController::class, 'apply_discount_code']);
Route::post('checkout/place_order', [PaymentController::class, 'place_order']);
Route::get('checkout/payment', [PaymentController::class, 'checkout_payment']);

Route::prefix('admin/orders')->group(function () {
    Route::get('/waiting', [OrderController::class, 'waiting'])->name('admin.orders.waiting');
    Route::post('/verify/{id}', [OrderController::class, 'verify'])->name('admin.orders.verify');
    Route::post('/reject/{id}', [OrderController::class, 'reject'])->name('admin.orders.reject');
    Route::post('/mark-done/{id}', [OrderController::class, 'markDone'])->name('admin.orders.done');
    Route::post('/cancel-verify/{id}', [OrderController::class, 'cancelVerify'])->name('admin.orders.cancel_verify');
    Route::post('/cancel-reject/{id}', [OrderController::class, 'cancelReject'])->name('admin.orders.cancel_reject');
    Route::get('/detail/{id}', [OrderController::class, 'detail'])->name('admin.orders.detail');
     Route::post('/update-shipping/{id}', [OrderController::class, 'updateShipping'])->name('admin.orders.update_shipping');
});



Route::get('/payment/confirm/{order_id}', [PaymentController::class, 'confirmPaymentForm'])->name('payment.confirm.form');
Route::post('/payment/confirm/{order_id}', [PaymentController::class, 'submitPaymentProof'])->name('payment.confirm.submit');

Route::post('product/add-to-cart', [PaymentController::class, 'add_to_cart']);
Route::get('search', [ProductFront::class, 'getProductSearch']);
Route::post('get_filter_product_ajax', [ProductFront::class, 'get_filter_product_ajax']);
Route::get('{category?}/{subcategory?}', [ProductFront::class, 'getCategory']);Route::get('product/detail/{slug}', [PageController::class, 'productDetail'])->name('product.detail');