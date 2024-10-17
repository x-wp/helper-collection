<?php //phpcs:disable WordPress.Security.NonceVerification, WordPress.Security.ValidatedSanitizedInput, SlevomatCodingStandard.Operators.SpreadOperatorSpacing.IncorrectSpacesAfterOperator

namespace XWP\Helper\Functions;

/**
 * Request helper class.
 */
final class Request {
    /**
     * Check if a REST namespace should be loaded. Useful to maintain site performance even when lots of REST namespaces are registered.
     *
     * @since 9.2.0.
     *
     * @param string        $space The namespace to check.
     * @param string        $route (Optional) The REST route being checked.
     * @param array<string> $known Known namespaces that we know are safe to not load if the request is not for them.
     *
     * @return bool True if the namespace should be loaded, false otherwise.
     */
    public static function should_load_rest_ns( string $space, ?string $route = null, array $known = array() ): bool {
        $route ??= $GLOBALS['wp']->query_vars['rest_route'] ?? false;

        if ( ! $route ) {
            return true;
        }

        $route = \trailingslashit( \ltrim( $route, '/' ) );
        $space = \trailingslashit( $space );

		/**
		 * Known namespaces that we know are safe to not load if the request is not for them.
		 * Namespaces not in this namespace should always be loaded, because we don't know if they won't be making another internal REST request to an unloaded namespace.
		 *
		 * @param  array<string> $known_ns Known namespaces that we know are safe to not load if the request is not for them.
		 * @param  string        $space    The namespace to check.
		 * @param  string        $route    The REST route being checked.
		 * @return array<string>
		 *
		 * @since 1.16.0
		 */
		$known = \apply_filters( 'xwp_known_rest_namespaces', $known, $space, $route );

		if ( ! \array_reduce( $known, static fn( $c, $r ) => $c || \str_starts_with( $route, $r ), false ) ) {
			return true;
		}

        $load = \str_starts_with( $route, $space );

		/**
		 * Filters whether a namespace should be loaded.
		 *
		 * @param bool   $load  True if the namespace should be loaded, false otherwise.
		 * @param string $space The namespace to check.
		 * @param string $route The REST route being checked.
		 * @param array  $known Known namespaces that we know are safe to not load if the request is not for them.
		 * @return bool
		 *
		 * @since 1.16.0
		 */
		return \apply_filters( 'xwp_rest_can_load_namespace', $load, $space, $route, $known );
    }

    /**
     * Clean input data.
     *
     * @param  string|array $input The input data.
     * @return string|array The cleaned input data.
     */
    public static function clean( $input ) {
        return match ( true ) {
            \is_array( $input )  => \array_map( array( self::class, 'clean' ), $input ),
            \is_scalar( $input ) => \sanitize_text_field( $input ),
            default              => $input,
        };
    }

    /**
     * Unslash and clean input data.
     *
     * @param  string|array $input The input data.
     * @return string|array The cleaned input data.
     */
    public static function uclean( $input ) {
        return self::clean( \wp_unslash( $input ) );
    }

    /**
     * Fetch, unslash, and clean a variable.
     *
     * @param  string $val Request variable.
     * @param  mixed  $def The default value.
     * @return mixed The fetched value.
     */
    private static function fetch_var( &$val, $def = null ) {
        return self::uclean( $val ?? $def );
    }

    /**
     * Fetch a variable from the $_GET superglobal.
     *
     * @param  string $key The key to fetch.
     * @param  mixed  $def The default value.
     * @return mixed The fetched value.
     */
    public static function fetch_get_var( $key, $def = null ) {
        return self::fetch_var( $_GET[ $key ], $def );
    }

    /**
     * Fetch a variable from the $_POST superglobal.
     *
     * @param  string $key The key to fetch.
     * @param  mixed  $def The default value.
     * @return mixed The fetched value.
     */
    public static function fetch_post_var( $key, $def = null ) {
        return self::fetch_var( $_POST[ $key ], $def );
    }

    /**
     * Fetch a variable from the $_REQUEST superglobal.
     *
     * @param  string $key The key to fetch.
     * @param  mixed  $def The default value.
     * @return mixed The fetched value.
     */
    public static function fetch_req_var( $key, $def = null ) {
        return self::fetch_var( $_REQUEST[ $key ], $def );
    }

    /**
     * Fetch a variable from the $_SERVER superglobal.
     *
     * @param  string $key The key to fetch.
     * @param  mixed  $def The default value.
     * @return mixed The fetched value.
     */
    public static function fetch_server_var( $key, $def = null ) {
        return self::fetch_var( $_SERVER[ $key ], $def );
    }

    /**
     * Fetch a variable from the $_COOKIE superglobal.
     *
     * @param  string $key The key to fetch.
     * @param  mixed  $def The default value.
     * @return mixed The fetched value.
     */
    public static function fetch_cookie_var( $key, $def = null ) {
        return self::fetch_var( $_COOKIE[ $key ], $def );
    }

    /**
     * Fetch a variable from the $_FILES superglobal.
     *
     * @param  string $key The key to fetch.
     * @param  mixed  $def The default value.
     * @return mixed The fetched value.
     */
    public static function fetch_files_var( $key, $def = null ) {
        return self::fetch_var( $_FILES[ $key ], $def );
    }

    /**
     * Fetch `$_GET` superglobal array.
     *
     * @return array<string, mixed>
     */
    public static function fetch_get_arr() {
        return self::fetch_var( $_GET, array() );
    }

    /**
     * Fetch `$_POST` superglobal array.
     *
     * @return array<string, mixed>
     */
    public static function fetch_post_arr() {
        return self::fetch_var( $_POST, array() );
    }

    /**
     * Fetch `$_REQUEST` superglobal array.
     *
     * @return array<string, mixed>
     */
    public static function fetch_req_arr() {
        return self::fetch_var( $_REQUEST, array() );
    }

    /**
     * Fetch `$_SERVER` superglobal array.
     *
     * @return array<string, mixed>
     */
    public static function fetch_server_arr() {
        return self::fetch_var( $_SERVER, array() );
    }

    /**
     * Fetch `$_COOKIE` superglobal array.
     *
     * @return array<string, mixed>
     */
    public static function fetch_cookie_arr() {
        return self::fetch_var( $_COOKIE, array() );
    }

    /**
     * Fetch `$_FILES` superglobal array.
     *
     * @return array<string, mixed>
     */
    public static function fetch_files_arr() {
        return self::fetch_var( $_FILES, array() );
    }
}
