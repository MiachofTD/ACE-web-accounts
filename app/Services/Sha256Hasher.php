<?php

/**
 * Created by PhpStorm.
 * User: riggllm
 * Date: 5/28/17
 * Time: 10:03 PM
 */

namespace Ace\Services;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class Sha256Hasher implements HasherContract
{
    /**
     * @param string $value
     * @param array $options
     *
     * @return string
     */
    public function make( $value, array $options = [] )
    {
        return hash( 'sha256', $value );
    }

    /**
     * @param string $value
     * @param string $hashedValue
     * @param array $options
     *
     * @return bool
     */
    public function check( $value, $hashedValue, array $options = [] )
    {
        if ( strlen( $hashedValue ) === 0 ) {
            return false;
        }

        return ( hash( 'sha256', $value ) === $hashedValue );
    }

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param string $hashedValue
     * @param array $options
     *
     * @return bool
     */
    public function needsRehash( $hashedValue, array $options = [] )
    {
        return password_needs_rehash( $hashedValue, PASSWORD_DEFAULT );
    }
}
