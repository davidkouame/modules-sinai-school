<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBootnetcrasherSchoolClasseMatiere extends Migration
{
    public function up()
    {
        Schema::create('bootnetcrasher_school_classe_matiere', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('matiere_id');
            $table->integer('classe_id');
            $table->integer('coefficient')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bootnetcrasher_school_classe_matiere');
    }
}
