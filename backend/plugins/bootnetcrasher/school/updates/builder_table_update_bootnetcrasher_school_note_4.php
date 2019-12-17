<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolNote4 extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_school_note', function($table)
        {
            $table->integer('backend_user_id');
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_school_note', function($table)
        {
            $table->dropColumn('backend_user_id');
        });
    }
}
