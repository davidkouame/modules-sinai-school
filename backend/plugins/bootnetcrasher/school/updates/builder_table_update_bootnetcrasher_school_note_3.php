<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolNote3 extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_school_note', function($table)
        {
            $table->integer('reference');
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_school_note', function($table)
        {
            $table->dropColumn('reference');
        });
    }
}
