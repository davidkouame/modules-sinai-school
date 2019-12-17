<?php namespace BootnetCrasher\Parametrage\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherParametrageAp extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_parametrage_ap', function($table)
        {
            $table->integer('frequence_to_send_rapport_id');
            $table->increments('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_parametrage_ap', function($table)
        {
            $table->dropColumn('frequence_to_send_rapport_id');
            $table->increments('id')->unsigned()->change();
        });
    }
}
