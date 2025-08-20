<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['pending','paid','completed','cancelled'])->default('pending');
            $table->foreignId('discount_id')->nullable()->constrained('discounts')->nullOnDelete();
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('final_amount', 10, 2)->default(0);
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('orders');
    }
};
