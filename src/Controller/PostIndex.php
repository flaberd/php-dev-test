<?php

namespace silverorange\DevTest\Controller;

use silverorange\DevTest\Context;
use silverorange\DevTest\Model\Post;
use silverorange\DevTest\Template;

class PostIndex extends Controller
{
    /**
     * @var array<Post>
     */
    private array $posts = [];

    public function getContext(): Context
    {
        $context = new Context();
        $context->title = 'Posts';
        $context->content = strval(count($this->posts));
        $context->posts = $this->posts;
        return $context;
    }

    public function getTemplate(): Template\Template
    {
        return new Template\PostIndex();
    }

    protected function loadData(): void
    {
        $sql = 'SELECT posts.*, authors.full_name AS author_name FROM posts
            JOIN authors ON posts.author = authors.id
            ORDER BY created_at DESC LIMIT 10';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $this->posts = $stmt->fetchAll(\PDO::FETCH_CLASS, Post::class);
    }
}
