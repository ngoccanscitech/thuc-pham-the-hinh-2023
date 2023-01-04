<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MailController extends Controller
{
    public function send_email()
    {
        $to_name = "hieu tan tutorial";
        $to_email = "nguyenngoccanvietnam@gmail.com";//send to this email

        $data = array("name"=>"chào khách hàng","body"=>"Nội dung thư"); //body of mail.blade.php

        Mail::send('pages.emails.test',$data,function($message) use ($to_name,$to_email){
            $message->to($to_email)->subject('Tiêu đề mail gửi khách');//send this mail with subject
            $message->from($to_email,$to_name);//send from this mail
        });


    }

    public function reset_new_password(Request $request)
    {
        $data = $request->all();
        $customer = Customer::where('email', $data['account_email'])->where('token', $data['account_token'])->first();
        $newToken = Str::random();
        if ($customer)
        {
            $customer->password =  Hash::make($data['account_password']);
            $customer->token = $newToken;
            $customer->save();
            session()->flash('success', 'Cập nhật mật khẩu thành công, vui lòng đăng nhập');
            return redirect()->route('login-checkout');
        }else
        {
            session()->flash('error', 'Vui lòng nhập lại email vì link đã hết hạn');
            return redirect()->back();
        }
    }

    public function update_new_password()
    {
        $categoryParents = Category::where('parent_id', 0)->get();
        $categoryMenuParents = Category::where('parent_id', 0)->take(3)->get();
        return view('pages.login.new_password', compact('categoryParents', 'categoryMenuParents'));
    }
    public function forget_password(Request $request)
    {
        $categoryParents = Category::where('parent_id', 0)->get();
        $categoryMenuParents = Category::where('parent_id', 0)->take(3)->get();
        return view('pages.login.forget_password', compact('categoryParents', 'categoryMenuParents'));
    }

    public function recovery_password(Request $request)
    {
        $data = $request->all();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
        $title_mail = "Lấy lại mật khẩu ShopCan ".$now;
        $customerExist = Customer::where('email', $data['account_email'])->first();
        if (empty($customerExist))
        {
            session()->flash('error', 'Email không tồn tại');
            return redirect()->back();
        }else
        {
            $token_random = Str::random();
            $customer = Customer::where('id', $customerExist->id)->first();
            $customer->token = $token_random;
            $customer->save();

            $to_email = $data['account_email'];
            $link_reset_pass = url('update-new-password?email='.$to_email.'&token='.$token_random);

            $data = array(
                'name'=>$title_mail,
                'body'=>$link_reset_pass,
                'email'=>$data['account_email']
            );

            Mail::send('login.forget_pass_notify', compact('data'), function ($message) use ($title_mail, $data){
                $message->to($data['email'])->subject($title_mail);
                $message->from($data['email'], $title_mail);
            });
            session()->put('success','Gửi mail thành công, vui lòng vào email để reset password');
            return redirect()->back();
        }
    }
}
