<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TagCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * 判断用户是否有权限发起请求
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();
        return $user ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //bail首次验证失败后，停止验证该属性的其他规则
            //unique 会去tags表里面验证tag字段的唯一性
            'tag'=>'bail|required|unique:tags,tag',
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
            'tag.required'=>'tag必须填写',
            'tag.unique'=>'tag必须是唯一的',
            'title.required'=>'标题必须填写',
            'subtitle.required'=>'副标题必须填写',
            'layout.require'=>'布局必须填写',
        ];

    }
}
