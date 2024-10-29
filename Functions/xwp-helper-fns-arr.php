<?php
/**
 * Array helper functions definition file.
 *
 * @package eXtended WordPress
 * @subpackage Helper\Functions
 */

use XWP\Helper\Functions as f;

if ( ! function_exists( 'xwp_array_flatmap' ) ) :
    /**
	 * Flattens and maps an array.
	 *
	 * @template T The type of the elements in the input array.
	 * @template R The type of the elements in the returned array.
     *
	 * @param  callable(T): R      $callback    Function to apply to each element.
	 * @param  array<array-key, T> $input_array  Array to flatten and map.
     *
	 * @return array<array-key, R>
	 */
	function xwp_array_flatmap( callable $callback, array $input_array ) {
        return f\Array_Extra::flatmap( $callback, $input_array );
	}
endif;

if ( ! function_exists( 'wp_array_flatmap' ) ) :
    /**
	 * Flattens and maps an array.
	 *
	 * @template T The type of the elements in the input array.
	 * @template R The type of the elements in the returned array.
     *
	 * @param  array<array-key, T>|callable(T): R $callback    Function to apply to each element.
	 * @param  array<array-key, T>|callable(T): R $input_array  Array to flatten and map.
     *
	 * @return array<array-key, R>
	 */
	function wp_array_flatmap( callable|array $callback, array|callable $input_array ) {
        return is_array( $input_array )
            ? xwp_array_flatmap( $callback, $input_array )
            : xwp_array_flatmap( $input_array, $callback );
	}
endif;

if ( ! function_exists( 'wp_array_flatmap_assoc' ) ) :
    /**
     * Flatten and map an associative array of arrays.
     *
     * @template R
     * @template T — Applies the callback to the elements of the given arrays
     *
     * @param  callable(T): R           $callback Callback function to run for each element in each array.
     * @param  array<string, <array<T>> $input    The input array.
     * @param  key-of<T>                $key      Key whose value will be used as the key for the returned array.
     * @param  bool                     $unkey    Optional. Whether to remove the key from the returned array. Default true.
     *
     * @return array<value-of<key-of<T>>, R> An array containing all the elements of arr1 after applying the callback function to each one.
     */
    function wp_array_flatmap_assoc( callable $callback, array $input, string $key, bool $unkey = true ) {
        return f\Array_Extra::flatmap_assoc( $callback, $input, $key, $unkey );
    }
endif;

if ( ! function_exists( 'wp_array_diff_assoc' ) ) :
    /**
     * Legacy function to extract a slice of an array not including the specified keys.
     *
     * @param  array $input_array Input array.
     * @param  array $keys        Keys to exclude.
     */
    function wp_array_diff_assoc( array $input_array, array $keys ) {
        return xwp_array_diff_assoc( $input_array, ...$keys );
    }
endif;

if ( ! function_exists( 'xwp_array_diff_assoc' ) ) :
    /**
     * Extracts a slice of array not including the specified keys.
     *
     * @template T
     *
     * @param  T                    $arr     Input array.
     * @param  string|array<string> ...$keys Keys to exclude.
     * @return T
     */
    function xwp_array_diff_assoc( array $arr, array|string ...$keys ) {
        if ( is_array( $keys[0] ) ) {
            $keys = $keys[0];
        }

        return f\Array_Extra::diff_assoc( $arr, $keys );
    }

endif;

if ( ! function_exists( 'wp_array_rekey' ) ) :
    /**
     * Rekey an array of arrays by a specific key.
     *
     * @param  array<string, array<string, mixed>> $arr The input array.
     * @param  string                              $key The key to rekey by.
     * @return array<string, array<string, mixed>>      The rekeyed array.
     */
    function wp_array_rekey( array $arr, string $key ): array {
        return f\Array_Extra::rekey( $arr, $key );
    }
endif;

if ( ! function_exists( 'xwp_array_slice_assoc' ) ) :
    /**
     * Extracts a slice of an array.
     *
     * @template T The type of the elements in the input array.
     *
     * @param  array<string, T> $input_array Input array.
     * @param  string           ...$keys     Keys to include.
     * @return array<string, T>              Array with only the keys specified.
     */
	function xwp_array_slice_assoc( array $input_array, string ...$keys ) {
		return f\Array_Extra::slice_assoc( $input_array, $keys );
	}
endif;

if ( ! function_exists( 'xwp_str_to_arr' ) ) :
    /**
     * Convert a string to an array.
     *
     * @param  null|string|array<int,string> $target The string to convert.
     * @param  null|string                   $delim              Optional. The delimiter to use. Default is ','.
     * @return array<int,string>
     */
    function xwp_str_to_arr( string|array|null $target = null, ?string $delim = null ): array {
        return f\Array_Extra::from_string( $target ?? array(), $delim ?? ',' );
    }
endif;
