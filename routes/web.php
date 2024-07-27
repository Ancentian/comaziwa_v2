<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\SuperAdminPaymentsController;
use App\Http\Controllers\SuperAdminSubscriptionPlansController;
use App\Http\Controllers\SuperAdminUsersController;
use App\Http\Controllers\SuperAdminReportsController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\ContractsController;
use App\Http\Controllers\SalariesController;
use App\Http\Controllers\DeductionsController;
use App\Http\Controllers\LeaveTypesController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\LeavesController;
use App\Http\Controllers\CommunicationsController;
use App\Http\Controllers\EmailsController;
use App\Http\Controllers\PayslipExports;
use App\Http\Controllers\PayslipsReports;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\CooperativeController;
use App\Http\Controllers\FarmersController;
use App\Http\Controllers\MilkCollectionController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SharesController;
use App\Http\Controllers\AssetsController;
use App\Http\Controllers\MilkManagementController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\Crons;
use App\Http\Controllers\StaffMilkController;
use App\Http\Controllers\AnalysisController;


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

//Route::get('/', [AuthController::class, 'index'])->name('home');
Route::get('/', [AuthController::class, 'login']);

Route::prefix('superadmin')->middleware(['auth:web,employee'])->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard']);
    Route::get('/list/payments', [SuperAdminPaymentsController::class, 'index']);
    Route::get('/payment-methods', [SuperAdminPaymentsController::class, 'payment_methods']);
    Route::get('/subscription-plans', [SuperAdminSubscriptionPlansController::class, 'index']);
    Route::post('/store', [SuperAdminSubscriptionPlansController::class, 'store']);
    Route::get('/editSubscription/{id}', [SuperAdminSubscriptionPlansController::class, 'editSubscription']);
    Route::post('/updateSubscription/{id}', [SuperAdminSubscriptionPlansController::class, 'updateSubscription']);
    Route::get('/assign-permissions/{id}', [SuperAdminUsersController::class, 'assign_permissions']);
    Route::post('/create-users', [SuperAdminUsersController::class, 'storeUser']);
    Route::post('/create-admin', [SuperAdminUsersController::class, 'storeAdmin']);
    Route::post('/create-role', [SuperAdminUsersController::class, 'storeRole']);
   
    Route::get('/extend-date/{id}', [SuperAdminUsersController::class, 'extend_expiry_date']);
    Route::post('/extend_userDates/{id}', [SuperAdminUsersController::class, 'extend_userDates']);
    Route::get('/edit-user-package/{id}', [SuperAdminUsersController::class, 'edit_userPackage']);
    Route::post('/update_userPackage/{id}', [SuperAdminUsersController::class, 'update_userPackage']);

    Route::get('/list/users', [SuperAdminUsersController::class, 'index']);
    Route::get('/list/roles', [SuperAdminUsersController::class, 'roles']);
    Route::get('/edit-admin/{id}', [SuperAdminUsersController::class, 'edit_admin']);
    Route::get('/edit-role/{id}', [SuperAdminUsersController::class, 'edit_role']);
    Route::post('/assign-permissions/{id}', [SuperAdminUsersController::class, 'post_assign_permissions']);
    
    Route::post('/update-admin/{id}', [SuperAdminUsersController::class, 'update_admin']);
    Route::post('/update-role/{id}', [SuperAdminUsersController::class, 'update_role']);

    Route::delete('/delete-admin/{id}', [SuperAdminUsersController::class, 'delete_admin']);

    Route::get('/list/clients', [SuperAdminUsersController::class, 'clients']);
    Route::get('/edit-client/{id}', [SuperAdminUsersController::class, 'edit_client']);
    Route::post('/update-client/{id}', [SuperAdminUsersController::class, 'update_client']);
    Route::delete('/delete-client/{id}', [SuperAdminUsersController::class, 'delete_client']);
    Route::delete('/delete-role/{id}', [SuperAdminUsersController::class, 'delete_role']);

    Route::get('/list/agents', [SuperAdminUsersController::class, 'agents']);
    Route::post('/create-agent', [SuperAdminUsersController::class, 'storeAgent']);
    Route::get('/edit-agent/{id}', [SuperAdminUsersController::class, 'edit_agent']);
    Route::get('/add-payment/{id}', [SuperAdminUsersController::class, 'add_payment']);
    Route::get('/edit-payment/{id}', [SuperAdminUsersController::class, 'edit_payment']);
    Route::post('/update-payment/{id}', [SuperAdminUsersController::class, 'update_payment']);
    Route::post('/update-agent/{id}', [SuperAdminUsersController::class, 'update_agent']);
    Route::post('/pay', [SuperAdminUsersController::class, 'store_payment']);
    Route::get('/agent-payments/{id}', [SuperAdminUsersController::class, 'agent_payments']);
    Route::delete('/delete-agent/{id}', [SuperAdminUsersController::class, 'delete_agent']);

    Route::get('/assign-agent/{id}', [SuperAdminUsersController::class, 'assign_agent']);
    Route::post('/update-user-agent/{id}', [SuperAdminUsersController::class, 'update_userAgent']);
    Route::get('/assigned-users/{id}', [SuperAdminUsersController::class, 'assigned_users']);
    
    Route::delete('/delete/{id}', [SuperAdminSubscriptionPlansController::class, 'delete']);
    Route::delete('/delete-payment/{id}', [SuperAdminUsersController::class, 'delete_payment']);
    
    // Route::get('/companies', [SuperAdminCompaniesController::class, 'index']);
});

