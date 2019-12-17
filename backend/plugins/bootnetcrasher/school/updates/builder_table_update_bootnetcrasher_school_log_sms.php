<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolLogSms extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_school_log_sms', function($table)
        {
            $table->integer('parent_id');
            $table->integer('user_id');
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_school_log_sms', function($table)
        {
            $table->dropColumn('parent_id');
            $table->dropColumn('user_id');
        });
    }
}
