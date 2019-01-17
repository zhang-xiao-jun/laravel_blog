<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagUpdateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'title'=>'required',
            'subtitle'=>'required',
            'layout'=>'required',
        ];
    }

    /**
     * -自定义验证消息的返回类型
     * @return array
     */
    public function messages()
    {
        return [
            'title.required'=>'标题必须填写',
            'subtitle.required'=>'副标题必须填写',
            'layout.require'=>'布局必须填写',
        ];

    }
}
