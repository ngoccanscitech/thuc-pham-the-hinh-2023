<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\SocialCustomers;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class LoginCustomerController extends Controller
{
    public function login_google_customer()
    {
        config(['services.google.redirect'=>env('GOOGLE_CLIENT_URL')]);
        return Socialite::driver('google')->redirect();
    }

    public function google_callback()
    {
        config(['services.google.redirect'=>env('GOOGLE_CLIENT_URL')]);
        $users = Socialite::driver('google')->stateless()->user();
        $authUser = $this->findOrCreateCustomer($users, 'google');
        if ($authUser) {
            $customer = Customer::where('id', $authUser->user)->first();
            session()->put('customer_name', $customer->name);
            session()->put('customer_id', $customer->id);
            session()->put('customer_picture', $customer->picture);
        }
        return redirect()->route('home')->with('success','Đăng nhập bằng tài khoản google <span style="color:red">'.
            $customer->email.'</span> thành công');
    }

    public function findOrCreateCustomer($users, $provider)
    {
        $authUser = SocialCustomers::where('provider_user_id', $users->id)->first();
        if($authUser){

            return $authUser;
        }

        $customer_new = new SocialCustomers([
            'provider_user_id' => $users->id,
            'provider_user_email'=>$users->email,
            'provider' => strtoupper($provider)
        ]);

        $customer = Customer::where('email',$users->email)->first();

        if(!$customer){
            $customer = Customer::create([
                'name' => $users->name,
                'email' => $users->email,
                'password' => '',
                'phone' => '',
                'picture'=>$users->avatar
            ]);
        }
        $customer_new->customer()->associate($customer);
        $customer_new->save();

        $account_name = Customer::where('id',$customer_new->user)->first();
        Session::put('admin_name',$account_name->admin_name);
        Session::put('admin_id',$account_name->admin_id);
        return $customer_new;
    }
}
