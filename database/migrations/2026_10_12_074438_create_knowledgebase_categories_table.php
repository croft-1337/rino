<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'knowledgebase_categories',
            function (Blueprint $table): void {
                $table->id();

                $table
                    ->string('name')
                    ->unique();

                $table
                    ->string('slug')
                    ->unique();

                $table
                    ->text('description')
                    ->nullable();

                $table
                    ->unsignedInteger('sort_order')
                    ->default(0);

                $table
                    ->boolean('active')
                    ->default(true);

                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'knowledgebase_categories'
        );
    }
};