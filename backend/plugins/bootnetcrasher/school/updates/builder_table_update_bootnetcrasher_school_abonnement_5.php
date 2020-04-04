<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolAbonnement5 extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_school_abonnement', function($table)
        {
            $table->boolean('is_run')->default(1)->change();
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_school_abonnement', function($table)
        {
            $table->boolean('is_run')->default(null)->change();
        });
    }
}
