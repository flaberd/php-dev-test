<?php

namespace silverorange\DevTest;

use silverorange\DevTest\Model\Post;

class Context
{
    // TODO: You can add more properties to this class to pass values to templates

    public string $title = '';

    public string $content = '';

    public array $posts = [];

    public ?Post $post = null;
}
