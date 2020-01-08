<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use BootnetCrasher\School\Models\AbonnementEleveModel;
use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\School\Models\AbonnementModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class AbonnementController extends Controller
{
    protected $AbonnementModel;

    protected $helpers;

    public function __construct(AbonnementModel $AbonnementModel, Helpers $helpers)
    {
        parent::__construct();
        $this->AbonnementModel    = $AbonnementModel;
        $this->helpers          = $helpers;
    }

    
    public function index(Request $request){
        $data = $this->AbonnementModel->with(array(
            'packabonnement'=>function($query){
                $query->select('*');
            },
            'parent'=>function($query){
                $query->select('*');
            },
            'anneescolaire'=>function($query){
                $query->select('*');
            }, ));
        if($request->has('search')){
            $data = $data->where("reference", 'like', '%'.$request->get('search').'%');
        }
            if($request->has('page') && $request->get('page') == 0){
                $data = $data->get()->toArray();
            }else{
                $data = $data->paginate(10)->toArray();
            }
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    
    public function show($id){ 
        $data = $this->AbonnementModel->with(array(
            'packabonnement'=>function($query){
                $query->select('*');
            },
            'parent'=>function($query){
                $query->select('*');
            },
            'anneescolaire'=>function($query){
                $query->select('*');
            }, ))->select('*')->where('id', '=', $id)->first();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function store(Request $request){
        $arr = $request->all();
        while ( $data = current($arr)) {
            $this->AbonnementModel->{key($arr)} = $data;
            next($arr);
        }
        $validation = Validator::make($request->all(), $this->AbonnementModel->rules);
        if( $validation->passes() ){
            $this->AbonnementModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->AbonnementModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }
    }

    public function storeWithEleve(Request $request){
        try{
            $arr = $request->except('eleves');
            while ( $data = current($arr)) {
                $this->AbonnementModel->{key($arr)} = $data;
                next($arr);
            }
            $validation = Validator::make($request->all(), $this->AbonnementModel->rules);
            if( $validation->passes() ){
                $this->AbonnementModel->save();
                $this->createAbonnementEleve($this->AbonnementModel, $request->get('eleves'));
                return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->AbonnementModel->id]);
            }else{
                return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
            }
        }catch (\Exception $e){
            trace_log($e->getTrace());
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $e->getTrace() );
        }
    }

    public function createAbonnementEleve($abonnement, $eleves){
        $abonnementeleves = AbonnementEleveModel::where('abonnement_id', $abonnement->id)->get();
        foreach($abonnementeleves as $abonnementeleve){
            $abonnementeleve->delete();
        }
        foreach($eleves as $eleve){
            // if(!$searchAbonnement){
                $abonnementeleve = new AbonnementEleveModel;
                $abonnementeleve->eleve_id = $eleve['id'];
                $abonnementeleve->abonnement_id = $abonnement->id;
                $abonnementeleve->annee_scolaire_id = $abonnement->annee_scolaire_id;
                $abonnementeleve->save();
            // }
        }
    }

    public function update($id, Request $request){
        $status = $this->AbonnementModel->where('id',$id)->update($request->all());
        if( $status ){
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');
        }
    }

    public function updateWithEleve($id, Request $request){
        try{
            $status = $this->AbonnementModel->where('id',$id)->update($request->except('eleves'));
            $this->createAbonnementEleve($this->AbonnementModel->where('id',$id)->first(), $request->get('eleves'));
            if( $status ){
                return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');
            }else{
                return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');
            }
        }catch (\Exception $e){
            trace_log($e->getTrace());
            $this->helpers->apiArrayResponseBuilder(400, 'fail', $e->getTrace() );
        }
    }

    public function getElevesAbonnement($id){
        try{
            $eleves = new Collection;
            // recuperation de l'abonnement
            $abonnement = AbonnementModel::find($id);
            foreach($abonnement->abonnementeleve as $abonnementeleve){
                $eleve = $abonnementeleve->eleve;
                $eleves->push(["id" => $eleve->id, "matricule" => $eleve->matricule, "name" => $eleve->name, "surname" => $eleve->surname]);
            }
            $data = $eleves->toArray();
            return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
        }catch (\Exception $e){
            trace_log($e->getTrace());
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $e->getTrace() );
        }
    }

    public function delete($id){

        $this->AbonnementModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->AbonnementModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}
