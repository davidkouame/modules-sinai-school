<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolSms extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_school_sms', function($table)
        {
            $table->timestamp('deleted_at')->nullable();
            $table->increments('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_school_sms', function($table)
        {
            $table->dropColumn('deleted_at');
            $table->increments('id')->unsigned()->change();
        });
    }
}
