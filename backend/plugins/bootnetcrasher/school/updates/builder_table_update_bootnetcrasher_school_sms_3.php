<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolSms3 extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_school_sms', function($table)
        {
            $table->boolean('is_run')->nullable()->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_school_sms', function($table)
        {
            $table->dropColumn('is_run');
        });
    }
}
