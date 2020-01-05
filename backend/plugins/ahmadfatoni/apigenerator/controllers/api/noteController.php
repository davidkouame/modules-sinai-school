<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\School\Models\NoteModel;
use BootnetCrasher\School\Models\NoteEleve;
use Dotenv\Validator;
use DB;
use Illuminate\Support\Collection;
use Bootnetcrasher\School\Classes\Collection as TestCollection;

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
                $data = $data->where("libelle", 'like', '%'.$value.'%');
            } else{
                $data = $data->where($key, $value);
            }
        }
        
        if(!$request->has('professeur_id')){
            $data = $data->where('professeur_id', 0);
        }
        
        $data = $data->paginate(10)->toArray();
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

    public function getNotesV3(Request $request){
        $data = DB::table('bootnetcrasher_school_note')
            ->leftJoin('bootnetcrasher_school_note_eleve', 'bootnetcrasher_school_note.id', '=', 'bootnetcrasher_school_note_eleve.note_id')
            ->leftJoin('bootnetcrasher_school_eleve', 'bootnetcrasher_school_note_eleve.eleve_id', '=', 'bootnetcrasher_school_eleve.id')
            ->leftJoin('bootnetcrasher_school_type_note', 'bootnetcrasher_school_note.typenote_id', '=', 'bootnetcrasher_school_type_note.id');
            // ->where('eleve_id', $request->get('eleve_id'))
            // ->WhereNull('eleve_id', $request->get('eleve_id'));
        foreach($request->except(['page', 'eleve_id']) as $key => $value){
            if($key == "search"){
                $date = explode("/", trim($request->get('search')));
                if(count($date) == 3){
                    $newdate = $date[2]."-".$date[1]."-".$date[0];
                    // dd($newdate);
                    $data = $data->whereDate("datenoteeffectue", "=", $newdate);
                }else{
                    // $data = $data->where(function ($query) use($request){
                    //     $query->where("bootnetcrasher_school_note.libelle", "=", $request->get('search'))
                    //         ->orWhere("bootnetcrasher_school_type_note.libelle", "=", $request->get('search'));
                    // });
                    $data = $data->where("bootnetcrasher_school_note.libelle", "like", "%".$request->get('search')."%")
                        ->orWhere("bootnetcrasher_school_type_note.libelle", "like", "%".$request->get('search')."%");
                }
            }else{
                $data = $data->where($key, $value);
            }
        }
        $data = $data->where('eleve_id', $request->get('eleve_id'))
            ->orWhereNull('eleve_id');
        $data = $data->select('bootnetcrasher_school_note_eleve.id as note_eleve_id', 'bootnetcrasher_school_note_eleve.*', 'bootnetcrasher_school_note.*', 'bootnetcrasher_school_type_note.libelle as libelle_type_note');
        $data = $data->paginate(10)->toArray();
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
        $datajson = json_decode($request->getContent(), true);
        $bodyResponse = null;
        $NoteModel = null;
        // foreach ($datajson['classe_id'] as $classe_id){
            // $arr = $request->except(['classe_id']);
            $arr = $request->all();
            $NoteModel = new NoteModel();
            while ( $data = current($arr)) {
                $NoteModel->{key($arr)} = $data;
                next($arr);
            }
            // $NoteModel->classe_id = join(",", $datajson['classe_id']);
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

        // $data['classe_id'] = join(',', $data['classe_id']);

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
