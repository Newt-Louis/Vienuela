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
        Schema::create('card_labelcolors', function (Blueprint $table) {
            $table->unsignedBigInteger('id_color');
            $table->unsignedBigInteger('id_card');
            $table->string('short_title', 10)->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at',0);
            // tạo khóa ngoại ->onDelete('cascade') để đảm bảo xóa card
            // cũng sẽ tự động xóa tham chiếu từ attachment tới card
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manycardslabelcolors');
    }
};
