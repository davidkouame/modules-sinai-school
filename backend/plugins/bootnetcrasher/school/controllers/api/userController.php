<?php namespace BootnetCrasher\School\Controllers\Api;

use Backend\Facades\BackendAuth;
use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\School\Models\ProfesseurModel;
use BootnetCrasher\School\Models\ParentEleve;
use RainLab\User\Models\BackendUser;
use RainLab\User\Models\User;
use Event;
use Auth;
use BootnetCrasher\School\Models\EleveModel;
use Validator;
use ValidationException;
class userController extends Controller
{
    protected $User;

    protected $helpers;

    private $rules = [];

    private $messages = [];

    public function __construct(User $User, Helpers $helpers)
    {
        parent::__construct();
        $this->User    = $User;
        $this->helpers          = $helpers;
    }


    /*public function index(){
        $data = $this->User->with(array(
            'users'=>function($query){
                $query->select('*');
            }, ))->select('*')->get()->toArray();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }*/

    public function index(Request $request){
        $data = $this->User;
        foreach($request->except('page') as $key => $value){
            if($key == "search"){
                $data = $data->where("name", 'like', '%'.$value.'%')
                ->orWhere("email", 'like', '%'.$value.'%')
                ->orWhere("username", 'like', '%'.$value.'%')
                ->orWhere("surname", 'like', '%'.$value.'%');
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

    /*public function show($id){
        $data = $this->User->with(array(
            'users'=>function($query){
                $query->select('*');
            }, ))->select('*')->where('id', '=', $id)->first();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }*/

    public function show($id){
        $data = $this->User->where('id',$id)->first();
        if($data){
            return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
        }
        $this->helpers->apiArrayResponseBuilder(400, 'bad request', ['error' => 'invalid key']);
    }


    /*public function store(Request $request){

        $arr = $request->all();

        while ( $data = current($arr)) {
            $this->User->{key($arr)} = $data;
            next($arr);
        }

        $validation = Validator::make($request->all(), $this->User->rules);

        if( $validation->passes() ){
            $this->User->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->User->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }

    }*/

    public function store(Request $request){
        $arr = $request->all();
        $validation = Validator::make($request->all(), $this->rules, $this->messages);
        if( $validation->passes() ){
            while ( $data = current($arr)) {
                $this->User->{key($arr)} = $data;
                next($arr);
            }
            $this->User->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->User->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }
    }

    /*public function update($id, Request $request){

        $status = $this->User->where('id',$id)->update($data);

        if( $status ){

            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');

        }else{

            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');

        }
    }*/

    public function update($id, Request $request){
        $validation = Validator::make($request->all(), $this->rules, $this->messages);
        if($validation->passes()){
            $status = $this->User->where('id',$id)->update($request->all());
            if( $status ){
                return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');
            }else{
                return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');
            }
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }
    }

    public function delete($id){

        $this->User->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->User->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function login(Request $request)
    {
        $user = null;
        // try {
            //recupération des données postées
            $data = post();
            $credentials = [
                'login'    => array_get($data, 'email'),
                'password' => array_get($data, 'password')
            ];

            //on verifie si l'email est dans la base et que celui est rattaché a un compte cabinetplacement
            $user = User::where('email', '=', $data['email'])
                // ->whereNotNull('parenteleve_id')
                ->first();

            if (!$user) {
                return $this->helpers->apiArrayResponseBuilder(403, 'success', "Désolé, l'email ou mot passe est incorrect .");
            }

            if($user->parenteleve_id){
                //recupération du compte parenteleve
                $parenteleve = ParentEleve::where('id', '=', $user->parenteleve_id)->first();
                if (!$parenteleve) {
                    return $this->helpers->apiArrayResponseBuilder(403, 'success', "Désolé, l'email ou mot passe est incorrect .");
                }
            }elseif($user->professeur_id){
                //recupération du compte professeur
                $professeur = ProfesseurModel::where('id', '=', $user->professeur_id)->first();
                if (!$professeur) {
                    return $this->helpers->apiArrayResponseBuilder(403, 'success', "Désolé, l'email ou mot passe est incorrect .");
                }
            }else{
                //recupération du compte eleve
                $eleve = EleveModel::where('id', '=', $user->eleve_id)->first();
                if (!$eleve) {
                    return $this->helpers->apiArrayResponseBuilder(403, 'success', "Désolé, l'email ou mot passe est incorrect .");
                }
            }
            // dd(Auth::attempt($request->only('email', 'password')));
            Event::fire('rainlab.user.beforeAuthenticate', [$this, $credentials]);
            $user = Auth::authenticate($credentials, true);
            $user = User::with('professeur')->where('id', $user->id)->first();
        /*} catch (\Exception $e) {
            trace_log("une erreur est survenue lors de l'authentification du compte, message=>" . $e->getMessage());
            return $this->helpers->apiArrayResponseBuilder(403, 'success', "Désolé, l'email ou mot passe est incorrect .");
        }*/
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $user);
    }

    public function loginBackend(Request $request)
    {
        $user = null;
        $data = post();
        $credentials = [
            'login'    => array_get($data, 'email'),
            'password' => array_get($data, 'password')
        ];
        //on verifie si l'email est dans la base et que celui est rattaché a un compte cabinetplacement
        $user = User::where('email', '=', $data['email'])->whereNotNull('ecole_id')
            ->first();
        // Event::fire('rainlab.user.beforeAuthenticate', [$this, $credentials]);
        $user = Auth::authenticate($credentials, true);
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $user);
    }

    /*public function loginBackend(Request $request)
    {
        $user = null;
        $data = post();
        $credentials = [
            'login'    => array_get($data, 'email'),
            'password' => array_get($data, 'password')
        ];
        //on verifie si l'email est dans la base et que celui est rattaché a un compte cabinetplacement
        $user = BackendUser::where('email', '=', $data['email'])
            ->first();

        if (!$user) {
            return $this->helpers->apiArrayResponseBuilder(403, 'success', "Désolé, l'email ou mot passe est incorrect .");
        }
        Event::fire('rainlab.user.beforeAuthenticate', [$this, $credentials]);
        $user = Auth::authenticate($credentials, true);
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $user);
    }*/


    public function updateUser(Request $request){
        try{
            $data = $request->all();
            // if($data["password"])
            $rules = [];
            $messages = [];
            if(!$request->has('first_login')){
                if(array_key_exists("password", $data)){
                    $rules = [
                        'name'     => 'required',
                        'surname'     => 'required',
                        // 'tel' => 'required',
                        'password' => 'required|confirmed',
                        'password_confirmation' => 'required_with:password'
                    ];
                    $messages = [
                        "name.required" => "Veuillez entrer un nom",
                        "surname.required" => "Veuillez entrer un prénom",
                        "password.required" => "Veuillez entrer un mot de passe",
                        "password_confirmation.required" => "Veuillez entrer un mot de passe de confirmation",
                        "password_confirmation.required_with" => "Désolé les mots de passes ne correspondent"
                    ];
                }else{
                    $rules = [
                        'name'     => 'required',
                        'surname'     => 'required'
                        // 'tel' => 'required',
                    ];
                    $messages = [
                        "name.required" => "Veuillez entrer un nom",
                        "surname.required" => "Veuillez entrer un prénom"
                    ];
                }
            }
            $validation = Validator::make($data, $rules, $messages);
            if (!$validation->passes()) {
                trace_log("Une erreur est survenue lors de la mise à jour de l'utilsateur, message : l'utilisateur
                n'existe pas ");
                return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
            }
            $user = User::where('email', $request->get('email'))->first();
            if(!$user){
                trace_log("Une erreur est survenue lors de la mise à jour de l'utilsateur, message : l'utilisateur
                n'existe pas ");
                // return $this->helpers->apiArrayResponseBuilder(500, 'error', "Une erreur est survenue lors de la mise à jour du professeur !");
                return $this->helpers->apiArrayResponseBuilder(400, 'fail', ["error" => "Une erreur est survenue lors de la mise à jour du professeur !"] );
            }
            /*if(array_key_exists("username", $data)){
                $user->name = $data['username'];
            }*/
            // $user->name = $data['username'];
            /*if(array_key_exists("password", $data)){
                $user->password = $data['password'];
                $user->password_confirmation = $data['password_confirmation'];
            }*/
            
            $user = $this->hydrate($user, $request, ['tel']);
            $user->save();
            if($user->professeur_id){
                $professeur = ProfesseurModel::find($user->professeur_id);
                if($professeur){
                    if(array_key_exists("tel", $data)){
                        $professeur->tel = $data['tel'];
                    }
                    if(array_key_exists("name", $data)){
                        $professeur->nom = $data['name'];
                    }
                    if(array_key_exists("surname", $data)){
                        $professeur->prenom = $data['surname'];
                    }
                    $professeur->save();
                }
            }
            return $this->helpers->apiArrayResponseBuilder(200, 'success', $user);
        }catch(\Exception $e){
            // trace_log("une erreur est survenue lors de la mise à jour du user => " . $e->getMessage());
            return $this->helpers->apiArrayResponseBuilder(500, 'error', "Une erreur est survenue lors de la mise à jour du professeur !");
        }
        // $user->name = $request->get('username');
    }

    public function hydrateUser($model, $request){
        $model = $this->hydrate($model, $request, ['password']);
        if(array_key_exists("password", $request->all())){
            $model->password = $data['password'];
            $model->password_confirmation = $data['password_confirmation'];
        }
        return $model;
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }

}
