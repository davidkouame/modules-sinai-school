<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolAnneeScolaire extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_school_annee_scolaire', function($table)
        {
            $table->date('start');
            $table->date('end');
            $table->increments('id')->unsigned(false)->change();
            $table->string('libelle')->change();
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_school_annee_scolaire', function($table)
        {
            $table->dropColumn('start');
            $table->dropColumn('end');
            $table->increments('id')->unsigned()->change();
            $table->string('libelle', 191)->change();
        });
    }
}
