<?php
namespace Parfaitementweb\DocBlog\Database\Seeds;

use Illuminate\Database\Seeder;
use Parfaitementweb\DocBlog\Models\Post;
use Spatie\Tags\Tag;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = Tag::all();

        factory(Post::class, 10)
            ->create()
            ->each(function (Post $post) use ($tags) {
                return $post->attachTags($tags->random(rand(1, 4)));
            });
    }
}
