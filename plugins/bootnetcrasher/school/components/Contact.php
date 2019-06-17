<?php

namespace Bootnetcrasher\School\Components;

use Cms\Classes\ComponentBase;
use BootnetCrasher\School\Models\ParametrageModel;
use BootnetCrasher\School\Models\EmailContactModel;

class Contact extends ComponentBase {

    public function componentDetails() {
        return [
            'name' => 'Contact',
            'description' => 'Implements a simple contact.'
        ];
    }

    public function defineProperties() {
        return [
        ];
    }

    public function onRun() {
        try {
            // recuperation des parametres de l'école
            $this->page["nom_ecole"] = ParametrageModel::where('key', 'name_ecole')->first();
            $this->page["adresse_postale_ecole"] = ParametrageModel::where('key', 'adresse_postale_ecole')->first();
            $this->page["tel_ecole"] = ParametrageModel::where('key', 'tel_ecole')->first();
            $this->page["email_ecole"] = ParametrageModel::where('key', 'email_ecole')->first();
            $this->page["email_front"] = ParametrageModel::where('key', 'email_front')->first();
            $this->page["prospectus"] = ParametrageModel::where('key', 'prospectus')->first();
            $this->page["map"] = ParametrageModel::where('key', 'map')->first();
            $this->page["active"] = "contact";
            // dd($this->page["map"]->value);
        } catch (Exception $ex) {
            trace_log("Une erreur est survenue lors de la recuperation des "
                    . "parametres, raison :" . $ex->getMessage());
        }
    }

    public function onSendmail() {
        try {
            $vars = [
                        "body" => post("message"), 
                        "telephone" => post("telephone"),
                        "email" => post("email"), 
                        "nomprenom" => post("nom_prenom")
                    ];
            $rules = [
                        "body" => "required", 
                        "telephone" => "required",
                        "email" => "required|email", 
                        "nomprenom" => "required"
            ];
            
            $message = [
                        "body.required" => "le champ message est obligatoire"
            ];
            
            $validation = \Validator::make($vars, $rules, $message);
            if ($validation->fails()) {
                throw new \ValidationException($validation);
            }
            $email = ParametrageModel::where('key', 'email_front')->first()->value;
            \Mail::send('contact::mail.send', $vars, function($message) use($email) {
                $message->to($email, 'Information');
                $message->subject("Demande dinformation");
            });
            \Flash::success("Votre mail a été envoyé avec succès !");
            $emailContactModel = new EmailContactModel();
            $emailContactModel->email = post("email");
            $emailContactModel->nomprenom = post("nom_prenom");
            $emailContactModel->body = post("message");
            $emailContactModel->save();
            return \Redirect::refresh();
        } catch (Exception $ex) {
            trace_log("Une erreur est survenue lors de l'envoi de mail, "
                    . "raison :" . $ex->getMessage());
        }
    }

}
