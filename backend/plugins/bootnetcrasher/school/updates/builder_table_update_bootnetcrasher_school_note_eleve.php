<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolNoteEleve extends Migration
{
    public function up()
    {
        Schema::rename('bootnetcrasher_school_note_eleves', 'bootnetcrasher_school_note_eleve');
    }
    
    public function down()
    {
        Schema::rename('bootnetcrasher_school_note_eleve', 'bootnetcrasher_school_note_eleves');
    }
}
