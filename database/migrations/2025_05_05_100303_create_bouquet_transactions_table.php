<?php

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
        Schema::create('bouquet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bouquet_id')->nullable()->constrained()->cascadeOnDelete();
            $table->unsignedInteger('quantity')->nullable();
            $table->string('transaction_trx_id');
            $table->unsignedBigInteger('sub_total_amount');
            $table->unsignedBigInteger('grand_total_amount');
            $table->string('proof');
            $table->foreignId('bank_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_paid')->default(false);
            $table->enum('status', ['unpaid', 'checking', 'paid', 'processing order', 'in delivery', 'success'])->default('unpaid');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bouquet_transactions');
    }
};
