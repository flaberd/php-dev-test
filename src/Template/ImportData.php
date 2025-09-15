<?php

namespace silverorange\DevTest\Template;

use silverorange\DevTest\Context;

class ImportData extends Layout
{
    protected function renderPage(Context $context): string
    {
        return <<<HTML
                            <h1>{$context->title}</h1>
                            <p>{$context->content}</p>
            HTML;
    }
}
