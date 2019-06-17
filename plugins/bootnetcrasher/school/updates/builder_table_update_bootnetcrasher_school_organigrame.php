<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolOrganigrame extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_school_organigrame', function($table)
        {
            $table->integer('parent_organigrame_id');
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_school_organigrame', function($table)
        {
            $table->dropColumn('parent_organigrame_id');
        });
    }
}
