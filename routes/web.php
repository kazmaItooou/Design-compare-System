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
/*
Route::get('/', function () {
    return view('welcome');
});
*/
//アンケート
Route::redirect('/', '/事前アンケート');
Route::get('/事前アンケート', 'AqController@index');
Route::get('/事前アンケートスマホ', 'AqController@userAgentPhone');
Route::post('/アンケート処理中', 'AqController@aqProcessing');
Route::get('/事前アンケート終了', 'AqController@aqProcesed');

Route::get('/テスト', 'QuestionController@index');
Route::post('/テスト', 'QuestionController@AnsProsessing');

Route::post('/テストアンケート', 'layoutAqController@aqProcessing');
Route::get('/テストアンケート', 'layoutAqController@aqProcessed');


Route::post('/終了アンケート', 'endAqController@aqProcessing');
Route::get('/終了アンケート', 'endAqController@aqProcessed');

//レイアウトの見本
Route::get('/layoutBad', 'LayoutViewController@bad');
Route::get('/layoutBasic', 'LayoutViewController@basic');
Route::get('/layoutBasicReform1', 'LayoutViewController@basicReform1');
