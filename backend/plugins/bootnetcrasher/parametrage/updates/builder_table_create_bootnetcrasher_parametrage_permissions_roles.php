<?php namespace BootnetCrasher\Parametrage\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBootnetcrasherParametragePermissionsRoles extends Migration
{
    public function up()
    {
        Schema::create('bootnetcrasher_parametrage_permissions_roles', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('permission_id');
            $table->integer('role_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bootnetcrasher_parametrage_permissions_roles');
    }
}
