<?php
/**
 * Created by PhpStorm.
 * User: lisa
 * Date: 12/8/18
 * Time: 9:52 PM
 */

namespace Ace\Services;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class PasswordHasher implements HasherContract
{
    /**
     * Password and salt are hashed together using sha512. The raw/binary output from that is base64 encoded. Using the
     * raw/binary output matches the SHA512Managed class being used in the C# application to generate the hash.
     *
     * @param string $value
     * @param array $options
     *
     * @return string
     */
    public function make( $value, array $options = [] )
    {
        if ( array_has( $options, 'salt' ) ) {
            $salt = base64_decode( $options[ 'salt' ] );
            return base64_encode( hash( 'sha512', $value . $salt, true ) );
        }
        return base64_encode( hash( 'sha512', $value ) );
    }

    /**
     * Password and salt are hashed together using sha512. The raw/binary output from that is base64 encoded. Using the
     * raw/binary output matches the SHA512Managed class being used in the C# application to generate the hash.
     *
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

        if ( array_has( $options, 'salt' ) ) {
            $salt = base64_decode( $options[ 'salt' ] );
            return ( base64_encode( hash( 'sha512', $value . $salt, true ) ) === $hashedValue );
        }

        return ( base64_encode( hash( 'sha512', $value, true ) ) === $hashedValue );
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