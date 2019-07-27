<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class EditUser extends FormRequest
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
            'pic' => 'file|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nickname' => 'max:15',
            'comments' => 'max:50',
        ];
    }
    public function attributes()
    {
        return [
            'pic' => 'プロフィール画像',
            'nickname' => 'ニックネーム',
            'comments' => '一言',
        ];
    }
}
