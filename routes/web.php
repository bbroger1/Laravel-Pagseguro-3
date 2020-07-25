<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'InicioController')->name('inicio');

Route::get('cep/{cep}', 'CepController')->name('cep');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::prefix('pagamento')->name('pagamento.')->group(function () {
        Route::get('/boleto', 'PedidoController@exibirBoleto')->name('boleto');
        Route::get('/cartao', 'PedidoController@exibirCartao')->name('cartao');
        Route::post('/boleto/processamento', 'PedidoController@processarBoleto')->name('processamento.boleto');
        Route::post('/cartao/processamento', 'PedidoController@processarCartao')->name('processamento.cartao');
        Route::get('/falha', 'PedidoController@exibirFalha')->name('falha');
        Route::get('/sucesso/{pedido}', 'PedidoController@exibirSucesso')->name('sucesso');
    });
});