<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use App\Traits\DeleteModelTrait;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    use DeleteModelTrait;

    public function check_coupon(Request $request)
    {
        $data = $request->all();
        $couponFromDB = Coupon::where('coupon_code', $data['coupon_code'])->first();

        $couponFromSession = session()->get('coupon');
        /*
         * Neu nhap ma sai thi bo qua
         * Check ma coupon duoc gui len xem co ton tai trong session coupon khong?
         * Neu khong co trung thi tao moi
         * Nguoc lai co roi thi bo qua
         * Neu chua co session coupon thi tao moi
         */
        if (!empty($couponFromDB))
        {
            if ($couponFromSession)
            {
                $is_available = 0;
                foreach ($couponFromSession as $key => $coupon)
                {
                    if ($coupon['coupon_code'] == $couponFromDB->coupon_code)
                    {
                        $is_available++;
                    }
                }
                if ($is_available == 0 ){
                    $new_coupon[] = array(
                        'coupon_code'=>$couponFromDB->coupon_code,
                        'coupon_condition'=>$couponFromDB->coupon_condition,
                        'coupon_number'=>$couponFromDB->coupon_number,
                    );
                    session()->flash('success','Thêm mã giảm giá thành công!');
                    session()->put('coupon', $new_coupon);
                }else{
                    session()->flash('error','Thêm mã giảm giá thất bại!');
                }
            }else{
                /*
                 * Neu chua co coupon trong session thi tao moi
                 */
                $new_coupon[] = array(
                    'coupon_code'=>$couponFromDB->coupon_code,
                    'coupon_condition'=>$couponFromDB->coupon_condition,
                    'coupon_number'=>$couponFromDB->coupon_number,
                );
                session()->flash('success','Thêm mã giảm giá thành công!');
                session()->put('coupon', $new_coupon);
            }
        }else{
            session()->flash('error','Thêm mã giảm giá thất bại!');
        }

        return redirect()->back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::orderBy('id', 'DESC')->paginate(7);
        return view('admin.coupon.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $coupon = new Coupon();
        $coupon->coupon_name = $data['coupon_name'];
        $coupon->coupon_code = $data['coupon_code'];
        $coupon->coupon_time = $data['coupon_time'];
        $coupon->coupon_condition = $data['coupon_condition'];
        $coupon->coupon_number = $data['coupon_number'];
        $coupon->save();
        session()->flash('success', 'Thêm mã giảm giá thành công');
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        return $this->deleteModelTrait($coupon);
    }
}
