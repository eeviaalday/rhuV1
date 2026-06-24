<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\MaternalController;
use App\Http\Controllers\ImmunizationController;
use App\Http\Controllers\MorbidityController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\FhsisController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BackupController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/first-time-register', [AuthController::class, 'showFirstTimeRegister'])->name('first.time.register');
Route::post('/first-time-register', [AuthController::class, 'firstTimeRegister']);

Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.forgot');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::get('/verify-questions', [AuthController::class, 'showVerifyQuestions'])->name('password.verify.questions');
Route::post('/verify-questions', [AuthController::class, 'verifyQuestions']);
Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])->name('password.reset.form');
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::middleware(['auth'])->group(function () {
    Route::get('/password-change', [AuthController::class, 'showPasswordChangeForm'])->name('password.change.form');
    Route::post('/password-change', [AuthController::class, 'changePassword'])->name('password.change');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
    
    // Patient Records
    Route::resource('patients', PatientController::class);
    Route::get('/patients/{patient}/medical-background', [PatientController::class, 'medicalBackground'])->name('patients.medical_background');
    Route::post('/patients/{patient}/medical-background', [PatientController::class, 'storeMedicalBackground']);
    Route::get('/patients/{patient}/print', [PatientController::class, 'print'])->name('patients.print');
    
    // Consultations
    Route::resource('consultations', ConsultationController::class);
    Route::get('/consultations/{consultation}/print', [ConsultationController::class, 'print'])->name('consultations.print');
    
    // Maternal Care
    Route::resource('maternal', MaternalController::class);
    Route::get('/maternal/{maternalCase}/visits/create', [MaternalController::class, 'createVisit'])->name('maternal.visits.create');
    Route::post('/maternal/{maternalCase}/visits', [MaternalController::class, 'storeVisit'])->name('maternal.visits.store');
    Route::get('/maternal/{maternalCase}/visits/{prenatalVisit}', [MaternalController::class, 'showVisit'])->name('maternal.visits.show');
    
    // Immunizations
    Route::resource('immunizations', ImmunizationController::class);
    
    // Morbidity
    Route::resource('morbidity', MorbidityController::class);
    
    // Archive
    Route::get('/archive', [ArchiveController::class, 'index'])->name('archive.index');
    Route::post('/archive/{patient}/restore', [ArchiveController::class, 'restore'])->name('archive.restore');
    Route::get('/archive/export-csv', [ArchiveController::class, 'exportCsv'])->name('archive.export');
    
    // FHSIS Reports
    Route::get('/fhsis', [FhsisController::class, 'index'])->name('fhsis.index');
    Route::get('/fhsis/m1', [FhsisController::class, 'm1'])->name('fhsis.m1');
    Route::get('/fhsis/m2', [FhsisController::class, 'm2'])->name('fhsis.m2');
    Route::get('/fhsis/quarterly', [FhsisController::class, 'quarterly'])->name('fhsis.quarterly');
    Route::get('/fhsis/annual', [FhsisController::class, 'annual'])->name('fhsis.annual');
    Route::get('/fhsis/pdf/{type}', [FhsisController::class, 'exportPdf'])->name('fhsis.pdf');
    Route::get('/fhsis/print', [FhsisController::class, 'print'])->name('fhsis.print');
    
    // User Management
    Route::resource('users', UserManagementController::class);
    Route::post('/users/{user}/reset-password', [UserManagementController::class, 'resetPassword'])->name('users.reset_password');
    
    // Account Management
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::post('/account/update-profile', [AccountController::class, 'updateProfile'])->name('account.update_profile');
    
    // Backup & Restore
    Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
    Route::post('/backup/run', [BackupController::class, 'run'])->name('backup.run');
    Route::post('/backup/restore', [BackupController::class, 'restore'])->name('backup.restore');
    Route::post('/backup/settings', [BackupController::class, 'updateSettings'])->name('backup.settings');
});

// User Routes
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'userDashboard'])->name('dashboard');
    
    Route::resource('patients', PatientController::class);
    Route::get('/patients/{patient}/medical-background', [PatientController::class, 'medicalBackground'])->name('patients.medical_background');
    Route::post('/patients/{patient}/medical-background', [PatientController::class, 'storeMedicalBackground']);
    Route::get('/patients/{patient}/print', [PatientController::class, 'print'])->name('patients.print');
    
    Route::resource('consultations', ConsultationController::class);
    Route::get('/consultations/{consultation}/print', [ConsultationController::class, 'print'])->name('consultations.print');
    
    Route::resource('maternal', MaternalController::class);
    Route::get('/maternal/{maternalCase}/visits/create', [MaternalController::class, 'createVisit'])->name('maternal.visits.create');
    Route::post('/maternal/{maternalCase}/visits', [MaternalController::class, 'storeVisit'])->name('maternal.visits.store');
    Route::get('/maternal/{maternalCase}/visits/{prenatalVisit}', [MaternalController::class, 'showVisit'])->name('maternal.visits.show');
    
    Route::resource('immunizations', ImmunizationController::class);
    Route::resource('morbidity', MorbidityController::class);
    
    Route::get('/archive', [ArchiveController::class, 'index'])->name('archive.index');
    Route::post('/archive/{patient}/restore', [ArchiveController::class, 'restore'])->name('archive.restore');
    Route::get('/archive/export-csv', [ArchiveController::class, 'exportCsv'])->name('archive.export');
    
    Route::get('/fhsis', [FhsisController::class, 'index'])->name('fhsis.index');
    Route::get('/fhsis/m1', [FhsisController::class, 'm1'])->name('fhsis.m1');
    Route::get('/fhsis/m2', [FhsisController::class, 'm2'])->name('fhsis.m2');
    Route::get('/fhsis/quarterly', [FhsisController::class, 'quarterly'])->name('fhsis.quarterly');
    Route::get('/fhsis/annual', [FhsisController::class, 'annual'])->name('fhsis.annual');
    Route::get('/fhsis/pdf/{type}', [FhsisController::class, 'exportPdf'])->name('fhsis.pdf');
    Route::get('/fhsis/print', [FhsisController::class, 'print'])->name('fhsis.print');
    
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::post('/account/update-profile', [AccountController::class, 'updateProfile'])->name('account.update_profile');
    Route::post('/account/change-password', [AccountController::class, 'changePassword'])->name('account.change_password');
});
