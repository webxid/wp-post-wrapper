<?php

namespace WebXID\WpPostWrapper\BaseClass;

use WebXID\BasicClasses\BaseCollection;

abstract class PostTypeAbstract extends BaseCollection
{
    // slug of a post type
    const TYPE_SLUG = null;

    #region Builders

    /**
     * @param \WP_Post $post
     *
     * @return PostAbstract
     */
    public static function itemFactory(\WP_Post $post)
    {
        $item = PostAbstract::make();

        static::setFields($post, $item);

        $item->image = $item->getField('image')['url'] ?? '';
        $item->title = __($item->getField('image')['title'] ?? '');

        return $item;
    }

    /**
     * @param array $data
     * @param bool $force
     *
     * @return PostTypeAbstract
     */
    public static function buildPostsList($data = [], bool $force = false)
    {
        $collection = static::make();

        foreach (static::getPostsList($data, $force) as $key => $post) {
            $collection[$key] = static::itemFactory($post);
        }

        return $collection;
    }

    #endregion

    #region Getters

    /**
     * @param array $data
     * @param bool $force
     *
     * @return array|mixed
     */
    public static function getPostsList($data = [], bool $force = false)
    {
        static $blocks_list;

        if ($blocks_list && !$force) {
            return $blocks_list;
        }

        if (static::TYPE_SLUG === null) {
            throw new \LogicException('Constant `' . static::class . '::SLUG` is not defined');
        }

        $posts = get_posts($data + [
                'posts_per_page' => -1,
                'post_type' => static::TYPE_SLUG,

                'post_status' => 'publish',
                'orderby' => 'menu_order',
                'order' => 'DESC',
        ]);

        $result = [];

        foreach ($posts as $post) {
            $result[$post->post_name ?? $post->ID] = $post;
        }

        return $blocks_list = $result;
    }

    #endregion

    #region Helpers

    /**
     * @param \WP_Post|\WP_Term $instance
     * @param PostAbstract $item
     */
    public static function setFields($instance, $item)
    {
        $item->fields = get_fields($instance->ID);
    }

    #endregion
}
