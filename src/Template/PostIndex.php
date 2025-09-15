<?php

namespace silverorange\DevTest\Template;

use silverorange\DevTest\Context;

class PostIndex extends Layout
{
    protected function renderPage(Context $context): string
    {
        $postsList = '';
        foreach ($context->posts as $post) {
            // Виводь дані поста
            $postsList .= <<<HTML
                <div class="post_card">
                    <div class="post_card_title">
                        <a href="/posts/{$post->id}">{$post->title}</a>
                    </div>
                    <div class="post_card_bottom">
                        <div class="post_card_author">author: {$post->author_name}</div>
                        <div class="post_card_link"><a href="/posts/{$post->id}">Go to the post</a></div>
                    </div>
                </div>
            HTML;
        }
        return <<<HTML
            <p>SHOW ALL {$context->content} POSTS HERE</p>
            <div>{$postsList}</div>
            HTML;
    }
}
