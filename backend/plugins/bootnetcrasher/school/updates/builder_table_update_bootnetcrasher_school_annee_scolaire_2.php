<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolAnneeScolaire2 extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_school_annee_scolaire', function($table)
        {
            $table->integer('type_annnee_scolaire_id');
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_school_annee_scolaire', function($table)
        {
            $table->dropColumn('type_annnee_scolaire_id');
        });
    }
}
