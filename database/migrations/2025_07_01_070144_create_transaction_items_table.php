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
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bouquet_transaction_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bouquet_id')->constrained()->cascadeOnDelete(); 
            $table->unsignedInteger('quantity'); 
            $table->unsignedBigInteger('sub_total_amount'); 
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_items');
    }
};
