<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->softDeletes();
            $table->increments('id');
            $table->string('name', 30)->comment('分类名称');
            $table->string('description')->default('')->comment('描述');
            $table->unsignedInteger('goal_id')->default(0)->comment('该分类下精选目标');
            $table->unsignedInteger('user_count')->default(0)->comment('该分类的参与人数');
            $table->char('color', 7)->default('#ffffff')->comment('纯色色值');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
