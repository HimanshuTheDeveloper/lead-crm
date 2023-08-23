<?php

use App\Http\Controllers\AmcController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HostingController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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
Route::get('checkrole', function(){
    return Auth::user()->hasRole;
})->name('user.login');


Route::get('/', [AuthController::class, 'login'])->name('user.login');

Route::post('login_submit', [AuthController::class, 'login_submit'])->name('user.login_submit');
Route::get('signup', function () {
    return view('auth.signup');
});

Route::get('flush', function () {
    Auth::logout();
    $t =  Session::flush();

    if($t){
        return "1";
    }else{
        return "5";
    }
});

Route::group(['middleware' => 'web_middleware'], function () {

        Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');
        Route::get('dashboard', [HomeController::class, 'dashboard'])->name('user.dashboard');

        // For Client
        Route::get('clients', [ClientController::class, 'index'])->name('admin.clients');
        Route::get('add-clients', [ClientController::class, 'add_clients'])->name('admin.add_clients');
        Route::post('save-clients', [ClientController::class, 'save_clients'])->name('admin.save_clients');
        Route::get('edit-clients/{id}', [ClientController::class, 'edit_clients'])->name('admin.edit_clients');
        Route::post('update-clients', [ClientController::class, 'update_clients'])->name('admin.update_clients');
        Route::post('client_list', [ClientController::class, 'client_list'])->name('admin.client_list');
        Route::post('client_delete', [ClientController::class, 'client_delete'])->name('admin.client_delete');

        //For Payment
        Route::get('payments', [PaymentController::class, 'index'])->name('admin.payments');
        Route::get('add-payments', [PaymentController::class, 'add_payments'])->name('admin.add_payments');
        Route::post('save-payments', [PaymentController::class, 'save_payments'])->name('admin.save_payments');
        Route::get('edit-payments/{id}', [PaymentController::class, 'edit_payments'])->name('admin.edit_payments');
        Route::post('update-payments', [PaymentController::class, 'update_payments'])->name('admin.update_payments');
        Route::post('payment_list', [PaymentController::class, 'payment_list'])->name('admin.payment_list');
        Route::post('payment_delete', [PaymentController::class, 'payment_delete'])->name('admin.payment_delete');
        Route::get('invoice/{id}', [PaymentController::class, 'invoice'])->name('admin.invoice');
        Route::post('getInvoiceCode', [PaymentController::class, 'getInvoiceCode'])->name('admin.getInvoiceCode');

        Route::post('saveInvoiceData', [PaymentController::class, 'saveInvoiceData'])->name('admin.saveInvoiceData');

        Route::get('getPaymentData', [PaymentController::class, 'getPaymentData'])->name('admin.getPaymentData');

        //  for Leads
        Route::get('leads', [LeadController::class, 'index'])->name('admin.leads');
        Route::get('addleads', [LeadController::class, 'addleads'])->name('admin.addleads');
        Route::post('save-lead', [LeadController::class, 'save_lead'])->name('admin.save_lead');
        Route::get('edit-lead/{id}', [LeadController::class, 'edit_lead'])->name('admin.edit_lead');
        Route::post('update-lead', [LeadController::class, 'update_lead'])->name('admin.update_lead');
        Route::post('lead_list', [LeadController::class, 'lead_list'])->name('admin.lead_list');
        Route::post('lead_delete', [LeadController::class, 'lead_delete'])->name('admin.lead_delete');

        Route::get('lead-followups/{id}', [LeadController::class, 'followup'])->name('admin.followup');
        Route::post('lead-follow', [LeadController::class, 'lead_modal'])->name('admin.lead_modal');
    
        //  for domain
        Route::get('domain', [DomainController::class, 'index'])->name('admin.domain');
        Route::get('add_domain', [DomainController::class, 'add_domain'])->name('admin.add_domain');
        Route::post('save-domain', [DomainController::class, 'save_domain'])->name('admin.save_domain');
        Route::get('edit-domain/{id}', [DomainController::class, 'edit_domain'])->name('admin.edit_domain');
        Route::post('update-domain', [DomainController::class, 'update_domain'])->name('admin.update_domain');
        Route::post('domain_list', [DomainController::class, 'domain_list'])->name('admin.domain_list');
        Route::post('domain_delete', [DomainController::class, 'domain_delete'])->name('admin.domain_delete');
    
        //  for hostings
        Route::get('hosting', [HostingController::class, 'index'])->name('admin.hosting');
        Route::get('add_hosting', [HostingController::class, 'add_hosting'])->name('admin.add_hosting');
        Route::post('save-hosting', [HostingController::class, 'save_hosting'])->name('admin.save_hosting');
        Route::get('edit-hosting/{id}', [HostingController::class, 'edit_hosting'])->name('admin.edit_hosting');
        Route::post('update-hosting', [HostingController::class, 'update_hosting'])->name('admin.update_hosting');
        Route::post('hosting_list', [HostingController::class, 'hosting_list'])->name('admin.hosting_list');
        Route::post('hosting_delete', [HostingController::class, 'hosting_delete'])->name('admin.hosting_delete');
    
        //for Amc
        Route::get('amc', [AmcController::class, 'index'])->name('admin.amc');
        Route::get('add-amc', [AmcController::class, 'add_amc'])->name('admin.add_amc');
        Route::post('save-amc', [AmcController::class, 'save_amc'])->name('admin.save_amc');
        Route::get('edit-amc/{id}', [AmcController::class, 'edit_amc'])->name('admin.edit_amc');
        Route::post('update-amc', [AmcController::class, 'update_amc'])->name('admin.update_amc');
        Route::post('amc_list', [AmcController::class, 'amc_list'])->name('admin.amc_list');
        Route::post('amc_delete', [AmcController::class, 'amc_delete'])->name('admin.amc_delete');

        //Hosting Import-Export
        Route::get('file-hostings', [HostingController::class, 'hostingView'])->name('admin.import-view');
        Route::post('import-hosting', [HostingController::class, 'importhostings'])->name('admin.hosting-view');
        Route::get('export-hostings', [HostingController::class, 'exportHosting'])->name('admin.export-hostings');
    
        //Leads Import-Export
        Route::get('file-import', [LeadController::class, 'importView'])->name('admin.import-view');
        Route::post('import-lead', [LeadController::class, 'import'])->name('admin.import');
        Route::get('export-leads', [LeadController::class, 'exportLeads'])->name('admin.export-leads');

        //Domain Import-Export
        Route::get('file-domains', [DomainController::class, 'domainView'])->name('admin.import-view');
        Route::post('import-domain', [DomainController::class, 'importdomains'])->name('admin.view-domain');
        Route::get('export-domains', [DomainController::class, 'exportDomains'])->name('admin.export-domains');

        Route::get('profile',[ProfileController::class,'profile'])->name('admin.profile');
        Route::post('save-profiles',[ProfileController::class,'update_profiles'])->name('admin.update_profiles');

        //Dashboard 
        Route::get('hotLeads', [HomeController::class, 'hotLeads'])->name('admin.hotLeads');
        Route::post('hotLead_list', [HomeController::class, 'hot_lead_list'])->name('admin.hotLead_list');

        Route::get('followup', [HomeController::class, 'followup'])->name('admin.followupDashboard');
        Route::post('followup_list', [HomeController::class, 'followup_list'])->name('admin.followup_list');

        Route::get('missingup', [HomeController::class, 'missingup'])->name('admin.missingup');
        Route::post('missingup_list', [HomeController::class, 'missingup_list'])->name('admin.missingup_list');

        Route::get('hostings-lookup', [HomeController::class, 'hostings_lookup'])->name('admin.hostings_lookup');
        Route::post('hostings-lookup-list', [HomeController::class, 'hostings_lookup_list'])->name('admin.hostings_lookup_list');

        Route::get('expired-hostings-lookup', [HomeController::class, 'expired_hostings_lookup'])->name('admin.expired_hostings_lookup');
        Route::post('expired-hostings-lookup-list', [HomeController::class, 'expired_hostings_lookup_list'])->name('admin.expired_hostings_lookup_list');

        Route::get('amc-lookup', [HomeController::class, 'amc_lookup'])->name('admin.amc_lookup');
        Route::post('amc-lookup-list', [HomeController::class, 'amc_lookup_list'])->name('admin.amc_lookup_list');

        Route::get('expired-amc-lookup', [HomeController::class, 'expired_amc_lookup'])->name('admin.expired_amc_lookup');
        Route::post('expired-amc-lookup-list', [HomeController::class, 'expired_amc_lookup_list'])->name('admin.expired_amc_lookup_list');


        //Invoice
        Route::get('invoice-view', [InvoiceController::class, 'index'])->name('admin.invoice_view');
        Route::post('invoice_list', [InvoiceController::class, 'invoice_list'])->name('admin.invoice_list');



    });

    
