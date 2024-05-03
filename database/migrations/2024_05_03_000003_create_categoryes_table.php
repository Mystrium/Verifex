<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void {
        Schema::create('categoryes', function (Blueprint $table) {
            $table->id();
            $table->string('title', 40);
            $table->string('description', 200)->nullable();
        });

        Schema::table('items', function ($table) {
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categoryes');
        });
    }

    public function down(): void {
        Schema::dropIfExists('categoryes');

        Schema::table('items', function ($table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};
