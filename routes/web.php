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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('activations', 'ActivationController')->middleware('auth');
Route::resource('offers','OfferController')->middleware('auth');
Route::resource('rates','RateController')->middleware('auth');
Route::resource('schedules','ScheduleController')->middleware('auth');
Route::resource('clients','ClientController')->middleware('auth');
Route::resource('facturacion', 'InvoiceController')->middleware('auth');
Route::resource('assignment', 'AssignmentController')->middleware('auth');
Route::resource('dealer', 'DealerController')->middleware('auth');
Route::resource('promotion', 'PromotionController')->middleware('auth');
Route::resource('notification', 'NotificationController')->middleware('auth');
Route::resource('portabilities', 'PortabilityController')->middleware('auth');
Route::resource('shipping','ShippingController')->middleware('auth');
Route::resource('directory','DirectoryController')->middleware('auth');
Route::resource('petition','PetitionController')->middleware('auth');
Route::resource('anothercompany','AnothercompanyController')->middleware('auth');
Route::resource('numberscompany','NumberscompanyController')->middleware('auth');
Route::resource('consumption','ConsumptionController')->middleware('auth');

Route::get('/show-shipping-async/{shipping}','ShippingController@showAsync')->name('showShipping.async')->middleware('auth');

// Petitions
// Route::post('/petition');

//Devices
Route::resource('devices', 'DeviceController')->middleware('auth');

// OpenPay Routes
Route::post('/charge', 'OpenPayController@store');
Route::post('/create-reference-openpay','ReferenceController@createReference')->name('create-reference.post');
Route::post('/create-reference-api','ReferenceController@createReference');
Route::post('/webhook-openpay','WebhookController@notificationOpenPay');
Route::get('/incomes','PaymentController@incomesQuery')->name('incomes.get')->middleware('auth');
Route::get('/webhook-pendings','PaymentController@paymentsPendings')->name('webhook-payments-pending.get')->middleware('auth');
Route::get('/webhook-overdue','PaymentController@paymentsOverdue')->name('webhook-payments-overdue.get')->middleware('auth');

// Activations Routes
Route::get('/activationsGeneral', 'ActivationController@activationGeneral')->name('activation-general.post');
Route::post('/activationsGeneralApi', 'ActivationController@activationGeneral');
Route::get('/activationsEthernet', 'ActivationController@activationEthernet')->name('activation-ethernet.post');
Route::get('/preactivations', 'ActivationController@preactivationsIndex')->name('preactivations.index')->middleware('auth');
Route::delete('/rollback-preactivate/{activation}','ActivationController@rollbackPreactivate')->name('rollbackPreactivate')->middleware('auth');
Route::delete('/rollback-preactivate-api/{activation}','ActivationController@rollbackPreactivate');
Route::post('/execute-activation/{petition}','ActivationController@executeActivation')->name('executeActivation')->middleware('auth');
Route::get('/create-delivery-format/{activation}','ActivationController@createDeliveryFormat')->name('formatDelivery')->middleware('auth');

// Stripe Routes
Route::post('/handle','WebhookController@handle');
Route::post('/notificationWHkStripe','WebhookController@notificationWHkStripe');

// Administrator Routes
Route::get('/users', 'UserController@showUsers')->name('show-users.get')->middleware('auth');
Route::post('/users', 'UserController@addUser')->name('add-user.post')->middleware('auth');
Route::get('/get-user', 'UserController@getUser')->name('get-user.get')->middleware('auth');
Route::post('/update-user', 'UserController@updateUser')->name('update-user.post')->middleware('auth');
Route::post('/change-rol-user', 'UserController@changeRolUser')->name('change-rol.post');
Route::get('/promoters', 'AssignmentController@index')->name('promoters.get');
Route::get('/assignment/show-promoter/{promoter}','AssignmentController@showAssignments')->name('showAssignments')->middleware('auth');
Route::get('/promotores-list', 'AdminController@promotores_view')->name('promotores-view.get')->middleware('auth');
Route::get('/supervisor-reports-veracruz', 'AdminController@reportsVeracruz')->name('reportsVeracruz');
Route::get('/modal-report-distribuidores', 'AdminController@modalReportVeracruz')->name('modalReportVeracruz');

