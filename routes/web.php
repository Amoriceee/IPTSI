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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

  Route::get('/stock', 'HomeController@stockIndex');
  Route::get('/stock/pdf', 'HomeController@stockPDF');

  //INVOICES
  Route::get('/invoices', 'InvoiceController@index')->name('invoice.main');
  Route::post('/invoices', 'InvoiceController@index');
  Route::get('/invoices/create', 'InvoiceController@indindex');
  Route::post('/invoices/create', 'InvoiceController@savePost');
  Route::post('/invoices/create/fetch', 'PipeController@fetch')->name('invoice.fetch');
  Route::get('/invoices/{id}', 'InvoiceController@indindexload')->name('invoice.id');
  Route::post('/invoices/{id}', 'InvoiceController@invoiceSort');
  Route::get('/invoices/togauth/{id}', 'InvoiceController@togauth');
  //Route::get('/invoices/pdf/{id}', 'InvoiceController@pdfLoad');
  Route::get('/invoices/del/{id}', 'InvoiceController@destroyInvoicePipes');
  Route::get('/invoices/destroy/{id}', 'InvoiceController@destroyAll');

  Route::get('/invoices/pdf/{id}', [ 'as' => 'customer.printpdf', 'uses' => 'InvoiceController@printPDF']);

  //PRODUCTION
  Route::get('/production', 'PipeController@index')->name('production');
  Route::post('/production', 'PipeController@sort');
  Route::get('/production/del/{id}', 'PipeController@delProduction');
  Route::post('/production/fetch', 'PipeController@fetch')->name('production.fetch');

  //GATEPASS
  Route::get('/gatepass', 'GatepassController@index');
  Route::get('/gatepass/{id}', 'GatepassController@indexload');
  Route::get('/gatepass/togComplete/{id}', 'GatepassController@togComplete');
  Route::get('/gatepass/del/{id}', 'GatepassController@delGp');
  Route::post('/gatepass/{id}', ['as'=>'send.sms','uses'=>'GatepassController@sendSMS']);

  //LEDGER
  Route::get('/ledgers', 'LedgersController@index');
  Route::post('/ledgers', 'LedgersController@ledgerLoad');
  Route::post('/ledgers/new', 'LedgersController@addLedger');

  Route::get('/reports', function () {
      return view('reports');
  });

  Route::get('/pdf-inv', function () {
      return view('pdf.invoices');
  });

  Route::get('/home', 'HomeController@index')->name('home');

});
