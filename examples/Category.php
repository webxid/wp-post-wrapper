<?php

namespace WebXID\WpPostWrapper\Example;

use WebXID\WpPostWrapper\BaseClass\ObjectAbstract;
use WebXID\WpPostWrapper\BaseClass\TermAbstract;

/**
 * @property int id
 * @property string title
 * @property string slug
 * @property string taxonomy
 * @property string description
 * @property string link
 *
 */
class Category extends TermAbstract
{
    /**
     * @param \WP_Term $post
     *
     * @return ObjectAbstract
     */
    public static function factory(\WP_Term $category)
    {
        $item = static::make();

        static::setFields($category, $item);

        $item->id = $category->term_id;
        $item->title = __($category->name);
        $item->slug = $category->slug;
        $item->taxonomy = $category->taxonomy;
        $item->description = static::filterPlanString($category->description);
        $item->link = get_term_link($category);

        return $item;
    }
}