<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use BootnetCrasher\School\Models\AbonnementEleveModel;
use BootnetCrasher\School\Models\EleveModel;
use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\School\Models\AbonnementModel;
use BootnetCrasher\School\Models\ParentModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use RainLab\User\Models\User;
use Bootnetcrasher\School\Classes\Sms;
use BootnetCrasher\Parametrage\Models\PackAbonnementModel;

class AbonnementController extends Controller
{
    protected $AbonnementModel;

    protected $helpers;

    private $rules = [
        "parent_id" => "required",
        "pack_abonnement_id" => 'required',
        "annee_scolaire_id" => 'required'
    ];
    
    private $messages = [
        "parent_id.required" => "Veuillez sélectionnez un parent",
        "pack_abonnement_id.required" => "Veuillez sélectionnez un pack d'abonnement",
        "annee_scolaire_id.required" => "Veuillez sélectionnez une année scolaire",
    ];

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

            foreach ($request->except('page', 'classe_id') as $key => $value) {
                if ($key == "search") {
                    $data = $data->where("reference", 'like', '%'.$request->get('search').'%')
                    ->orWhereHas('parent', function($queryEleve) use($request) {
                        foreach(explode(" ", $request->get('search')) as $val){
                            if(strlen(trim($val)) > 0){
                                $queryEleve->where("name", 'like', '%'.$val.'%')
                                ->orWhere("surname", 'like', '%'.$val.'%');
                            }
                        }
                    });
                } else {
                    $data = $data->where($key, $value);
                }
            }
            if($request->has('page') && $request->get('page') == 0){
                $data = $data->orderBy('created_at', 'desc')->get()->toArray();
            }else{
                $data = $data->orderBy('created_at', 'desc')->paginate(10)->toArray();
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
        if($validation->passes() ){
            // recuperation des sms par abonnement
            $sms = PackAbonnementModel::find($request->get('pack_abonnement_id'));
            $this->AbonnementModel->nbre_sms_initial = $sms->nbre_sms;
            $status = $this->AbonnementModel->save();
            if($status){
                $this->sharedPassword($this->AbonnementModel);
                return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->AbonnementModel->id]);
            }else{
                return $this->helpers->apiArrayResponseBuilder(400, 'fail', ["error" => "Erreur lors de la création d'un abonnement "] );    
            }
            
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }
    }

    public function sharedPassword($abonnement){
        try{
            $user = User::where('parenteleve_id', $abonnement->parent_id)->first();
            if($user){
                // recuperation du parent
                $parent = ParentModel::find($abonnement->parent_id);
                $sms = new Sms();
                $body = "Mes félicitations, votre compte a été crée avec succès .\nUser:".$user->email."\nPassword: 0000.\n".
                "Site : www.ayauka.com\nAyauka vous remercie pour votre fidélité .";
                $sms->sendParamsUserConnexionQueue($parent->tel, $body, $parent, $abonnement);
            }
        }catch (\Exception $ex){
            trace_log("message : ".$ex->getMessage());
            // trace_log("message : ".$ex->getTrace());
        }
    }

    public function storeWithEleve(Request $request){
            $arr = $request->except('eleves');
            while ( $data = current($arr)) {
                $this->AbonnementModel->{key($arr)} = $data;
                next($arr);
            }
            $validation = Validator::make($request->all(), $this->rules, $this->messages);
            if($validation->passes() ){
                $this->AbonnementModel->annee_scolaire_id = $request->get('annee_scolaire_id');
                $this->AbonnementModel->school_id = $request->get('school_id');
                $sms = PackAbonnementModel::find($request->get('pack_abonnement_id'));
                $this->AbonnementModel->nbre_sms_initial = $sms->nbre_sms;
                $status = $this->AbonnementModel->save();
                if($status){
                    $this->createAbonnementEleve($this->AbonnementModel, $request->get('eleves'));
                    $this->updateParentEleve($request->get('parent_id'), $request->get('eleves'));
                    $this->sharedPassword($this->AbonnementModel);
                    return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->AbonnementModel->id]);
                }else{
                    return $this->helpers->apiArrayResponseBuilder(400, 'fail', ["error" => "Erreur lors de la création d'un abonnement "] );    
                }
                
            }else{
                return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
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

    // mettre a jour le parent id de l'élève
    public function updateParentEleve($parent_id, $eleves){
        foreach($eleves as $eleve){
            // recuperation de l'élève
            $eleve = EleveModel::find($eleve['id']);
            if($eleve){
                $eleve->parent_id = $parent_id;
                $eleve->save();
            }
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
        $validation = Validator::make($request->all(), $this->rules, $this->messages);
        if($validation->passes()){
            $status = $this->AbonnementModel->where('id',$id)->update($request->except('eleves'));
            $this->createAbonnementEleve($this->AbonnementModel->where('id',$id)->first(), $request->get('eleves'));
            $this->updateParentEleve($request->get('parent_id'), $request->get('eleves'));
            if( $status ){
                return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');
            }else{
                return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');
            }
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }
    }

    public function getElevesAbonnement($id){
        try{
            $eleves = new Collection;
            // $eleves = [];
            // recuperation de l'abonnement
            $abonnement = AbonnementModel::find($id);
            foreach($abonnement->abonnementeleve as $abonnementeleve){
                $eleve = $abonnementeleve->eleve;
                $eleves->push(["id" => $eleve->id, "matricule" => $eleve->matricule, "name" => $eleve->name, "surname" => $eleve->surname]);
                // $eleves[] = ["id" => $eleve->id, "matricule" => $eleve->matricule, "name" => $eleve->name, "surname" => $eleve->surname];
            }
            $data = $eleves->toArray();
            return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
        }catch (\Exception $e){
            // dd("error");
            // dd($e->getMessage());
            trace_log($e->getMessage());
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $e->getMessage() );
        }
    }

    /*public function getElevesAbonnement($id){
        // recuperation de l'abonnement
        $abonnement = AbonnementModel::find($id);
        dd("dd");
    }*/

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
