<?php //phpcs:disable Squiz.Commenting

namespace XWP\Helper\Functions;

class Array_Extra {
    final public static function rekey( array $arr, string $key ): array {
        return \array_combine(
            \array_column( $arr, $key ),
            \array_map(
                static fn( $v ) => \array_diff_key( $v, array( $key => null ) ),
                $arr,
            ),
        );
    }

    final public static function flatmap( callable $callback, $arr ): array {
		return \array_merge( array(), ...\array_map( $callback, \array_values( $arr ) ) );
    }

    final public static function flatmap_assoc( callable $callback, array $assoc, string $key, $remove_key = true ): array {
        $arr_cb = $remove_key
            ? static fn( $arr ) => \array_diff_key( $arr, array( $key => null ) )
            : static fn( $arr ) => $arr;

        return \array_merge(
            array(),
            ...\array_map(
                static fn( $v, $k ) => array( $k => \array_map( $callback, $arr_cb( $v ) ) ),
                $assoc,
                \array_column( $assoc, $key ),
            ),
        );
    }

    final public static function diff_assoc( array $input_array, array $keys ): array {
        return \array_diff_key( $input_array, \array_flip( $keys ) );
    }

    final public static function slice_assoc( array $input_array, array $keys ) {
        return \array_intersect_key( $input_array, \array_flip( $keys ) );
    }

    final public static function from_string( string|array $target, string $delim ): array {
        if ( \is_array( $target ) ) {
            return $target;
        }

        return \array_values(
            \array_filter(
                \array_map( 'trim', \explode( $delim, $target ) ),
                static fn( $v ) => '' !== $v,
            ),
        );
    }
}
