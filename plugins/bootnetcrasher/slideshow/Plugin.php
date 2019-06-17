<?php namespace BootnetCrasher\Slideshow;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            '\Bootnetcrasher\SlideShow\Components\SlideShow' => 'SlideShow',
        ];
    }

    public function registerSettings()
    {
    }
}
