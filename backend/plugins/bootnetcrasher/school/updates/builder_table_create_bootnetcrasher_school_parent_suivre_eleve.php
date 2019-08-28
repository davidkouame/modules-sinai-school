<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBootnetcrasherSchoolParentSuivreEleve extends Migration
{
    public function up()
    {
        Schema::create('bootnetcrasher_school_parent_suivre_eleve', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('noreference');
            $table->integer('parent_id');
            $table->integer('eleve_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('statutabonnement_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bootnetcrasher_school_parent_suivre_eleve');
    }
}
