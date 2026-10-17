<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'knowledgebase_articles',
            function (Blueprint $table): void {
                $table->id();

                $table
                    ->foreignId(
                        'knowledgebase_category_id'
                    )
                    ->constrained(
                        'knowledgebase_categories'
                    )
                    ->cascadeOnDelete();

                $table
                    ->string('title');

                $table
                    ->string('slug')
                    ->unique();

                $table
                    ->text('short_description')
                    ->nullable();

                $table
                    ->longText('content');

                $table
                    ->boolean('active')
                    ->default(true);

                $table
                    ->unsignedInteger('sort_order')
                    ->default(0);

                $table->timestamps();

                $table->index(
                    [
                        'knowledgebase_category_id',
                        'active',
                        'sort_order',
                    ],
                    'kb_articles_cat_active_sort_idx'
                );
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'knowledgebase_articles'
        );
    }
};