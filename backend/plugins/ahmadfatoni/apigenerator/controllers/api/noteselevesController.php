<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use Illuminate\Support\Facades\Validator;
use BootnetCrasher\School\Models\NoteEleve;
class noteselevesController extends Controller
{
	protected $NoteEleve;

    protected $helpers;

    public function __construct(NoteEleve $NoteEleve, Helpers $helpers)
    {
        parent::__construct();
        $this->NoteEleve    = $NoteEleve;
        $this->helpers          = $helpers;
    }

    public function index(){
        $dataGet = get();
        $query = $this->NoteEleve->with(array(
            'note' => function ($query) {
                $query->select('*');
            },
            'eleve' => function ($query) {
                $query->select('*');
            },
        ));
        foreach($dataGet as $key => $data) {
            if($key != 'page'){
                $query->where($key, $data);
            } 
        }
        $data = $query->orderBy('created_at', 'desc')->paginate(10)->toArray();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }
    
    public function addValueNote($eleve_id, $note_id, Request $request){
        $data = $this->NoteEleve->where('eleve_id', $eleve_id)
                ->where('note_id', $note_id)
                ->first();
        if($data){
            $data->valeur = $request->get('valeur');
            $data->save();
        }else{
            $data = new NoteEleve;
            $data->eleve_id = $eleve_id;
            $data->note_id = $note_id;
            $data->valeur = $request->get('valeur');
            $data->save();
        }
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function show($id){

        $data = $this->NoteEleve->with(array(
            'note' => function ($query) {
                $query->select('*');
            },
            'eleve' => function ($query) {
                $query->select('*');
            },
        ))->where('id',$id)->first();

        if($data){

            return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);

        }

        $this->helpers->apiArrayResponseBuilder(400, 'bad request', ['error' => 'invalid key']);

    }

    public function store(Request $request){

    	$arr = $request->all();

        while ( $data = current($arr)) {
            $this->NoteEleve->{key($arr)} = $data;
            next($arr);
        }

        $validation = Validator::make($request->all(), $this->NoteEleve->rules);
        
        if( $validation->passes() ){
            $this->NoteEleve->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->NoteEleve->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }

    }

    public function update($id, Request $request){

        $status = $this->NoteEleve->where('id',$id)->update($data);
    
        if( $status ){
            
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');

        }else{

            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');

        }
    }

    public function delete($id){

        $this->NoteEleve->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->NoteEleve->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }
    
    /*public function getValeurByEleveIdAndNoteId($eleve_id, $note_id){
        $data = $this->NoteEleve->where('eleve_id', $eleve_id)
                ->where('note_id', $note_id)
                ->first();
        $data = $data ? $data->valeur : null;
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }*/


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}