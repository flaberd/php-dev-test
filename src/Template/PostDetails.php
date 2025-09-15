<?php

namespace silverorange\DevTest\Template;

use silverorange\DevTest\Context;

class PostDetails extends Layout
{
    protected function renderPage(Context $context): string
    {
        if ($context->post === null) {
            $content = <<<HTML
            <p>SHOW CONTENT FOR {$context->content} HERE</p>
            HTML;
        }else {
            $body = nl2br(htmlspecialchars($context->post->body));
            $content = <<<HTML
            <h1>{$context->post->title}</h1>
            <p>Written by: {$context->post->author_name}</p>
            <div>{$body}</div>
            HTML;
        }
        return <<<HTML
            {$content}
            HTML;
    }
}