Route::prefix('dashboard')->middleware(['auth:web,employee'])->group(function () {
    Route::get('/index', [DashboardController::class, 'index']);

    Route::get('/subscriptions', [DashboardController::class, 'subscriptions']);

    Route::get('/confirm-payment/{ref}/{plan}', [DashboardController::class, 'confirmPayment']);
    Route::get('/tryplan/{id}', [DashboardController::class, 'tryPlan']);
});

Route::prefix('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/login', [AuthController::class, 'login']);
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::get('/signup', [AuthController::class, 'signup']);
    Route::get('/pass-reset', [AuthController::class, 'pass_reset']);
    Route::post('/storeUser', [AuthController::class, 'storeUser']);

    Route::post('forgot-password', [ForgotPasswordController::class, 'forgot_password']);
    Route::post('staff-forgot-password', [ForgotPasswordController::class, 'staff_forgot_password']);
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'resetPasswordForm'])->name('password.reset');
    Route::get('staff-reset-password/{token}', [ForgotPasswordController::class, 'staff_resetPasswordForm'])->name('staff.password.reset');
    Route::post('reset-password', [ForgotPasswordController::class, 'updatePasswordForm']);
    Route::post('staff-reset-password', [ForgotPasswordController::class, 'update_staffPasswordForm']);
});

Route::prefix('company')->middleware(['auth:web,employee'])->group(function () {
    Route::get('/profile', [CompaniesController::class, 'createCompanyProfile']);
    Route::get('/settings', [CompaniesController::class, 'company_settings']);
    Route::post('/storeCompany', [CompaniesController::class, 'storeCompany']);
});

Route::prefix('centers')->middleware(['auth:web,employee'])->group(function () {
    Route::get('/collection-centers', [CooperativeController::class, 'collection_centers']);
    Route::post('/store-collection-center', [CooperativeController::class, 'store_collectionCenter']);
});

Route::prefix('cooperative')->middleware(['auth:web,employee'])->group(function () {
    Route::get('/index', [CooperativeController::class, 'index']);
    Route::get('/farmers', [FarmersController::class, 'index']);
    Route::get('/banks', [CooperativeController::class, 'cooperative_banks']);
    Route::post('/store-farmers', [FarmersController::class, 'store_cooperativeFarmers']);
    Route::post('/store-banks', [CooperativeController::class, 'store_banks']);
    //Farmer
    Route::get('/edit-farmer/{id}', [FarmersController::class, 'edit_farmer']);
    Route::post('/update-farmer/{id}', [FarmersController::class, 'update_farmer']);
    Route::delete('/delete-farmer/{id}', [FarmersController::class, 'delete_farmer']);

    Route::get('/getFarmersByCenter/{centerId}', [FarmersController::class, 'getFarmersByCenter']);

});

