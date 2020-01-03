<?php namespace BootnetCrasher\Parametrage\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherParametrageSms extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_parametrage_sms', function($table)
        {
            $table->increments('id')->unsigned(false)->change();
            $table->string('libelle')->change();
            $table->dropColumn('description');
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_parametrage_sms', function($table)
        {
            $table->increments('id')->unsigned()->change();
            $table->string('libelle', 191)->change();
            $table->text('description')->nullable();
        });
    }
}
