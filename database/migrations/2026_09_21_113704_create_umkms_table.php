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
        Schema::create('umkms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('owner_name')->nullable();
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('instagram')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('cover_image')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('status')->default('draft');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkms');
    }
};
