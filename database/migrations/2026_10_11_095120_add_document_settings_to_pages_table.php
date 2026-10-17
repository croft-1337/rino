<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('document_type')
                ->default('standard')
                ->after('content');

            $table->string('document_layout')
                ->default('left')
                ->after('document_type');

            $table->date('document_updated_at')
                ->nullable()
                ->after('document_layout');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn([
                'document_type',
                'document_layout',
                'document_updated_at',
            ]);
        });
    }
};