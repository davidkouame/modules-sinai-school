<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use Illuminate\Support\Facades\Validator;
use BootnetCrasher\School\Models\RapportValidationModel;
use BootnetCrasher\School\Models\ClasseModel;
use BootnetCrasher\School\Models\NoteModel;
use BootnetCrasher\School\Models\NoteEleve;
class rapportvalidationController extends Controller
{
	protected $RapportValidationModel;

    protected $helpers;

    public function __construct(RapportValidationModel $RapportValidationModel, Helpers $helpers)
    {
        parent::__construct();
        $this->RapportValidationModel    = $RapportValidationModel;
        $this->helpers          = $helpers;
    }

    public function index(){

        $data = $this->RapportValidationModel->all()->toArray();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function show($id){

        $data = $this->RapportValidationModel->where('id',$id)->first();

        if( count($data) > 0){

            return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);

        }

        $this->helpers->apiArrayResponseBuilder(400, 'bad request', ['error' => 'invalid key']);

    }

    public function store(Request $request){
        // dd($request->get('description'));
    	$arr = $request->all();
        // dd($arr);
        while ( $data = current($arr)) {
            $this->RapportValidationModel->{key($arr)} = $data;
            next($arr);
        }
        $validation = Validator::make($request->all(), $this->RapportValidationModel->rules);
        if( $validation->passes() ){
            $this->RapportValidationModel->save();
            $this->validatedNote($this->RapportValidationModel->id, $request->get('classe_id'));
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->RapportValidationModel->id]);
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors() );
        }
    }
    
    // Validation des notes
    public function validatedNote($rapport_validation_id, $classe_id){
        NoteModel::where('classe_id', $classe_id)
                ->update(['rapport_validation_id' => $rapport_validation_id]);
        $notes = NoteModel::where('classe_id', $classe_id)->get();
        $notes->each(function($element, $item) use($rapport_validation_id){
            NoteEleve::where('note_id', $element->id)
                    ->update(['rapport_validation_id' => $rapport_validation_id]);
        });
    }

    public function update($id, Request $request){

        $status = $this->RapportValidationModel->where('id',$id)->update($data);
    
        if( $status ){
            
            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');

        }else{

            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');

        }
    }

    public function delete($id){

        $this->RapportValidationModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id){

        $this->RapportValidationModel->where('id',$id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}