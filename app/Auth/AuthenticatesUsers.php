<?php
/**
 * Created by PhpStorm.
 * User: riggllm
 * Date: 5/29/17
 * Time: 6:36 PM
 */

namespace Ace\Auth;

trait AuthenticatesUsers
{
    /**
     * Overload the username function in Illuminate\Foundation\Auth\AuthenticatesUsers
     *
     * @return string
     */
    public function loginUsername()
    {
        return 'account';
    }
}