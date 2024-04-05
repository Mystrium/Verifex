<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void {
        Schema::table('work_hours', function ($table) {
            $table->dropColumn('stop');
            $table->time('time');
        });
    }

    public function down(): void {
        Schema::table('work_hours', function ($table) {
            $table->dropColumn('time');
            $table->time('stop');
        });
    }
};