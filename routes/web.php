<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminPermissionController;
use App\Http\Controllers\Admin\AdminRoleController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\MailController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;

//Customer
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\LoginCustomerController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('home');
//});
Route::get('send-mail',[MailController::class, 'send_email']);

Route::get('/admin/login',[LoginController::class, 'index'])->name('login');
Route::get('/admin/logout',[LoginController::class, 'logout'])->name('logout');
Route::post('/admin/login',[LoginController::class, 'store'])->name('login.store');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

//Login facebook
Route::get('/admin/login-facebook', [LoginController::class, 'login_facebook'])->name('login-facebook');
Route::get('/admin/callback', [LoginController::class, 'callback_facebook']);

//Login Google
Route::get('/admin/login-google', [LoginController::class, 'login_google'])->name('login-google');
Route::get('/google/callback', [LoginController::class, 'callback_google']);


Route::get('/admin/dashboard', function (){
    return view('admin.home');
})->name('dashboard');

Route::group(['prefix' => 'admin', 'middleware'=>['auth']], function (){

//    Route::get('/', function (){
//        return view('home');
//    })->name('home');

    Route::prefix('products')->group(function (){
        Route::get('/',[ProductController::class, 'index'])->name('products.index')
            ->middleware('can:product-list');
        Route::get('create',[ProductController::class, 'create'])->name('products.create')
            ->middleware('can:product-add');
        Route::post('store',[ProductController::class, 'store'])->name('products.store');
        Route::get('edit/{product}',[ProductController::class, 'edit'])->name('products.edit')
            ->middleware('can:product-edit,product');
        Route::post('{product}', [ProductController::class, 'update'])->name('products.update');
        Route::get('/delete/{product}',[ProductController::class,'delete'])->name('products.delete');

        Route::get('inactive-product/{product}', [ProductController::class, 'inactive_product'])->name('products.inactive');
        Route::get('active-product/{product}', [ProductController::class, 'active_product'])->name('products.active');
    });

   Route::prefix('categories')->group(function(){
       Route::get('/', [CategoryController::class, 'index'])->name('categories.index')
           ->middleware('can:category-list');

       Route::get('create', [CategoryController::class, 'create'])->name('categories.create')
       ->middleware('can:category-add');

       Route::post('store', [CategoryController::class, 'store'])->name('categories.store');
       Route::get('/edit/{category}', [CategoryController::class, 'edit'])->name('categories.edit')
       ->middleware('can:category-edit');

       Route::post('/edit/{category}', [CategoryController::class, 'update'])->name('categories.update');
       Route::get('/delete/{category}', [CategoryController::class, 'destroy'])
           ->name('categories.destroy')->middleware('can:category-delete');
   });

   Route::prefix('sliders')->group(function (){
       Route::get('/',[SliderController::class, 'index'])->name('sliders.index');
       Route::get('create', [SliderController::class, 'create'])->name('sliders.create');
       Route::post('store', [SliderController::class, 'store'])->name('sliders.store');
       Route::get('{slider}/edit',[SliderController::class, 'edit'])->name('sliders.edit');
       Route::post('/{slider}', [SliderController::class, 'update'])->name('sliders.update');
       Route::get('/{slider}/delete',[SliderController::class, 'destroy'])->name('sliders.destroy');
   });

   Route::prefix('settings')->group(function (){
       Route::get('/',[SettingController::class, 'index'])->name('settings.index');
       Route::get('create',[SettingController::class, 'create'])->name('settings.create');
       Route::post('/',[SettingController::class, 'store'])->name('settings.store');
       Route::get('{setting}/edit',[SettingController::class, 'edit'])->name('settings.edit');
       Route::post('{setting}/update',[SettingController::class, 'update'])->name('settings.update');
       Route::get('{setting}/delete',[SettingController::class, 'destroy'])->name('settings.destroy');
   });

   Route::prefix('users')->group(function (){
       Route::get('/', [AdminUserController::class, 'index'])->name('users.index');
       Route::get('create',[AdminUserController::class, 'create'])->name('users.create');
       Route::post('/',[AdminUserController::class, 'store'])->name('users.store');
       Route::get('{user}/edit',[AdminUserController::class, 'edit'])->name('users.edit');
       Route::post('{user}/update', [AdminUserController::class, 'update'])->name('users.update');
       Route::get('{user}/delete', [AdminUserController::class, 'destroy'])->name('users.delete');
   });

   Route::prefix('roles')->group(function (){
       Route::get('/',[AdminRoleController::class, 'index'])->name('roles.index');
       Route::get('create', [AdminRoleController::class, 'create'])->name('roles.create');
       Route::post('store',[AdminRoleController::class, 'store'])->name('roles.store');
       Route::get('{role}/edit', [AdminRoleController::class, 'edit'])->name('roles.edit');
       Route::post('{role}/update', [AdminRoleController::class, 'update'])->name('roles.update');
   });

   Route::prefix('permissions')->group(function (){
       Route::get('/',[AdminPermissionController::class, 'createPermissions'])
           ->name('permissions.create');
       Route::post('store',[AdminPermissionController::class, 'store'])
           ->name('permissions.store');
   });

   Route::prefix('orders')->group(function (){
       Route::get('/',[OrderController::class, 'index'])->name('orders.index');
       Route::get('/{order}',[OrderController::class, 'show'])->name('orders.show');
       Route::get('/create-pdf/{order}',[OrderController::class, 'create_pdf'])->name('orders.create-pdf');
       Route::post('/update-order-qty',[OrderController::class, 'update_order_qty'])->name('orders.update-order-qty');
       Route::post('/update-row-qty',[OrderController::class, 'update_row_qty'])->name('orders.update-row-qty');
   });

   Route::prefix('coupons')->group(function (){
        Route::get('index',[CouponController::class,'index'])->name('coupons.index');
        Route::get('create',[CouponController::class,'create'])->name('coupons.create');
        Route::get('delete',[CouponController::class,'destroy'])->name('coupons.destroy');
        Route::post('store',[CouponController::class,'store'])->name('coupons.store');
   });

   Route::prefix('delivery')->group(function (){
       Route::get('create',[DeliveryController::class, 'create'])->name('delivery.create');
        Route::post('select-delivery',[DeliveryController::class, 'select_delivery'])->name('select-delivery');
        Route::post('store-delivery',[DeliveryController::class, 'store'])->name('store-delivery');
        Route::post('show-feeship',[DeliveryController::class, 'show_feeship'])->name('show-feeship');
        Route::post('update-feeship',[DeliveryController::class, 'update_feeship'])->name('update-feeship');
   });


});




