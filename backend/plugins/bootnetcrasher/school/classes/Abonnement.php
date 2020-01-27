<?php


namespace Bootnetcrasher\School\Classes;

use BootnetCrasher\School\Models\EleveModel;
use BootnetCrasher\School\Models\AnneeScolaireModel;
use BootnetCrasher\School\Models\AbonnementEleveModel;
use BootnetCrasher\School\Models\ParentModel;

/**
 * Class to trait abonnement
 */
class Abonnement
{
    /**
     * Check if student has abonnement this year
     * @param EleveModel $eleve
     * @return Bool true if student has abonnement in year run 
     */
    public static function hasAbonnement(EleveModel $eleve){
        // recover run year
        $anneescolaire = self::getAnneeScolaireEnCours();
        $abonnement = AbonnementEleveModel::where('eleve_id', $eleve->id)
        ->whereHas('abonnement', function ($query) use ($anneescolaire) {
            $query->where('annee_scolaire_id', $anneescolaire->id);
        })->first();
        return $abonnement ? true : false;
    }

    /**
     * Get parent to connect abonnement
     * @param EleveModel $eleve
     * @return ParentModel $parent 
     */
    public static function getParentToAbonnement(EleveModel $eleve){
        // recover run year
        $anneescolaire = self::getAnneeScolaireEnCours();
        $abonnementeleve = AbonnementEleveModel::where('eleve_id', $eleve->id)
        ->whereHas('abonnement', function ($query) use ($anneescolaire) {
            $query->where('annee_scolaire_id', $anneescolaire->id);
        })->first();
        return $abonnementeleve && $abonnementeleve->abonnement ? $abonnementeleve->abonnement->parent : null;
    }

    // Get year in run
    public static function getAnneeScolaireEnCours(){
        return AnneeScolaireModel::find(1);
    }

}