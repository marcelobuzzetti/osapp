<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\OsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\PecaController;
use App\Http\Controllers\BalancoController;
use App\Events\AtualizacaoOrdem;
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

/* Route::get('/', function () {
    return view('welcome');
}); */

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::group(['middleware' => ['web', 'auth', 'isadmin']], function() {

    Route::resource('usuarios', UserController::class);

});

Route::group(['middleware' => 'auth'], function() {

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('clientes', ClienteController::class);

Route::resource('marcas', MarcaController::class);

Route::resource('ordens', OsController::class);

Route::resource('pecas', PecaController::class);

Route::get('/pecas/showos', [PecaController::class, 'showPecasOs'])->name('pecas.showos');

Route::resource('empresas', EmpresaController::class)->except([
    'index','create', 'destroy', 'store'
]);

Route::get('/ordens/{id}/entrega', [OsController::class, 'entregaShow'])->name('ordens.orcamento');

Route::get('/ordens/{id}/recusou', [OsController::class, 'recusouShow'])->name('ordens.recusou');

Route::put('/entrega/{id}', [OsController::class, 'entrega'])->name('ordens.entrega');

Route::put('/recusou/{id}', [OsController::class, 'recusou'])->name('ordens.recusouOrcamento');

Route::get('autocompletecliente', [ClienteController::class, 'autocomplete'])->name('autocompletecliente');

Route::get('autocompletemarca', [MarcaController::class, 'autocomplete'])->name('autocompletemarca');

Route::post('buscarOs', [OsController::class, 'buscarOs'])->name('buscarOs');

Route::get('imprimirOs', [OsController::class, 'imprimirOs'])->name('imprimirOs');

Route::get('retornoEmGarantia', [OsController::class, 'retornoEmGarantia'])->name('retornoEmGarantia');

Route::get('arquivarOS', [OsController::class, 'arquivarOS'])->name('arquivarOS');

Route::get('desarquivarOS', [OsController::class, 'desarquivarOS'])->name('desarquivarOS');

Route::get('arquivadas', [OsController::class, 'arquivadas'])->name('arquivadas');

Route::post('relatorio', [BalancoController::class, 'relatorio'])->name('relatorio');

Route::resource('balanco', BalancoController::class)->except([
    'create', 'destroy', 'store', 'edit', 'show', 'update'
]);

});

Route::get('/orcamento/{id}', [OsController::class, 'orcamento'])->name('orcamento');

Route::put('/orcamento/{id}', [OsController::class, 'orcamentoStore'])->name('ordens.orcamentoStore');

/* Route::put('/status/{id}', [OsController::class, 'orcamentoStore'])->name('ordens.status'); */

/* Route::get('/ordemservico/{id}', [OsController::class, 'showTeste']);

Route::get('/ordemservico/{id}/edit', [OsController::class, 'editTeste']);

Route::delete('/ordemservico/{id}/delete', [OsController::class, 'destroyTeste']); */

/*Route::get('/event', function () {
    $array = ['name' => 'Ekpono Ambrose']; //data we want to pass
    event(new AtualizacaoOrdem($array));

    return 'done';
});*/