//Front end

Route::get('/',[HomeController::class, 'index'])->name('home');

Route::get('/categories/{slug}/{id}',[CategoryController::class, 'index_customer'])->name('categories.product');

Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

//Cart
Route::post('save-cart',[CartController::class, 'save_cart'])->name('cart.save');
Route::get('show-cart',[CartController::class, 'show_cart'])->name('cart.show');
Route::get('delete-to-cart/{rowId}',[CartController::class, 'delete_to_cart'])->name('cart.deleteItem');
Route::get('delete-product-from-cart/{sessionId}',[CartController::class, 'deleteProductFromSession'])->name('cart.deleteProductSession');
Route::post('update-cart-quantity',[CartController::class, 'update_cart_quantity'])->name('cart.update');

//Cart session
Route::post('update-cart',[CartController::class, 'update_cart'])->name('cart.update-cart');
Route::post('add-product-to-cart',[CartController::class, 'add_product_to_cart'])->name('cart.add-product-to-cart');
Route::get('delete-all-product',[CartController::class, 'delete_all_product'])->name('delete-all-product');
Route::get('delete-coupon',[CartController::class, 'delete_coupon'])->name('delete-coupon');

//Coupon
Route::post('check-coupon',[CouponController::class, 'check_coupon'])->name('coupons.check-coupon');



//Checkout
Route::get('login-checkout',[CheckoutController::class, 'login_checkout'])->name('login-checkout');
Route::get('logout-checkout',[CheckoutController::class, 'logout_checkout'])->name('logout-checkout');
Route::post('/add-customer',[CheckoutController::class, 'add_customer'])->name('add-customer');
Route::get('checkout',[CheckoutController::class,'checkout'])->name('checkout');
Route::post('save-checkout-customer',[CheckoutController::class, 'save_checkout_customer'])->name('save-checkout-customer');
Route::post('login-customer',[CheckoutController::class, 'login_customer'])->name('login-customer');
Route::get('payment',[CheckoutController::class,'payment'])->name('payment');
Route::post('order-place',[CheckoutController::class, 'order_place'])->name('order-place');
Route::post('confirm-order',[CheckoutController::class, 'confirm_order'])->name('confirm-order');


Route::post('tim-kiem',[HomeController::class, 'search_product'])->name('tim-kiem');

Route::post('select-delivery',[DeliveryController::class, 'select_delivery'])->name('select-delivery');
Route::post('calculate-feeship',[DeliveryController::class, 'calculate_feeship'])->name('calculate-feeship');

Route::get('delete-fee',[DeliveryController::class, 'delete_fee'])->name('cart.delete-fee');


//Forget password
Route::get('forget-password',[MailController::class, 'forget_password'])->name('forget-password');
Route::get('update-new-password',[MailController::class, 'update_new_password'])->name('update-new-password');
Route::post('recovery-password',[MailController::class, 'recovery_password'])->name('recovery-password');
Route::post('reset-new-password',[MailController::class, 'reset_new_password'])->name('reset-new-password');


//Login google
Route::get('login-google-customer',[LoginCustomerController::class, 'login_google_customer'])->name('login-google-customer');
Route::get('google/callback',[LoginCustomerController::class, 'google_callback']);

Route::get('history', [OrderController::class, 'history'])->name('history');
Route::get('view-history-order/{order}', [OrderController::class, 'view_history_order'])->name('view-history-order');
