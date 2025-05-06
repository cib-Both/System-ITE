<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            // $table->foreignId('purchase_id')->constrained()->onDelete('cascade');
            $table->string('class_of_asset')->nullable();
            $table->string('asset_identity_no')->nullable();
            $table->string('serial_number', 50)->unique();
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 15, 2);
            $table->string('user', 50)->nullable();
            $table->string('code', 20)->unique();
            $table->enum('status', ['available', 'loaned', 'damaged', 'lost'])->default('available');
            $table->enum('remark', ['install', 'not yet install'])->default('not yet install');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
