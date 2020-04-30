<?php

use BootnetCrasher\School\Models\AbsenceEleveModel;

Route::get('api/v1/noteeleves', 'BootnetCrasher\School\Controllers\Api\NoteEleveController@searchEleves')->name('eleves.search');
/*Route::get('api/v1/professeursclasses', 'BootnetCrasher\School\Controllers\Api\ProfesseursClasses@searchProfesseursClasses')->name('professeursclasses.search');*/
Route::post('api/v1/users/login', ['as' => 'api/v1/users.login', 'uses' => 'BootnetCrasher\School\Controllers\Api\userController@login']);
Route::post('api/v1/users/login-backend', 'BootnetCrasher\School\Controllers\Api\userController@loginBackend');
Route::post('api/v1/users/update', ['as' => 'api/v1/users.update', 'uses' => 'BootnetCrasher\School\Controllers\Api\userController@updateUser']);
Route::get('api/v1/classes/{id}/get-all-eleves', 'AhmadFatoni\ApiGenerator\Controllers\API\classesController@getAllEleves');

// 

Route::get('api/v1/classes-by-professeur-id/{professeurId}', 'BootnetCrasher\School\Controllers\Api\ClasseMatiereProfesseurController@getClassesByProfesseurId');
Route::get('api/v1/notes-eleve/{eleve_id}', 'AhmadFatoni\ApiGenerator\Controllers\API\noteController@getNotesByEleveId');
Route::get('api/v1/get-notes', 'AhmadFatoni\ApiGenerator\Controllers\API\noteController@getNotes');
Route::get('api/v1/get-notes-v2', 'AhmadFatoni\ApiGenerator\Controllers\API\noteController@getNotesV2');
Route::get('api/v1/get-notes-v3', 'AhmadFatoni\ApiGenerator\Controllers\API\noteController@getNotesV3');
Route::get('api/v1/get-notes-v4', 'AhmadFatoni\ApiGenerator\Controllers\API\noteController@getNotesV4');
Route::get('api/v1/matieres-all', 'AhmadFatoni\ApiGenerator\Controllers\API\matiereController@all');
Route::get('api/v1/notemodel-valeur', 'AhmadFatoni\ApiGenerator\Controllers\API\noteController@indexValeur');
Route::get('api/v1/notemodel-valeur-v2', 'AhmadFatoni\ApiGenerator\Controllers\API\noteController@indexValeurV2');
Route::get('api/v1/matieres-v2', 'AhmadFatoni\ApiGenerator\Controllers\API\matiereController@indexV2');
Route::put('api/v1/noteseleves-valeur/{eleve_id}/{note_id}', 'AhmadFatoni\ApiGenerator\Controllers\API\noteselevesController@addValueNote');
Route::get('api/v1/search-matiere-by-classe-and-professeur', 'AhmadFatoni\ApiGenerator\Controllers\API\matiereController@searchMatiereByClasseAndProfesseur');
Route::get('api/v1/eleves-without-paginate', 'AhmadFatoni\ApiGenerator\Controllers\API\eleveController@indexWithoutPaginate');
Route::get('api/v1/search-moyennes-by-classe-and-professeur-and-section', 'AhmadFatoni\ApiGenerator\Controllers\API\moyenneController@searchMoyennesByClasseAndMatiereAndSectionTypeMoyenne');
Route::get('api/v1/eleves-customise', 'AhmadFatoni\ApiGenerator\Controllers\API\eleveController@indexCustomise');
Route::post('api/v1/elevesclasses/save-eleves', 'AhmadFatoni\ApiGenerator\Controllers\API\classeeleveController@saveElevesClasse');
Route::post('api/v1/abonnements/store-with-eleves', 'AhmadFatoni\ApiGenerator\Controllers\API\AbonnementController@storeWithEleve');
Route::put('api/v1/abonnements/update-with-eleves/{id}', 'AhmadFatoni\ApiGenerator\Controllers\API\AbonnementController@updateWithEleve');
Route::get('api/v1/abonnements/abonnements-eleves/{id}', 'AhmadFatoni\ApiGenerator\Controllers\API\AbonnementController@getElevesAbonnement');
Route::get('api/v1/moyennes/generate-moyennes-matieres-sections/{id}', 'AhmadFatoni\ApiGenerator\Controllers\API\moyenneController@generateMoyenneMatiereForSection');
Route::get('api/v1/moyennes/send-billan-periodique/{sectionAnneeScolaireId}', 'AhmadFatoni\ApiGenerator\Controllers\API\moyenneController@sendBillanPeriodique');
Route::put('api/v1/anneesscolaires/validate/{id}', 'AhmadFatoni\ApiGenerator\Controllers\API\anneeScolaireController@validate');
Route::put('api/v1/sectionsanneescolaire/validate/{id}', 'AhmadFatoni\ApiGenerator\Controllers\API\sectionAnneeScolaireController@validate');
Route::get('api/v1/eleves/get-eleveclasse/{eleve_id}/{annee_scolaire_id}', 'AhmadFatoni\ApiGenerator\Controllers\API\eleveController@getEleveClasseByEleveIdAndAnneeScolaireId');
Route::get('api/v1/anneesscolaires/get-by-school-id/{school_id}', 'AhmadFatoni\ApiGenerator\Controllers\API\anneeScolaireController@getAnneesScolairesBySchoolId');
Route::get('api/v1/anneescolaire/get-by-school-id/{annee_scolaire_id}/{school_id}', 'AhmadFatoni\ApiGenerator\Controllers\API\anneeScolaireController@getAnneeScolaireBySchoolId');
Route::get('api/v1/schools/show-customise/{id}', 'AhmadFatoni\ApiGenerator\Controllers\API\SchoolController@getCustomiseShow');
Route::put('api/v1/schools/customise-school/{id}', 'AhmadFatoni\ApiGenerator\Controllers\API\SchoolController@customiseUpdate');
Route::get('api/v1/permissionsroles/onload-permissions-by-role-id/{id}', 'AhmadFatoni\ApiGenerator\Controllers\API\PermissionRoleController@onloadPermissionsCodeByRoleId');


