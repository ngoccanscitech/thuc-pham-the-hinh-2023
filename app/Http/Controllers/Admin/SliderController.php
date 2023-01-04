<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SliderAddRequest;
use App\Models\Slider;
use App\Traits\DeleteModelTrait;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SliderController extends Controller
{
    use StorageImageTrait, DeleteModelTrait;
    protected $slider;
    public function __construct(Slider $slider)
    {
        $this->slider = $slider;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = $this->slider->latest()->paginate(5);
        return view('admin.slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderAddRequest $request)
    {
        $dataSlider = [
            'name' =>$request->name,
            'description'=>$request->description
        ];
        $dataImageUpload = $this->storageTraitUpload($request,'slider_image', 'slider');
        if (!empty($dataImageUpload))
        {
            $dataSlider['image_name'] = $dataImageUpload['file_name'];
            $dataSlider['image_path'] = $dataImageUpload['file_path'];
        }
        $slider = $this->slider->create($dataSlider);
        session()->flash('success','Tạo Slider thành công!');
        return redirect()->route('sliders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        return view('admin.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(SliderAddRequest $request, Slider $slider)
    {
        try {
            $dataSlider = [
                'name' =>$request->name,
                'description'=>$request->description
            ];
            $dataImageUpload = $this->storageTraitUpload($request,'slider_image', 'slider');
            if (!empty($dataImageUpload))
            {
                $dataSlider['image_name'] = $dataImageUpload['file_name'];
                $dataSlider['image_path'] = $dataImageUpload['file_path'];
            }
            $slider->update($dataSlider);
            session()->flash('success','Update Slider thành công!');
            return redirect()->back();
        }catch (\Exception $exception)
        {
            Log::error('Message '.$exception->getMessage().'--Line: '.$exception->getLine());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        return $this->deleteModelTrait($slider);
    }
}
