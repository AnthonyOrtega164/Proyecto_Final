<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

/**
 * Description of TestController
 *
 * @author antho
 */
class TestController extends Controller{
    public function index($msg) {
        echo $msg;
        $data=\App\Models\Persona::all();
        return response()->json($data,200);
    }
}
