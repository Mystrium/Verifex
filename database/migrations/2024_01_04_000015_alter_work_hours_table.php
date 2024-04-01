<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void {
        Schema::table('work_hours', function ($table) {
            $table->dropColumn('date');
            $table->dateTime('start')->change();
            $table->time('stop');
        });
    }

    public function down(): void {
        Schema::table('work_hours', function ($table) {
            $table->dropColumn('stop');
            $table->dateTime('date');
            $table->boolean('start')->change();
        });
    }
};