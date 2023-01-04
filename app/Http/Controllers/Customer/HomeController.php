<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        //seo
        $meta_desc = "Thể hình phục vụ cuộc sống không để cuộc sống phục vụ thể hình. Là 1 gymer ngoài việc có body đẹp cần là 1 người có ích trong xã hội: trí tuệ, sức khỏe, sẻ chia";
        $meta_keywords = "thol store, trang bị thể hình, quần áo gym, thực phẩm bổ sung";
        $meta_title = "THOL - Thực phẩm bổ sung thể hình, phụ kiện tập GYM VIP";
        $url_canonical = $request->url();

        $categoryParents = Category::where('parent_id', 0)->get();
        $categoryMenuParents = Category::where('parent_id', 0)->take(3)->get();
        $sliders = Slider::latest()->get();
        $products = Product::latest()->take(6)->get();
        $productsRecommend = Product::latest('views_count', 'desc')->take(6)->get();
        $categories = Category::all();
        return view('pages.home.home', compact('sliders', 'categoryParents',
            'products', 'productsRecommend', 'categoryMenuParents',
            'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical'
        ));
    }

    public function search_product(Request $request)
    {
        $categoryParents = Category::where('parent_id', 0)->get();
        $categoryMenuParents = Category::where('parent_id', 0)->take(3)->get();
        $sliders = Slider::latest()->get();
        $products = Product::where('name','LIKE','%'.$request->keyword.'%')->paginate(6);
        return view('pages.product.search_products', compact('sliders', 'categoryParents',
            'products', 'categoryMenuParents'));
    }
}