// Client Routes
Route::get('/rechargeGenerate', 'ClientController@rechargeGenerateClient')->name('recharge-view-client.get')->middleware('auth');
Route::get('/clients-pay-all', 'ClientController@clientsPayAll')->name('clients-pay-all.get')->middleware('auth');
Route::get('/pre-registro', 'ClientController@preRegistro')->name('pre-registro');
Route::get('/clients-details/{id}', 'ClientController@clientDetails')->middleware('auth');;
Route::post('/buying', 'CheckoutController@buying');
Route::get('/search/clients', 'ClientController@searchClients')->name('search-clients.get');
Route::get('/search/client-product', 'ClientController@searchClientProduct')->name('search-client-product.get');
Route::get('/generateReference/{id}/{type}/{user_id}','ClientController@generateReference')->middleware('auth');
Route::get('/show-reference','ClientController@showReferenceClient');
Route::get('/show-product-details/{id_dn}/{id_act}/{service}','ClientController@productDetails')->name('showProductDetails');
Route::get('/add-client-async','ClientController@storeAsync')->name('addClientAsync.get');
Route::get('/get-number-instalation','ClientController@getNumberInstalation')->name('getNumberInstalation.get');
Route::get('/set-number-instalation','ClientController@setNumberInstalation')->name('setNumberInstalation.get');
Route::get('/prospects','ClientController@prospects')->name('prospects.index')->middleware('auth');
//Route::post('/update-port-icc','PortabilityController@getAllDataPortPendiente')->name('getAllDataPortPendiente')->middleware('auth');
Route::post('/get-all-data-client','ClientController@getAllDataClient')->name('getAllDataClient.post')->middleware('auth');
Route::post('/set-all-data-client','ClientController@setAllDataClient')->name('setAllDataClient.post')->middleware('auth');
Route::get('/special-operations','ClientController@specialOperations')->name('operations.specials')->middleware('auth');
Route::get('/get-data-client-change-product','ClientController@getDataClientChangeProduct')->name('getDataClientChangeProduct.get');
Route::get('/get-data-client-by-sim','ClientController@getDataClientBySIM')->name('getDataClientBySIM.get');
Route::get('/clients-report','ClientController@reportsFilter')->name('clients-reports-filter.get')->middleware('auth');
Route::get('/reports-plans', 'ClientController@repostsPlans')->name('repostsPlans');
Route::post('/send-preregistro','AltanController@sendPreRegistro')->name('sendPreRegistro');

// Offers Routes
Route::get('/get-offer','OfferController@findOffer')->name('get-offer.get')->middleware('auth');
Route::get('/getAllOffers','OfferController@getAllOffer')->name('getAllOffers.get');
Route::get('/getAllOffersByType','OfferController@getAllOfferByType')->name('getAllOffersByType.get');


// Rates Numbers(DN's)
Route::post('/getDn', 'NumberController@getNumber')->name('search-dn.post');
Route::post('/activate-deactivate/DN', 'AltanController@activateDeactivateDN')->name('activate-deactivate.post');
Route::get('/activate-deactivate/DN-finance', 'AltanController@activateDeactivateDN');
Route::post('/activate-deactivate/DN-api', 'AltanController@activateDeactivateDN');
Route::get('/consultUF','AltanController@consultUF')->name('consultUF.get');
Route::post('/predeactivate-reactivate','AltanController@predeactivateReactivate')->name('predeactivate.reactivate');
Route::get('/get-offers-rates-diff','RateController@getOffersRatesDiff')->name('getOffersRatesDiff.get');
Route::get('/get-offers-rates-diff-api','RateController@getOffersRatesDiffAPI')->name('getOffersRatesDiffAPI.get');
Route::get('/get-offers-rates-diff-api-public','RateController@getOffersRatesDiffAPIPublic')->name('getOffersRatesDiffAPIPublic.get');
Route::get('/get-offers-rates-surplus','RateController@getOffersRatesSurplus')->name('getOffersSurplus.get');
Route::post('/get-offers-rates-surplus-bulks','RateController@getOffersRatesSurplusBulk')->name('getOffersSurplusBulk.get');
Route::post('/change-product','AltanController@changeProduct')->name('changeProduct.post');
Route::get('/purchase','AltanController@productPurchase')->name('purchase');
Route::post('/purchase-api','AltanController@productPurchase')->name('purchase-api');
Route::post('/locked', 'AltanController@locked')->name('locked');
Route::get('/status', 'AltanController@statusImei')->name('status');
Route::get('/consultUFSpecial/{msisdn}','ClientController@getInfoUF')->name('consultUFSpecial.get')->middleware('auth');
Route::post('/bondingSIM','AltanController@bondingSIM')->name('bonding')->middleware('auth');
// Route::get('/get-rates-')

