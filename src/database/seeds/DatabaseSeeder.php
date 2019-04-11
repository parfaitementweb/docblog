<?php
namespace Parfaitementweb\DocBlog\Database\Seeds;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TagSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(DocSeeder::class);
    }
}