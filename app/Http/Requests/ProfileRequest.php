<?php
/**
 * Created by PhpStorm.
 * User: lisa
 * Date: 6/16/17
 * Time: 8:31 PM
 */

namespace Ace\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'email' => 'email|unique:account,email,' . auth()->user()->getAuthIdentifier(),
            'password' => 'present|min:6|confirmed',
            'password_confirmation' => 'min:6',
        ];
    }
}