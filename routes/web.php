<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;

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



Route::get('/backup', function () {
    $exitCode = Artisan::call('backup:run --only-db');
    echo 'DONE'; //Return anything
});

Route::get('/createlink', function () {
    Artisan::call('storage:link');
    echo 'created';
});

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('config:clear');
    echo 'DONE'; //Return anything
});


//---------------------------Country State City FIlter-----------------------//
Route::get('/', 'AdminAuth\LoginController@showLoginForm')->name('login');
Route::get('/login-as-admin', 'AdminAuth\LoginController@loginAsAdmin')->name('loginAs.admin');
Route::get('/login-as-staff', 'AdminAuth\LoginController@loginAsStaff')->name('loginAs.staff');

Route::get('f/country', 'Admin\SerchController@getCountry')->name('get.country');
Route::get('f/state', 'Admin\SerchController@getState')->name('get.state');
Route::get('f/city', 'Admin\SerchController@getCity')->name('get.city');

Route::post('common_check_exist', 'Controller@common_check_exist')->name('common_check_exist');


Route::post('getCaseSubType', 'Controller@getCaseSubType');
Route::post('getCourt', 'Controller@getCourt');
Route::post('getTaxById', 'Controller@getTaxById');

Route::post('common_change_state', 'Controller@common_change_state')->name('common_change_state');
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {

    //Dashboard

    Route::resource('/dashboard', 'DashBordController');
    Route::post('/dashboard', 'DashBordController@index');
    Route::get('/ajaxCalander', 'DashBordController@ajaxCalander');
    Route::post('dashboard-all-caseList', 'DashBordController@dashboardAllCaseList');
    Route::post('dashboard-appointment-list', 'DashBordController@appointmentList')->name('dashboard-appointment-list');
    Route::get('downloadCaseBoard/{date}', 'DashBordController@downloadCaseBoard');
    Route::get('printCaseBoard/{date}', 'DashBordController@printCaseBoard');

    //---------------------------Client-----------------------//
    Route::resource('clients', 'ClientController');
    Route::post('clients/data-list', 'ClientController@ClientList')->name('clients.list');
    Route::post('clients/data-status', 'ClientController@changeStatus')->name('clients.status');
    Route::post('check_client_email_exits', 'ClientController@check_client_email_exits')->name('check_client_email_exits');
    Route::get('client/case-list/{id}', 'ClientController@caseDetail')->name('clients.case-list');
    Route::get('client/account-list/{id}', 'ClientController@AccountDetail')->name('clients.account-list');


    //---------------------------task-----------------------//
    Route::resource('tasks', 'TaskController');
    Route::post('tasks/data-list', 'TaskController@TaskList')->name('task.list');
    Route::post('tasks/data-status', 'TaskController@changeStatus')->name('task.status');

    //-----------------------Vendor-------------------------//
    Route::resource('vendor', 'VendorController');
    Route::post('vendor/data-list', 'VendorController@VendorList')->name('vendor.list');
    Route::post('vendor/data-status', 'VendorController@changeStatus')->name('vendor.status');

    //-----------------------Invoice---------------------------//
    Route::resource('invoice', 'InvoiceController');
    Route::post('invoice-list', 'InvoiceController@InvoiceList')->name('invoice-list');
    Route::post('invoice-list-client', 'InvoiceController@InvoiceClientList')->name('invoice-list-client');
    Route::get('show_payment_history/{id}', 'InvoiceController@paymentHistory')->name('paymentHistory');
    Route::get('create-Invoice-view/{id?}', 'InvoiceController@CreateInvoiceView');
    Route::get('create-Invoice-view-detail/{id}/{p}', 'InvoiceController@CreateInvoiceViewDetail');
    Route::post('getClientDetailById', 'InvoiceController@getClientDetailById')->name('getClientDetailById');
    Route::post('add_invoice', 'InvoiceController@storeInvoice')->name('store_invoice');
    Route::post('edit_invoice', 'InvoiceController@editInvoice')->name('edit_invoice');


    //------------------Appointment----------------------------//
    Route::resource('appointment', 'AppointmentController');
    Route::post('appointment/data-list', 'AppointmentController@appointmentList')->name('appointment.list');
    Route::post('getMobileno', 'AppointmentController@getMobileno')->name('getMobileno');

    //----------------------setting case type------------------//
    Route::resource('case-type', 'CashTypeController');
    Route::post('cash-type-list', 'CashTypeController@cashTypeList')->name('cash.type.list');
    Route::post('cash-type-list/changestatus', 'CashTypeController@changeStatus')->name('cash.type.casetype.status');

    //---------------------setting court type--------------------------//
    Route::resource('court-type', 'CourtTypeController');
    Route::post('court-type-list', 'CourtTypeController@courtTypeList')->name('court.type.list');
    Route::post('court-type-list/CourtTypeController', 'CourtTypeController@changeStatus')->name('court.type.courttype.status');

    //setting court
    Route::resource('court', 'CourtController');
    Route::post('court-list', 'CourtController@cashList')->name('court.list');
    Route::post('court-list/changestatus', 'CourtController@changeStatus')->name('court.status');

    //setting case status
    Route::resource('case-status', 'CaseStatusController');
    Route::post('case-status-list', 'CaseStatusController@caseStatusList')->name('case.status.list');
    Route::post('case-status-list/changestatus', 'CaseStatusController@changeStatus')->name('case.status');

    //setting judge
    Route::resource('judge', 'JudgeController');
    Route::post('judge-list', 'JudgeController@caseStatusList')->name('judge.list');
    Route::post('judge-status-list/changestatus', 'JudgeController@changeStatus')->name('judge.status');


    //setting Tax
    Route::resource('tax', 'TaxController');
    Route::post('tax-list', 'TaxController@taxList')->name('tax.list');
    Route::post('tax-status-list', 'TaxController@changeStatus')->name('tax.status');


    Route::resource('database-backup', 'DatabaseBackupController');
    Route::get('database-restore/{id}', 'DatabaseBackupController@restore')->name('database-backup.restore');
    Route::post('database-backup-list', 'DatabaseBackupController@List')->name('database-backup.list');

    //setting invoice setting
    Route::resource('invoice-setting', 'InvoiceSettingController');

    // Expense type
    Route::resource('expense-type', 'ExpenseTypeController');
    Route::post('expense-type-list', 'ExpenseTypeController@expenceList')->name('expense.type.list');
    Route::post('expense-type-status-list', 'ExpenseTypeController@changeStatus')->name('expense.status');
    Route::resource('expense', 'ExpenseController');
    Route::get('expense-create/{id?}', 'ExpenseController@expenseCreate');
    Route::post('edit_expense', 'ExpenseController@editExpense')->name('edit_expense');
    Route::post('expense-list', 'ExpenseController@expenseList')->name('expense-list');
    Route::get('expense-account-list/{id}', 'ExpenseController@AccountDetail');
    Route::post('expense-filter-list', 'ExpenseController@expenseFilterClientList');
    Route::post('add_expense_payment', 'ExpenseController@addExpensePayment')->name('addExpensePayment');
    Route::get('show_payment_made_history/{id}', 'ExpenseController@paymentMadeHistory')->name('paymentMadeHistory');

    Route::get('create-expence-view-detail/{id}/{p}', 'ExpenseController@CreateExpenseViewDetail');
    Route::post('getVendorDetailById', 'ExpenseController@getVendorDetailById')->name('getVendorDetailById');

    //---------------------------Case Running-----------------//
    Route::resource('case-running', 'CaseRunningController');
    Route::post('allCaseList', 'CaseRunningController@allCaseList');
    Route::get('select2Case', 'CaseRunningController@select2Case')->name('select2Case');
    Route::get('case-list/{id}', 'CaseRunningController@caseListByClientId');
    Route::post('client/client_case_list', 'CaseRunningController@client_case_list')->name('client.case_view.list');
    Route::post('allCaseList', 'CaseRunningController@allCaseList');
    Route::get('/case-nb', 'CaseRunningController@caseNB');
    Route::get('/case-important', 'CaseRunningController@caseImportant');
    Route::get('/case-archived', 'CaseRunningController@caseArchived');
    Route::post('allCaseHistoryList', 'CaseRunningController@allCaseHistoryList');
    Route::get('addNextDate/{case_id}', 'CaseRunningController@addNextDate');
    Route::get('restoreCase/{case_id}', 'CaseRunningController@restoreCase');
    Route::post('case-next-date', 'CaseRunningController@caseNextDate');
    Route::get('/getNextDateModal/{case_id}', 'CaseRunningController@getNextDateModal')->name('getnextmodal');
    Route::get('/getChangeCourtModal/{case_id}', 'CaseRunningController@getChangeCourtModal')->name('transfermodal');
    Route::get('/case-history/{case_id}', 'CaseRunningController@caseHistory');
    Route::get('/case-transfer/{case_id}', 'CaseRunningController@caseTransfer');
    Route::get('/getCaseImportantModal/{case_id}', 'CaseRunningController@getCaseImportantModal');
    Route::post('allCaseTransferList', 'CaseRunningController@allCaseTransferList');
    Route::post('changeCasePriority', 'CaseRunningController@changeCasePriority');
    Route::post('transferCaseCourt', 'CaseRunningController@transferCaseCourt');
    Route::get('case-running-download/{id}/{action}', 'CaseRunningController@downloadPdf');

    //-----------------------invite member-----------------------//
    Route::resource('client_user', 'ClientUserController');
    Route::post('client-user-list', 'ClientUserController@clientUserList')->name('client-user-list');
    Route::post('client-user/status', 'ClientUserController@changeStatus')->name('client_user.status');
    Route::post('check_user_email_exits', 'ClientUserController@check_user_email_exits')->name('check_user_email_exits');
    Route::post('check_user_name_exits', 'ClientUserController@check_user_name_exits')->name('check_user_name_exits');

    Route::resource('mail-setup', 'SmtpController');
    Route::resource('general-setting', 'GeneralSettingController');
    Route::get('database-backups', 'GeneralSettingController@databaseBackup');
    Route::resource('date-timezone', 'GeneralSettingDateController');


    Route::resource('admin-profile', 'ProfileController');
    Route::post('edit-profile', 'ProfileController@editProfile');
    Route::post('image-crop', 'ProfileController@imageCropPost');
    Route::get('change/password', 'ProfileController@change_pass');
    Route::post('changed-password', 'ProfileController@changedPassword');

    //-----------Role----------------------//
    Route::resource('role', 'RoleController');
    Route::post('role/data-list', 'RoleController@roleList')->name('role.list');

    Route::resource('permission', 'PermissionController');

    //--------------------Service--------------------------------//
    Route::resource('service', 'ServiceController');
    Route::post('service/data-list', 'ServiceController@serviceList')->name('service.list');
    Route::post('service/status', 'ServiceController@changeStatus')->name('service.status');
});


Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'AdminAuth\LoginController@login');
    Route::post('/logout', 'AdminAuth\LoginController@logout')->name('logout');

    Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm')->name('register');
    Route::post('/register', 'AdminAuth\RegisterController@register');

    Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
    Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('password.email');
    Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');

    

Route::get('/language/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'ar'])) {
        abort(400, 'Unsupported language.');
    }
    Session::put('locale', $locale);
    return redirect()->back();
})->name('language.switch');

});
