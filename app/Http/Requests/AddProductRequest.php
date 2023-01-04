<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddProductRequest extends FormRequest
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
            'name' =>'bail|required|unique:products|min:5|max:255',
            'price'=>'required',
            'category_id'=>'required',
            'contents'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được phép để trống',
            'name.unique'=>'Tên bắt buộc là duy nhất',
            'name.min'=>'Tên bắt buộc tối thiểu 5 ký tự',
            'name.max'=>'Tên không được vượt quá 255 ký tự',
            'price.required'=>'Giá không được phép để trống',
            'category_id.required'=>'Danh mục không được phép để trống',
            'contents.required'=>'Nội dung không được phép để trống'
        ];
    }
}
