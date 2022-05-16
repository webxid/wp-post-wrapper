<?php

namespace WebXID\WpPostWrapper\Example;

use WebXID\WpPostWrapper\BaseClass\PostAbstract;

/**
 * @property string description
 */
class SimpleBlock extends PostAbstract
{
    /**
     * @param \WP_Post $post
     *
     * @return static
     */
    public static function build(\WP_Post $post): PostAbstract
    {
        $item = static::make();

        PageBlocks::setFields($post, $item);

        $item->admin_title = __($post->post_title);

        $item->getField('public_title')
            && $item->title = __($item->getField('public_title'));
        $item->getField('description')
            && $item->description = static::filterPlanString($item->getField('description'));

        return $item;
    }
}
