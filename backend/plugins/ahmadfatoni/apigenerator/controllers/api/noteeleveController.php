<?php

namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\School\Models\NoteEleve;

class noteeleveController extends Controller
{
    protected $NoteEleve;

    protected $helpers;

    private $rules = [
        "valeur" => "required",
        "note_id" => 'required',
        "eleve_id" => 'required',
    ];
    
    private $messages = [
        "valeur.required" => "Veuillez entrer une valeur",
        "note_id.required" => "Veuillez sélectionnez une note",
        "eleve_id.required" => "Veuillez sélectionnez un élève"
    ];

    public function __construct(NoteEleve $NoteEleve, Helpers $helpers)
    {
        parent::__construct();
        $this->NoteEleve    = $NoteEleve;
        $this->helpers          = $helpers;
    }


    public function index()
    {
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
        $data = $query->paginate(10)->toArray();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }


    public function show($id)
    {
        $data = $this->NoteEleve->with(array(
            'typenote' => function ($query) {
                $query->select('*');
            },
            'matiere' => function ($query) {
                $query->select('*');
            },
        ))->select()->where('id', '=', $id)->first();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function store(Request $request)
    {
        $arr = $request->all();
        $validation = Validator::make($request->all(), $this->rules, $this->messages);
        if ($validation->passes()) {
            while ($data = current($arr)) {
                $this->NoteEleve->{key($arr)} = $data;
                next($arr);
            }
            $this->NoteEleve->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->NoteEleve->id]);
        } else {
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors());
        }
    }

    public function update($id, Request $request)
    {
        $validation = Validator::make($request->all(), $this->rules, $this->messages);
        if($validation->passes()){
            $status = $this->NoteEleve->where('id', $id)->update($data);
            if ($status) {
                return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');
            } else {
                return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');
            }
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors());
        }
    }

    public function delete($id)
    {

        $this->NoteEleve->where('id', $id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id)
    {

        $this->NoteEleve->where('id', $id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }


    public static function getAfterFilters()
    {
        return [];
    }
    public static function getBeforeFilters()
    {
        return [];
    }
    public static function getMiddleware()
    {
        return [];
    }
    public function callAction($method, $parameters = false)
    {
        return call_user_func_array(array($this, $method), $parameters);
    }
}
