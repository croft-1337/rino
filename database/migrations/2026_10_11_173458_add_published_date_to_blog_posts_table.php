<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        //
        // Legacy migration.
        //
        // published_date is already created by:
        // 2026_10_11_173000_create_blog_posts_table.php
        //
    }

    public function down(): void
    {
        //
        // Intentionally empty.
        //
        // Do not remove published_date because the column
        // belongs to the original create migration.
        //
    }
};