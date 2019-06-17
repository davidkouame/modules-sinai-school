<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBootnetcrasherSchoolProfesseur extends Migration
{
    public function up()
    {
        Schema::create('bootnetcrasher_school_professeur', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nom');
            $table->string('prenom');
            $table->string('email');
            $table->string('telephone', 10);
            $table->string('matiere');
            $table->string('description')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bootnetcrasher_school_professeur');
    }
}
