<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('title', 15);
        });
    }

    public function down(): void {
        Schema::dropIfExists('units');
    }
};
