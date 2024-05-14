<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('accesses', function (Blueprint $table) {
            $table->id();
            $table->string('title', 25);
            $table->string('slug', 20);
        });

        $accesses = [
            [
                'title' => 'Вироби',
                'slug' => 'items',
            ], [
                'title' => 'Собівартість',
                'slug' => 'cost',
            ], [
                'title' => 'Закупи',
                'slug' => 'purchases',
            ], [
                'title' => 'Типи цехів',
                'slug' => 'cehtypes',
            ], [
                'title' => 'Цехи',
                'slug' => 'cehs',
            ], [
                'title' => 'Робітники',
                'slug' => 'workers',
            ], [
                'title' => 'Посади',
                'slug' => 'worktypes',
            ], [
                'title' => 'Заробітня плата',
                'slug' => 'pay',
            ], [
                'title' => 'Переміщення',
                'slug' => 'movement',
            ], [
                'title' => 'Залишки',
                'slug' => 'remains',
            ], [
                'title' => 'Виробіток',
                'slug' => 'production',
            ], [
                'title' => 'Одиниці виміру',
                'slug' => 'units',
            ], [
                'title' => 'Кольори',
                'slug' => 'colors',
            ], [
                'title' => 'Категорії виробів',
                'slug' => 'categoryes',
            ], [
                'title' => 'Адміністратори',
                'slug' => 'users',
            ], [
                'title' => 'Ролі',
                'slug' => 'roles',
            ],
        ];

        DB::table('accesses')->insert($accesses);
    }

    public function down(): void {
        Schema::dropIfExists('accesses');
    }
};
