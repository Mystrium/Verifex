<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('title', 15);
            $table->tinyInteger('priority');
        });

        $roles = [
                [
                    'title' => 'Суперадмін',
                    'priority' => '1',
                ], 
            ];

        DB::table('roles')->insert($roles);
    }

    public function down(): void {
        Schema::dropIfExists('roles');
    }
};
