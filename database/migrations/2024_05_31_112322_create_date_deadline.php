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
        Schema::create('date_deadlines', function (Blueprint $table) {
            $table->unsignedBigInteger('id_card')->primary();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->unsignedInteger('warning')->nullable();
            $table->unsignedInteger('danger')->nullable();
            $table->boolean('is_duedate_done')->default(false);
            $table->timestamps();
            $table->softDeletes('deleted_at',0);
            $table->foreign('id_card')->references('id_card')->on('cards');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('date_deadline');
    }
};
