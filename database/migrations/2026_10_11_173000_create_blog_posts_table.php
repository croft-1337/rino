<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table): void {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->string('author')->nullable();
            $table->date('published_date')->nullable();
            $table->unsignedSmallInteger('read_time')->default(5);
            $table->boolean('published')->default(false);
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->timestamps();

            $table->index([
                'published',
                'published_date',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};