<?php

use App\Enums\OrderDelivery;
use App\Enums\OrderPayment;
use App\Enums\OrderStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name')->nullable();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->enum('method', array_column(OrderDelivery::cases(), 'value'));
            $table->enum('payment', array_column(OrderPayment::cases(), 'value'));
            $table->text('details')->nullable();
            $table->enum('status', array_column(OrderStatus::cases(), 'value'))->default(OrderStatus::Pending->value);
            $table->text('address');
            $table->decimal('total', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
