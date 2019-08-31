<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolParent extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_school_parent', function($table)
        {
            $table->integer('user_id');
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_school_parent', function($table)
        {
            $table->dropColumn('user_id');
        });
    }
}
