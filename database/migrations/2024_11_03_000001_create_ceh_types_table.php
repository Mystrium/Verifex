<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void {
        Schema::create('ceh_types', function (Blueprint $table) {
            $table->id();
            $table->string('title', 30);
        });
    }

    public function down(): void {
        Schema::dropIfExists('ceh_types');
    }
};
