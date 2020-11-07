<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_menus', function (Blueprint $table) {
            $table->integer('role_id', false, true);
            $table->integer('menus_id', false, true);
            $table->text('fields');
            $table->text('rule_fields');
            $table->primary(['role_id', 'menus_id']);
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade')->onUpdate('restrict');
            $table->foreign('menus_id')->references('id')->on('menus')->onDelete('cascade')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_menus');
    }
}
