<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');

            $table->json('file_format')->nullable();
            $table->string('tags')->nullable();

            $table->integer('days')->nullable();
            $table->integer('revisions')->nullable();
            $table->decimal('price', 10, 2)->default(0);

            $table->json('add_ons')->nullable();
            $table->json('requirements')->nullable();
            $table->text('description')->nullable();
            $table->json('questions')->nullable();

            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('sub_category_id')->nullable();


            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('set null');
            $table->foreignId('freelancer_id')->references('id')->on('freelancers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
