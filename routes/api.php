<?php

use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [Controllers\AuthController::class, 'register']);
Route::post('/login', [Controllers\AuthController::class, 'login']);

Route::resource("/user", Controllers\UserController::class)->only(['index', 'show']);
Route::resource("/category", Controllers\CategoryController::class)->only(['index', 'show']);
Route::resource("/topic", Controllers\TopicController::class)->only(['index', 'show']);
Route::resource('/test', Controllers\TestController::class)->only(['index', 'show']);
Route::resource('/question', Controllers\QuestionController::class)->only(['index', 'show']);
Route::resource('/choice', Controllers\ChoiceController::class)->only(['index', 'show']);



Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/logout', [Controllers\AuthController::class, 'logout']);
    Route::resource("/user", Controllers\UserController::class)->only(['store', 'update', 'destroy']);
    Route::resource("/category", Controllers\CategoryController::class)->only(['store', 'update', 'destroy']);
    Route::resource("/topic", Controllers\TopicController::class)->only(['store', 'update', 'destroy']);
    Route::resource('/test', Controllers\TestController::class)->only(['store', 'update', 'destroy']);
    Route::resource('/question', Controllers\QuestionController::class)->only(['store', 'update', 'destroy']);
    Route::resource('/choice', Controllers\ChoiceController::class)->only(['store', 'update', 'destroy']);
});

//route to test apis
Route::post('/save-image', function (Request $request) {
    return ImageController::store($request);
});
Route::post('/test-question', function (Request $request) {
    $ans_arr = ['A', "B", 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
    $questions = $request->input('questions');
    foreach ($questions as $q_index => $question) {
        echo "<br>Câu " . (++$q_index) . ": " . $question["content"] . "<br>";
        $choices = $question["choices"];
        foreach ($choices as $c_index => $choice) {
            if ($choice['is_answer']) {
                echo "<b>" . $ans_arr[$c_index] . ". " . $choice["content"] . "</b><br>";
            } else {
                echo $ans_arr[$c_index] . ". " . $choice["content"] . "<br>";
            }
        }
    }
});
