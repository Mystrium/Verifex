<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void {
        Schema::create('work_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cehtype_id');
            $table->foreign('cehtype_id')->references('id')->on('ceh_types');
            $table->string('title', 40);
            $table->decimal('min_pay', 7, 2);
        });
    }

    public function down(): void {
        Schema::dropIfExists('work_types');
    }
};
