<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MeuControlador extends Controller
{
    public function produtos(){
        return \view('produtos');
    }

    public function multiplicar($n1, $n2){
        return $n1 * $n2;
    }
}
