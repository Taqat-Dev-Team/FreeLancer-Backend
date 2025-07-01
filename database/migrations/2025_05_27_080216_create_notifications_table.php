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
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID مفتاح أساسي
            $table->string('type'); // كلاس الإشعار الكامل
            $table->morphs('notifiable'); // notifiable_id + notifiable_type
            $table->text('data'); // بيانات الإشعار (JSON)
            $table->timestamp('read_at')->nullable(); // وقت القراءة
            $table->timestamps(); // created_at و updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
