<?php
namespace Parfaitementweb\DocBlog\Database\Seeds;

use Illuminate\Database\Seeder;
use Parfaitementweb\DocBlog\Models\Doc;
use Spatie\Tags\Tag;

class DocSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = Tag::all();

        factory(Doc::class, 10)
            ->create()
            ->each(function (Doc $post) use ($tags) {
                return $post->attachTags($tags->random(rand(1, 4)));
            });
    }
}
