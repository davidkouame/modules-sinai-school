<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolExamen extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_school_examen', function($table)
        {
            $table->renameColumn('datedeut', 'datedebut');
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_school_examen', function($table)
        {
            $table->renameColumn('datedebut', 'datedeut');
        });
    }
}
