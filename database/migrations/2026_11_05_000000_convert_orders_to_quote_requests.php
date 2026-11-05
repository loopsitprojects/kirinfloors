<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Orders are now quote requests. The shipping columns stay (nullable) so
     * orders placed before this change keep their details.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('name')->nullable()->after('status');
            $table->string('phone')->nullable()->after('name');
            $table->string('whatsapp')->nullable()->after('phone');
            $table->string('property_type')->nullable()->after('email');

            $table->string('first_name')->nullable()->change();
            $table->string('last_name')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('zip')->nullable()->change();
        });

        DB::table('orders')->orderBy('id')->each(function ($order) {
            DB::table('orders')->where('id', $order->id)->update([
                'name' => trim($order->first_name.' '.$order->last_name),
            ]);
        });

        // Holds the floor area in sq ft, which is not always a whole number.
        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('quantity', 12, 2)->change();
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->integer('quantity')->change();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['name', 'phone', 'whatsapp', 'property_type']);
        });
    }
};
