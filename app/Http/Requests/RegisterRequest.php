<?php
/**
 * Created by PhpStorm.
 * User: riggllm
 * Date: 5/28/17
 * Time: 9:17 PM
 */

namespace Ace\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'account' => 'required|min:3|max:32|lowercase_alpha_dash|unique:account,account',
            'email' => 'required|email|unique:account,email',
            'g-recaptcha-response' => 'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'lowercase_alpha_dash' => 'The :attribute field can only contain lowercase letters, numbers, hyphens, and underscores.',
            'g-recaptcha-response.required' => 'The reCAPTCHA input is required.',
        ];
    }
}