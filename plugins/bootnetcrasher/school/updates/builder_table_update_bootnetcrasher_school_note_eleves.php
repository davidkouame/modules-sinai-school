<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolNoteEleves extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_school_note_eleves', function($table)
        {
            $table->integer('note_id');
            $table->increments('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_school_note_eleves', function($table)
        {
            $table->dropColumn('note_id');
            $table->increments('id')->unsigned()->change();
        });
    }
}
