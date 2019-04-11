<?php
namespace Parfaitementweb\DocBlog\Database\Seeds;

use Illuminate\Database\Seeder;
use Spatie\Tags\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Tag::class, 20)->create();
    }
}
