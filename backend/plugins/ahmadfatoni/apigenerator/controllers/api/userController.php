<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use RainLab\User\Models\User;
use BootnetCrasher\School\Models\EleveModel;
use BootnetCrasher\School\Models\ProfesseurModel;
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
            }, ))->orderBy('created_at', 'desc')->select('*')->get()->toArray();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }*/

    public function index(Request $request){
        $data = $this->User->with(array(
            'role' => function ($query) {
                $query->select('*');
            })
        );
        foreach($request->except('page') as $key => $value){
            if($key == "search"){
                $data = $data->where("name", 'like', '%'.$value.'%')
                ->orWhere("email", 'like', '%'.$value.'%')
                ->orWhere("name", 'like', '%'.$value.'%');
            }else{
                $data = $data->where($key, $value);
            }
        }
        $data = $data->where('is_admin', 1);
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
        $data = $this->User->with(array(
            'role' => function ($query) {
                $query->select('*');
            })
        )->where('id',$id)->first();
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

        if($validation->passes() ){
            $this->User->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->User->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }

    }*/

    /*public function update($id, Request $request){
        $data = $request->all();
        $status = $this->User->where('id',$id)->update($data);
        if( $status ){

            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');

        }else{

            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');

        }
    }*/

    public function store(Request $request){
        $arr = $request->except('password');
        $validation = Validator::make($request->all(), $this->rules, $this->messages);
        if($validation->passes() ){
            while ( $data = current($arr)) {
                $this->User->{key($arr)} = $data;
                next($arr);
            }
            if($request->get('password')){
                $this->User->password = $request->get('password');
                $this->User->password_confirmation = $request->get('password_confirmation');
            }
            $this->User->is_activated = 1;
            $this->User->activated_at = now();
            $this->User->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->User->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }
    }

    public function update($id, Request $request){
        $validation = Validator::make($request->all(), $this->rules, $this->messages);
        if($validation->passes()){
            $arr = $request->except('password', 'confirmation_password');
            $user = $this->User->where('id',$id)->first();
            while ( $data = current($arr)) {
                $user->{key($arr)} = $data;
                next($arr);
            }
            if($request->get('password')){
                $user->password = $request->get('password');
                $user->password_confirmation = $request->get('password_confirmation');
            }
            $user->is_activated = 1;
            $user->activated_at = now();
            if($request->get('role_id')){
                $user->role_id = $request->get('role_id');
            }
            $user->save();
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');
            /*if( $status ){
                return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');
            }else{
                return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');
            }*/
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
        try {
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

            Event::fire('rainlab.user.beforeAuthenticate', [$this, $credentials]);
            $user = Auth::authenticate($credentials, true);
        } catch (\Exception $e) {
            trace_log("une erreur est survenue lors de l'authentification du compte cabinet, message=>" . $e->getMessage());
            return $this->helpers->apiArrayResponseBuilder(403, 'success', "Désolé, l'email ou mot passe est incorrect .");
        }
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $user);
    }



    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }

}
