<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolAbonnement4 extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_school_abonnement', function($table)
        {
            $table->boolean('is_run')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_school_abonnement', function($table)
        {
            $table->dropColumn('is_run');
        });
    }
}