Route::prefix('milkCollection')->middleware(['auth:web,employee'])->group(function () {
    //Milk Collection
    Route::get('/index', [MilkCollectionController::class, 'index'])->name('milk-collection.index');
    Route::get('/all-milk-collection', [MilkCollectionController::class, 'all_milk_collection']);
    Route::get('/add-collection', [MilkCollectionController::class, 'add_collection']);
    Route::post('/store-milk-collection', [MilkCollectionController::class, 'store_milkCollection']);
    Route::get('/edit-milk-collection/{id}', [MilkCollectionController::class, 'edit_milkCollection']);
    Route::post('/update-milk-collection/{id}', [MilkCollectionController::class, 'update_milkCollection']);
    Route::delete('/delete-milk-collection/{id}', [MilkCollectionController::class, 'delete_milkCollection']);
    //Center
    Route::get('/center-farmers/{id}', [MilkCollectionController::class, 'center_farmers']);

    //Import Milk
    Route::get('/import-milk/{id}', [MilkCollectionController::class, 'import_milk']);
    Route::post('/store-import-milk', [MilkCollectionController::class, 'store_import_milk']);
    
});

Route::prefix('inventory')->middleware(['auth:web,employee'])->group(function () {
    //Inventory
    Route::get('/index', [InventoryController::class, 'index']);
    Route::get('/all-inventory', [InventoryController::class, 'all_inventory']);
    Route::post('store-inventory', [InventoryController::class, 'store_inventory']);
    Route::get('/edit-inventory/{id}', [InventoryController::class, 'edit_inventory'])->name('inventory.edit');
    Route::post('/update-inventory/{id}', [InventoryController::class, 'update_inventory']);
    Route::get('/add-stock/{id}', [InventoryController::class, 'add_stock']);
    Route::post('/update-inventory-stock/{id}', [InventoryController::class, 'update_inventory_stock']);
    Route::delete('/delete-inventory/{id}', [InventoryController::class, 'delete_inventory']);

    //Category
    Route::get('/categories', [InventoryController::class, 'categories']);
    Route::post('/store-category', [InventoryController::class, 'store_category']);
    Route::get('/edit-category/{id}', [InventoryController::class, 'edit_category']);
    Route::post('/update-category/{id}', [InventoryController::class, 'update_category']);
    Route::delete('/delete-category/{id}', [InventoryController::class, 'delete_category']);
    //Center
    Route::get('/center-farmers/{id}', [MilkCollectionController::class, 'center_farmers']); 
    //Unit
    Route::get('/units', [InventoryController::class, 'units']);
    Route::post('/store-unit', [InventoryController::class, 'store_unit']);
    Route::get('/edit-unit/{id}', [InventoryController::class, 'edit_unit']);
    Route::post('/update-unit/{id}', [InventoryController::class, 'update_unit']);
    Route::delete('/delete-unit/{id}', [InventoryController::class, 'delete_unit']);
});

Route::prefix('sales')->middleware(['auth:web,employee'])->group(function () {
    Route::get('/index', [SalesController::class, 'index'])->name('sales.index');
    Route::get('/add-sales', [SalesController::class, 'add_sales']);
    Route::get('/getFarmersByCenter/{centerId}', [SalesController::class, 'getFarmersByCenter']);
    Route::get('/getFarmerDetails/{farmerId}', [SalesController::class, 'getFarmerDetails']);
    Route::get('/getProductsByCategory/{categoryId}', [SalesController::class, 'getProductsByCategory']);
    Route::get('/get-product-details/{itemId}', [SalesController::class, 'getproductdetails']);

    Route::post('store-sales', [SalesController::class, 'store_sales']);

    Route::get('all-transactions', [SalesController::class, 'all_transactions']);
    Route::get('view-transation/{id}', [SalesController::class, 'view_transaction_details']);
    Route::get('transaction-details/{id}', [SalesController::class, 'transaction_details']);
    Route::post('print-invoice', [SalesController::class, 'print_invoice']);
});

