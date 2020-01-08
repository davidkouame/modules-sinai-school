<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolAbonnement extends Migration
{
    public function up()
    {
        Schema::rename('bootnetcrasher_school_abonement', 'bootnetcrasher_school_abonnement');
        Schema::table('bootnetcrasher_school_abonnement', function($table)
        {
            $table->dropColumn('user_id');
        });
    }
    
    public function down()
    {
        Schema::rename('bootnetcrasher_school_abonnement', 'bootnetcrasher_school_abonement');
        Schema::table('bootnetcrasher_school_abonement', function($table)
        {
            $table->integer('user_id');
        });
    }
}
