<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolAbonnement3 extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_school_abonnement', function($table)
        {
            $table->integer('school_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_school_abonnement', function($table)
        {
            $table->dropColumn('school_id');
        });
    }
}
