<?php namespace Bootnetcrasher\SlideShow\Components;

use Cms\Classes\ComponentBase;
use ApplicationException;
use BootnetCrasher\Slideshow\Models\SlideShowModel;

class SlideShow extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'SlideShow',
            'description' => 'Implements a simple slideshow.'
        ];
    }

    public function defineProperties()
    {
        return [
            /*'max' => [
                'description'       => 'The most amount of todo items allowed',
                'title'             => 'Max items',
                'default'           => 10,
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'The Max Items value is required and should be integer.'
            ]*/
        ];
    }

    public function onRun(){
        
        // recuperation de touts les slideshow
        $slideshows = SlideShowModel::all();
        
        $this->page["slideshows"] = $slideshows;
    }
}
