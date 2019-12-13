<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBootnetcrasherSchoolSessionUserApp extends Migration
{
    public function up()
    {
        Schema::create('bootnetcrasher_school_session_user_app', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('annee_scolaire_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bootnetcrasher_school_session_user_app');
    }
}
