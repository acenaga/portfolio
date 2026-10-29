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
        Schema::create('instagram_posts', function (Blueprint $table) {
            $table->id();
            $table->string('external_id')->unique();
            $table->string('media_type')->index();
            $table->text('caption')->nullable();
            $table->string('media_url')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->string('permalink');
            $table->unsignedBigInteger('like_count')->nullable();
            $table->unsignedBigInteger('comments_count')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->timestamp('fetched_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instagram_posts');
    }
};
