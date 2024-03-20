<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('pib', 70);
            $table->bigInteger('phone');
            $table->string('password', 120);
            $table->boolean('role');
            $table->boolean('allowed');
        });
    }

    public function down(): void {
        Schema::dropIfExists('admins');
    }
};
