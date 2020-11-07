<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_roles', function (Blueprint $table) {
            $table->integer('admin_id',false,true);
            $table->integer('role_id',false,true);
            $table->primary(['admin_id', 'role_id']);
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade')->onUpdate('restrict');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_roles');
    }
}
