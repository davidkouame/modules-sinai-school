<?php 

namespace BootnetCrasher\School\Controllers\Api;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\School\Models\ClasseMatiereModel;

class classeMatiereProfesseurController extends Controller
{
    protected $ClasseMatiereModel;

    protected $helpers;

    public function __construct(ClasseMatiereModel $ClasseMatiereModel, Helpers $helpers)
    {
        parent::__construct();
        $this->ClasseMatiereModel    = $ClasseMatiereModel;
        $this->helpers          = $helpers;
    }

    
    public function index(Request $request){
        $data = $this->ClasseMatiereModel;
        $data = $data->paginate(10)->toArray();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function getClassesByProfesseurId($professeurId = null){
        $data = $this->ClasseMatiereModel->where('professeur_id', $professeurId)
        ->with(array(
            'classe'=>function($query){
                //$query->select('*');
                $query->with(array(
                    'professeurprincipal'=>function($q){
                        $q->select('*');
                    }
                ))->select('*');
            }))->get();
        // $data = $data->paginate(10)->toArray();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}
