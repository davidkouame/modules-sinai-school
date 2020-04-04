<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBootnetcrasherSchoolSouscriptionSchool extends Migration
{
    public function up()
    {
        Schema::create('bootnetcrasher_school_souscription_school', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('school_id');
            $table->integer('type_souscription_id');
            $table->integer('annee_scolaire_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bootnetcrasher_school_souscription_school');
    }
}