// Rates Routes
Route::post('/get-rates', 'RateController@getRates')->name('get-rates.post');
Route::post('/get-rates-alta', 'RateController@getRatesAlta')->name('get-rates-alta.post');
Route::post('/get-rates-alta-api', 'RateController@getRatesAltaApi');
Route::post('/get-politics-rates','RateController@getPoliticsRates')->name('get-politics-rates.post');

// Ethernet Admin
Route::get('/ethernetAdmin','AdminController@index')->name('ethernet-admin.get')->middleware('auth');

// Packs Routes
Route::post('/create-pack','AdminController@createPack');
Route::post('/create-radiobase','AdminController@createRadiobase');
Route::get('/get-pack-ethernet','AdminController@getPackEthernet')->name('get-pack-ethernet.get');
Route::post('/update-pack-ethernet/{pack_id}','AdminController@updatePackEthernet')->name('update-pack-ethernet.get');

// Politics Routes
Route::get('/create-politic','AdminController@createPoliticRate')->name('politicRate.create')->middleware('auth');
Route::post('/create-politic','AdminController@insertPoliticRate')->name('politicRate.create');
Route::get('/politics/delete/{politic_id}','AdminController@destroy')->name('politic.delete');
Route::get('/politics/edit/{politic_id}','AdminController@getPolitic')->name('politic.edit');
Route::put('/politics/update/{politic}','AdminController@updatePolitic')->name('politic.update');

// Pays Routes
Route::get('/save-manual-pay','WebhookController@saveManualPay')->name('save-manual-pay.get');
Route::get('/get-data-payment','ActivationController@getDataPayment')->name('getDataPayment.get');
Route::get('/get-data-monthly','ActivationController@getDataMonthly')->name('getDataMonthly.get');
Route::get('/set-data-monthly','ActivationController@setDataMonthly')->name('setDataMonthly.get');

Route::post('/notifications-webhook', 'WebhookController@notificationWHk');
Route::post('/conekta-webhook', 'WebhookController@notificationWHkConekta');
Route::get('/date-pay', 'ActivationController@datePay')->name('date-pay');
Route::get('/my-profile','UserController@myProfile')->name('myProfile');
Route::get('/update-my-profile','UserController@updateMyProfile')->name('update-my-profile');
Route::get('/change-status-packsNrates','AdminController@changeStatusPacksRates')->name('change-status.rates-packs');
Route::post('/overdue-payments','AdminController@checkOverduePayments');
Route::get('/set-payment-status','ActivationController@setPaymentStatus')->name('setPaymentStatus.get');
Route::get('/update-price-device', 'DeviceController@updatePriceDevice')->name('updatePriceDevice.get');

// Card Payments
Route::post('/card-payment','OpenPayController@cardPayment')->name('cardPayment');
Route::post('/send-card-payment','OpenPayController@cardPaymentSend');

// Done by Charles
Route::get('/get-imei','DeviceController@getImei')->name('getImei.get');
Route::post('/create-payments','PaymentController@createPaymentsSwitchCase');
Route::post('/create-payments-ethernet','PaymentController@createPaymentsEthernet');
Route::post('/check-payments-overdue','PaymentController@checkOverduePaymentsSwitchCase');
Route::post('/create-payments-sandbox','PaymentController@createPaymentsSandbox');

    // Exports
Route::get('/new-clients-export-excel','ClientController@exportNewClients')->name('newClients.excel');
Route::get('/rates-actives-export-excel','RateController@exportRatesActives')->name('rates.excel');
Route::get('/consumos-export-excel','ClientController@exportConsumos')->name('consumos.excel');
Route::get('/consumos-general-export-excel','ClientController@exportConsumosGeneral')->name('consumosGeneral.excel');

