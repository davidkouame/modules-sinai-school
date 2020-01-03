<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\School\Models\EleveModel;
use Illuminate\Support\Facades\Validator;
class eleveController extends Controller
{
    protected $EleveModel;

    protected $helpers;

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
            $data = $data->get()->toArray();
        }else{
            $data = $data->paginate(10)->toArray();
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

        while ( $data = current($arr)) {
            $this->EleveModel->{key($arr)} = $data;
            next($arr);
        }

        $validation = Validator::make($request->all(), $this->EleveModel->rules);
        
        if( $validation->passes() ){
            $this->EleveModel->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->EleveModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }

    }

    public function update($id, Request $request){
        $status = $this->EleveModel->where('id',$id)->update($request->all());
        if( $status ){
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');
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


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}
