<?php

use App\Models\FoodRecipe;
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
            $table->timestamps();
            $table->foreignIdFor(FoodRecipe::class,'recipe_id');
            $table->uuid('code')->unique();
            $table->enum('status', ['pending', 'confirmed', 'processing', 'canceled', 'delivered'])->default('pending');
            $table->timestamp('delivery_date')->nullable();
            $table->boolean('is_sent')->default(false);
            $table->softDeletes();
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