Route::prefix('deductions')->middleware(['auth:web,employee'])->group(function () {
    Route::get('/index', [DeductionsController::class, 'index'])->name('deductions.index');
    Route::get('/add-deduction', [DeductionsController::class, 'add_deduction'])->name('deductions.add-deduction');
    Route::get('/get-deduction-details/{id}', [DeductionsController::class, 'getdeductiondetails']);
    Route::post('/store-deduction', [DeductionsController::class, 'store_deduction']);
    Route::post('/store-general-deduction', [DeductionsController::class, 'store_general_deduction']);

    Route::get('/deduction-types', [DeductionsController::class, 'deduction_types']);
    Route::post('/store-deduction-type', [DeductionsController::class, 'store_deduction_type']);

    Route::get('/edit-deduction/{id}', [DeductionsController::class, 'edit_deduction']);
    Route::get('/edit-deduction-type/{id}', [DeductionsController::class, 'edit_deduction_type']);

    Route::post('/update-deduction/{id}', [DeductionsController::class, 'update_deduction']);
    Route::post('/update-deduction-type/{id}', [DeductionsController::class, 'update_deduction_type']);

    Route::delete('/delete-deduction/{id}', [DeductionsController::class, 'delete_deduction']);
    Route::delete('/delete-deduction-type/{id}', [DeductionsController::class, 'delete_deduction_type']);
});

Route::prefix('shares')->middleware(['auth:web,employee'])->group(function () {
    Route::get('/index', [SharesController::class, 'index'])->name('shares.index');
    Route::get('/all-shares', [SharesController::class, 'all_shares']);
    Route::post('/store-shares', [SharesController::class, 'store_shares']); 
    Route::get('/edit-shares/{id}', [SharesController::class, 'edit_shares']);
    Route::post('/update-shares/{id}', [SharesController::class, 'update_shares']);
    Route::delete('/delete-shares/{id}', [SharesController::class, 'delete_shares']); 
    
    //Settings
    Route::get('/shares-settings', [SharesController::class, 'shares_settings']);
    Route::get('/all-shares-settings', [SharesController::class, 'all_shares_settings']);
    Route::post('/store-shares-settings', [SharesController::class, 'store_shares_settings']);
    Route::get('/edit-shares-settings/{id}', [SharesController::class, 'edit_shares_settings']);
    Route::post('/update-shares-settings/{id}', [SharesController::class, 'update_shares_settings']);
    Route::delete('/delete-shares-settings/{id}', [SharesController::class, 'delete_shares_settings']);
});

Route::prefix('assets')->middleware(['auth:web,employee'])->group(function () {
    Route::get('/index', [AssetsController::class, 'index'])->name('assets.index');
    Route::get('/all-assets', [AssetsController::class, 'all_assets']);

    Route::get('/categories', [AssetsController::class, 'categories']);
    Route::get('/asset-categories', [AssetsController::class, 'asset_categories']);

    Route::post('/store-asset-category', [AssetsController::class, 'store_asset_category']);
    Route::post('/store-assets', [AssetsController::class, 'store_assets']);

    Route::get('/edit-asset-category/{id}', [AssetsController::class, 'edit_asset_category']);
    Route::get('/edit-asset/{id}', [AssetsController::class, 'edit_asset']);

    Route::post('/update-asset-category/{id}', [AssetsController::class, 'update_asset_category']);
    Route::post('/update-asset/{id}', [AssetsController::class, 'update_assets']);

    Route::delete('/delete-asset-category/{id}', [AssetsController::class, 'delete_asset_category']);
    Route::delete('/delete-asset/{id}', [AssetsController::class, 'delete_asset']);   
});

Route::prefix('milk-management')->middleware(['auth:web,employee'])->group(function () {
    Route::get('/index', [MilkManagementController::class, 'index'])->name('management.index');
    Route::get('/spillages', [MilkManagementController::class, 'spillages']);
    Route::get('/milk-spillages', [MilkManagementController::class, 'milk_spillages']);
    Route::post('/store-spillages', [MilkManagementController::class, 'store_spillages']);
    Route::get('/edit-spillage/{id}', [MilkManagementController::class, 'edit_spillage']);
    Route::post('/update-spillage/{id}', [MilkManagementController::class, 'update_spillage']);
    Route::delete('/delete-spillage/{id}', [MilkManagementController::class, 'delete_spillage']); 

    //Comment
    Route::get('/view-comment/{id}', [MilkManagementController::class, 'view_comments']);
});

