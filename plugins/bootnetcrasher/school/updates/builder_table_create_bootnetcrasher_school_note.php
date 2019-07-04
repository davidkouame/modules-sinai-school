<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBootnetcrasherSchoolNote extends Migration
{
    public function up()
    {
        Schema::create('bootnetcrasher_school_note', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('libelle')->nullable();
            $table->date('datenoteeffectue')->nullable();
            $table->text('description')->nullable();
            $table->integer('typenote_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bootnetcrasher_school_note');
    }
}
