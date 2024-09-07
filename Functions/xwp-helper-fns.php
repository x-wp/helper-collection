<?php
/**
 * Helper functions definition file
 *
 * @package eXtended WordPress
 * @subpackage Helper\Functions
 */

use XWP\Helper\Functions as f;

if ( ! function_exists( 'wp_load_filesystem' ) ) :
	/**
	 * Loads the WordPress filesystem
	 *
	 * @param  array|false  $args                         Optional. Connection args, These are passed directly to the WP_Filesystem_*() classes. Default false.
	 * @param  string|false $context                      Optional. Context for get_filesystem_method(). Default false.
	 * @param  bool         $allow_relaxed_file_ownership Optional. Whether to allow Group/World writable. Default false.
     *
	 * @return \WP_Filesystem_Base|false|null
	 */
	function wp_load_filesystem(
        array|false $args = false,
        string|false $context = false,
        bool $allow_relaxed_file_ownership = false,
	): \WP_Filesystem_Base|false|null {
		return f\WPFS::load( $args, $context, $allow_relaxed_file_ownership );
	}
endif;

if ( ! function_exists( 'wp_array_flatmap' ) ) :
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
	function wp_array_flatmap( callable $callback, array $input_array ) {
        return f\Array_Extra::flatmap( $callback, $input_array );
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
     * @template T The type of the elements in the input array.
     *
     * @param  array<string, T>     $input_array Input array.
     * @param  array<string>|string ...$keys     Keys to exclude.
     * @return array<string, T>                  Array with the keys removed.
     */
    function xwp_array_diff_assoc( array $input_array, string ...$keys ) {
        if ( is_array( $keys[0] ) ) {
            $keys = $keys[0];
        }

        return f\Array_Extra::diff_assoc( $input_array, $keys );
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

if ( ! function_exists( 'xwp_deregister_blocks' ) ) :
    /**
     * Deregister all blocks.
     *
     * @return array<string> The names of the blocks that were deregistered.
     */
    function xwp_deregister_blocks(): array {
        return f\Block::deregister_all();
    }
endif;

if ( ! function_exists( 'xwp_remove_hook_callbacks' ) ) :
    /**
     * Remove callbacks for a given classname.
     *
     * @param class-string $classname   The name of the class to remove callbacks for.
     * @param string|false $target_hook Optional. Hook tag to remove callbacks for.
     * @param string|false $method      Optional. The name of the method to remove callbacks for.
     * @param int|false    $priority    Optional. The priority of the hook to remove callbacks for.
     *
     * @return array<string, array> The names of the callbacks that were removed.
     */
    function xwp_remove_hook_callbacks(
        string $classname,
        string|false $target_hook = false,
        string|false $method = false,
        int|false $priority = false,
	): array {
        return f\Hook_Remover::remove_callbacks( $classname, $target_hook, $method, $priority );
    }
endif;

if ( ! function_exists( 'xwp_clean' ) ) :
    /**
     * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
     * Non-scalar values are ignored.
     *
     * @param  string|array $input Data to sanitize.
     * @return string|array
     */
    function xwp_clean( $input ) {
        return f\Request::clean( $input );
    }
endif;

if ( ! function_exists( 'xwp_uclean' ) ) :
    /**
     * Unslash then clean variables using sanitize_text_field. Arrays are cleaned recursively.
     * Non-scalar values are ignored.
     *
     * @param  string|array $input Data to sanitize.
     * @return string|array
     */
	function xwp_uclean( $input ) {
		return f\Request::uclean( $input );
	}
endif;

if ( ! function_exists( 'xwp_format_term_name' ) ) :
    /**
     * Format a term name with term parents.
     *
     * @param  WP_Term|int|string|null|array|\WP_Error $term WP_Term object, Term ID, Term slug, or Term name.
     * @param  array<string, mixed>                    $args Formatting arguments. Default empty array.
     *   - formatter (callable) Custom formatter for the displayed term name. Default null.
     *   - count (bool) Whether to include the term count in the formatted name. Default false.
     *   - link_format (string|callable|array|bool) URL Link format for the term link. Default false.
     *   - link_items (bool) Whether to link the term items. Default false.
     *   - link_final (bool) Whether to link the final term. Default true.
     *   - separator (string) Separator between terms. Default ' > '.
     *   - taxonomy (string) Taxonomy name. Default null. Mandatory if $term is a string. Optional otherwise.
     * @return string Formatted term name with ancestors.
     */
    function xwp_format_term_name( WP_Term|int|string|null|array|\WP_Error $term, array $args = array() ): string {
        return f\Term::format_hierarhical_name( $term, $args );
    }
endif;
