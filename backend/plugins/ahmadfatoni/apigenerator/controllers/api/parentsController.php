<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\School\Models\ParentModel;
use Illuminate\Support\Facades\Validator;
use RainLab\User\Models\User;
use Bootnetcrasher\School\Classes\Sms;

class parentsController extends Controller
{
    protected $ParentModel;

    protected $helpers;

    public function __construct(ParentModel $ParentModel, Helpers $helpers)
    {
        parent::__construct();
        $this->ParentModel    = $ParentModel;
        $this->helpers          = $helpers;
    }

    public function index(Request $request){
        $data = $this->ParentModel->with(array(
            'user'=>function($query){
                $query->select('*');
            },
            'eleves'=>function($query){
                $query->with(array(
                    'user' => function($query){
                        $query->select('*');
                    }
                ));
            } ));
        if($request->has('search')){
            $data = $data->where(function($query) use ($request){
                $query->where("name", 'like', '%'.$request->get('search').'%')
                    ->orWhere("surname", 'like', '%'.$request->get('search').'%')
                    ->orWhere("matricule", 'like', '%'.$request->get('search').'%')
                    ->orWhere("email", 'like', '%'.$request->get('search').'%');
            });
        }
        if($request->has('page') && $request->get('page') == 0){
            $data = $data->get()->toArray();
        }else{
            $data = $data->paginate(10)->toArray();
        }
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    
    public function show($id){ 
        $data = $this->ParentModel->with(array(
            'user'=>function($query){
                $query->select('*');
            },
            'eleves'=>function($query){
                $query->with(array(
                    'user' => function($query){
                        $query->select('*');
                    }
                ));
            },
             ))->select('*')->where('id', '=', $id)->first();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function store(Request $request){
        $arr = $request->except('create_account');
        while ( $data = current($arr)) {
            $this->ParentModel->{key($arr)} = $data;
            next($arr);
        }
        $validation = Validator::make($request->all(), $this->ParentModel->rules);
        if( $validation->passes() ){
            $this->ParentModel->save();
            $this->createOrUpdateAccountUser($request, $this->ParentModel);
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->ParentModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }
    }

    public function createOrUpdateAccountUser($data, $parent){
        if($data->create_account){
            $user = User::where('parenteleve_id', $parent->id)->first();
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
                $user->is_activated = 1;
                $user->password_confirmation = "0000";
                $user->activated_at = now();
                $user->parenteleve_id = $parent->id;
            }
            $user->save();
            $this->sharedPassword($user);
        }
    }

    public function sharedPassword($user){
        try{
            // recuperation du parent
            $parent = ParentModel::find($user->parenteleve_id);
            // trace_log("tel ".$parent->tel);
            $sms = new Sms();
            $body = "Mes félicitations, votre compte a été crée avec succès .\nUser:".$user->email."\nPassword: 0000.\n".
            "Site : www.ayauka.com\nAyauka vous remercie pour votre fidélité .";
            $sms->sendParamsUserConnexionQueue($parent->tel, $body, $parent);
        }catch (\Exception $ex){
            trace_log("message : ".$ex->getMessage());
            // trace_log("message : ".$ex->getTrace());
        }
    }

    public function update($id, Request $request){
        $status = $this->ParentModel->where('id',$id)->update($request->except('create_account'));
        if( $status ){
            $this->createOrUpdateAccountUser($request, $this->ParentModel->where('id',$id)->first());
            $this->updateUser($this->ParentModel->where('id',$id)->first(), $request);
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');
        }
    }

    public function updateUser($parent, $request){
        if($parent->user){
            $parent->user->name = $request->get('name');
            $parent->user->surname = $request->get('surname');
            $parent->user->surname = $request->get('surname');
            $parent->user->email = $request->get('email');
            $parent->user->save();
        }
    }

    public function delete($id){

        $this->ParentModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->ParentModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}
