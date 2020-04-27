<?php namespace BootnetCrasher\Parametrage\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBootnetcrasherParametrageUserGroup extends Migration
{
    public function up()
    {
        Schema::create('bootnetcrasher_parametrage_user_group', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('libelle');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bootnetcrasher_parametrage_user_group');
    }
}
