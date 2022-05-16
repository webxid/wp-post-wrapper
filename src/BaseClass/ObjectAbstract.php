<?php

namespace WebXID\WpPostWrapper\BaseClass;

use WebXID\BasicClasses\DataContainer;

/**
 * @property string image
 * @property array fields
 */
abstract class ObjectAbstract extends DataContainer
{
    /**
     * @param string $field_name
     *
     * @return mixed|null
     */
    public function getField(string $field_name)
    {
        if (!is_scalar($field_name) && !$field_name) {
            throw new \InvalidArgumentException('Invalid $field_name');
        }

        $field_name = explode('.', $field_name);
        $first_key = array_shift($field_name);
        $result = $this->fields;

        while (isset($result[$first_key])) {
            $result = $result[$first_key];

            if (empty($field_name)) {
                return $result;
            }

            $first_key = array_shift($field_name);
        }

        return null;
    }


    /**
     * @param $wp_image_data
     *
     * @return string
     */
    public static function getImage(array $wp_image_data): string
    {
        return $wp_image_data['url'] ?? '';
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function filterHtmlString(string $string): string
    {
        return apply_filters( 'the_content', $string);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function filterPlanString(string $string): string
    {
        return __(nl2br($string));
    }
}
