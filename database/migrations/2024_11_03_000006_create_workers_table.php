<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void {
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->string('pib', 70);
            $table->unsignedBigInteger('ceh_id');
            $table->foreign('ceh_id')->references('id')->on('ceh');
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('work_types');
            $table->bigInteger('phone');
            $table->string('passport', 15);
            $table->string('password', 120);
            $table->boolean('checked');
        });
    }

    public function down(): void {
        Schema::dropIfExists('workers');
    }
};
