<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class OrderController extends Controller
{
    public function view_history_order(Order $order)
    {
        if (!session()->get('customer_id'))
        {
            return redirect()->route('login-checkout')->with('error', 'Vui lòng đăng nhập để xem lịch sử đơn hàng');
        }else
        {
            $categoryParents = Category::where('parent_id', 0)->get();
            $categoryMenuParents = Category::where('parent_id', 0)->take(3)->get();
            $orderDetails = OrderDetail::where('order_id', $order->order_code)->get();
            foreach ($orderDetails as $orderDetail)
            {
                $coupon_code = $orderDetail->coupon;
            }
            $coupon = Coupon::where('coupon_code',$coupon_code)->first();
            if ($coupon)
            {
                $coupon_condition = $coupon->coupon_condition;
                $coupon_number = $coupon->coupon_number;
            }else
            {
                $coupon_condition = 2;
                $coupon_number = 0;
            }
            $orderDetail = OrderDetail::where('order_id', $order->order_code)->first();
            return view('pages.history.view_history_order',
                compact('order', 'coupon_condition', 'coupon_number',
                    'orderDetail', 'categoryParents', 'categoryMenuParents'));
        }

    }

    public function history()
    {
        if (!session()->get('customer_id'))
        {
            return redirect()->route('login-checkout')->with('error', 'Vui lòng đăng nhập để xem lịch sử đơn hàng');
        }else
        {
            $orders = Order::where('customer_id',session()->get('customer_id') )->latest()->paginate(10);
            $categoryParents = Category::where('parent_id', 0)->get();
            $categoryMenuParents = Category::where('parent_id', 0)->take(3)->get();
            return view('pages.history.history', compact('orders', 'categoryParents', 'categoryMenuParents'));
        }
    }


    public function create_pdf(Order $order)
    {
        $order = Order::where('id',$order->id)->first();
        $orderDetail = OrderDetail::where('order_id', $order->order_code)->first();
        $orderDetails = OrderDetail::where('order_id', $order->order_code)->get();
        foreach ($orderDetails as $orderDetail)
        {
            $coupon_code = $orderDetail->coupon;
        }
        $coupon = Coupon::where('coupon_code',$coupon_code)->first();
        if ($coupon)
        {
            $coupon_condition = $coupon->coupon_condition;
            $coupon_number = $coupon->coupon_number;
        }else
        {
            $coupon_condition = 2;
            $coupon_number = 0;
        }
        $pdf = Pdf::loadView('admin.order.pdf.invoice',
            compact('order', 'coupon_condition', 'coupon_number', 'orderDetail'));
        return $pdf->download('invoice.pdf');
    }

    public function update_row_qty(Request $request)
    {
        $orderDetail = OrderDetail::where('order_id',$request->order_id)->where('product_id',$request->product_id)->first();
        $orderDetail->product_sales_quantity = $request->order_quantity;
        $orderDetail->save();
    }
    public function update_order_qty(Request $request)
    {
        $data = $request->all();
        $order = Order::where('id',$data['order_id'])->first();
        $order->status = $data['order_status'];
        $order->save();

        if($order->status == 2)
        {
            foreach ($data['order_product_id'] as $key => $product_id)
            {
                foreach ($data['order_quantity'] as $key2 => $order_product_qty)
                {
                    $product = Product::find($product_id);
                    $product_quantity = $product->quantity;
                    $product_sold = $product->product_sold;
                    if ($key == $key2)
                    {
                        $product_remain = $product_quantity - $order_product_qty;
                        $product->quantity = $product_remain;
                        $product->product_sold = $product_sold + $order_product_qty;
                        $product->save();
                    }

                }
            }
        }elseif ($order->status == 1)
        {
            foreach ($data['order_product_id'] as $key => $product_id)
            {
                foreach ($data['order_quantity'] as $key2 => $product_sole)
                {
                    $product_update_qty = Product::find($product_id);
                    if ($key == $key2)
                    {
                        $product_update_qty->quantity = $product_update_qty->quantity + $product_sole;
                        $product_update_qty->product_sold = $product_update_qty->product_sold - $product_sole;
                        $product_update_qty->save();
                    }
                }
            }
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::latest()->paginate(5);
        return view('admin.order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        $order = DB::table('orders')
//            ->join('customers','orders.customer_id','=','customers.id')
//            ->join('shippings','orders.shipping_id','=','shippings.id')
//            ->join('order_details','orders.id','=','order_details.order_id')
//            ->select('orders.*','shippings.*','customers.*','order_details.*')
//            ->where('orders.id',$id)
//            ->first();
        $order = Order::where('id',$id)->first();
//        $customer_id = $order->customer_id;
//        $shipping_id = $order->shipping_id;
//        $customer = Customer::find($customer_id);
//        $shipping = Shipping::find($shipping_id);
        $orderDetails = OrderDetail::where('order_id', $order->order_code)->get();
        foreach ($orderDetails as $orderDetail)
        {
            $coupon_code = $orderDetail->coupon;
        }
        //Nếu có mã khuyến mãi thì lấy ra
        if (!empty($coupon_code))
        {
            $coupon = Coupon::where('coupon_code',$coupon_code)->first();
        }else
        {
            $coupon = 0;
        }
        if (!empty($coupon))
        {
            $coupon_condition = $coupon->coupon_condition;
            $coupon_number = $coupon->coupon_number;
        }else
        {
            $coupon_condition = 2;
            $coupon_number = 0;
        }

        $orderDetail = OrderDetail::where('order_id', $order->order_code)->first();

        return view('admin.order.show', compact('order', 'coupon_condition', 'coupon_number', 'orderDetail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
