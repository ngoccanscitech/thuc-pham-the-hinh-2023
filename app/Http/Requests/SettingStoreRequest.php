<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingStoreRequest extends FormRequest
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
            'config_key' => 'bail|required|unique:settings|max:255|min:5',
            'config_value' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'config_key.required'=>'Key Config bắt buộc phải nhập',
            'config_key.unique'=>'Key Config bắt buộc phải duy nhất',
            'config_key.min'=>'Key Config tối thiểu phải 5 ký tự',
            'config_value.required'=>'Value Config là bắt buộc phải nhập',
        ];
    }
}
