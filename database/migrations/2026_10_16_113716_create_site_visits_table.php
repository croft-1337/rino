<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_visits', function (Blueprint $table) {
            $table->id();

            $table->uuid('visitor_id');

            $table->string(
                'session_id',
                255
            )->nullable();

            $table->string(
                'path',
                2048
            );

            $table->string(
                'route_name',
                255
            )->nullable();

            $table->string(
                'referrer_host',
                255
            )->nullable();

            $table->string(
                'ip_hash',
                64
            )->nullable();

            $table->text(
                'user_agent'
            )->nullable();

            $table->timestamp(
                'viewed_at'
            );

            $table->timestamps();

            $table->index(
                'visitor_id'
            );

            $table->index(
                'viewed_at'
            );

            $table->index([
                'visitor_id',
                'viewed_at',
            ]);

            $table->index(
                'referrer_host'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'site_visits'
        );
    }
};