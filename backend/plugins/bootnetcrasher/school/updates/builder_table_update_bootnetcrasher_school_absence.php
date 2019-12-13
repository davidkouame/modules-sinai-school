<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolAbsence extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_school_absence', function($table)
        {
            $table->integer('section_annee_scolaire_id');
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_school_absence', function($table)
        {
            $table->dropColumn('section_annee_scolaire_id');
        });
    }
}
