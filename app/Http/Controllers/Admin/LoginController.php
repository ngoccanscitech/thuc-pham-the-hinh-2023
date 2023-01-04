<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use App\Models\Login;
use App\Models\Social;
use App\Models\SocialCustomers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function login_google(){
        return Socialite::driver('google')->redirect();
    }

    public function callback_google(){
        $users = Socialite::driver('google')->stateless()->user();
        // return $users->id;
        /*
         * Hàm findOrCreateUser
         * nhận vào user từ Socialite
         *  Trả về account social
         */
        $authUser = $this->findOrCreateUser($users,'google');
        $account_name = Login::where('admin_id',$authUser->user)->first();
        Session::put('admin_name',$account_name->admin_name);
        Session::put('admin_id',$account_name->admin_id);
        return redirect()->route('home');


    }
    public function findOrCreateUser($users,$provider){
        $authUser = Social::where('provider_user_id', $users->id)->first();
        if($authUser){

            return $authUser;
        }

        $hieu = new Social([
            'provider_user_id' => $users->id,
            'provider_user_email'=>$users->email,
            'provider' => strtoupper($provider)
        ]);

        $orang = Login::where('admin_email',$users->email)->first();

        if(!$orang){
            $orang = Login::create([
                'admin_name' => $users->name,
                'admin_email' => $users->email,
                'admin_password' => '',

                'admin_phone' => '',
                'admin_status' => 1
            ]);
        }
        $hieu->login()->associate($orang);
        $hieu->save();

        $account_name = Login::where('admin_id',$hieu->user)->first();
        Session::put('admin_name',$account_name->admin_name);
        Session::put('admin_id',$account_name->admin_id);
        return $hieu;

    }



    public function login_facebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback_facebook()
    {
        /**
         * 1. Check trong table social xem id tu socialite co trung voi provider_user_id
         * 2. Neu trung la co, co thi tu bang social lay ra user admin
         * 3. roi dat vao session admin_id, admin_name
         * 4.redirect vao route home
         *
         * neu khong co trong tbl_social
         * 1. Tao ra record social gom provider_user_id la id socialite, provider la facebook, chua gan user id vao
         * 2. Tao ra record admin gom name, email, (phone,passsoword de trong), lay ra tu socialite
         * 3. gett id cua admin vua tao gan vao user id trong social
         * 4. redirect vao route home tuc la dashboard
         */
        $user = Socialite::driver('facebook')->user();
        $userExist = Social::where('provider_user_id', $user->id)->first();
        if ($userExist)
        {
            $admin = Login::where('admin_id', $userExist->user)->first();
            session()->put('admin_id', $admin->admin_id);
            session()->put('admin_name', $admin->admin_name);
            return redirect()->route('home');
        }else
        {
            $newUser = new Social();
            $newUser->provider_user_id = $user->id;
            $newUser->provider = 'facebook';

            /*
             * compare email socialite va email trong admin xem co ton tai khong?
             * ton tai thi lay ra, neu khong tao moi record admin
             */
            $getInfoAdmin = Login::where('admin_email', $user->email)->first();
            if (!empty($getInfoAdmin))
            {
                $newUser->login()->associate($getInfoAdmin);
            }else
            {
                $newInfoAdmin = new Login();
                $newInfoAdmin->admin_name = $user->name;
                $newInfoAdmin->admin_email = $user->email;
                $newInfoAdmin->admin_password = '';
                $newInfoAdmin->admin_phone = '';
                $newInfoAdmin->save();
                //$newUser->user = $newInfoAdmin->admin_id;
                $newUser->login()->associate($newInfoAdmin); // assign child to parent
            }
            $newUser->save();
            return redirect()->route('home');
        }

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check())
        {
            return redirect()->to('/dashboard');
        }
        return view('admin.login');
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
        if(Auth::attempt([
            'email'=>$request->email,
            'password'=>$request->password
        ],$request->remember))
        {
            $user = auth()->user();
            session()->put('admin_id', $user->id);
            session()->put('admin_name', $user->name);
            return redirect()->route('dashboard');
        }else
        {
            session()->put('errorCustom','Your email or password is incorrect!!!');
            return redirect()->route('login');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
