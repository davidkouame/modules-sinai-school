<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use Illuminate\Support\Facades\Validator;
use BootnetCrasher\School\Models\ProfesseurModel;
use RainLab\User\Models\User;
use Bootnetcrasher\School\Classes\Sms;

class professeurController extends Controller
{
	protected $ProfesseurModel;

    protected $helpers;

    private $rules = [
        "nom" => "required",
        "prenom" => 'required',
        "email" => 'required',
        "tel" => 'required',
    ];
    
    private $messages = [
        "nom.required" => "Veuillez entrer un nom",
        "prenom.required" => "Veuillez entrer un prénom",
        "email.required" => "Veuillez entrer un email",
        "tel.required" => "Veuillez entrer un tel",
    ];

    public function __construct(ProfesseurModel $ProfesseurModel, Helpers $helpers)
    {
        parent::__construct();
        $this->ProfesseurModel    = $ProfesseurModel;
        $this->helpers          = $helpers;
    }

    public function index(Request $request){
        $data = $this->ProfesseurModel;
        foreach($request->except(['page']) as $key => $value){
            if($request->has('search')){
                // dd("dd");
                /*$data = $data->where("nom", 'like', '%'.$request->get('search'.'%'))
                ->orWhere("prenom", 'like', '%'.$request->get('search'.'%'))
                ->orWhere("reference", 'like', '%'.$request->get('search'.'%'))
                ->orWhere("name", 'like', '%'.$request->get('search'.'%'))
                ->orWhere("email", 'like', '%'.$request->get('search'.'%'));*/
                $data = $data->where(function($query) use ($request){
                    $query->where("nom", 'like', '%'.$request->get('search').'%')
                        ->orWhere("prenom", 'like', '%'.$request->get('search').'%')
                        ->orWhere("reference", 'like', '%'.$request->get('search').'%')
                        ->orWhere("name", 'like', '%'.$request->get('search').'%')
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

    public function show($id){
        // $data = $this->ProfesseurModel->where('id',$id)->first();
        $data = $this->ProfesseurModel->with(array(
            'users'=>function($query){
                $query->select('*');
            }))->select('*')->where('id', '=', $id)->first();
        if($data){
            return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
        }
        $this->helpers->apiArrayResponseBuilder(400, 'bad request', ['error' => 'invalid key']);
    }

    public function store(Request $request){
        $arr = $request->except('create_account');
        $validation = Validator::make($request->all(), $this->rules, $this->messages);
        if($validation->passes() ){
            /*while ( $data = current($arr)) {
                $this->ProfesseurModel->{key($arr)} = $data;
                next($arr);
            }*/
            $this->ProfesseurModel = $this->hydrate($this->ProfesseurModel, $request, ['create_account']);
            $this->ProfesseurModel->save();
            // création d'un compte user pour le professeur
            $this->createOrUpdateAccountUser($request, $this->ProfesseurModel);
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->ProfesseurModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }
    }

    public function createUserCompte(){
        // todo create teacher accoumpt if the checkbox is checked
    }

    public function createOrUpdateAccountUser($data, $professeur){
        // if($data->create_account){
        $user = User::where('professeur_id', $professeur->id)->first();
        if($user){
            $user->password = "0000";
            $user->password_confirmation = "0000";
        }else{
            $user = new User;
            $user->name = $data->name;
            $user->email = $data->email;
            $user->surname = $data->surname;
            $user->username = $data->email;
            $user->password = "0000";
            $user->password_confirmation = "0000";
            $user->activated_at = now();
            $user->is_activated = 1;
            $user->professeur_id = $professeur->id;
        }
        $user->save();
        $this->sharedPassword($user);
        // 
    }

    public function sharedPassword($user){
        try{
            // recuperation du professeur
            $professeur = ProfesseurModel::find($user->professeur_id);
            $sms = new Sms();
                $body = "Mes félicitations, votre compte a été crée avec succès .\nUser:".$user->email."\nPassword: 0000.\n".
                "Site : www.ayauka.com\nAyauka vous remercie pour votre fidélité .";
                $sms->sendParamsUserConnexionQueue($professeur->tel, $body, $professeur, null, "professeur");
        }catch (\Exception $ex){
            trace_log("Erreur dans la fonction sharedPassword message : ".$ex->getMessage());
            // trace_log("message : ".$ex->getTrace());
        }
    }

    public function update($id, Request $request){
        $validation = Validator::make($request->all(), $this->rules, $this->messages);
        if($validation->passes()){
            $status = $this->ProfesseurModel->where('id',$id)->update($request->except('create_account'));
            if( $status ){
                $this->createOrUpdateAccountUser($request, $this->ProfesseurModel->where('id',$id)->first());
                return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');
            }else{
                return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');
            }
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }
    }

    public function delete($id){

        $this->ProfesseurModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->ProfesseurModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}