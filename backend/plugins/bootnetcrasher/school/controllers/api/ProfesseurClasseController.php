<?php namespace BootnetCrasher\School\Controllers\Api;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use Illuminate\Support\Facades\Validator;
use BootnetCrasher\School\Models\ProfesseurClasseModel;

class ProfesseurClasseController extends Controller
{
    protected $ProfesseurClasseModel;

    protected $helpers;

    public function __construct(ProfesseurClasseModel $ProfesseurClasseModel, Helpers $helpers)
    {
        parent::__construct();
        $this->ProfesseurClasseModel    = $ProfesseurClasseModel;
        $this->helpers          = $helpers;
    }

    public function searchProfesseursClasses(){
        // $data = $this->ProfesseurClasseModel->all()->toArray();
        // return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}