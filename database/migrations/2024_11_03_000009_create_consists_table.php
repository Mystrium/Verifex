<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void {
        Schema::create('consists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('what_id');
            $table->foreign('what_id')->references('id')->on('items')->onDelete('cascade');
            $table->unsignedBigInteger('have_id');
            $table->foreign('have_id')->references('id')->on('items')->onDelete('cascade');
            $table->decimal('count', 5, 2, true)->default(1);
        });
    }

    public function down(): void {
        Schema::dropIfExists('consists');
    }
};
