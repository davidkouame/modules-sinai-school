<?php

namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use BootnetCrasher\School\Models\ParentEleve;
use Illuminate\Support\Facades\Validator;
use RainLab\User\Facades\Auth;
use RainLab\User\Models\User;
use Event;

class userController extends Controller
{
    protected $User;

    protected $helpers;

    public function __construct(User $User, Helpers $helpers)
    {
        parent::__construct();
        $this->User    = $User;
        $this->helpers          = $helpers;
    }

    public function index()
    {

        $data = $this->User->all()->toArray();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
    }

    public function show($id)
    {

        $data = $this->User->where('id', $id)->first();

        if (count($data) > 0) {

            return $this->helpers->apiArrayResponseBuilder(200, 'success', $data);
        }

        $this->helpers->apiArrayResponseBuilder(400, 'bad request', ['error' => 'invalid key']);
    }

    public function store(Request $request)
    {

        $arr = $request->all();

        while ($data = current($arr)) {
            $this->User->{key($arr)} = $data;
            next($arr);
        }

        $validation = Validator::make($request->all(), $this->User->rules);

        if ($validation->passes()) {
            $this->User->save();
            return $this->helpers->apiArrayResponseBuilder(201, 'created', ['id' => $this->User->id]);
        } else {
            return $this->helpers->apiArrayResponseBuilder(400, 'fail', $validation->errors());
        }
    }

    public function update($id, Request $request)
    {

        $status = $this->User->where('id', $id)->update($data);

        if ($status) {

            return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been updated successfully.');
        } else {

            return $this->helpers->apiArrayResponseBuilder(400, 'bad request', 'Error, data failed to update.');
        }
    }

    public function delete($id)
    {

        $this->User->where('id', $id)->delete();

        return $this->helpers->apiArrayResponseBuilder(200, 'success', 'Data has been deleted successfully.');
    }

    public function destroy($id)
    {

        $this->User->where('id', $id)->delete();

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
                ->whereNotNull('parenteleve_id')
                ->first();

            if (!$user) {
                return $this->helpers->apiArrayResponseBuilder(403, 'success', "Désolé, l'email ou mot passe est incorrect .");
            }

            //recupération du compte parenteleve
            $parenteleve = ParentEleve::where('id', '=', $user->parenteleve_id)->first();
            if (!$parenteleve) {
                return $this->helpers->apiArrayResponseBuilder(403, 'success', "Désolé, l'email ou mot passe est incorrect .");
            }

            Event::fire('rainlab.user.beforeAuthenticate', [$this, $credentials]);
            $user = Auth::authenticate($credentials, true);
        } catch (\Exception $e) {
            trace_log("une erreur est survenue lors de l'authentification du compte cabinet, message=>" . $e->getMessage());
            return $this->helpers->apiArrayResponseBuilder(403, 'success', "Désolé, l'email ou mot passe est incorrect .");
        }
        return $this->helpers->apiArrayResponseBuilder(200, 'success', $user);
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
