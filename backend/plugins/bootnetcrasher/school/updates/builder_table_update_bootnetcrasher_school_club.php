<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolClub extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_school_club', function($table)
        {
            $table->text('content');
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_school_club', function($table)
        {
            $table->dropColumn('content');
        });
    }
}
