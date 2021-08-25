<?php

use Doctrine\DBAL\Schema\Index;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    if(Auth::user()) {
        return redirect('app/home');
    } else {
        return view('auth.login');
    }
});

Auth::routes();

Route::get('/autorizar', function() {
    if(!Auth::user()->autorizado) {
        return view('autorizar');
    } else {
        return redirect('app/home');
    }
})->name('autorizar');

Route::prefix('app')->middleware('auth','autorizar')->group(function () {
    //Adicionar middleware de autorizar
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('chat');    
    Route::get('/configuracoes', [App\Http\Controllers\ConfiguracoesController::class, 'index'])->name('configuracoes');
    Route::get('/metas', [App\Http\Controllers\MetaController::class, 'index'])->name('metas');
    Route::post('/metas', [App\Http\Controllers\MetaController::class, 'meta_import'])->name('meta_import');
    Route::get('/reset-password', [App\Http\Controllers\Api\ForgotPass::class, 'index'])->name('reset_password');
});
