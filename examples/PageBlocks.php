<?php

namespace WebXID\WpPostWrapper\Example;

use WebXID\WpPostWrapper\BaseClass\PostTypeAbstract;

class PageBlocks extends PostTypeAbstract
{
    const TYPE_SLUG = 'post';

    /**
     * @param \WP_Post $post
     *
     * @return SimpleBlock
     */
    public static function itemFactory(\WP_Post $post)
    {
        $post_slug = $post->post_name;

        switch ($post_slug) {
            default:
                $class_name = SimpleBlock::class;
        }

        /** @var $class_name SimpleBlock */
        return $class_name::build($post);
    }

    /**
     * @inheritDoc
     */
    protected static function isEntityValid($object) : bool
    {
        return $object instanceof SimpleBlock;
    }
}
