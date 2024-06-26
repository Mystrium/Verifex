<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('transactions_types');
            $table->unsignedBigInteger('worker_from_id');
            $table->foreign('worker_from_id')->references('id')->on('workers');
            $table->unsignedBigInteger('worker_to_id')->nullable();
            $table->foreign('worker_to_id')->references('id')->on('workers');
            $table->unsignedBigInteger('item_id_id');
            $table->foreign('item_id_id')->references('id')->on('items');
            $table->unsignedBigInteger('color_id')->nullable();
            $table->foreign('color_id')->references('id')->on('colors');
            $table->integer('count');
            $table->decimal('price', 7, 2, true)->nullable();
            $table->dateTime('date');
        });
    }

    public function down(): void {
        Schema::dropIfExists('transactions');
    }
};
