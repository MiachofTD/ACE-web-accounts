<?php
/**
 * Created by PhpStorm.
 * User: riggllm
 * Date: 5/28/17
 * Time: 9:17 PM
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'account' => 'required|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
//            'email' => 'optional|email'
        ];
    }
}