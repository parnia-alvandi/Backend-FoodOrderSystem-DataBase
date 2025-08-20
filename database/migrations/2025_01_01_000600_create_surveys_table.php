<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('menu_id')->constrained('menus')->cascadeOnDelete();
            $table->unsignedTinyInteger('rating'); // 1..5
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->unique(['user_id','menu_id']); // هر کاربر یک رأی برای هر غذا
        });
    }
    public function down(): void {
        Schema::dropIfExists('surveys');
    }
};