Route::prefix('payments')->middleware(['auth:web,employee'])->group(function () {
    Route::get('/index', [PaymentsController::class, 'index'])->name('payments.index');
    Route::get('/all-payments', [PaymentsController::class, 'all_payments']);
    Route::get('/generate-payments', [PaymentsController::class, 'generate_payments'])->name('payments.generate-payments');
    Route::post('/store-payments', [PaymentsController::class, 'store_payments']);

    Route::post('/print-payslip', [PaymentsController::class, 'print_payslip'])->name('payments.print-payslip');
    Route::get('/bank-list', [PaymentsController::class, 'bank_list']);
});

Route::prefix('profile')->middleware(['auth:web,employee'])->group(function () {
    Route::get('/my-profile', [ProfilesController::class, 'myProfile']);
    Route::get('/staff-profile', [ProfilesController::class, 'staffProfile']);
    Route::post('/update-profile', [ProfilesController::class, 'updateProfile']);
    Route::post('/update-staff-profile', [ProfilesController::class, 'update_staffProfile']);
});

Route::prefix('analysis')->middleware(['auth:web,employee'])->group(function () {
    Route::get('/index', [AnalysisController::class, 'index']);
    Route::get('/collection-center-monthly-report', [AnalysisController::class, 'collection_center_monthly_report']);
    Route::get('/collection-center-report/{id}', [AnalysisController::class, 'report_by_center']);
    Route::get('/farmers-monthly-report', [AnalysisController::class, 'farmers_monthly_report']);
    Route::get('/farmers-report/{id}', [AnalysisController::class, 'report_by_farmer']);
    Route::get('sales-monthly-report', [AnalysisController::class, 'sales_monthly_report']);
    Route::get('farmer-sales-report/{id}', [AnalysisController::class, 'farmer_sales_report']);
    Route::get('monthly-deductions-report', [AnalysisController::class, 'monthly_deductions_report']);
    Route::get('farmers-deductions-report/{id}', [AnalysisController::class, 'farmers_deductions_report']);

    //Payments
    Route::get('payments-report', [AnalysisController::class, 'payments_report']);
    //Shares
    Route::get('shares-contribution-report', [AnalysisController::class, 'shares_contribution_report']);
});

Route::prefix('contracts')->middleware(['auth:web,employee'])->group(function () {
    Route::get('/list', [ContractsController::class, 'index']);
    Route::post('/storeContract', [ContractsController::class, 'storeContract']);
    Route::get('/editContract/{id}', [ContractsController::class, 'edit']);
    Route::post('/updateContract/{id}', [ContractsController::class, 'update']);
    Route::delete('/deleteContract/{id}', [ContractsController::class, 'deleteContract']);
});

Route::prefix('departments')->middleware(['auth:web,employee'])->group(function () {
    Route::get('/list', [ContractsController::class, 'indexContractType']);
    Route::post('/store', [ContractsController::class, 'store']);
    Route::get('/edit/{id}', [ContractsController::class, 'edit']);
    Route::post('/update/{id}', [ContractsController::class, 'update']);
    Route::delete('/delete/{id}', [ContractsController::class, 'delete']);
});

Route::prefix('salaries')->middleware(['auth:web,employee'])->group(function () {
    Route::get('/list', [SalariesController::class, 'index']);
    Route::post('/store_salaryType', [SalariesController::class, 'store_salaryType']);
    Route::get('/editSalary/{id}', [SalariesController::class, 'edit']);
    Route::post('/updateSalary/{id}', [SalariesController::class, 'update']);
    Route::delete('/delete_salaryType/{id}', [SalariesController::class, 'delete_salaryType']);
});


Route::prefix('leave-types')->middleware(['auth:web,employee'])->group(function () {
    Route::get('/list', [LeaveTypesController::class, 'index']);
    Route::POST('/store', [LeaveTypesController::class, 'store']);
    Route::get('/edit/{id}', [LeaveTypesController::class, 'edit']);
    Route::post('/update/{id}', [LeaveTypesController::class, 'update']);
    Route::delete('/delete/{id}', [LeaveTypesController::class, 'destroy']);
});

