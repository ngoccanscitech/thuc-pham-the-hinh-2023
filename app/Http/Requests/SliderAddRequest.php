<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'bail|required|unique:sliders|max:255|min:5',
            'description' => 'required',
            'slider_image' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Tên bắt buộc phải nhập',
            'name.unique'=>'Tên bắt buộc phải duy nhất',
            'name.min'=>'Tên tối thiểu phải 5 ký tự',
            'slider_image.required'=>'Hình ảnh là bắt buộc',
            'description.required'=>'Mô tả là bắt buộc',
        ];
    }
}
