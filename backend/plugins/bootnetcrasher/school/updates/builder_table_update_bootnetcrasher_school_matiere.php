<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolMatiere extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_school_matiere', function($table)
        {
            $table->increments('id')->unsigned(false)->change();
            $table->string('libelle')->change();
            $table->renameColumn('decription', 'description');
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_school_matiere', function($table)
        {
            $table->increments('id')->unsigned()->change();
            $table->string('libelle', 191)->change();
            $table->renameColumn('description', 'decription');
        });
    }
}
