<?php namespace BootnetCrasher\Slideshow\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBootnetcrasherSlideshowSlideshow extends Migration
{
    public function up()
    {
        Schema::table('bootnetcrasher_slideshow_slideshow', function($table)
        {
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('title_cover')->nullable();
            $table->string('description_cover')->nullable();
            $table->increments('id')->unsigned(false)->change();
            $table->string('name')->change();
        });
    }
    
    public function down()
    {
        Schema::table('bootnetcrasher_slideshow_slideshow', function($table)
        {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
            $table->dropColumn('title_cover');
            $table->dropColumn('description_cover');
            $table->increments('id')->unsigned()->change();
            $table->string('name', 191)->change();
        });
    }
}