Route::prefix('payslip-reports')->middleware(['auth:web,employee'])->group(function () {
    Route::get('/paye',[PayslipsReports::class, 'paye']);
    Route::get('/paye-tax', [PayslipsReports::class, 'paye_tax']); 
    Route::get('/bank-net-pay', [PayslipsReports::class, 'bank_net_pay']); 
    Route::get('/print-tier-one', [PayslipsReports::class, 'printTierOne']);  
});

Route::prefix('payslip-exports')->middleware(['auth:web,employee'])->group(function () {
    Route::get('/print-payslip/{id}/{action}', [PayslipExports::class, 'printPayslip']);
    
    Route::get('/email-payslip/{id}/{action}', [PayslipExports::class, 'emailPayslip']);
    Route::post('/bulk-email-payslip', [PayslipExports::class, 'bulkemailPayslip']);
    
    Route::post('/bulk-print-payslip', [PayslipExports::class, 'bulkprintPayslip']);
    Route::get('/download-pdfs/{id}/{zip?}', [PayslipExports::class, 'downloadPdfExports']);
    Route::post('/print-tier-one', [PayslipExports::class, 'print_tierOne']);
    Route::post('/print-tier-two', [PayslipExports::class, 'print_tierTwo']);
    Route::post('/generate-payee-report', [PayslipExports::class, 'generate_payee_report']);
    Route::post('/print-paye-tax', [PayslipExports::class, 'print_paye_tax']);
    Route::post('/print-bank-net-pay', [PayslipExports::class, 'print_bank_net_pay']);
});

Route::prefix('employees')->middleware(['auth:web,employee'])->group(function () {
    Route::get('/', [EmployeesController::class, 'index']);
    Route::post('/imports', [EmployeesController::class, 'import_employee']);
    Route::get('/create', [EmployeesController::class, 'create']);
    Route::post('/create', [EmployeesController::class, 'store']);
    Route::get('/edit/{id}', [EmployeesController::class, 'edit']);
    Route::post('/edit/{id}', [EmployeesController::class, 'update']);
    Route::delete('/delete/{id}', [EmployeesController::class, 'delete']);

    Route::get('/generatePayslip/{id}', [EmployeesController::class, 'generatePayslip']);
    Route::post('/savepayslip', [EmployeesController::class, 'savePayslip']);

    Route::get('/generate-monthly-payslip/{id}', [EmployeesController::class, 'generateMonthlyPayslip']);
    Route::get('/staff-generate-monthly-payslip/{id}', [EmployeesController::class, 'staffGenerateMonthlyPayslip']);
    Route::post('/generate-monthly-payslip', [EmployeesController::class, 'postMonthlyPayslip']);
    
    Route::post('/bulk-generate-monthly-payslip', [EmployeesController::class, 'bulkGenerate']);

    Route::get('/generateinitialPayslip/{id}', [EmployeesController::class, 'generateInitialPayslip']);
    
    Route::get('/list-groups', [EmployeesController::class, 'indexEmployeeGroup']);
    Route::post('/store_employeesGroup', [EmployeesController::class, 'store_employeesGroup']);
    Route::get('/edit_employeesGroup/{id}', [EmployeesController::class, 'editEmployeeGroup']);
    Route::post('/update_employeesGroup/{id}', [EmployeesController::class, 'updateEmployeeGroup']);
    Route::delete('/delete_employeesGroup/{id}', [EmployeesController::class, 'delete_employeesGroup']);

    Route::get('/assign-permissions/{id}', [EmployeesController::class, 'assignPermission']);
    Route::post('/assign-permissions/{id}', [EmployeesController::class, 'postAssignPermission']);
});

Route::prefix('packages')->middleware(['auth:web,employee'])->group(function () {
    Route::get('/list', [PackageController::class, 'index']);
    Route::POST('/store', [PackageController::class, 'store']);
    Route::get('/edit/{id}', [PackageController::class, 'edit']);
    Route::post('/update/{id}', [PackageController::class, 'update']);
    Route::delete('/delete/{id}', [PackageController::class, 'delete']);
});


Route::prefix('exports')->middleware(['auth:web,employee'])->group(function () {
    Route::get('/paye/{id}', [PayslipExports::class, 'paye']);
});

