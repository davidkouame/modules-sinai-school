<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolSujets extends Migration
{
    public function up()
    {
        Schema::rename('bootnetcrasher_school_', 'bootnetcrasher_school_sujets');
        Schema::table('bootnetcrasher_school_sujets', function($table)
        {
            $table->increments('id')->unsigned(false)->change();
            $table->string('name')->change();
        });
    }
    
    public function down()
    {
        Schema::rename('bootnetcrasher_school_sujets', 'bootnetcrasher_school_');
        Schema::table('bootnetcrasher_school_', function($table)
        {
            $table->increments('id')->unsigned()->change();
            $table->string('name', 191)->change();
        });
    }
}
