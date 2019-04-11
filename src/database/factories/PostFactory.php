<?php

use Faker\Generator as Faker;
use Parfaitementweb\DocBlog\Models\Post;

$factory->define(Post::class, function (Faker $faker) {

    $sentences = ['fr' => $faker->sentence, 'en' => $faker->sentence];
    $paragraphs = ['fr' => $faker->paragraph, 'en' => $faker->paragraph];
    $published = ['fr' => $faker->boolean(90), 'en' => $faker->boolean(90)];

    return [
        'title' => $sentences,
        'excerpt' => $sentences,
        'text' => $paragraphs,
        'publish_date' => $faker->dateTimeBetween('-5 years'),
        'published' => $published,
        'slug' => ['fr' => str_slug($sentences['fr']), 'en' => str_slug($sentences['en'])],
    ];
});