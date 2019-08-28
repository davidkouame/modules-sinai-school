<?php namespace BootnetCrasher\School\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSchoolNote2 extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_school_note', function($table)
        {
            $table->string('libelle')->nullable(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_school_note', function($table)
        {
            $table->string('libelle', 191)->nullable()->change();
        });
    }
}
