<?php

namespace WebXID\WpPostWrapper\BaseClass;

/**
 * @property string title
 */
abstract class PostAbstract extends ObjectAbstract
{
    #region Abstract methods

    /**
     * @param \WP_Post $post
     *
     * @return static
     */
    abstract public static function build(\WP_Post $post): self;

    #endregion
}