Route::prefix('leaves')->middleware(['auth:web,employee'])->group(function () {
    Route::get('/list', [LeavesController::class, 'index']);
    Route::get('/pendingLeaves', [LeavesController::class, 'pendingLeaves']);
    Route::get('/all-leaves', [LeavesController::class, 'allLeaves']);
    Route::POST('/store', [LeavesController::class, 'store']);
    Route::get('/edit/{id}', [LeavesController::class, 'edit']);
    Route::get('/approve/{id}', [LeavesController::class, 'approve']);
    Route::get('/decline/{id}', [LeavesController::class, 'decline']);
    Route::post('/update/{id}', [LeavesController::class, 'update']);
    Route::post('/updateStatus/{id}', [LeavesController::class, 'updateStatus']);
    Route::get('/employeeLeaves/{id}', [LeavesController::class, 'employeeLeaves']);
    Route::delete('/delete/{id}', [LeavesController::class, 'delete']);

    Route::get('/remaining-days/{id}', [LeavesController::class, 'remaining_leave_days']);
});


Route::prefix('communications')->middleware(['auth:web,employee'])->group(function () {
    Route::get('/list', [CommunicationsController::class, 'index']);
});

Route::prefix('communications')->middleware(['auth:web,employee'])->group(function () {
    Route::get('/emails', [EmailsController::class, 'index']);
    Route::get('/viewemail/{id}', [EmailsController::class, 'view']);
    Route::post('/sendMail', [EmailsController::class, 'sendMail']);
    Route::get('/bulkyMails', [EmailsController::class, 'send_bulkyMails']);
    Route::get('/mailSettings', [EmailsController::class, 'mailSettings']);
    Route::post('/store_mailSettings', [EmailsController::class, 'store_mailSettings']);
    Route::post('/send_bulkyEmails', [EmailsController::class, 'send_bulkyEmails']);

    Route::get('/email-templates', [EmailsController::class, 'email_templates']);
    Route::post('/create-email-template', [EmailsController::class, 'store_email_templates']);
    Route::get('/edit-template/{id}', [EmailsController::class, 'edit_template']);
    Route::get('/fetch-template-message/{id}', [EmailsController::class, 'fetch_template_message']);
    Route::post('/update-template/{id}', [EmailsController::class, 'update_template']);
    Route::delete('/delete-template/{id}', [EmailsController::class, 'delete_template']);
    Route::get('/view-template/{id}', [EmailsController::class, 'view_template']);
});

Route::prefix('staff')->middleware(['auth:web,employee'])->group(function () {
    Route::get('/index',    [StaffController::class, 'index']);
    Route::get('/settings',    [StaffController::class, 'settings']);
    Route::get('/payslip',  [StaffController::class, 'payslip']);
    Route::get('/allLeaves',   [StaffController::class, 'allLeaves']);
    Route::POST('/storeLeave', [StaffController::class, 'storeLeave']);
    Route::get('/paye', [StaffController::class, 'paye']);

    Route::get('/print-payslip/{id}/{action}', [StaffController::class, 'printPayslip']);

    Route::get('/leaves',   [StaffController::class, 'leaves']);
    Route::POST('/store-staff-leave', [LeavesController::class, 'store_staffLeave']);

    Route::get('/company-profile', [CompaniesController::class, 'company_profile']);
    Route::post('/storeCompany', [CompaniesController::class, 'updateCompany']);

    Route::get('/staff-contracts', [ContractsController::class, 'staff_contracts']);
    Route::post('/storeContract', [ContractsController::class, 'storeContract']);

    Route::get('/all-staff', [EmployeesController::class, 'all_staff']);
    Route::get('/edit-staff/{id}', [EmployeesController::class, 'edit_staff']);
    Route::post('/update-staff/{id}', [EmployeesController::class, 'update_staff']);

    Route::get('/staff-emails', [EmailsController::class, 'staff_emails']);
    Route::post('/sendMail', [EmailsController::class, 'staff_sendMail']);
    Route::post('/store_mailSettings', [EmailsController::class, 'store_mailSettings']);
    Route::post('/send_bulkyEmails', [EmailsController::class, 'staff_sendBulkyEmails']);

    Route::get('/email-templates', [EmailsController::class, 'staff_email_templates']);
    Route::post('/create-email-template', [EmailsController::class, 'staff_store_email_templates']);
    Route::get('/mail-settings', [EmailsController::class, 'staff_mailSettings']);
    Route::post('/store_mailSettings', [EmailsController::class, 'store_staffMailSettings']);

    Route::get('/set-as-admin',[AuthController::class, 'set_as_admin']);
    Route::get('/set-as-staff',[AuthController::class, 'set_as_staff']);
    
    Route::post('/post-assign-permissions/{id}', [EmployeesController::class, 'post_assign_permissions']);

    Route::get('index-milk', [StaffMilkController::class, 'index'])->name('staff.milk-index');
    Route::get('/add-milk-collection', [StaffMilkController::class, 'add_milk_collection'])->name('staff.milk.add-collection');
    Route::post('/store-milkCollection', [StaffMilkController::class, 'store_milkCollection']);
    Route::get('/all-milk-collection', [StaffMilkController::class, 'all_milk_collection']);


    //Center
    Route::get('/center-farmers/{id}', [StaffMilkController::class, 'center_farmers']);


});

