<?php
/**
 * Created by PhpStorm.
 * User: riggllm
 * Date: 5/29/17
 * Time: 9:10 AM
 */

namespace Ace\Services;

use Illuminate\Validation\Validator;

class CustomValidators extends Validator
{
    /**
     * Validate that an attribute contains only lowercase alpha-numeric characters, dashes, and underscores.
     *
     * @see Validator:validateAlphaDash for default alpha_dash functionality
     *
     * @param string $attribute Applied Field Name
     * @param string $value Applied Field Value
     * @param array $parameters Validation rule(s)
     * @param Validator $validator The full validation object
     *
     * @return boolean
     */
    public function validateLowercaseAlphaDash( $attribute, $value, $parameters, $validator )
    {
        if ( !is_string( $value ) && !is_numeric( $value ) ) {
            return false;
        }
        elseif ( $value != strtolower( $value ) ) {
            return false;
        }

        return preg_match( '/^[\pL\pM\pN_-]+$/u', $value ) > 0;
    }
}
