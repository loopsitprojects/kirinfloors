<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Deleting a quote request failed while it still had items; delete them with it.
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }
};
