<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Http\Request;



Route::get('/', function () {
    return view('welcome');
});


Route::get('produtos','MeuControlador@produtos');
Route::get('multiplicar/{n1}/{n2}','MeuControlador@multiplicar');


Route::get(
    'mal/genres', array( 'middleware' => 'cors' ,'uses' => 'JikanMal@genres')
);

Route::get(
    'mal/anime/{id}', array( 'middleware' => 'cors' ,'uses' => 'JikanMal@anime')
);

Route::get(
    'mal/suggestions/{page?}', array( 'middleware' => 'cors' ,'uses' => 'JikanMal@suggestions')
);

Route::get('mal/season/{year}/{season}/{later?}',array(
    'middleware' => 'cors' ,'uses' => 'JikanMal@season')
);

Route::get(
    'mal/genres/{genreid}/{page?}', array( 'middleware' => 'cors' ,'uses' => 'JikanMal@genre')
);

Route::get(
    'mal/review/{id}/{page}', array( 'middleware' => 'cors' ,'uses' => 'JikanMal@reviews')
);



Route::get('mal/{year}/{season}',array(
    'middleware' => 'cors' ,'uses' => 'JikanMal@index')
);




Route::resource('clientes', 'ClienteControlador');



// Route::get('/teste', function(){
//     return "teste";
// });

// Route::get('/seunome/{nome}', function($nome){
//     return "ola $nome";
// });

// Route::get('/seunome/{nome?}', function($nome = null){
//     if(isset($nome))
//         return "ola, $nome";
//     else
//         return "voce nao digitou seu nome!";
// });

// Route::get('/rotacomregras/{nome}/{n}', function ($nome, $n) {
//     for($i = 0; $i < $n ; $i++){
//         echo "ola! Seja bem vindo, $nome! <br>";
//     }
// })->where('nome', '[A-Za-z]+')->where('n', '[0-9]+');

// #agrupamento de rotas

// Route::prefix('/app')->group(function(){
//     Route::get('/', function(){
//         return  view('app');
//     })->name('app');

//     Route::get('/profile', function(){
//         return view('profile');
//     })->name('app.profile');

// });

// Route::get('/produtos', function(){
//     return view('produtos');
// })->name('meusprodutos');

// Route::redirect('todosprodutos1', 'produtos', 301);

// #redirecionamento apartir de controladores
// Route::get('todosprodutos2', function(){
//     return redirect()->route('meusprodutos');
// });

// Route::post('/requisicoes', function(Request $request){
//     return "Hello Post";
// });