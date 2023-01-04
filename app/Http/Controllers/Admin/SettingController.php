<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SettingStoreRequest;
use App\Models\Setting;
use App\Traits\DeleteModelTrait;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use DeleteModelTrait;
    private $setting;

    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = $this->setting->latest()->paginate(5);
        return view('admin.setting.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.setting.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SettingStoreRequest $request)
    {
        $setting = $this->setting->create([
            'config_key'=> $request->config_key,
            'config_value'=>$request->config_value,
            'type'=>$request->type
        ]);
        session()->flash('success', 'Tạo setting thành công');
        return redirect()->route('settings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        return view('admin.setting.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        $setting->update($request->input());
        session()->flash('success', 'Cập nhật setting thành công.');
        return redirect()->route('settings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        return $this->deleteModelTrait($setting);
    }
}