//Invoice
Route::resource('invoice', 'InvoiceController@invoice');
Route::get('/invoice/{facturacion}', 'InvoiceController@destroy');
Route::get('/details/{facturacion}','InvoiceController@invoice');
Route::get('invoices', 'InvoiceController@invoices');
Route::post('/invoice-join', 'InvoiceController@invoiceJoin')->name('invoiceJoin.post');

//change
Route::get('change', 'AltanController@changeLink')->name('changeLink');
Route::patch('/updateCoordinate', 'AltanController@updateCoordinate')->name('updateCoordinate');

//serviciabilidad
Route::get('serviciabilidad','AltanController@serviciabilidad')->name('serv');

        
// Assignments
// Route::post('/assignment','');

Route::get('change-product', 'PaymentController@changeProductPayment')->name('changeProduct');
Route::get('excedentes', 'PaymentController@excedentes')->name('excedentes');

//admin
Route::get('generalConcesiones','AdminController@indexConcesiones')->name('indexConcesiones');
Route::get('/cortes/{id}', 'AdminController@consulta')->name('cortes.get');
Route::post('consultaCortes', 'AdminController@consultaCortes')->name('consulta.post');
Route::post('updateStatusCortes', 'AdminController@statusCortes')->name('status.update');
Route::post('payAll','AdminController@payAll')->name('payAll');

// Petitions
Route::get('solicitudes', 'PetitionController@index')->name('solicitudes')->middleware('auth');
Route::get('completadas','PetitionController@show')->name('completadas')->middleware('auth');
Route::get('completadasFinanzas','PetitionController@recibidosFinance')->name('recibidos')->middleware('auth');
Route::get('completadas','PetitionController@show')->name('completadas')->middleware('auth');
Route::get('activationOperaciones', 'PetitionController@activationOperaciones')->name('activation.get');
Route::post('collect-money', 'PetitionController@collectMoney')->name('collectMoney');
Route::post('save-collected', 'PetitionController@saveCollected')->name('saveCollected');
Route::get('/get-activation-by-petition/{petition}', 'PetitionController@getActivation')->name('getActivation');
Route::get('/activate-dealer-petition/{petition}','PetitionController@activateDealerPetition')->middleware('auth');
Route::post('/change-rate-petition','PetitionController@changeRatePetition')->name('changeRatePetition')->middleware('auth');

Route::get('/petitions-notifications', 'PetitionController@petitiosNotification');
//Petitions Línea Nueva CRM
Route::get('petitionCrm', 'PetitionController@lineNewCRM')->name('petitionCrm')->middleware('auth');
Route::get('changePetition', 'PetitionController@changeStatusLine')->name('changePetition');
//reemplazo Sim
Route::get('replacementSim', 'AltanController@replacementSim')->name('replacementSim');
Route::get('consultaVinculacion', 'AltanController@consultaVinculacion')->name('consultaVinculacion');
Route::get('/income','AdminController@income')->name('income');
Route::get('/incomes-export','AdminController@incomesExport');
Route::get('/validate-imei','AltanController@validateIMEI')->name('validateIMEI');
Route::get('/reports', 'ClientController@reports')->name('reports');
Route::get('/consumos', 'ClientController@consumos')->name('consumos');
Route::get('/reports-consumo-veracruz', 'ClientController@reportsConsumoVeracruz')->name('reportsConsumoVeracruz');
Route::get('/get-consumo-veracruz', 'ClientController@getConsumoVeracruz')->name('getConsumoVeracruz');

//reports Activations
Route::get('/reports-activations', 'ClientController@reportsActivations')->name('reportscAtivations');
Route::get('/bulk-activations','ActivationController@bulkActivations')->name('bulkActivations')->middleware('auth');
Route::post('/extract-csv','ActivationController@extractCSV')->name('extractCSV');
Route::post('/consume-csv','ActivationController@consumeCSV')->name('consumeCSV');
Route::get('/find-client-son','ClientController@findClientSon')->name('findClientSon');
//rerports money
Route::get('/reports-money', 'ClientController@reportMoney')->name('reportMoney');
Route::get('/reports-payments', 'ClientController@exportReportMoney')->name('payments');
Route::get('consultMoney', 'ClientController@consultMoney')->name('consultMoney');


Route::get('/search-moral-person','ClientController@searchMoralPerson')->name('searchMoralPerson');
Route::post('/webhook-altan-redes','NotificationController@getData');

