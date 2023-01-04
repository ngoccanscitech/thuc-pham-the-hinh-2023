<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\FeeShip;
use App\Models\Province;
use App\Models\Wards;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function delete_fee()
    {
        session()->forget('fee');
        return redirect()->back();
    }

    public function calculate_feeship(Request $request)
    {
        $data = $request->all();
        if ($data['matp'])
        {
            $fee_ship = FeeShip::where('matp',$data['matp'])->where('maqh', $data['maqh'])->where('xaid', $data['xaid'])->first();
            if ($fee_ship)
            {
                session()->put('fee', $fee_ship->fee_ship);
            }else
            {
                session()->put('fee', 25000);
            }

        }

    }

    public function update_feeship(Request $request)
    {
        $data = $request->all();
        $feeShip = FeeShip::find($data['feeship_id']);
//        $fee_value = rtrim($data['feeship_value'], '.');
//        $feeShip->fee_ship = $fee_value;
        $fee_value = str_replace('.','',$data['feeship_value']);
        $feeShip->fee_ship = $fee_value;
        $feeShip->save();
    }

    public function show_feeship(Request $request)
    {
        $fee_ship = FeeShip::orderBy('id','DESC')->get();
        $output = '';
        $output.='<div class="table-responsive">
<table class="table table-bordered">
<thead>
    <tr>
      <th>Tên thành phố</th>
      <th>Tên quận huyện</th>
      <th>Tên xã phường</th>
      <th>Phí ship(VNĐ)</th>
    </tr>
</thead>
<tbody>';

        foreach ($fee_ship as $feeShip)
        {
            $output.='
            <tr>
                <td>'.$feeShip->city->name.'</td>
                <td>'.$feeShip->province->name.'</td>
                <td>'.$feeShip->wards->name.'</td>
                <td contenteditable data-feeship_id="'.$feeShip->id.'"class="feeship_edit">'.number_format($feeShip->fee_ship,0,',','.').'</td>
            </tr>
            ';
        }

$output.='</tbody>
</table>
                </div>

        ';
        return $output;
    }

    public function create()
    {
        $cities = City::orderBy('matp', 'ASC')->get();
        return view('admin.delivery.create', compact('cities'));
    }

    public function select_delivery(Request $request)
    {
        $data = $request->all();
        $option = '';
        if ($data['action'] == 'city')
        {
            $provinces = Province::where('matp', $data['ma_id'])->get();
            $option.='<option value="0">---Chọn quận huyện---</option>';
            foreach ($provinces as $province)
            {
               $option.='<option value="'.$province->maqh.'">'.$province->name.'</option>';
            }
        }elseif($data['action'] == 'province'){
            $wards = Wards::where('maqh', $data['ma_id'])->get();
            $option.='<option value="0">---Chọn xã phường---</option>';
            foreach ($wards as $ward)
            {
                return $option.='<option value="'.$ward->xaid.'">'.$ward->name.'</option>';
            }
        }
        return $option;

    }

    public function store(Request $request)
    {
        $data = $request->all();
        $fee_ship = new FeeShip();
        $fee_ship->matp = $data['city'];
        $fee_ship->maqh = $data['province'];
        $fee_ship->xaid = $data['wards'];
        $fee_ship->fee_ship = $data['fee_ship'];
        $fee_ship->save();
    }

}
