<?php
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\Admin\CarouselSlideController;
use App\Http\Controllers\Admin\CenterInformationController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ServiceController; 
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\Admin\RequirementController;
use App\Http\Controllers\Admin\ClassesController as adminClassesController;
use App\Http\Controllers\User\ClassesController as userClassesController;
use App\Http\Controllers\User\MembershipController as UserMembershipController;
use App\Http\Controllers\Admin\MembershipController as AdminMembershipController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\User\PaymentHistoryController as UserPaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

// Rutas públicas: login y registro
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Redirigir automáticamente a login si acceden a la raíz
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas para administrador
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
     // Rutas para servicios
    Route::resource('services', ServiceController::class);
    // Gestión de usuarios
    Route::resource('users', UsersController::class);
});

// Rutas para instructor
Route::middleware(['auth', 'role:instructor'])->prefix('instructor')->name('instructor.')->group(function () {
    Route::get('/dashboard', [InstructorController::class, 'dashboard'])->name('dashboard');
});


// Rutas para usuario (cliente)
Route::middleware(['auth', 'role:usuario'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UsersController::class, 'dashboard'])->name('dashboard');
});


// Rutas de membresía
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    // Rutas resource para ver membresías
Route::resource('memberships', UserMembershipController::class)->only(['index', 'show']);
    // Rutas adicionales para pagar una membresía
Route::get('memberships/{membership}/pay', [UserMembershipController::class, 'pay'])->name('memberships.pay');
Route::post('memberships/{membership}/pay', [UserMembershipController::class, 'processPayment'])->name('memberships.process');
});

Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::resource('memberships', UserMembershipController::class)->only(['index']);
    // Vista para subir comprobante
    Route::get('payments/{membership}/upload', [UserMembershipController::class, 'uploadReceipt'])->name('payments.upload');
    // Guardar comprobante
    Route::post('payments/store', [UserMembershipController::class, 'storeReceipt'])->name('payments.store');
});

Route::middleware(['auth', 'can:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('memberships', AdminMembershipController::class);
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('requirements', RequirementController::class);
});

Route::middleware(['auth', 'can:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('classes', AdminClassesController::class);
    Route::get('classes/{class}/registrations', [AdminClassesController::class, 'registrations'])
        ->name('classes.registrations');
});

Route::middleware(['auth', 'can:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('payments', AdminPaymentController::class)->only(['index', 'show', 'update']);
    Route::post('payments/{payment}/approve', [AdminPaymentController::class, 'approve'])->name('payments.approve');
    Route::post('payments/{payment}/reject', [AdminPaymentController::class, 'reject'])->name('payments.reject');
    Route::get('/report', [AdminPaymentController::class, 'generateReport'])->name('payments.report'); 
});

// Grupo de rutas con prefijo 'user'
Route::prefix('user')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/payments', [UserPaymentController::class, 'index'])->name('user.payments.index');
    Route::get('/payments/{id}', [UserPaymentController::class, 'show'])->name('user.payments.show');
});

// Ruta para historial, diferente URL pero mismo controlador
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/history', [UserPaymentController::class, 'index'])
        ->name('user.history');
});



// Rutas accesibles solo con autenticación (sin necesidad de membresía activa)
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/history', [UserClassesController::class, 'history'])->name('history');
});

// Rutas que requieren membresía activa y vigente
Route::middleware(['auth', 'check.membership'])->prefix('user')->name('user.')->group(function () { 
    Route::get('/classes', [UserClassesController::class, 'index'])->name('classes.index');
    Route::post('/classes/register/{id}', [UserClassesController::class, 'reserve'])->name('classes.register');
    Route::delete('/classes/cancel/{id}', [UserClassesController::class, 'cancelReservation'])->name('classes.cancel');
    Route::post('/classes/rate/{registration}', [UserClassesController::class, 'rate'])->name('classes.rate');
    // Esta es la ruta correcta para el historial:
    Route::get('/classes/history', [UserClassesController::class, 'history'])->name('classes.history');
});

//Rutas para recuperacion de password
// Mostrar formulario para solicitar enlace
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
// Enviar el enlace al correo
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
// Mostrar formulario para establecer nueva contraseña
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
// Guardar nueva contraseña
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Página de servicios para la home (CMS)
    Route::resource('service', ServiceController::class);
    // Información del centro (CMS)
    Route::resource('center-information', CenterInformationController::class)
        ->except(['show']);
});


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('carousel', CarouselSlideController::class);
    Route::post('carousel/settings', [CarouselSlideController::class, 'updateSettings'])->name('carousel.updateSettings');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('carousel', CarouselSlideController::class);
});

Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
