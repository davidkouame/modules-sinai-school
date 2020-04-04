<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolSms2 extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_school_sms', function($table)
        {
            $table->integer('school_id');
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_school_sms', function($table)
        {
            $table->dropColumn('school_id');
        });
    }
}
