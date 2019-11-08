<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\School\Models\NoteModel;
use BootnetCrasher\School\Models\NoteEleve;
use Dotenv\Validator;
class noteController extends Controller
{
    protected $NoteModel;

    protected $helpers;

    public function __construct(NoteModel $NoteModel, Helpers $helpers)
    {
        parent::__construct();
        $this->NoteModel    = $NoteModel;
        $this->helpers          = $helpers;
    }

    
    public function index(Request $request){
        $data = $this->NoteModel->with(array(
            'typenote'=>function($query){
                $query->select('*');
            },
            'matiere'=>function($query){
                $query->select('*');
            },
            'classe'=>function($query){
                $query->with(array(
                    'eleves'=>function($q){
                        $q->select('*');
                    }
                ));
            } ));//->paginate(10)->toArray();

        foreach($request->except(['page']) as $key => $value){
            if($key == "libelle"){
                $data = $data->where($key, 'like', '%'.$value.'%');
            }elseif($key == 'eleve_id'){
                $data = $data->whereHas(
                    'classe',function($query){
                        $query->whereHas(
                            'eleves',function($query){
                                $query->where('id', 4)
                                ->select('*');
                            }
                        );
                    }
                );
            }else{
                $data = $data->where($key, $value);
            }
        }
        $data = $data->paginate(10)->toArray();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function getNotesByEleveId(Request $request, $eleve_id = null){
        $data = NoteEleve::with(array(
            'eleve'=>function($query){
                $query->select('*');
            },
            'note'=>function($query){
                $query->select('*');
            } ))->where('eleve_id', $eleve_id);
        foreach($request->except(['page']) as $key => $value){
            if($key == "libelle"){
                $data = $data->where($key, 'like', '%'.$value.'%');
            }else{
                $data = $data->where($key, $value);
            }
        }
        $data = $data->paginate(10)->toArray();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function getNotes(Request $request){
        $data = NoteEleve::with(array(
            'eleve'=>function($query){
                $query->select('*');
            },
            'note'=>function($query){
                $query->with(array(
                    'typenote' => function($q){
                        $q->select('*');
                    }))->select('*');
            } ));
        foreach($request->except(['page']) as $key => $value){
            if($key == "libelle"){
                $data = $data->whereHas('note', function ($query) use($request, $key) {
                    $query->where($key, 'like', '%'.$request->get('libelle').'%');
                });
            }elseif($key == "parent_id"){
                $data = $data->whereHas('eleve', function ($query) use($request, $key) {
                    $query->where($key,$request->get('parent_id'));
                });
            }elseif($key == "matiere_id"){
                $data = $data->whereHas('note', function ($query) use($request, $key) {
                    $query->where($key,$request->get('matiere_id'));
                });
            }else{
                $data = $data->where($key, $value);
            }
        }
        $data = $data->paginate(10)->toArray();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    
    public function show($id){ 
        $data = $this->NoteModel->with(array(
            'typenote'=>function($query){
                $query->select('*');
            },
            'matiere'=>function($query){
                $query->select('*');
            }, ))->select()->where('id', '=', $id)->first();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function store(Request $request){
        $datajson = json_decode($request->getContent(), true);
        $bodyResponse = null;
        $NoteModel = null;
        // foreach ($datajson['classe_id'] as $classe_id){
            $arr = $request->except(['classe_id']);
            $NoteModel = new NoteModel();
            while ( $data = current($arr)) {
                $NoteModel->{key($arr)} = $data;
                next($arr);
            }
            $NoteModel->classe_id = join(",", $datajson['classe_id']);
            $NoteModel->save();
            if(count($NoteModel->rules) > 0){
                $validation = Validator::make($request->all(), $NoteModel->rules);
                if( $validation->passes() ){
                    $NoteModel->save();
                    $bodyResponse = $this->helpers->apiArrayResponseBuilder(201, 'created',
                        ['id' => $NoteModel->id]);
                }else{
                    $bodyResponse = $this->helpers->apiArrayResponseBuilder(400, 'fail',
                        $validation->errors() );
                }
            }else{
                $NoteModel->save();
                $bodyResponse = $this->helpers->apiArrayResponseBuilder(201, 'created',
                    $NoteModel->toArray());
            }
        // }
        return $bodyResponse;
    }

    public function update($id, Request $request){

        $data = json_decode($request->getContent(), true);

        $data['classe_id'] = join(',', $data['classe_id']);

        $status = $this->NoteModel->where('id',$id)->update($data);
    
        if( $status ){
            
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');

        }else{

            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');

        }
    }

    public function delete($id){

        $this->NoteModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->NoteModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}
