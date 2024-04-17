<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void {
        Schema::table('work_types', function ($table) {
            $table->string('operations', 5);
        });
    }

    public function down(): void {
        Schema::table('work_types', function ($table) {
            $table->dropColumn('operations');
        });
    }
};