Route::prefix('expenses')->middleware(['auth:web,employee'])->group(function () {
    Route::get('/list', [ExpensesController::class, 'index']);
    Route::get('/expense-types', [ExpensesController::class, 'expense_types']);
    Route::get('/staff-expenses',[ExpensesController::class, 'staff_expenses']);
    Route::get('/all-staff-expenses', [ExpensesController::class, 'all_staff_expenses']);
    Route::get('/all-expenses', [ExpensesController::class, 'all_expenses']);
    Route::get('/edit-status/{id}', [ExpensesController::class, 'edit_expense_status']);
    Route::get('/edit-status/{id}', [ExpensesController::class, 'edit_expense_status']);
    Route::get('/view-purpose/{id}', [ExpensesController::class, 'view_expensePurpose']);
    Route::get('/edit-staff-expense/{id}', [ExpensesController::class, 'edit_staff_expense']);
    Route::get('/edit-payment-status/{id}', [ExpensesController::class, 'edit_payment_status']);
    Route::post('/store-expenses-type', [ExpensesController::class, 'store_expenseTypes']);
    Route::post('/store-staffExpenseRequest', [ExpensesController::class, 'store_expenseRequest']);
    Route::post('/update-status/{id}', [ExpensesController::class, 'updateStatus']);
    Route::get('/approve-request/{id}', [ExpensesController::class, 'edit_expense_status']);
    Route::get('/decline-request/{id}', [ExpensesController::class, 'decline_expenseRequest']);
    Route::get('/update-payment-status/{id}', [ExpensesController::class, 'update_paymentStatus']);
    Route::post('/update-staff-expense/{id}',  [ExpensesController::class, 'update_staffExpense']);
    Route::post('/update-payment/{id}', [ExpensesController::class, 'update_paymentStatus']);
    Route::delete('/delete-expense-type/{id}', [ExpensesController::class, 'delete_expense_type']);
    Route::delete('/delete-expense/{id}', [ExpensesController::class, 'delete_expense']);
    Route::delete('/delete-staff-expense/{id}', [ExpensesController::class, 'delete_staff_expense']);
});

Route::get('/staff/login', [StaffController::class, 'login']);
Route::get('/staff/logout', [StaffController::class, 'logout']);
Route::post('/staff/login', [StaffController::class, 'authenticate']);

Route::get('/staff/staff-forgot-password', [StaffController::class, 'forgot_password']);

Route::get('/check-subscriptions', [Crons::class, 'checkSubscriptions']);

Route::get('/milk-analysis', [DashboardController::class, 'milk_analysis']);
Route::get('/monthly-milk-analysis', [DashboardController::class, 'monthly_milk_analysis']);
Route::get('/collection-center-analysis', [DashboardController::class, 'collection_center_analysis']);
Route::get('/center-statistics', [DashboardController::class, 'center_statistics']);
Route::get('/farmer-statistics', [DashboardController::class, 'farmer_statistics']);

Route::get('/monthly-sales-analysis', [DashboardController::class, 'monthly_sales_analysis']);

Route::get('/payment-analysis', [DashboardController::class, 'payment_analysis']);
    




