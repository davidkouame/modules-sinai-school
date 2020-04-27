<?php namespace BootnetCrasher\Parametrage\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherParametragePermission extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_parametrage_permission', function($table)
        {
            $table->string('code_permission');
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_parametrage_permission', function($table)
        {
            $table->dropColumn('code_permission');
        });
    }
}
