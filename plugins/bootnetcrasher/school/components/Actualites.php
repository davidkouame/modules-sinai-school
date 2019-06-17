<?php

namespace Bootnetcrasher\School\Components;

use Cms\Classes\ComponentBase;
use ApplicationException;
use BootnetCrasher\School\Models\ActualiteModel;
use Indikator\News\Models\Subscribers;
use Lang;
use App;
use Validator;
use ValidationException;
use Request;
use Indikator\News\Classes\SubscriberService;

class Actualites extends ComponentBase {
    
    use SubscriberService;

    public function componentDetails() {
        return [
            'name' => 'Actualites',
            'description' => 'Implements a simple actualites.'
        ];
    }

    public function defineProperties() {
        return [
        ];
    }

    public function onRun() {
        // recuperation de toutes les actualites
        $actualites = ActualiteModel::whereNotNull('published_at')->paginate(4);
        $this->page["actualites"] = $actualites;
        $this->page["active"] = 'accueil';
    }

    public function onSuscriber() {
        try {
            // Get data from form
            $data = post();

            // Validate input data
            $rules = [
                'email' => 'required|email|between:8,64'
            ];

            $validation = Validator::make($data, $rules);
            if ($validation->fails()) {
                throw new ValidationException($validation);
            }

            $email = post('email');
            $categories = [1];

            // looking for existing subscriber
            $subscriberResult = Subscribers::email($email);
            // var_dump($subscriberResult->count());

            if ($subscriberResult->count() == 0) {
                $subscriber = Subscribers::create([
                            'email' => $email,
                            'common' => '',
                            'locale' => App::getLocale(),
                            'created' => 2,
                            'statistics' => 0,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                            'registered_at' => now(),
                            'registered_ip' => Request::ip(),
                            'status' => 3
                ]);
                
                $this->onSubscriberRegister($subscriber, $categories);
            }
            // dd("dd");
            // var_dump(Request::url());
            // return \Redirect::to(Request::url());
            return \Redirect::refresh();
        } catch (Exception $ex) {
            trace_log("Une erreur est survenue lors de l'enregistrement d'un "
                    . "email pour l'envoi de newstletters, raison :" . $ex->getMessage());
        }
    }

}
