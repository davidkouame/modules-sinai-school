<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolAbonnement2 extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_school_abonnement', function($table)
        {
            $table->integer('nbre_sms_initial')->nullable();
            $table->integer('nbre_sms_consomme')->nullable();
            $table->integer('nbre_sms_restant')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_school_abonnement', function($table)
        {
            $table->dropColumn('nbre_sms_initial');
            $table->dropColumn('nbre_sms_consomme');
            $table->dropColumn('nbre_sms_restant');
        });
    }
}