Route::get('/create-csv','ActivationController@createCSV');

Route::get('/companies','CompanyController@index')->name('companies')->middleware('auth');
Route::post('/companies-store','CompanyController@store')->name('companies.store');
Route::post('/charge-csv-inventory','CompanyController@chargeInventory')->name('chargeCSVInventory');
Route::post('/store-dealer','CompanyController@storeDealer')->name('store.dealer');

Route::get('/dele-activation','ActivationController@deleteActivation')->name('deleteActivation');

Route::get('/notification-solution','NotificationController@notificationSolution')->name('notification.solution');
Route::get('/change-owner','ClientController@changeOwner')->name('changeOwner');
Route::get('/get-inventory-company','CompanyController@getInventoryCompanies')->name('getInventoryCompanies');

Route::get('/unbarring','ClientController@unbarring')->name('unbarring.get')->middleware('auth');

// Portability
Route::get('/portability-status','PortabilityController@PortabilityStatus')->name('PortabilityStatus');
Route::get('/status-filter','PortabilityController@getPortabilityStatus')->name('getPortabilityStatus');
Route::post('/do-activation','PortabilityController@doActivationPort')->name('doActivationPort')->middleware('auth');
Route::post('/import-all-ports','PortabilityController@importAllPorts')->name('importAllPorts')->middleware('auth');
Route::post('/update-port-icc','PortabilityController@getAllDataPortPendiente')->name('getAllDataPortPendiente')->middleware('auth');
Route::post('/update-data-port-pendientes','PortabilityController@getAllDataPortaPendiente')->name('getAllDataPortaPendiente')->middleware('auth');
Route::post('/update-data-port','PortabilityController@getAllDataPorta')->name('getAllDataPorta')->middleware('auth');
Route::post('/set-update-data-port','PortabilityController@setAllDataPorta')->name('setAllDataPorta')->middleware('auth');
Route::post('/destroy-port','PortabilityController@destroyPort')->name('destroyPort')->middleware('auth');
Route::post('/update-data','PortabilityController@updateABD')->name('updateABD');

// NumbersCompany
Route::post('/number-company', 'NumberscompanyController@allDataLinea')->name('allDataLinea')->middleware('auth');
Route::get('/add-number-company','NumberscompanyController@numberCompany')->name('addNumbersCompany');
Route::get('/all-company-id','NumberscompanyController@idCompany')->name('allCompanyId');
Route::post('/csv-Number','NumberscompanyController@csvNumber')->name('csvNumberComapy');
Route::post('/recharge-bulk','NumberscompanyController@rechargeBulk')->name('rechargeBulk');

//CSV ALTAN
Route::post('/csvAltan','PortabilityController@csvAltan')->name('csvAltan');
Route::post('/store-client-from-another-company','AnothercompanyController@storeClientFromAnotherCompany')->name('clients.storeFromAnotherCompany')->middleware('auth');
Route::post('/decline-prospect','AnothercompanyController@declineProspect')->name('declineProspect')->middleware('auth');
Route::post('/charge-csv-nir','DeviceController@chargeCSVNIR')->name('chargeCSVNIR');
Route::post('/set-update-data-port-pendientes','PortabilityController@setAllDataPortaPendiente')->name('setAllDataPortaPendiente')->middleware('auth');

// CRM
Route::get('/portabilities-crm','PortabilityController@portabilitiesCRM')->name('portaCRM');
Route::get('/changeStatusPortability','PortabilityController@changeStatusPortability')->name('changeStatusCRM');

Route::get('/lines-administration','AdminController@linesAdministration')->name('administrationLines.get')->middleware('auth');
Route::get('linePorta', 'ClientController@reportLinePorta')->name('linePorta');

// ROUTES APP MOBILE DEALERS
Route::post('/dealer-store','DealerController@dealerStoreTwo')->name('dealer.storeTwo')->middleware('auth');
Route::get('/consumos-roots','ConsumptionController@index');


Route::get('/numPortado', 'PortabilityController@portado')->name('numPortado');
Route::get('/rechargeDealer', 'PortabilityController@rechargeDealer')->name('rechargeDealer');
Route::get('/recharge-veracruz', 'ClientController@rechargeVeracruz')->name('recharge-veracruz');