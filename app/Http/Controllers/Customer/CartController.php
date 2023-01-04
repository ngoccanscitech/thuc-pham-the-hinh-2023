<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function delete_coupon()
    {
        $coupon = \session()->get('coupon');
        if ($coupon == true)
        {
            \session()->forget('coupon');
        }
        return redirect()->back();
    }

    public function delete_all_product()
    {
        $cart = \session()->get('cart');
        if ($cart == true)
        {
//            Session::destroy();
            \session()->forget('coupon');
            Session::forget('cart');
        }
        return redirect()->back();
    }

    public function update_cart(Request $request)
    {
        $data = $request->all();
        $cart = \session()->get('cart');
        if($cart == true)
        {
            foreach ($data['cart_qty'] as $key => $quantity) //key la sessionid, value la so san pham
            {
                echo $key.' '.$quantity.'<br/>';
                foreach ($cart as $cartRow => $product)
                {
                    if($product['session_id'] == $key)
                    {
                        $cart[$cartRow]['product_qty'] = $quantity;
                    }
                }
            }
            session()->put('cart',$cart);
        }
        \session()->flash('success', 'Cập nhật sản phẩm thành công');
        return redirect()->back();

    }

    public function deleteProductFromSession($sessionId)
    {
        $cart = \session()->get('cart');
        foreach ($cart as $key => $product)
        {
            if ($product['session_id'] == $sessionId)
            {
                unset($cart[$key]);
            }
        }
        \session()->put('cart', $cart);
        \session()->flash('success', 'Xóa sản phẩm thành công');
        return redirect()->back();
    }

    public function add_product_to_cart(Request $request)
    {
        $data = $request->all();
        $session_id = str(md5(microtime()),rand(0,26),5);
        $cart = Session::get('cart');
        if ($cart == true){
            $is_available = 0;
            foreach ($cart as $key => $value)
            {
                if($value['product_id'] == $data['cart_product_id'])
                {
                    $is_available++;
                }
            }
            if ($is_available == 0)
            {
                $cart[] = array(
                    'session_id'=>$session_id ,
                    'product_id'=>$data['cart_product_id'],
                    'product_name'=>$data['cart_product_name'],
                    'product_quantity'=>$data['cart_product_quantity'],
                    'product_qty'=>$data['cart_product_qty'],
                    'product_price'=>$data['cart_product_price'],
                    'product_image_path'=>$data['cart_product_image_path'],
                );
                Session::put('cart', $cart);
            }


        }else{
            $cart[] = array(
                'session_id'=>$session_id ,
                'product_id'=>$data['cart_product_id'],
                'product_name'=>$data['cart_product_name'],
                'product_quantity'=>$data['cart_product_quantity'],
                'product_qty'=>$data['cart_product_qty'],
                'product_price'=>$data['cart_product_price'],
                'product_image_path'=>$data['cart_product_image_path'],
            );
            Session::put('cart', $cart);
        }
    }

    public function save_cart(Request $request)
    {
        $data = $request->all();
        $session_id = str(md5(microtime()),rand(0,26),5);
        $cart = Session::get('cart');
        if ($cart == true){
            $is_available = 0;
            foreach ($cart as $key => $value)
            {
                if($value['product_id'] == $data['cart_product_id'])
                {
                    $is_available++;
                }
            }
            if ($is_available == 0)
            {
                $cart[] = array(
                    'session_id'=>$session_id ,
                    'product_id'=>$data['cart_product_id'],
                    'product_name'=>$data['cart_product_name'],
                    'product_quantity'=>$data['cart_product_quantity'],
                    'product_qty'=>$data['cart_product_qty'],
                    'product_price'=>$data['cart_product_price'],
                    'product_image_path'=>$data['cart_product_image_path'],
                );
                Session::put('cart', $cart);
            }


        }else{
            $cart[] = array(
                'session_id'=>$session_id ,
                'product_id'=>$data['cart_product_id'],
                'product_name'=>$data['cart_product_name'],
                'product_quantity'=>$data['cart_product_quantity'],
                'product_qty'=>$data['cart_product_qty'],
                'product_price'=>$data['cart_product_price'],
                'product_image_path'=>$data['cart_product_image_path'],
            );
            Session::put('cart', $cart);
        }
        return redirect()->route('cart.show');



        //Cart bumbummen99
//        $productId = $request->productId_hidden;
//        $quantity = $request->qty;
//        $product = Product::where('id',$productId)->first();
////        Cart::add('293ad', 'Product 1', 1, 9.99, 550);
//        $data['id'] = $productId;
//        $data['qty'] = $quantity;
//        $data['name'] = $product->name;
//        $data['price'] = $product->price;
//        $data['options']['image'] = $product->feature_image_path;
//        $data['weight'] = 0;
//        Cart::add($data);
//        Cart::setGlobalTax(0);
////        Cart::destroy();
    }

    public function show_cart()
    {
        $categoryMenuParents = Category::where('parent_id', 0)->take(3)->get();
        return view('pages.cart.show_cart_from_session', compact('categoryMenuParents'));
    }

    public function delete_to_cart($rowId)
    {
        Cart::update($rowId, 0);
        return redirect()->route('cart.show');
    }

    public function update_cart_quantity(Request $request)
    {
        $rowId = $request->rowId_cart;
        $quantity = $request->cart_quantity;
        Cart::update($rowId, $quantity);
        return redirect()->route('cart.show');
    }
}
