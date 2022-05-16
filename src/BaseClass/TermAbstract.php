<?php

namespace WebXID\WpPostWrapper\BaseClass;

/**
 * @property string image
 * @property string title
 * @property array fields
 */
abstract class TermAbstract extends ObjectAbstract
{
    #region Abstract methods

    /**
     * @param \WP_Term $taxonomy
     *
     * @return static
     */
    abstract public static function factory(\WP_Term $taxonomy);

    #endregion

    public static function setFields(\WP_Term $category, TermAbstract $term)
    {
        $allmeta = get_metadata('term', $category->term_id);

        // Loop over meta and check that a reference exists for each value.
        $meta = array();
        if ( $allmeta ) {
            foreach ( $allmeta as $key => $value ) {

                // If a reference exists for this value, add it to the meta array.
                if ( isset( $allmeta[ "_$key" ] ) ) {
                    $meta[ $key ]    = $allmeta[ $key ][0];
                    $meta[ "_$key" ] = $allmeta[ "_$key" ][0];
                }
            }
        }

        // Unserialized results (get_metadata does not unserialize if $key is empty).
        $meta = array_map( 'maybe_unserialize', $meta );

        /**
         * Filters the $meta array after it has been loaded.
         *
         * @date    25/1/19
         * @since   5.7.11
         *
         * @param array  $meta    The array of loaded meta.
         * @param string $post_id The $post_id for this meta.
         */
        $meta = apply_filters( 'acf/load_meta', $meta, $category->term_id);


        // populate vars
        $fields = array();

        foreach ( $meta as $key => $value ) {

            // bail if reference key does not exist
            if ( ! isset( $meta[ "_$key" ] ) ) {
                continue;
            }

            // get field
            $field = acf_get_field( $meta[ "_$key" ] );

            $fields[$field['name']] = get_field($field['name'], $category);
        }

        $term->fields = $fields;
    }
}
