<?php //phpcs:disable Squiz.Commenting

namespace XWP\Helper\Functions;

class WPFS {
	final public static function load( array|false $args = false, string|false $ctx = false, bool $ownr = false ): \WP_Filesystem_Base|false|null {
        require_once ABSPATH . 'wp-admin/includes/file.php';

		return match ( \WP_Filesystem( $args, $ctx, $ownr ) ) {
            true    => $GLOBALS['wp_filesystem'],
            false   => false,
            default => null
        };
	}
}
