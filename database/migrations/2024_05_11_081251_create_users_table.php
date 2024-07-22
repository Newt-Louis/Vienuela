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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id_user');
            $table->text('avatar_user')->nullable();
            $table->text('avatar_path')->nullable();
            $table->string('account_user',25)->unique();
            $table->text('name_user');
            $table->string('email_user')->unique();
            $table->string('phone_user',10)->unique();
            $table->softDeletes('deleted_at',0);
            $table->string('password_user');
            $table->timestamp('login_at')->nullable();
            $table->timestamp('change_password_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
