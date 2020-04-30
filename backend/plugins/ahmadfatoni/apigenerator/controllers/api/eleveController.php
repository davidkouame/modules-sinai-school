<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\School\Models\EleveModel;
use Illuminate\Support\Facades\Validator;
use RainLab\User\Models\User;
use BootnetCrasher\School\Models\ClasseEleveModel;
class eleveController extends Controller
{
    protected $EleveModel;

    protected $helpers;

    private $rules = [
        "name" => "required",
        "surname" => "required",
        "tel" => 'required',
        "email" => 'required',
        // "datenaissance" => 'required'
    ];
    
    private $messages = [
        "name.required" => "Veuillez entrer un nom",
        "surname.required" => "Veuillez entrer un prénom",
        "tel.required" => "Veuillez entrer un numéros",
        "email.required" => "Veuillez entrer un email ",
        // "datenaissance.required" => "Veuillez entrer une date de naissance"
    ];

    public function __construct(EleveModel $EleveModel, Helpers $helpers)
    {
        parent::__construct();
        $this->EleveModel    = $EleveModel;
        $this->helpers          = $helpers;
    }

    public function index(Request $request){ 
        $data = $this->EleveModel->with(array(
            'user'=>function($query){
                $query->select('*');
            },
            'parent'=>function($query){
                $query->with(array(
                    'users'=>function($q){
                        $q->select('*');
                    }
                ))->select('*');
            }, 
            'noteseleves'=>function($query){
                $query->select('*');
            },          
            ))->select('*');
        foreach($request->except('page') as $key => $value){
            if($key == "search"){
                $data = $data->where(function($query) use ($request){
                    $query->where("name", 'like', '%'.$request->get('search').'%')
                        ->orWhere("surname", 'like', '%'.$request->get('search').'%')
                        ->orWhere("matricule", 'like', '%'.$request->get('search').'%')
                        ->orWhere("email", 'like', '%'.$request->get('search').'%');
                });
            }else{
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

    public function indexCustomise(Request $request){
        $data = $this->EleveModel;
        $data = $data->select('id', 'matricule', 'name', 'surname');
        foreach($request->except('page') as $key => $value){
            if($key == "search"){
                $data = $data->where(function($query) use ($request){
                    $query->where("name", 'like', '%'.$request->get('search').'%')
                        ->orWhere("surname", 'like', '%'.$request->get('search').'%')
                        ->orWhere("matricule", 'like', '%'.$request->get('search').'%')
                        ->orWhere("email", 'like', '%'.$request->get('search').'%');
                });
            }else{
                $data = $data->where($key, $value);
            }

        }
        if($request->has('page') && $request->get('page') == 0){
            $data = $data->get()->toArray();
        }else{
            $data = $data->paginate(10)->toArray();
        }
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function indexWithoutPaginate(Request $request){
        $data = $this->EleveModel->with(array(
            'user'=>function($query){
                $query->select('*');
            },
            'parent'=>function($query){
                $query->with(array(
                    'users'=>function($q){
                        $q->select('*');
                    }
                ))->select('*');
            },
            'noteseleves'=>function($query){
                $query->select('*');
            },
        ))->select('*');

        foreach($request->except('page') as $key => $value){
            $data = $data->where($key, $value);
        }

        $data = $data->get()->toArray();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }
    
    public function show($id){
        $data = $this->EleveModel->with(array(
            'user'=>function($query){
                $query->select('*');
            },'parent'=>function($query){
                // $query->select('*');
                $query->with(array(
                    'users'=>function($q){
                        $q->select('*');
                    }
                ))->select('*');
            },
            'classeseleves'=>function($query){
                $query->select('*');
            },
            'noteseleves'=>function($query){
                $query->select('*');
            }))->select('*')->where('id', '=', $id)->first();
            // dd($data);
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function store(Request $request){
        $arr = $request->all();
        $validation = Validator::make($request->all(), $this->rules, $this->messages);
        if($validation->passes() ){
            while ( $data = current($arr)) {
                $this->EleveModel->{key($arr)} = $data;
                next($arr);
            }
            $this->EleveModel->save();
            $eleve = $this->EleveModel;
            $this->createOrUpdateAccountUser($request, $eleve);
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->EleveModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }
    }

    public function createOrUpdateAccountUser($data, $eleve){
        $user = User::where('eleve_id', $eleve->id)->first();
        if($user){
            $user->password = "0000";
            $user->password_confirmation = "0000";
            trace_log("creation d'un utilisateur");
        }else{
            $user = new User;
            $user->name = $data->name;
            $user->email = $data->email;
            $user->surname = $data->surname;
            $user->username = $data->email;
            $user->is_activated = 1;
            $user->password = "0000";
            $user->password_confirmation = "0000";
            $user->activated_at = now();
            $user->eleve_id = $eleve->id;
        }
        $user->save();
    }

    public function updateUser($eleve, $request){
        if($eleve->user){
            $eleve->user->name = $request->get('name');
            $eleve->user->surname = $request->get('surname');
            $eleve->user->surname = $request->get('surname');
            $eleve->user->email = $request->get('email');
            $eleve->user->save();
        }
    }

    public function update($id, Request $request){
        $validation = Validator::make($request->all(), $this->rules, $this->messages);
        if(
            $validation->passes()){
            $status = $this->EleveModel->where('id',$id)->update($request->all());
            $eleve = $this->EleveModel->where('id',$id)->first();
            $this->updateUser($this->EleveModel->where('id',$id)->first(), $request);
            if($status){
                $this->createOrUpdateAccountUser($request, $eleve);
                return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');
            }else{
                return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');
            }
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }
    }

    public function delete($id){
        $this->EleveModel->where('id',$id)->delete();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){
        $this->EleveModel->where('id',$id)->delete();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function getEleveClasseByEleveIdAndAnneeScolaireId($eleve_id, $annee_scolaire_id){
        $classeEleve = ClasseEleveModel::where('eleve_id', $eleve_id)->where('annee_scolaire_id', $annee_scolaire_id)->first();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $classeEleve->toArray());
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}
