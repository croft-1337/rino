<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table
                ->foreignId('category_id')
                ->nullable()
                ->after('published_date')
                ->constrained('page_categories')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropForeign([
                'category_id',
            ]);

            $table->dropColumn(
                'category_id'
            );
        });
    }
};