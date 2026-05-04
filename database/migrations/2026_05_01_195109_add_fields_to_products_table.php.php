<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Corrige category_id para FK real
            $table->dropColumn('category_id');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();

            // Novos campos
            $table->string('artist');
            $table->string('slug')->unique()->nullable();
            $table->integer('stock')->default(0);
            $table->string('spotify_track_id')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['category_id', 'artist', 'slug', 'stock', 'spotify_track_id', 'status']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->integer('category_id')->nullable();
        });
    }
};