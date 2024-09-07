<?php
/**
 * Singleton_Trait trait.
 *
 * @package WP Polyfills
 * @subpackage Traits
 */

namespace XWP\Helper\Traits;

/**
 * Enables the singleton pattern.
 */
trait Singleton_Ex {
    use Singleton;

    /**
     * Returns the singleton instance
     *
     * @return static
     */
    public static function instance(): static {
        static::$instance ??= array();

        return static::$instance[ static::class ] ??= new static();
    }
}
