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
        Schema::table('tasks', function (Blueprint $table){
            $table->foreign('id_checklist')->references('id_checklist')->on('checklists')->onDelete('cascade');
        });
        Schema::table('checklists', function (Blueprint $table){
            $table->foreign('id_card')->references('id_card')->on('cards')->onDelete('cascade');
        });
        Schema::table('attachment_cards', function (Blueprint $table){
            $table->foreign('id_attachment')->references('id_attachment')->on('attachments');
            $table->foreign('id_card')->references('id_card')->on('cards')->onDelete('cascade');
        });
        Schema::table('card_labelcolors', function (Blueprint $table){
            $table->foreign('id_color')->references('id_color')->on('labelcolors');
            $table->foreign('id_card')->references('id_card')->on('cards')->onDelete('cascade');
        });
        Schema::table('cards', function (Blueprint $table){
            $table->foreign('id_list')->references('id_list')->on('list_of_cards')->onDelete('cascade');
        });
        Schema::table('list_of_cards', function (Blueprint $table){
            $table->foreign('id_board')->references('id_board')->on('boards')->onDelete('cascade');
        });
        Schema::table('boards', function (Blueprint $table){
            $table->foreign('id_bgcolor')->references('id_bgcolor')->on('background_colors');
            $table->foreign('id_workspace')->references('id_workspace')->on('workspaces')->onDelete('cascade');
        });
        Schema::table('workspaces', function (Blueprint $table){
            $table->foreign('id_user')->references('id_user')->on('users');
        });
        Schema::table('users_cards', function (Blueprint $table){
            $table->foreign('id_user')->references('id_user')->on('users');
            $table->foreign('id_card')->references('id_card')->on('cards')->onDelete('cascade');
        });
        Schema::table('users_boards', function (Blueprint $table){
            $table->foreign('id_user')->references('id_user')->on('users');
            $table->foreign('id_role')->references('id_role')->on('roles');
            $table->foreign('id_board')->references('id_board')->on('boards')->onDelete('cascade');
        });
        Schema::table('users_workspaces', function (Blueprint $table){
            $table->foreign('id_user')->references('id_user')->on('users');
            $table->foreign('id_role')->references('id_role')->on('roles');
            $table->foreign('id_workspace')->references('id_workspace')->on('workspaces')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
