<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['type_id']);
            $table->dropColumn('type_id');

            $table->decimal('count', 7, 3)->change();

            $table->dropColumn('price');
        });
    }

    public function down(): void {
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('type_id')->references('id')->on('transactions_types');
            $table->unsignedBigInteger('worker_from_id');

            $table->integer('count')->change();

            $table->decimal('price', 7, 2, true)->nullable();
        });
    }
};

