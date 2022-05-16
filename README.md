The lib help to wrap WP instances and to cache already collected data. Also, you can implement your own method for a post instance 

# Install

Run `composer require webxid/wp-post-wrapper`

# How to use

E.g. 
we have the next implementation: [PageBlocks](./examples/PageBlocks.php) of a posts type
and the next [SimpleBlock](./examples/SimpleBlock.php) of a post
and the next [Category](./examples/Category.php) of a post taxonomy

## Factory method

You can implement a separate class for a specific post and handle custom fields as the post instance properties

## Get data

### To get a posts list

```php
use WebXID\WpPostWrapper\Example\PageBlocks
use WebXID\WpPostWrapper\Example\SimpleBlock;

foreach(PageBlocks::buildPostsList() $key => $post) {
    /** @var SimpleBlock $post */
    
    // do some code
}

```

### To build a single post instance

```php

use WebXID\WpPostWrapper\Example\PageBlocks
use WebXID\WpPostWrapper\Example\SimpleBlock;

/** @var SimpleBlock $post */
$post = PageBlocks::itemFactory(get_post());

```

### To build a taxonomy instance

```php

use WebXID\WpPostWrapper\Example\Category
use WebXID\WpPostWrapper\Example\SimpleBlock;


/** @var Category $post */
$category = Category::factory(get_queried_object());

```