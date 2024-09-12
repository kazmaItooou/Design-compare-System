<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AqController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


//アンケート
Route::redirect('/', '/事前アンケート');
Route::get('/事前アンケート', [AqController::class, 'index']);
Route::get('/事前アンケートスマホ', [AqController::class, 'userAgentPhone']);
Route::post('/アンケート処理中', [AqController::class, 'aqProcessing']);
Route::get('/事前アンケート終了', [AqController::class, 'aqProcesed']);

Route::get('/テスト', [QuestionController::class, 'index']);
Route::post('/テスト', [QuestionController::class, 'AnsProsessing']);

Route::post('/テストアンケート', [layoutAqController::class, 'aqProcessing']);
Route::get('/テストアンケート', [layoutAqController::class, 'aqProcessed']);


Route::post('/終了アンケート', [endAqController::class, 'aqProcessing']);
Route::get('/終了アンケート', [endAqController::class, 'aqProcessed']);

//レイアウトの見本
Route::get('/layoutBad', [LayoutViewController::class, 'bad']);
Route::get('/layoutBasic', [LayoutViewController::class, 'basic']);
Route::get('/layoutBasicReform1', [LayoutViewController::class, 'basicReform1']);
