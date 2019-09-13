<?php

namespace BootnetCrasher\School\Controllers\Api;

use Cms\Classes\Controller;
use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\School\Models\NoteEleve;

class NoteEleveController extends Controller
{
    protected $NoteEleve;

    protected $helpers;

    public function __construct(NoteEleve $NoteEleve, Helpers $helpers)
    {
        parent::__construct();
        $this->NoteEleve = $NoteEleve;
        $this->helpers   = $helpers;
    }

    public function searchEleves(Request $request){
        $data = $this->NoteEleve;
        foreach($request->all() as $key => $value){
            $data = $data->where($key, $value);
        }
        $data = $data->get()->toArray();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }
}
