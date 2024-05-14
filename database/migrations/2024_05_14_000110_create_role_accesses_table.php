<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void {
        Schema::create('role_access', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->unsignedBigInteger('access_id');
            $table->foreign('access_id')->references('id')->on('accesses')->onDelete('cascade');
        });

        $accesses = [];

        for($i = 1; $i <= DB::table('accesses')->selectRaw('count(id) as cnt')->get()[0]->cnt; $i++)
            $accesses[] = [
                'role_id' => 1,
                'access_id' => $i,
            ];

        DB::table('role_access')->insert($accesses);
    }

    public function down(): void {
        Schema::dropIfExists('role_access');
    }
};
