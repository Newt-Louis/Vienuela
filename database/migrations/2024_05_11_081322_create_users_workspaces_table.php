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
        Schema::create('users_workspaces', function (Blueprint $table) {
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_workspace');
            $table->bigInteger('id_role');
            $table->unique(['id_user','id_workspace']);
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
        Schema::dropIfExists('users_workspaces');
    }
};
