<?php
return [
    'feeds' => [
        'blog' => [
            'url' => '/blog/feed',
            'title' => 'Blog Feed',
            'items' => \Parfaitementweb\DocBlog\Models\Post::class . '@getFeedItems'
        ],
        'docs' => [
            'url' => '/docs/feed',
            'title' => 'Docs Feed',
            'items' => \Parfaitementweb\DocBlog\Models\Post::class . '@getFeedItems'
        ]
    ]
];
