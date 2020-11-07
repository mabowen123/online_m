<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->char('slug', 40)->default('')->comment("唯一标识")->unique();
            $table->string('name', 40)->default('')->comment('菜单名称');
            $table->text('fields')->comment('展示字段名 为空则全展示');
            $table->text('rules')->comment('规则');
            $table->integer('parent_id')->default(0);
            $table->string('comment', 255)->default('')->comment('备注');
            $table->timestamps();
            $table->SoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
