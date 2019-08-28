<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolNote extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_school_note', function($table)
        {
            $table->increments('id')->unsigned(false)->change();
            $table->string('libelle')->change();
            $table->dateTime('datenoteeffectue')->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_school_note', function($table)
        {
            $table->increments('id')->unsigned()->change();
            $table->string('libelle', 191)->change();
            $table->date('datenoteeffectue')->nullable()->unsigned(false)->default(null)->change();
        });
    }
}
