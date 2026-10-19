<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('seo_social_image')->nullable();
        });
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->string('seo_social_image')->nullable();
        });
        Schema::table('knowledgebase_articles', function (Blueprint $table) {
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('seo_social_image')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('knowledgebase_articles', fn (Blueprint $table) => $table->dropColumn(['seo_title', 'seo_description', 'seo_social_image']));
        Schema::table('blog_posts', fn (Blueprint $table) => $table->dropColumn('seo_social_image'));
        Schema::table('pages', fn (Blueprint $table) => $table->dropColumn(['seo_title', 'seo_description', 'seo_social_image']));
    }
};
