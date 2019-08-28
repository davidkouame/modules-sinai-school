<?php

namespace Bootnetcrasher\School\Components;

use Cms\Classes\ComponentBase;
use ApplicationException;
use Raviraj\Rjgallery\Models\Gallery;

class DetailGalerie extends ComponentBase {

    public function componentDetails() {
        return [
            'name' => 'Détail galerie',
            'description' => 'Implements a simple détail galerie.'
        ];
    }

    public function defineProperties() {
        return [
        ];
    }

    public function onRun() {
        try {
            $galerie_slug = $this->param('galerie_slug');
            $galerie = Gallery::where('slug', $galerie_slug)->first();
            // dd($galerie);
            $column = "column";
            // dd(count($galerie->images));
            $nb = count($galerie->images);
            switch ($nb){
                case 4:
                    $column = "column";
                    break;
                case 5:
                    $column = "column-20";
                    break;
                case 6:
                    $column = "column-16";
                    break;
                case 7:
                    $column = "column-14";
                    break;
                case 8:
                    $column = "column-12";
                    break;
                case 9:
                    $column = "column-11";
                    break;
                case 10:
                    $column = "column-10";
                    break;
                case 10:
                    $column = "column-9";
                    break;
                case 10:
                    $column = "column-8";
                    break;
                case 11:
                    $column = "column-9";
                    break;
                case 12:
                    $column = "column-8";
                    break;
                case 13:
                    $column = "column-7";
                    break;
                case 14:
                    $column = "column-7";
                    break;
                case 15:
                    $column = "column-6";
                    break;
                case $nb > 15:
                    $column = "column-h";
                    break;
            }
            // dd(count($galerie->images));
            $this->page["galerie"] = $galerie;
            $this->page["column"] = $column;
        } catch (\Exception $e) {
            trace_log("Une erreur s'est produite lors de la recuperation des informations d'une galerie, error:" . $e->getMessage());
        }
    }

}
