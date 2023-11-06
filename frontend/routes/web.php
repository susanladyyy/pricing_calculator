<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalculationController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseVersionController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\FormulaController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\ParameterFormulaController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\UserController;
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

Route::group(['middleware' => 'auth'], function () {
    // History
    Route::get('/history', [HistoryController::class, 'index'])->name('history');

    // Courses Routes
    Route::get('/', [CourseController::class, 'index'])->name('index');
    Route::get('/detail/{version}', [DetailController::class, 'index'])->name('detail');
    Route::get('/insert-course', [CourseController::class, 'insertCourseView'])->name('insertCourseView');
    Route::post('/insert-course', [CourseController::class, 'insertCourse'])->name('postInsertCourse');
    Route::post('/add-new-version', [CourseController::class, 'insertNewVersion'])->name('insertNewVersion');

    Route::get('/search-course', [CourseController::class, 'searchCourse']);
    Route::get('/update-course/{id}', [CourseController::class, 'updateCourseView'])->name('updateCourse');
    Route::post('/update-course{id}', [CourseController::class, 'updateCourse'])->name('postUpdateCourse');
    Route::delete('/delete-course/{id}', [CourseController::class, 'deleteCourse'])->name('deleteCourse');

    // Parameter Routes
    Route::post('/update-param', [ParameterController::class, 'updateParameterContent'])->name('detail.updateParam');
    Route::post('/get-calculation-data', [ParameterController::class, 'getCalculationData'])->name('detail.getCalculationData');
    Route::get('add-new-parameter/{versionId}/{calculationTypeId}', [ParameterController::class, 'addNewParameterView'])->name('addNewParameter');
    Route::post('add-new-parameter/{versionId}/{calculationTypeId}', [ParameterController::class, 'addNewParameter'])->name('addNewParameterPost');
    Route::get('/add-sub-parameter/{parameterId}/{calculationTypeId}/{versionId}', [ParameterController::class, 'addNewSubParameterView'])->name('addNewSubParameter');
    Route::post('/add-sub-parameter/{parameterId}/{calculationTypeId}/{versionId}', [ParameterController::class, 'addNewSubParameter'])->name('addNewSubParameterPost');
    Route::delete('delete-sub-parameter/{childParameterId}', [ParameterController::class, 'deleteSubParameter'])->name('deleteSubParameter');
    Route::delete('delete-sub-parent-parameter/{parentParameterId}', [ParameterController::class, 'deleteSubParentParameter'])->name('deleteSubParentParameter');
    Route::get('/update-parameter/{parameterId}', [ParameterController::class, 'updateParameterView'])->name('updateParameter');
    Route::post('/update-parameter/{parameterId}', [ParameterController::class, 'updateParameter'])->name('updateParameterPost');

    // Calculation Routes
    Route::post('/update/{version}', [CalculationController::class, 'saveCalculation'])->name('detail.update');
    Route::post('/save-calculation/{versionId}', [CalculationController::class, 'saveToHistory']);
    Route::delete('/delete-history/{historyId}', [HistoryController::class, 'deleteHistory']);

    // Formula Routes
    Route::get('/edit-formula/{version}/{calculationTypeId}', [FormulaController::class, 'index'])->name('editFormulaView');
    Route::post('/edit-formula/{version}/{calculationTypeId}', [FormulaController::class, 'editFormula'])->name('editFormula');

    // ParameterFormula Routes
    Route::post('/get-parameter-formula', [ParameterFormulaController::class, 'getFromParameter'])->name('detail.getParameterFormula');

    // User Routes
    Route::get('/insert-user', [UserController::class, 'insertView'])->name('insertUser');
    Route::get('/update-user/{id}', [UserController::class, 'updateView'])->name('updateUser');
    Route::post('/insert-user', [UserController::class, 'insertUser'])->name('postInsertUser');
    Route::post('/update-user/{id}', [UserController::class, 'updateUser'])->name('postUpdateUser');
    Route::delete('/delete-user/{id}', [UserController::class, 'deleteUser'])->name('deleteUser');
    Route::get('/search-user', [CourseController::class, 'searchUser']);

    // University Routes
    Route::get('/insert-university', [UniversityController::class, 'universityInsertView'])->name('insertUniversity');
    Route::get('/update-university/{id}', [UniversityController::class, 'universityUpdateView'])->name('updateUniversity');
    Route::post('/insert-university', [UniversityController::class, 'insertUniversity'])->name('postInsertUniversity');
    Route::post('/update-university/{id}', [UniversityController::class, 'updateUniversity'])->name('postUpdateUniversity');
    Route::delete('/delete-university/{id}', [UniversityController::class, 'deleteUniversity'])->name('deleteUniversity');
    Route::get('/search-university', [CourseController::class, 'searchUniversity']);
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginPage'])->name('login');
Route::post('/postLogin', [AuthController::class, 'login'])->name('postLogin');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
