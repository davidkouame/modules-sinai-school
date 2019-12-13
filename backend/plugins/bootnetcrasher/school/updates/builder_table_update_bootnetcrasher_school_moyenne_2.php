<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolMoyenne2 extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_school_moyenne', function($table)
        {
            $table->renameColumn('type_moyenne', 'type_moyenne_id');
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_school_moyenne', function($table)
        {
            $table->renameColumn('type_moyenne_id', 'type_moyenne');
        });
    }
}
