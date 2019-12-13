<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolMoyenne extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_school_moyenne', function($table)
        {
            $table->integer('type_moyenne');
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_school_moyenne', function($table)
        {
            $table->dropColumn('type_moyenne');
        });
    }
}
