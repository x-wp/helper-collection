<?php //phpcs:disable WordPress.Security.NonceVerification, WordPress.Security.ValidatedSanitizedInput, SlevomatCodingStandard.Operators.SpreadOperatorSpacing.IncorrectSpacesAfterOperator

namespace XWP\Helper\Functions;

/**
 * Request helper class.
 */
final class Request {
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
