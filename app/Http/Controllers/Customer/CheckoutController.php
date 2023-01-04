<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Shipping;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function confirm_order(Request $request)
    {
        try {
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            DB::beginTransaction();
            $data = $request->all();

            if ($data['order_coupon'] != 'no')
            {
                $coupon = Coupon::where('coupon_code', $data['coupon_code'])->first();
                $coupon_mail = $coupon->coupon_code;
            }else
            {
                $coupon_mail = 'Không có sử dụng';
            }

            $shipping = new Shipping();
            $shipping->name = $data['shipping_name'];
            $shipping->address = $data['shipping_address'];
            $shipping->phone = $data['shipping_phone'];
            $shipping->email = $data['shipping_email'];
            $shipping->notes = $data['shipping_notes'];
            $shipping->method = $data['shipping_method'];
            $shipping->save();

            $checkout_code = substr(md5(microtime()),rand(0,26),5);

            $order = new Order();
            $order->order_code = $checkout_code;
            $order->customer_id = session()->get('customer_id');
            $order->shipping_id = $shipping->id;
            $order->status = 1;
            $order->save();


            $carts = session()->get('cart');
            foreach ($carts as $key => $cart)
            {
                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $checkout_code;
                $orderDetail->product_id = $cart['product_id'];
                $orderDetail->product_name = $cart['product_name'];
                $orderDetail->product_price = $cart['product_price'];
                $orderDetail->product_sales_quantity = $cart['product_qty'];
                $orderDetail->coupon = $data['order_coupon'];
                $orderDetail->feeship = $data['order_fee'];
                $orderDetail->save();
            }

            /*
             * Send mail confirm order
             */
            $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
            $title_mail = 'Đơn xác nhận ngày'.' '.$now;
            $customer = Customer::find(session()->get('customer_id'));
            $data['email'][] = $customer->email;

            if (session()->get('cart'))
            {
                foreach (session()->get('cart') as $key => $cart_email)
                {
                    $cart_array[] = array(
                        'product_name' => $cart_email['product_name'],
                        'product_price' => $cart_email['product_price'],
                        'product_qty' => $cart_email['product_qty'],
                    );
                }
            }

            $shipping_array = array(
              'customer_name'=>$customer->name,
                'shipping_name' => $data['shipping_name'],
            'shipping_address' => $data['shipping_address'],
            'shipping_phone' => $data['shipping_phone'],
            'shipping_email' => $data['shipping_email'],
            'shipping_notes' => $data['shipping_notes'],
            'shipping_method' => $data['shipping_method'],
            );

            $ordercode_mail = array(
                'coupon_code' => $coupon_mail,
                'order_code' => $checkout_code,
            );


            Mail::send('pages.mail.mail_order',
                ['cart_array'=>$cart_array, 'shipping_array'=>$shipping_array, 'code'=>$ordercode_mail]
                , function ($message) use ($title_mail, $data)
            {
                $message->to($data['email'])->subject($title_mail);
                $message->from($data['email'], $title_mail);
            });
            DB::commit();
//            session()->forget('cart');
//            session()->forget('coupon');
//            session()->forget('fee');
        }catch (\Exception $exception)
        {
            Log::error('Message: '.$exception->getMessage().'--Line: '.$exception->getLine());
            DB::rollBack();
        }

    }
    public function login_checkout()
    {
        $categoryMenuParents = Category::where('parent_id', 0)->take(3)->get();
        return view('pages.checkout.login_checkout', compact('categoryMenuParents'));
    }

    public function logout_checkout()
    {
        session()->flush();
        return redirect()->route('login-checkout');
    }

    public function add_customer(Request $request)
    {
        $customer = Customer::create([
           'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'phone'=>$request->phone
        ]);
        session()->put('customer_id', $customer->id);
        session()->put('customer_name', $customer->name);
        return redirect()->route('checkout');
    }

    public function checkout()
    {
        $cities = City::orderBy('matp', 'ASC')->get();
        $categoryMenuParents = Category::where('parent_id', 0)->take(3)->get();
        return view('pages.checkout.show_checkout', compact('categoryMenuParents', 'cities'));
    }

    public function save_checkout_customer(Request $request)
    {
        $shipping = Shipping::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'notes'=>$request->notes,
        ]);
        session()->put('shipping_id', $shipping->id);
        return redirect()->route('payment');
    }

    public function login_customer(Request $request)
    {
        $customer = DB::table('customers')->where('email',$request->email)->first();
        if ($customer && Hash::check($request->password, $customer->password))
        {
            session()->put('customer_id',$customer->id);
            session()->put('customer_name',$customer->name);
            return redirect()->route('checkout');
        }else
        {
            return redirect()->route('login-checkout');
        }
    }

    public function payment()
    {
        $categoryMenuParents = Category::where('parent_id', 0)->take(3)->get();
        return view('pages.checkout.payment', compact('categoryMenuParents'));
    }

    public function order_place(Request $request)
    {
        $cartProducts = session()->get('cart');
        //insert payment
        $payment_data = array();
        $payment_data['method'] = $request->payment_option;
        $payment_data['status'] = '1';
        $payment = Payment::create($payment_data);

        //insert order
        $order_data = array();
        $order_data['customer_id'] = session()->get('customer_id');
        $order_data['shipping_id'] = session()->get('shipping_id');
        $order_data['payment_id'] = $payment->id;
        $total = 0;
        foreach($cartProducts as $key => $product)
        {
            $sub_total = $product['product_price']*$product['product_qty'];
            $total += $sub_total;
        }
        $order_data['total'] = number_format($total,0,',','.');
        $order_data['status'] = '1';
        $order = Order::create($order_data);

        //insert order detail
        $order_detail = array();
        foreach ($cartProducts as $product)
        {
            $order_detail['order_id'] = $order->id;
            $order_detail['product_id'] = $product['product_id'];
            $order_detail['product_name'] = $product['product_name'];
            $order_detail['product_price'] = $product['product_price'];
            $order_detail['product_sales_quantity'] = $product['product_qty'];
            $orderDetailInstance = OrderDetail::create($order_detail);
        }
        $categoryMenuParents = Category::where('parent_id', 0)->take(3)->get();
        if ($payment_data['method'] == 1)
        {
            Cart::destroy();
            return view('pages.checkout.payment.atm-cash', compact('categoryMenuParents'));
        }else
        {
            Cart::destroy();
            return view('pages.checkout.payment.hand-cash', compact('categoryMenuParents'));
        }

    }

    public function order_place_use_bumbumman99(Request $request)
    {
        $cartProducts = Cart::content();
        //insert payment
        $payment_data = array();
        $payment_data['method'] = $request->payment_option;
        $payment_data['status'] = '1';
        $payment = Payment::create($payment_data);

        //insert order
        $order_data = array();
        $order_data['customer_id'] = session()->get('customer_id');
        $order_data['shipping_id'] = session()->get('shipping_id');
        $order_data['payment_id'] = $payment->id;
        $order_data['total'] = Cart::total(0,',','.');
        $order_data['status'] = '1';
        $order = Order::create($order_data);

        //insert order detail
        $order_detail = array();
        foreach ($cartProducts as $product)
        {
            $order_detail['order_id'] = $order->id;
            $order_detail['product_id'] = $product->id;
            $order_detail['product_name'] = $product->name;
            $order_detail['product_price'] = $product->price;
            $order_detail['product_sales_quantity'] = $product->qty;
            $orderDetailInstance = OrderDetail::create($order_detail);
        }
        $categoryMenuParents = Category::where('parent_id', 0)->take(3)->get();
        if ($payment_data['method'] == 1)
        {
            Cart::destroy();
            return view('pages.checkout.payment.atm-cash', compact('categoryMenuParents'));
        }else
        {
            Cart::destroy();
            return view('pages.checkout.payment.hand-cash', compact('categoryMenuParents'));
        }

    }

}
