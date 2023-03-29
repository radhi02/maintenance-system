<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PreventivePlanController;
use App\Http\Controllers\PreventivePlanActivityController;
use App\Http\Controllers\MaintenancePlanController;
use App\Http\Controllers\ReactiveMaintenanceController;
use App\Http\Controllers\ReactiveMaintenancePlanController;
use App\Http\Controllers\ReportReactiveController;
use App\Http\Controllers\ReportPMController;
use App\Http\Controllers\UnitController;

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
    return view('auth/login');
});
Auth::routes();

Route::group(['middleware' => ['auth']], function() {

    Route::get('home',[HomeController::class,'home']);
    Route::get('users',[UserController::class,'users']);
    Route::resource('companies', CompanyController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('vendors', VendorController::class);
    Route::resource('equipment', EquipmentController::class);
    Route::resource('task', TaskController::class);
    Route::resource('maintenanceplan', MaintenancePlanController::class);
    Route::resource('/unit','App\Http\Controllers\UnitController');

    Route::get('donwloadInvoicefile/{fpath}', [App\Http\Controllers\EquipmentController::class, 'downloadInvoiceFile'])->name('donwloadInvoicefile');
    Route::get('fetchdashboarddata', [App\Http\Controllers\HomeController::class, 'fetchdashboarddata'])->name('fetchdashboarddata');
    Route::post('/deleteInvoicefile', [App\Http\Controllers\EquipmentController::class, 'deleteInvoicefile'])->name('deleteInvoicefile');

    //  Reactive Maintenance Plan Start
    Route::resource('reactive_maintenance', ReactiveMaintenanceController::class);
    Route::resource('reactive_maintenance_plan', ReactiveMaintenancePlanController::class);
    Route::resource('reactivereports', ReportReactiveController::class);

    Route::post('/getdata', [App\Http\Controllers\ReportReactiveController::class, 'getdata'])->name('getdata');
    Route::post('/export', [App\Http\Controllers\ReportReactiveController::class, 'export'])->name('export');

    Route::get('showdetail/{id}', [App\Http\Controllers\ReactiveMaintenancePlanController::class, 'showdetail'])->name('showdetail');
    Route::post('/get_date', [App\Http\Controllers\ReactiveMaintenancePlanController::class, 'get_date'])->name('get_date');
    Route::get('/changeUser', [App\Http\Controllers\ReactiveMaintenancePlanController::class, 'changeUser'])->name('changeUser');
    Route::get('/changeUserself', [App\Http\Controllers\ReactiveMaintenancePlanController::class, 'changeUserself'])->name('changeUserself');
    Route::post('/changeEndstatus', [App\Http\Controllers\ReactiveMaintenancePlanController::class, 'changeEndstatus'])->name('changeEndstatus');
    //  Reactive Maintenance Plan Finish

    Route::resource('plan', PreventivePlanController::class);
    Route::resource('planactivity', PreventivePlanActivityController::class);
    Route::get('getEvent', [HomeController::class, 'index']);
    Route::post('/showcalender', [App\Http\Controllers\HomeController::class, 'showcalender'])->name('showcalender');
    Route::post('showMaintenanceEnginner', [PreventivePlanController::class, 'showMaintenanceEnginner']);
    Route::post('/addNoteData', [App\Http\Controllers\PreventivePlanActivityController::class, 'addNoteData'])->name('addNoteData');
    Route::post('/getNoteData', [App\Http\Controllers\PreventivePlanActivityController::class, 'getNoteData'])->name('getNoteData');

    // Route::post('updateplan', [PreventivePlanController::class, 'update']);
    
    //  PM Report Finish
    Route::resource('pmreports', ReportPMController::class);
    Route::post('/getpmdata', [App\Http\Controllers\ReportPMController::class, 'getpmdata'])->name('getpmdata');
    Route::post('/pmexport', [App\Http\Controllers\ReportPMController::class, 'pmexport'])->name('pmexport');
    //  PM Report Finish

    Route::post('/task/create', [App\Http\Controllers\taskController::class, 'DestroyOther'])->name('task.DestroyOther');
    Route::post('/updatePreventiveStatus', [App\Http\Controllers\HomeController::class, 'updatePreventiveStatus'])->name('updatePreventiveStatus');
    Route::post('fullcalenderAjax', [HomeController::class, 'ajaxUpdate']);
    Route::get('updateByEndUser/{id}', '\App\Http\Controllers\PreventivePlanActivityController@updateByEndUser')->name('updateByEndUser');
    Route::put('statusByEndUser/{id}', '\App\Http\Controllers\PreventivePlanActivityController@statusByEndUser')->name('statusByEndUser');
    Route::get('startPMActivity/{id}', '\App\Http\Controllers\PreventivePlanActivityController@startPMActivity')->name('startPMActivity');

    Route::POST('api/fetch-states', [DropdownController::class, 'fetchState']);
    Route::POST('api/fetch-cities', [DropdownController::class, 'fetchCity']);
    Route::POST('api/fetch-department', [UserController::class, 'fetchDepartment']);

    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
    Route::resource('/role','App\Http\Controllers\RoleController');
    Route::post('role_destroy', [RoleController::class, 'destroy']);
    Route::post('/statusRole', 'App\Http\Controllers\RoleController@Status')->name('role.status');
    Route::resource('/user','App\Http\Controllers\UserController');

    Route::post('user_destroy', [UserController::class, 'destroy']);
    Route::post('/statusUser', 'App\Http\Controllers\UserController@Status')->name('User.status');

    Route::get('/Module/create/',[App\Http\Controllers\Module\ModuleController::class, 'Create'])->name('Module.new.creates');
    Route::post('/Module/Store/',[App\Http\Controllers\Module\ModuleController::class, 'store'])->name('Module.store');
    Route::get('/Module/{id}',[App\Http\Controllers\Module\ModuleController::class, 'index'])->name('Module.permission');
    Route::post('/Module/permission/',[App\Http\Controllers\Module\ModuleController::class, 'GivePermission'])->name('Module.GivePermission');
    Route::get('/changeUserselfTicket', [App\Http\Controllers\ReactiveMaintenanceController::class, 'changeUserselfTicket'])->name('changeUserselfTicket');
    Route::post('/changeUserTicket', [App\Http\Controllers\ReactiveMaintenanceController::class, 'changeUserTicket'])->name('changeUserTicket');

    Route::post('/createPDF', [App\Http\Controllers\ReportReactiveController::class, 'createPDF'])->name('createPDF');
    Route::post('/createPMPDF', [App\Http\Controllers\ReportPMController::class, 'createPMPDF'])->name('createPMPDF');
    // Route::post('/deleteplancost',   [App\Http\Controllers\PreventivePlanActivityController::class, 'deleteplancost'])->name('deleteplancost.all');
    Route::post('/deleteplancost', [App\Http\Controllers\PreventivePlanActivityController::class, 'deleteplancost'])->name('deleteplancost.all');

});    

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

