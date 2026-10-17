<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->foreignId('category_id')
                ->nullable()
                ->after('id')
                ->constrained('page_categories')
                ->nullOnDelete();

            $table->string('page_type')
                ->default('structured')
                ->after('category_id');

            $table->text('short_description')
                ->nullable()
                ->after('template');

            $table->longText('content')
                ->nullable()
                ->after('short_description');

            $table->string('external_url')
                ->nullable()
                ->after('content');

            $table->boolean('open_new_tab')
                ->default(false)
                ->after('external_url');

            $table->boolean('active')
                ->default(true)
                ->after('open_new_tab');

            $table->boolean('show_in_header')
                ->default(false)
                ->after('active');

            $table->boolean('show_in_footer')
                ->default(false)
                ->after('show_in_header');

            $table->unsignedInteger('sort_order')
                ->default(0)
                ->after('show_in_footer');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropForeign([
                'category_id',
            ]);

            $table->dropColumn([
                'category_id',
                'page_type',
                'short_description',
                'content',
                'external_url',
                'open_new_tab',
                'active',
                'show_in_header',
                'show_in_footer',
                'sort_order',
            ]);
        });
    }
};