Route::group(['middleware' => ['web_middleware', 'role:admin']], function () {
    // For Users
    Route::get('users', [UserController::class, 'index'])->name('admin.users');
    Route::get('add-users', [UserController::class, 'add_users'])->name('admin.add_users');
    Route::post('save-users', [UserController::class, 'save_users'])->name('admin.save_users');
    Route::get('edit-users/{id}', [UserController::class, 'edit_users'])->name('admin.edit_users');
    Route::post('update-users', [UserController::class, 'update_users'])->name('admin.update_users');
    Route::post('user_list', [UserController::class, 'user_list'])->name('admin.user_list');
    Route::post('user_delete', [UserController::class, 'user_delete'])->name('admin.user_delete');

    //for roles
    Route::get('roles', [RoleController::class, 'index'])->name('admin.roles');
    Route::get('add_role', [RoleController::class, 'add_role'])->name('admin.add_role');
    Route::post('save_role', [RoleController::class, 'save_role'])->name('admin.save_role');
    Route::get('edit_role/{id}', [RoleController::class, 'edit_role'])->name('admin.edit_role');
    Route::post('update_role', [RoleController::class, 'update_role'])->name('admin.update_role');
    Route::post('delete_role', [RoleController::class, 'role_delete'])->name('admin.delete_role');
    Route::post('roles_list', [RoleController::class, 'roles_list'])->name('admin.roles_list');

    //for expenses
    Route::get('expense', [ExpenseController::class, 'expense'])->name('admin.expense');
    Route::get('addExpense', [ExpenseController::class, 'addExpense'])->name('admin.addExpense');
    Route::post('saveExpense', [ExpenseController::class, 'saveExpense'])->name('admin.saveExpense');
    Route::post('update-Expense', [ExpenseController::class, 'updateExpense'])->name('admin.updateExpense');
    Route::get('edit-Expense/{id}', [ExpenseController::class, 'editExpense'])->name('admin.editExpense');
    Route::post('expenseList', [ExpenseController::class, 'expenseList'])->name('admin.expenseList');
    Route::post('delete_expense', [ExpenseController::class, 'delete_expense'])->name('admin.delete_expense');

    Route::get('expenseExport', [ExpenseController::class, 'expenseExport'])->name('admin.expenseExport');

    //for revenue
    Route::get('revenue', [RevenueController::class, 'revenue'])->name('admin.revenue');
    Route::post('revenueData', [RevenueController::class, 'revenueData'])->name('admin.revenueData');
    
});

Route::group(['middleware' => ['web_middleware', 'role:hr']], function () {
    // Route::get('role1', function(){
    //     return 'hr';
    // });
});
Route::group(['middleware' => ['web_middleware', 'role:bdm']], function () {
    // Route::get('role1', function(){
    //     return 'hr';
    // });

});
