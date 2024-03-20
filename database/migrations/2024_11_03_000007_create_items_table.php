<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('title', 70);
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->boolean('hascolor');
            $table->decimal('price', 6, 2);
            $table->string('url_photo', 150);
            $table->string('url_instruction', 150)->nullable();
            $table->string('description', 200)->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('items');
    }
};
