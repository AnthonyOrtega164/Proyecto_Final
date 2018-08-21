<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
//            if ($request->input('api_token')) {
//                return User::where('api_token', $request->input('api_token'))->first();
//            }
            $user=null;
            $header=$request->header('Api-Token');
            if($header){
                $data= base64_decode($header);//external_id--usuario decodificar el token
                $arreglo= explode("--", $data);
                if(count($arreglo)==2){
                    $userAux= \App\Models\Administrador::where("external_id",$arreglo[0])
                            ->where("usuario",$arreglo[1])->first();
                    if($userAux){
                        $user=$userAux;
                    }
                }
            }
            return $user;
        });
    }
}
