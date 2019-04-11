<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('docs', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title');
            $table->text('slug');
            $table->text('text');
            $table->text('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('breadcrumb_title')->nullable();
            $table->datetime('publish_date');
            $table->text('published');
            $table->string('author')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('docs');
    }
}
