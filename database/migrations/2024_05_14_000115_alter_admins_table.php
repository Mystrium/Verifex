<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void {
        Schema::table('admins', function ($table) {
            $table->dropColumn('role');

            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::table('admins', function ($table) {
            $table->dropForeign('admins_role_id_foreign');
            $table->dropColumn('role_id');

            $table->boolean('role');
        });
    }
};