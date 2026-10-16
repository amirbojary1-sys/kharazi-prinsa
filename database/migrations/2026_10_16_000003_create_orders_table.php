<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('customer_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('zip')->nullable();
            $table->text('notes')->nullable();
            $table->string('pay_method')->default('online'); // online | cod | card
            $table->string('status')->default('pending');     // pending|paid|shipped|delivered|cancelled
            $table->unsignedInteger('subtotal')->default(0);
            $table->unsignedInteger('shipping')->default(0);
            $table->unsignedInteger('total')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
