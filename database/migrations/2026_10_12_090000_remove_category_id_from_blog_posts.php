<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (
            Schema::hasColumn(
                'blog_posts',
                'category_id'
            )
        ) {
            Schema::table(
                'blog_posts',
                function (
                    Blueprint $table
                ): void {
                    $table->dropForeign([
                        'category_id',
                    ]);

                    $table->dropColumn(
                        'category_id'
                    );
                }
            );
        }
    }

    public function down(): void
    {
        if (
            !Schema::hasColumn(
                'blog_posts',
                'category_id'
            )
        ) {
            Schema::table(
                'blog_posts',
                function (
                    Blueprint $table
                ): void {
                    $table
                        ->foreignId(
                            'category_id'
                        )
                        ->nullable()
                        ->constrained(
                            'page_categories'
                        )
                        ->nullOnDelete();
                }
            );
        }
    }
};