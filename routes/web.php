<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderReportsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProfileController;
use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home',[HomeController::class,'index'])->middleware('auth')->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


//Admin page

Route::middleware('process')->group(function(){
            //add process by admin
        Route::get('/add-process',[AdminController::class,'addProcess'])->name('admin.process');
        //store process by admin
        Route::post('/store-process',[AdminController::class,'storeProcess'])->name('admin.store_process');
        //view admin body contents
        Route::get('/body',[AdminController::class,'index'])->name('admin.body');
        //edit process by admin
        Route::get('edit-process/{id}',[AdminController::class,'editProcess'])->name('admin.edit_process');
        //update process by admin
        Route::put('/update-process/{id}',[AdminController::class,'updateProcess'])->name('admin.update_process');
        //delete process by admin
        Route::delete('/delete-process/{id}',[AdminController::class,'deleteProcess'])->name('admin.delete_process');



        //admin to add form employee 
        Route::get('/add-employee',[AdminController::class,'addEmployee'])->name('admin.add_employee');
        //admin to store employee
        Route::post('/store-employee',[AdminController::class,'storeEmployee'])->name('admin.store_employee');
        //admin to view employee side
        Route::get('/employee-details',[AdminController::class,'showEmployees'])->name('admin.show_employees');
        //admin to edit employee
        Route::get('/edit-employee/{id}',[AdminController::class,'editEmployee'])->name('admin.edit_employee');
        //admin to update employee
        Route::put('/update-employee/{id}',[AdminController::class,'updateEmployee'])->name('admin.update_employee');
        //admin to update employee
        Route::delete('/delete-employee/{id}',[AdminController::class,'deleteEmployee'])->name('admin.delete_employee');



        //assign order list
        Route::get('/assign-list',[AdminController::class,'assignList'])->name('admin.assign_list');
       //admin Assign orders to employee form
        Route::get('/assign-order',[AdminController::class,'assignOrder'])->name('admin.assign_order');
        //store the assined oders
        Route::post('/assign-store',[AdminController::class,'storeAssign'])->name('admin.store_assign');
       
        

        //resource controller for orders crud

        Route::resource('orders',OrdersController::class);


        //ajax request to get processes
        Route::get('/get-processes/{id}',[AdminController::class,'getProcessesByOrderId']);


        //order reports page
        Route::get('/order-reports',[OrderReportsController::class,'index'])->name('admin.order_reports');

        //list billings
        Route::get('/list-billings',[OrderReportsController::class,'listBill'])->name('admin.bill_index');
        //order billings form
        Route::get('/order-billings',[OrderReportsController::class,'billings'])->name('admin.billings');

        //store bill datas
        Route::post('/store-bill',[OrderReportsController::class,'storeBill'])->name('admin.store_bill');

        //edit bill
        Route::get('/edit-bill/{id}',[OrderReportsController::class,'editBill'])->name('admin.edit_bill');

        //update bill
        Route::put('/update-bill/{id}',[OrderReportsController::class,'updateBill'])->name('admin.update_bill');


        //delete bill
        Route::delete('/delete-bill/{id}',[OrderReportsController::class,'deleteBill'])->name('admin.delete_bill');


});

Route::middleware('employee')->group(function(){

//employee dashboard
//view auth employee work list
Route::get('/work-list',[EmployeeController::class,'index'])->name('employees.index');
//start work--- to save time to db
Route::post('/start-work',[EmployeeController::class,'startWork']);
//complete work ---to save time to db
Route::post('/complete-work',[EmployeeController::class,'endWork']);

//notification page for employee
Route::get('/view-notification',[EmployeeController::class,'viewNotifications'])->name('employees.notification');

//switch process form by employee
Route::get('/switch-process/{id}',[EmployeeController::class,'switchProcess'])->name('employees.switch_process');

//store switch process by employee
Route::post('/store-process',[EmployeeController::class,'storeSwitchProcess'])->name('employees.assign_order');
});