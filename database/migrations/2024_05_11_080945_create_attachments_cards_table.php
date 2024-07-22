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
        Schema::create('attachment_cards', function (Blueprint $table) {
            $table->unsignedBigInteger('id_card');
            $table->unsignedBigInteger('id_attachment');
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
            $table->unique(['id_card','id_attachment']);
            // tạo khóa ngoại ->onDelete('cascade') để đảm bảo xóa card
            // cũng sẽ tự động xóa tham chiếu từ attachment tới card
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachment_card');
    }
};
