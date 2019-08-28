<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolNoteEleve2 extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_school_note_eleve', function($table)
        {
            $table->integer('eleve_id');
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_school_note_eleve', function($table)
        {
            $table->dropColumn('eleve_id');
        });
    }
}
