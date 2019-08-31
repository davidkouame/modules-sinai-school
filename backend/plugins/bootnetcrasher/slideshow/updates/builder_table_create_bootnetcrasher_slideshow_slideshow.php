<?php namespace BootnetCrasher\Slideshow\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBootnetcrasherSlideshowSlideshow extends Migration
{
    public function up()
    {
        Schema::create('bootnetcrasher_slideshow_slideshow', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bootnetcrasher_slideshow_slideshow');
    }
}
