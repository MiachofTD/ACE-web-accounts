<?php
/**
 * Created by PhpStorm.
 * User: lisa
 * Date: 6/2/17
 * Time: 6:53 PM
 */

if ( !function_exists( 'input_compare' ) ) {
    /**
     * @param $input
     * @param $compare
     *
     * @return bool|mixed
     *
     */
    function input_compare( $input, $compare )
    {
        if ( is_string( $input ) && is_string( $compare ) ) {
            $inputValue = input_get( $input );
            if ( is_array( $inputValue ) ) {
                return ( in_array( $compare, $inputValue ) );
            }

            return ( $inputValue == $compare );
        }

        return false;
    }
}

if ( !function_exists( 'input_get' ) ) {
    /***
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    function input_get( $key, $default = null )
    {
        return request()->get( $key, $default );
    }
}

if ( !function_exists( 'input_has' ) ) {
    /***
     * @param $key
     *
     * @return boolean
     */
    function input_has( $key )
    {
        return request()->has( $key );
    }
}
