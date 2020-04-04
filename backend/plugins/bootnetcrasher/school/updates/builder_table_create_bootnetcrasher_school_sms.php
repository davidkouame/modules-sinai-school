<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBootnetcrasherSchoolSms extends Migration
{
    public function up()
    {
        Schema::create('bootnetcrasher_school_sms', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('nbre_sms_initial');
            $table->integer('nbre_sms_restant')->nullable();
            $table->integer('nbre_sms_consome')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bootnetcrasher_school_sms');
    }
}
