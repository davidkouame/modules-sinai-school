<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBootnetcrasherSchoolNoteEleves extends Migration
{
    public function up()
    {
        Schema::create('bootnetcrasher_school_note_eleves', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('valeur');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bootnetcrasher_school_note_eleves');
    }
}
