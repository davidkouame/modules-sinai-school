<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\School\Models\NoteModel;
use BootnetCrasher\School\Models\NoteEleve;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Collection;
use Bootnetcrasher\School\Classes\Collection as TestCollection;

class noteController extends Controller
{
    protected $NoteModel;

    protected $helpers;

    private $rules = [
        "libelle" => "required",
        "datenoteeffectue" => 'required',
        "typenote_id" => 'required',
        "matiere_id" => 'required',
        "coefficient" => 'required',
        "classe_id" => 'required',
        "section_annee_scolaire_id" => 'required'
    ];
    
    private $messages = [
        "libelle.required" => "Veuillez entrer un libellé",
        "datenoteeffectue.required" => "Veuillez entrer la date à la note a été effectuée",
        "typenote_id.required" => "Veuillez sélectionner le type de note",
        "matiere_id.required" => "Veuillez sélectionner une matière",
        "coefficient.required" => "Veuillez entrer un coefficient",
        "classe_id.required" => "Veuillez sélectionner une classe",
        "classe_id.required" => "Veuillez sélectionner une classe",
        "section_annee_scolaire_id.required" => "Veuillez sélectionner une section d'année scolaire",
    ];

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
            } ));
        foreach($request->except(['page']) as $key => $value){
            if($key == "libelle"){
                $data = $data->where($key, 'like', '%'.$value.'%');
            }elseif($key == 'eleve_id'){
                $data = $data->whereHas(
                    'classe',function($query) use($request){
                        $query->whereHas(
                            'eleves',function($query) use($request){
                                $query->where('eleve_id', $request->get('eleve_id'))
                                ->select('*');
                                // dd($query->get());
                                // return $query->select('*');
                            }
                        );
                    }
                );
            }else if($key == "search"){
                $data = $data->where("libelle", 'like', '%'.$value.'%')
                ->orWhere('created_at', 'like', '%'.$value.'%')
                ->orWhere('reference', 'like', '%'.$value.'%')
                ->orWhereHas(
                    'typenote',function($query) use($request){
                        $query->where('libelle', $request->get('search'))
                        ->select('*');
                    }
                );
            } else{
                $data = $data->where($key, $value);
            }
        }
        
        /*if(!$request->has('professeur_id')){
            $data = $data->where('professeur_id', 0);
        }*/

        //if($request->has('professeur_id')){
        //    $data = $data->where('professeur_id', 0);
        //}
        // dd($data->get());
        
        $data = $data->orderBy('created_at', 'desc')->paginate(10)->toArray();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }
    
    // elle retourne les notes et ainsi que le valeur
    public function indexValeur(Request $request){
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
            } ));
        foreach($request->except(['page']) as $key => $value){
            if($key == "libelle"){
                $data = $data->where($key, 'like', '%'.$value.'%');
            }elseif($key == 'eleve_id'){
                $data = $data->whereHas(
                    'classe',function($query) use($request){
                        $query->whereHas(
                            'eleves',function($query) use($request){
                                // $query->where('id', $request->get('eleve_id'))
                                return $query->select('*');
                            }
                        );
                    }
                );
            }else{
                $data = $data->where($key, $value);
            }
        }
        $notesValeurs = collect([]);
        if($request->has('eleve_id')){
            $eleve_id = $request->get('eleve_id');
            $data->get()->each(function ($item, $key) use($notesValeurs, $eleve_id){
                $notesValeurs->push($item->id);
            });
        }
        $noteleve = NoteEleve::whereIn('note_id',$notesValeurs->toArray())
                ->where('eleve_id', $request->get('eleve_id'))->get();
        $data = $data->paginate(10)->toArray();
        $data = ["notes"=>$data, "valeurs"=>$noteleve->toArray()];
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    // elle retourne les notes et ainsi que le valeur
    public function indexValeurV2(Request $request){
        $data = DB::table('bootnetcrasher_school_note_eleve')
            ->join('bootnetcrasher_school_note', 'bootnetcrasher_school_note.id', '=', 'bootnetcrasher_school_note_eleve.note_id')
            ->join('bootnetcrasher_school_type_note', 'bootnetcrasher_school_type_note.id', '=', 'bootnetcrasher_school_note.typenote_id')
            ->join('bootnetcrasher_school_matiere', 'bootnetcrasher_school_matiere.id', '=', 'bootnetcrasher_school_note.matiere_id')
            ->join('bootnetcrasher_school_classe', 'bootnetcrasher_school_classe.id', '=', 'bootnetcrasher_school_note.classe_id');
        foreach($request->except(['page']) as $key => $value){
            if($key == "libelle"){
                $data->where('bootnetcrasher_school_note.libelle', 'like', '%'.$value.'%');
            }elseif ($key == "eleve_id"){
                $data->where('bootnetcrasher_school_note_eleve.eleve_id', '=', $value);
            }else{
                $data = $data->where($key, $value);
            }
        }
        $data = $data->select('bootnetcrasher_school_note.libelle', 'bootnetcrasher_school_type_note.libelle as type_note_libelle',
            'bootnetcrasher_school_note.created_at', 'bootnetcrasher_school_note_eleve.valeur', 'bootnetcrasher_school_note_eleve.rang',
            'bootnetcrasher_school_note.coefficient', 'bootnetcrasher_school_note_eleve.id as note_eleve_id', 'bootnetcrasher_school_note.id')
            ->get()->toArray();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function showNote(Request $request){
        $data = DB::table('bootnetcrasher_school_note')
            ->leftJoin('bootnetcrasher_school_note_eleve', 'bootnetcrasher_school_note.id', '=', 'bootnetcrasher_school_note_eleve.note_id')
            ->leftJoin('bootnetcrasher_school_eleve', 'bootnetcrasher_school_note_eleve.eleve_id', '=', 'bootnetcrasher_school_eleve.id')
            ->leftJoin('bootnetcrasher_school_type_note', 'bootnetcrasher_school_note.typenote_id', '=', 'bootnetcrasher_school_type_note.id')
            ->select('bootnetcrasher_school_note_eleve.*', 'bootnetcrasher_school_note.*', 'bootnetcrasher_school_type_note.libelle as libelle_type_note')
            ->where('eleve_id', $request->get('eleve_id'))
            ->where('eleve_id', $request->get('eleve_id'));
        foreach($request->except(['page']) as $key => $value){
            if($key == "search"){
                $date = explode("/", trim($request->get('search')));
                if(count($date) == 3){
                    $newdate = $date[2]."-".$date[1]."-".$date[0];
                    // dd($newdate);
                    $data = $data->whereDate("datenoteeffectue", "=", $newdate);
                }else{
                    $data = $data->where("bootnetcrasher_school_note.libelle", "=", trim($request->get('search')))
                        ->orWhere("bootnetcrasher_school_type_note.libelle", "=", trim($request->get('search')));
                }
            }else{
                $data = $data->where($key, $value);
            }
        }
        $data = $data->paginate(10)->toArray();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function getNotesV2(Request $request){
        $data = NoteModel::with(array(
            'noteseleves'=>function($query){
                $query->select('*');
            }));
        foreach($request->except(['page']) as $key => $value){
            if($key == "libelle"){
                $data = $data->where($key, 'like', '%'.$request->get('libelle').'%');
            }elseif($key == "parent_id"){
                $data = $data->whereHas('noteseleves', function ($query) use($request, $key) {
                    $query->whereHas('eleve', function ($query) use($request, $key) {
                        $query->where($key,$request->get('parent_id'));
                    });
                });
            }elseif($key == "eleve_id"){
                $data = $data->whereHas('noteseleves', function ($query) use($request, $key) {
                    $query->where($key,$request->get('eleve_id'));
                });
            }elseif($key == "search"){
                $date = explode("/", trim($request->get('search')));
                if(count($date) == 3){
                    $newdate = $date[2]."-".$date[1]."-".$date[0];
                    // dd($newdate);
                    $data = $data->whereDate("datenoteeffectue", "=", $newdate);
                }else{
                    $data = $data->where("libelle", 'like', '%'.trim($request->get('search')).'%')
                        ->orWhereHas('typenote', function($queryTypeNote) use($request) {
                            $queryTypeNote->where("libelle", "=", trim($request->get('search')));
                        });
                }
            }else{
                $data = $data->where($key, $value);
            }
        }
        $data = $data->paginate(10)->toArray();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    /*public function getNotesV3(Request $request){
        $data = DB::table('bootnetcrasher_school_note')
            ->leftJoin('bootnetcrasher_school_note_eleve', 'bootnetcrasher_school_note.id', '=', 'bootnetcrasher_school_note_eleve.note_id')
            ->leftJoin('bootnetcrasher_school_eleve', 'bootnetcrasher_school_note_eleve.eleve_id', '=', 'bootnetcrasher_school_eleve.id')
            ->leftJoin('bootnetcrasher_school_type_note', 'bootnetcrasher_school_note.typenote_id', '=', 'bootnetcrasher_school_type_note.id');
        foreach($request->except(['page', 'eleve_id']) as $key => $value){
            if($key == "search"){
                $date = explode("/", trim($request->get('search')));
                if(count($date) == 3){
                    $newdate = $date[2]."-".$date[1]."-".$date[0];
                    $data = $data->whereDate("datenoteeffectue", "=", $newdate);
                }else{
                    $data = $data->where("bootnetcrasher_school_note.libelle", "like", "%".$request->get('search')."%")
                        ->orWhere("bootnetcrasher_school_type_note.libelle", "like", "%".$request->get('search')."%");
                }
            }else{
                $data = $data->where($key, $value);
            }
        }
        $data = $data->select('bootnetcrasher_school_note_eleve.id as note_eleve_id', 'bootnetcrasher_school_note_eleve.*', 'bootnetcrasher_school_note.*', 'bootnetcrasher_school_type_note.libelle as libelle_type_note');
        $data = $data->paginate(10)->toArray();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }*/

    public function getNotesV3(Request $request){
        // die("dd")
        // recuperation des notes
        $collect = new TestCollection();
        // $notes = NoteModel::where('classe_id', $request->get('classe_id'))->get();
        $notes = $this->NoteModel;
        foreach($request->except(['page']) as $key => $value){
            if($key == "search"){
                $date = explode("/", trim($request->get('search')));
                if(count($date) == 3){
                    $newdate = $date[2]."-".$date[1]."-".$date[0];
                    $notes = $notes->whereDate("datenoteeffectue", "=", $newdate);
                }else{
                    $notes = $notes->where("libelle", "like", "%".$request->get('search')."%")
                        ->orWhereHas('typenote', function($queryTypeNote) use($request) {
                            $queryTypeNote->where("libelle", "=", trim($request->get('search')));
                        });
                }
            }elseif($key == "eleve_id"){
                $notes = $notes->whereHas('noteseleves', function ($query) use($request, $key) {
                    $query->where($key,$request->get('eleve_id'));
                });
            }elseif($key == "parent_id"){
                $notes = $notes->whereHas('noteseleves', function ($query) use($request, $key) {
                    $query->whereHas('eleve', function ($query) use($request, $key) {
                        $query->where($key,$request->get('parent_id'));
                    });
                });
            }else{
                $notes = $notes->where($key, $value);
            }
        }
        // die("hdh");
        $notes = $notes->get();
        foreach($notes as $note){
            $noteeleve = NoteEleve::where('note_id', $note->id)->where('eleve_id', $request->get('eleve_id'))->first();
            $collect->push([
                "noteeleve" => $noteeleve ? $noteeleve->toArray() : null,
                "note" => $note->toArray(),
                "eleve" => $noteeleve && $noteeleve->eleve ? $noteeleve->eleve->toArray() : null,
                "typenote" => $note->typenote ? $note->typenote->toArray() : null,
                "matiere" => $note->matiere ? $note->matiere->toArray() : null
            ]);
        }
        $data = $collect->paginate(10)->toArray();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function getNotesV4(Request $request){
        // recuperation des notes
        $collect = new TestCollection();
        $notes = NoteModel::where('classe_id', $request->get('classe_id'))->get();
        foreach($notes as $note){
            $noteeleve = NoteEleve::where('note_id', $note->id)->where('eleve_id', $request->get('eleve_id'))->first();
            $collect->push([
                "noteeleve" => $noteeleve ? $noteeleve->toArray() : null,
                "note" => $note->toArray(),
                "eleve" => $noteeleve && $noteeleve->eleve ? $noteeleve->eleve->toArray() : null,
                "typenote" => $note->typenote ? $note->typenote->toArray() : null,
                "matiere" => $note->matiere ? $note->matiere->toArray() : null
            ]);
        }
        $data = $collect->paginate(10)->toArray();
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
            }elseif($key == "search"){
                $data = $data->whereHas('note', function ($query) use($request, $key) {
                    // $query->where("libelle", 'like', '%'.$request->get('search').'%');
                        // ->orWhereDate("datenoteeffectue", "=", "2019-12-04 21:41:08");
                    // $query->whereDate("datenoteeffectue", "=", "2019-12-04");
                    $date = explode("/", trim($request->get('search')));
                    if(count($date) == 3){
                        $newdate = $date[2]."-".$date[1]."-".$date[0];
                        // dd($newdate);
                        $query->whereDate("datenoteeffectue", "=", $newdate);
                    }else{
                        $query->where("libelle", 'like', '%'.trim($request->get('search')).'%')
                        ->orWhereHas('typenote', function($queryTypeNote) use($request) {
                            $queryTypeNote->where("libelle", "=", trim($request->get('search')));
                        });
                    }

                });
            }elseif($key == "matiere_id"){
                $data = $data->whereHas('note', function ($query) use($request, $key) {
                    $query->where($key,$request->get('matiere_id'));
                });
            }elseif($key == "section_annee_scolaire_id"){
                $data = $data->whereHas('note', function ($query) use($request, $key) {
                    $query->where($key,$request->get('section_annee_scolaire_id'));
                });
            }else{
                $data = $data->where($key, $value);
            }
        }
        $data = $data->paginate(10)->toArray();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function showV2($id){
        $data = DB::table('bootnetcrasher_school_note_eleve')
            ->leftJoin('bootnetcrasher_school_note', 'bootnetcrasher_school_note.id', '=', 'bootnetcrasher_school_note_eleve.note_id')
            ->leftJoin('bootnetcrasher_school_eleve', 'bootnetcrasher_school_note_eleve.eleve_id', '=', 'bootnetcrasher_school_eleve.id')
            ->leftJoin('bootnetcrasher_school_type_note', 'bootnetcrasher_school_note.typenote_id', '=', 'bootnetcrasher_school_type_note.id')
            ->select('bootnetcrasher_school_note_eleve.*', 'bootnetcrasher_school_note.*', 'bootnetcrasher_school_type_note.libelle as libelle_type_note')
            ->where('id', $id)
            ->first();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function show($id){
        $data = $this->NoteModel->with(array(
            'typenote'=>function($query){
                $query->select('*');
            },
            'matiere'=>function($query){
                $query->select('*');
            },
            'classe'=>function($query){
                $query->select('*');
            },
            'sectionanneescolaire'=>function($query){
                $query->select('*');
            },))->select()->where('id', '=', $id)->first();
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function store(Request $request){
        $validation = Validator::make($request->all(), $this->rules, $this->messages);
        if( $validation->passes() ){
            $datajson = json_decode($request->getContent(), true);
            $bodyResponse = null;
            $arr = $request->all();
            
            $note = new NoteModel();
            /*while ( $data = current($arr)) {
                $note->{key($arr)} = $data;
                next($arr);
            }*/
            $note = $this->hydrate($note, $request);
            // $NoteModel->typenote_id = $request->get('typenote_id');
            $note->save();
            $bodyResponse = $this->helpers->apiArrayResponseBuilder(201, 'created',
                ['id' => $note->id]);
        }else{
            $bodyResponse = $this->helpers->apiArrayResponseBuilder(400, 'fail',
                $validation->errors() );
        }
        return $bodyResponse;
    }

    public function update($id, Request $request){
        $validation = Validator::make($request->all(), $this->rules, $this->messages);
        if($validation->passes()){
            $data = json_decode($request->getContent(), true);
            $status = $this->NoteModel->where('id',$id)->update($data);
            if( $status ){
                return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');
            }else{
                return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');
            }
        }else{
            return $this->helpers->apiArrayResponseBuilder(400, 'fail',
            $validation->errors() );
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
