<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolLogSms2 extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_school_log_sms', function($table)
        {
            $table->text('tel');
            $table->dropColumn('parent_id');
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_school_log_sms', function($table)
        {
            $table->dropColumn('tel');
            $table->integer('parent_id');
        });
    }
}
