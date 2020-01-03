<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolMoyenne3 extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_school_moyenne', function($table)
        {
            $table->text('reference')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_school_moyenne', function($table)
        {
            $table->dropColumn('reference');
        });
    }
}
