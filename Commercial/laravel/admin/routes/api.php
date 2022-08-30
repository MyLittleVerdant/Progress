<?php

use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\Api\CareersController;
use App\Http\Controllers\Api\ClientsController;
use App\Http\Controllers\Api\ContactsController;
use App\Http\Controllers\Api\FavoursController;
use App\Http\Controllers\Api\FooterController;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\PartnersController;
use App\Http\Controllers\Api\PatronagesController;
use App\Http\Controllers\Api\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/newsList', [NewsController::class, 'getNews'])->name('newsList');
Route::get('/newsList/{news}', [NewsController::class, 'getSpecificNews'])->name('news');

Route::get('/teamListPage', [TeamController::class, 'getTeamByPage'])->name('teamListByPage');
Route::get('/teamList', [TeamController::class, 'getTeam'])->name('teamList');

Route::get('/clientsListPage', [ClientsController::class, 'getClientsByPage'])->name('clientsListByPage');
Route::get('/clientsList', [ClientsController::class, 'getClients'])->name('clientsList');

Route::get('/contactsListPage', [ContactsController::class, 'getContactsByPage'])->name('contactsListByPage');
Route::get('/contactsList', [ContactsController::class, 'getContacts'])->name('contactsList');

Route::get('/partnersListPage', [PartnersController::class, 'getPartnersByPage'])->name('partnersListByPage');
Route::get('/partnersList', [PartnersController::class, 'getPartners'])->name('partnersList');

Route::get('/patronagesListPage', [PatronagesController::class, 'getPatronagesByPage'])->name('patronagesListByPage');
Route::get('/patronagesList', [PatronagesController::class, 'getPatronages'])->name('patronagesList');

Route::get('/careersListPage', [CareersController::class, 'getCareersByPage'])->name('careersListByPage');
Route::get('/careersList', [CareersController::class, 'getCareers'])->name('careersList');

Route::get('/aboutListPage', [AboutController::class, 'getAboutByPage'])->name('aboutListByPage');
Route::get('/aboutList', [AboutController::class, 'getAbout'])->name('aboutList');

Route::get('/favoursList', [FavoursController::class, 'getFavours'])->name('favoursList');
Route::get('/favourByKey', [FavoursController::class, 'getFavourByKey'])->name('favourByKey');

Route::get('/mainList', [MainController::class, 'getMain'])->name('mainList');

Route::get('/footerList', [FooterController::class, 'getFooter'])->name('footerList');


