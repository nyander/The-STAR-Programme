<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ClientEnquiryController;
use App\Http\Controllers\ClientGoalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PerformanceCategoryController;
use App\Http\Controllers\PerformanceProfileController;
use App\Http\Controllers\PerformanceProfileTemplateController;
use App\Http\Controllers\PerformanceTemplateQuestionController;
use App\Http\Controllers\PostProgramController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('performance-profile-templates', PerformanceProfileTemplateController::class)->middleware(['auth', 'verified']);
Route::resource('feedbacks', PostProgramController::class)->middleware(['auth', 'verified']);

// Goals
Route::get('goals/{client}', [ClientGoalController::class, 'index'])->middleware(['auth', 'verified'])->name('goals.index');
Route::get('goals/create/{client}', [ClientGoalController::class, 'create'])->middleware(['auth', 'verified'])->name('goals.create');
Route::post('goals', [ClientGoalController::class, 'store'])->middleware(['auth', 'verified'])->name('goals.store');
Route::get('goals/{goal}', [ClientGoalController::class, 'show'])->middleware(['auth', 'verified'])->name('goals.show');
Route::get('goals/{goal}/edit', [ClientGoalController::class, 'edit'])->middleware(['auth', 'verified'])->name('goals.edit');
Route::put('goals/{goal}', [ClientGoalController::class, 'update'])->middleware(['auth', 'verified'])->name('goals.update');
Route::delete('goals/{goal}', [ClientGoalController::class, 'destroy'])->middleware(['auth', 'verified'])->name('goals.destroy');
Route::get('goals/{goal}/update-goal', [ClientGoalController::class, 'updateGoal'])->middleware(['auth', 'verified'])->name('goals.updateGoal');
Route::put('goals/{goal}/update-goal', [ClientGoalController::class, 'storeUpdateGoal'])->middleware(['auth', 'verified'])->name('goals.storeUpdateGoal');



Route::resource('performance-profile-templates.questions', PerformanceTemplateQuestionController::class)->only(['index','store','edit','destroy','update'])->middleware(['auth','verified']);


Route::resource('performance-profiles', PerformanceProfileController::class)->middleware(['auth','verified']);
Route::post('/performance-profiles/{performanceProfile}/add-feedback', [PerformanceProfileController::class, 'addFeedback'])->name('performance-profiles.addFeedback');
Route::post('/performance-profiles/search', [PerformanceProfileController::class, 'search'])->name('performance-profiles.search');
Route::get('/mark-as-read', [PerformanceProfileController::class, 'markAsRead'])->name('mark-as-read');
Route::get('/clear-read', [PerformanceProfileController::class, 'clearRead'])->name('clear-read');
Route::get('{user}/performance-profiles-admin', [PerformanceProfileController::class, 'adminIndex'])->middleware(['auth','verified'])->name('performance-profiles.adminIndex');
Route::get('/read-notification/{notification}', [PerformanceProfileController::class, 'readNotification'])->name('read-notification');

Route::get('enroll-client', [RegisteredUserController::class, 'createClient'])->middleware(['auth', 'permission:enroll-client'])->name('client.create'); 
Route::post('enroll-client', [RegisteredUserController::class, 'storeClient'])->middleware(['auth', 'permission:enroll-client'])->name('client.register');
Route::put('enroll-client/{client}', [RegisteredUserController::class, 'updateClient'])->name('client.update');


Route::get('program-completion/{id}', [UserController::class, 'completeContract'])->name('client.completion');
Route::put('program-completion/client/{id}', [UserController::class, 'storeCompleteContract'])->name('client.storeCompletion');
Route::put('program-completion/admin/{id}', [UserController::class, 'storeAdminCompletion'])->name('client.storeAdminCompletion');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

Route::get('clients', [UserController::class, 'clients'])->name('users.clients');

Route::get('clients/{client}/overview', [UserController::class, 'clientOverview'])->name('users.clientOverview');

Route::get('/files/create', [FileController::class, 'create'])->name('files.create');

Route::resource('categories', PerformanceCategoryController::class);


Route::post('/files', [FileController::class, 'store'])->name('files.store');

Route::get('/files/{id}', [FileController::class, 'show'])->name('files.show');

// routes/web.php

Route::get('/404', [ErrorController::class, 'notFound'])->name('notFound');


Route::middleware(['auth'])->group(function () {
    // Routes for creating and managing client enquiries
    Route::get('enquiries/create', [ClientEnquiryController::class, 'create'])->name('enquiries.create');
    Route::post('enquiries', [ClientEnquiryController::class, 'store'])->name('enquiries.store');
    Route::get('enquiries', [ClientEnquiryController::class, 'index'])->name('enquiries.index');
    Route::get('enquiries/{enquiry}', [ClientEnquiryController::class, 'show'])->name('enquiries.show');
    Route::post('enquiries/{enquiry}', [ClientEnquiryController::class, 'respond'])->name('enquiries.respond');
    
});
