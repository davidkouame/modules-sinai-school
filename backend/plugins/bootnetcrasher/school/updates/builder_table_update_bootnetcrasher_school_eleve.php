<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolEleve extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_school_eleve', function($table)
        {
            $table->dropColumn('nom');
            $table->dropColumn('prenom');
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_school_eleve', function($table)
        {
            $table->string('nom', 191);
            $table->string('prenom', 191);
        });
    }
}
