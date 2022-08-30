<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\CareersController;
use App\Http\Controllers\Admin\ClientsController;
use App\Http\Controllers\Admin\ContactsController;
use App\Http\Controllers\Admin\FavourDetailsController;
use App\Http\Controllers\Admin\FooterController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\MediasController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PartnersController;
use App\Http\Controllers\Admin\PatronagesController;
use App\Http\Controllers\Admin\FavoursController;
use App\Http\Controllers\Admin\SocialController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\ValuesController;
use App\Http\Controllers\Admin\WhalesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::group(['prefix' => '/news', 'as' => 'news.'], function () {
    Route::get('/', [NewsController::class, 'index'])->name('index');
    Route::get('/create', [NewsController::class, 'create'])->name('create');
    Route::get('/{news}', [NewsController::class, 'edit'])->name('edit');
    Route::post('/{news?}', [NewsController::class, 'store'])->name('store');
    Route::put('/{news}', [NewsController::class, 'update'])->name('update');
    Route::delete('/{news}', [NewsController::class, 'delete'])->name('delete');

});

Route::group(['prefix' => '/team', 'as' => 'team.'], function () {
    Route::get('/', [TeamController::class, 'index'])->name('index');
    Route::get('/create', [TeamController::class, 'create'])->name('create');
    Route::get('/{member}', [TeamController::class, 'edit'])->name('edit');
    Route::post('/{member?}', [TeamController::class, 'store'])->name('store');
    Route::put('/{member}', [TeamController::class, 'update'])->name('update');
    Route::delete('/{member}', [TeamController::class, 'delete'])->name('delete');

});

Route::group(['prefix' => '/clients', 'as' => 'clients.'], function () {
    Route::get('/', [ClientsController::class, 'index'])->name('index');
    Route::get('/create', [ClientsController::class, 'create'])->name('create');
    Route::get('/{client}', [ClientsController::class, 'edit'])->name('edit');
    Route::post('/{client?}', [ClientsController::class, 'store'])->name('store');
    Route::put('/{client}', [ClientsController::class, 'update'])->name('update');
    Route::delete('/{client}', [ClientsController::class, 'delete'])->name('delete');

});

Route::group(['prefix' => '/contacts', 'as' => 'contacts.'], function () {
    Route::get('/', [ContactsController::class, 'index'])->name('index');
    Route::get('/create', [ContactsController::class, 'create'])->name('create');
    Route::get('/{contact}', [ContactsController::class, 'edit'])->name('edit');
    Route::post('/{contact?}', [ContactsController::class, 'store'])->name('store');
    Route::put('/{contact}', [ContactsController::class, 'update'])->name('update');
    Route::delete('/{contact}', [ContactsController::class, 'delete'])->name('delete');

});

Route::group(['prefix' => '/partners', 'as' => 'partners.'], function () {
    Route::get('/', [PartnersController::class, 'index'])->name('index');
    Route::get('/create', [PartnersController::class, 'create'])->name('create');
    Route::get('/{partner}', [PartnersController::class, 'edit'])->name('edit');
    Route::post('/{partner?}', [PartnersController::class, 'store'])->name('store');
    Route::put('/{partner}', [PartnersController::class, 'update'])->name('update');
    Route::delete('/{partner}', [PartnersController::class, 'delete'])->name('delete');

});

Route::group(['prefix' => '/patronages', 'as' => 'patronages.'], function () {
    Route::get('/', [PatronagesController::class, 'index'])->name('index');
    Route::get('/create', [PatronagesController::class, 'create'])->name('create');
    Route::get('/{patronage}', [PatronagesController::class, 'edit'])->name('edit');
    Route::post('/{patronage?}', [PatronagesController::class, 'store'])->name('store');
    Route::put('/{patronage}', [PatronagesController::class, 'update'])->name('update');
    Route::delete('/{patronage}', [PatronagesController::class, 'delete'])->name('delete');
    Route::delete('/detailPicture/{patronage}',
        [PatronagesController::class, 'deleteDetailPicture'])->name('deletePicture');

});

Route::group(['prefix' => '/careers', 'as' => 'careers.'], function () {
    Route::get('/', [CareersController::class, 'index'])->name('index');
    Route::put('/{career?}', [CareersController::class, 'update'])->name('update');

    Route::group(['prefix' => '/values', 'as' => 'values.'], function () {
        Route::get('/create', [ValuesController::class, 'create'])->name('create');
        Route::get('/{value}', [ValuesController::class, 'edit'])->name('edit');
        Route::post('/{value?}', [ValuesController::class, 'store'])->name('store');
        Route::put('/{value}', [ValuesController::class, 'update'])->name('update');
        Route::delete('/{value}', [ValuesController::class, 'delete'])->name('delete');
    });

});

Route::group(['prefix' => '/about', 'as' => 'about.'], function () {
    Route::get('/', [AboutController::class, 'index'])->name('index');
    Route::get('/create', [AboutController::class, 'create'])->name('create');
    Route::get('/{aboutBlock}', [AboutController::class, 'edit'])->name('edit');
    Route::post('/{aboutBlock?}', [AboutController::class, 'store'])->name('store');
    Route::put('/{aboutBlock}', [AboutController::class, 'update'])->name('update');
    Route::delete('/{aboutBlock}', [AboutController::class, 'delete'])->name('delete');

});

Route::group(['prefix' => '/favours', 'as' => 'favours.'], function () {
    Route::get('/', [FavoursController::class, 'index'])->name('index');
    Route::get('/create', [FavoursController::class, 'create'])->name('create');
    Route::get('/{favour}', [FavoursController::class, 'edit'])->name('edit');
    Route::post('/{favour?}', [FavoursController::class, 'store'])->name('store');
    Route::put('/{favour}', [FavoursController::class, 'update'])->name('update');
    Route::delete('/{favour}', [FavoursController::class, 'delete'])->name('delete');

});

Route::group(['prefix' => '/medias', 'as' => 'medias.'], function () {
    Route::delete('/{mediaID}', [MediasController::class, 'delete'])->name('delete');
});

Route::group(['prefix' => '/favour_detail', 'as' => 'favour_detail.'], function () {
    Route::delete('/{detailID}', [FavourDetailsController::class, 'delete'])->name('delete');
});

Route::group(['prefix' => '/main', 'as' => 'main.'], function () {
    Route::get('/', [MainController::class, 'index'])->name('index');
    Route::put('/{main?}', [MainController::class, 'update'])->name('update');
    Route::post('/{main?}', [MainController::class, 'store'])->name('store');
});

Route::group(['prefix' => '/footer', 'as' => 'footer.'], function () {
    Route::get('/', [FooterController::class, 'index'])->name('index');
    Route::put('/{footer?}', [FooterController::class, 'update'])->name('update');
    Route::post('/{footer?}', [FooterController::class, 'store'])->name('store');
});

Route::group(['prefix' => '/social', 'as' => 'social.'], function () {
    Route::delete('/{socialID}', [SocialController::class, 'delete'])->name('delete');
});

Route::group(['prefix' => '/whales', 'as' => 'whales.'], function () {
    Route::get('/', [WhalesController::class, 'index'])->name('index');
    Route::get('/create', [WhalesController::class, 'create'])->name('create');
    Route::get('/{whale}', [WhalesController::class, 'edit'])->name('edit');
    Route::post('/{whale?}', [WhalesController::class, 'store'])->name('store');
    Route::put('/{whale}', [WhalesController::class, 'update'])->name('update');
    Route::delete('/{whale}', [WhalesController::class, 'delete'])->name('delete');

});
