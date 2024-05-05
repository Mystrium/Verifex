<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void {
        Schema::table('items', function ($table) {
            $table->unsignedBigInteger('category_id')->nullable(false)->change();
        });
    }

    public function down(): void {
        Schema::table('items', function ($table) {
            $table->unsignedBigInteger('category_id')->nullable(true)->change();
        });
    }
};
