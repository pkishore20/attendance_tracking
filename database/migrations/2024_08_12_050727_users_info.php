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
        Schema::create('users_infos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        $table->unsignedBigInteger('department_id');
        $table->foreign('department_id')->references('id')->on('departments')->onDelete('restrict');
        $table->unsignedBigInteger('add_roles_id');
        $table->foreign('add_roles_id')->references('id')->on('add_roles')->onDelete('restrict');
        $table->softDeletes();
        $table->timestamps();
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
