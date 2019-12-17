<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBootnetcrasherSchoolAbonement extends Migration
{
    public function up()
    {
        Schema::create('bootnetcrasher_school_abonement', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('reference');
            $table->integer('parent_id');
            $table->integer('user_id');
            $table->integer('pack_abonnement_id')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bootnetcrasher_school_abonement');
    }
}
