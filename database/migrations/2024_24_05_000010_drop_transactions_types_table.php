<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void {
        Schema::dropIfExists('transactions_types');
    }

    public function down(): void {
        Schema::create('transactions_types', function (Blueprint $table) {
            $table->id();
            $table->string('title', 30);
        });     
    }
};
