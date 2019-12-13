<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBootnetcrasherSchoolTypeMoyenne extends Migration
{
    public function up()
    {
        Schema::create('bootnetcrasher_school_type_moyenne', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('libelle');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bootnetcrasher_school_type_moyenne');
    }
}
