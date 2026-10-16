<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedInteger('discount')->default(0)->after('shipping');
            $table->string('coupon_code', 40)->nullable()->after('discount');
            $table->string('ref_id', 40)->nullable()->after('pay_method');
            $table->string('card_pan', 30)->nullable()->after('ref_id');
            $table->timestamp('paid_at')->nullable()->after('card_pan');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['discount', 'coupon_code', 'ref_id', 'card_pan', 'paid_at']);
        });
    }
};