Route::get('test-code-source', function (){
    $absence = \BootnetCrasher\School\Models\AbsenceEleveModel::find(2);
    if($absence->validated_at){
        // $absence->validated_at = now();
        // $absence->save();
    }else{
        $absence->validated_at = now();
        $absence->save();
    }
    // dd("dgd");
    $absences = \BootnetCrasher\School\Models\AbsenceEleveModel::where('section_annee_scolaire_id', 1)->select('id')->get();
    $absences = $absences ? $absences->toArray() : null;
    // dd($absences);
    foreach($absences as $ab){
        dd($ab['id']);
    }
});

// elle permet d'envoyer un bilan des élèves aux parents d'élèves pour année scolaire
Route::get('api/v1/eleves/rapport/{section_annee_scolaire_id}', function($section_annee_scolaire){
    // \Queue::push(\Bootnetcrasher\School\Jobs\MoyenneJob::class, ["section_annee_scolaire_id" => $section_annee_scolaire]);
    $moyenne = new Bootnetcrasher\School\Classes\MoyenneClasse($section_annee_scolaire);
    $moyenne->sendRapport();
    return response()->json(["status_code" => 200, "message" => "success", "data" => "Data has been deleted successfully."]);
});


Route::get('/test-sms', function (){
    $sms = new \Bootnetcrasher\School\Classes\Sms();
    // $sms->sendWithoutLog("22662049271", "Test ayauka");
    // $sms->sendWithoutLog("22577024542", "Test ayauka");
    $sms->sendWithoutLog("22547886905", "Test ayauka");
    // $sms->sendWithoutLog("22541166425", "Test ayauka");
    // 
    die("Sms envoyé ");
});

Route::get('api/v1/test-sms-v1', function (\Illuminate\Http\Request $request){
    $sms = new \Bootnetcrasher\School\Classes\Sms();
    $sms->sendWithoutLog($request->get('tel'), $request->get('message'));
    trace_log("tel ".$request->get('tel'));
    trace_log("message ".$request->get('message'));
    // $sms->sendWithoutLog("22547886905", "Test ayauka");
    return response()->json(["status_code" => 200, "message" => "success", "data" => "Data has sent deleted successfully."]);
    // return $request->get('message');
});

Route::get('api/v1/generate-data-for-section-annee-scolaire/{section_id}', function($section_id){
    \Artisan::call('school:seeder', [
        "--section" => $section_id
    ]);
    return response()->json(["status_code" => 200, "message" => "success", "data" => "Data has sent deleted successfully."]);
});

/*Route::get('test-verify-abonnement', function(){
    $eleve = BootnetCrasher\School\Models\EleveModel::find(1);
    $response = Bootnetcrasher\School\Classes\Abonnement::hasAbonnement($eleve);
    die($response);
});*/

Route::get('api/v1/send-code-reset-password/{email}', function($email){

    $user = RainLab\User\Models\User::findByEmail($email);
    if(!$user){
        return response()->json(["status_code" => 400, "message" => "error", "data" => "Erreur code invalide !."]);
    }
    $code = implode('!', [$user->id, $user->getResetPasswordCode()]);
    $link = "http://localhost:8080/#/check-reset-password/".$code;
    $data = [
        'name' => $user->name,
        'link' => $link,
        'code' => $code
    ];
    \Mail::send('rainlab.user::mail.restore', $data, function($message) use ($user) {
        $message->to($user->email, $user->full_name);
    });
    return response()->json(["status_code" => 200, "message" => "success", "data" => "Un email a été envoyé !"]);
});

Route::get('api/v1/check-code-reset-password/{code}', function($code){
    $parts = explode('!', $code);
    if (count($parts) != 2) {
        return response()->json(["status_code" => 400, "message" => "error", "data" => "Erreur code invalide !."]);
    }

    list($userId, $code) = $parts;

    if (!strlen(trim($userId)) || !strlen(trim($code)) || !$code) {
        return response()->json(["status_code" => 400, "message" => "error", "data" => "Erreur code invalide !."]);
    }

    if (!$user = \Auth::findUserById($userId)) {
        return response()->json(["status_code" => 400, "message" => "error", "data" => "Erreur code invalide !."]);
    }

    return response()->json(["status_code" => 200, "message" => "success", "data" => ['user' => $user, 'code' => $code]]);
});

Route::post('api/v1/reset-password/{id}', function(\Illuminate\Http\Request $request, $id){
    $user = \Auth::findUserById($id);
    if (!$user) {
        return response()->json(["status_code" => 400, "message" => "error", "data" => "Erreur user does not exist !."], 400, ['error' => 'invalid key']);
    }
    $result = $user->attemptResetPassword($request->get('code'), $request->get('password'));
    // return response()->json(["status_code" => 200, "message" => "success", "data" => " L'utilisateur a été réinitialisé avec succès !."], 200, $user->toArray());
    if (!$result) {
        return response()->json(["status_code" => 400, "message" => "error", "data" => "Erreur when réinitialisation password !."]);
    }else{
        // return response()->json(["status_code" => 200, "message" => "success", "data" => $result->toArray()]);
        return response()->json(["status_code" => 200, "message" => "success", "data" => " L'utilisateur a été réinitialisé avec succès !."], 200, $user->toArray());
    }
});