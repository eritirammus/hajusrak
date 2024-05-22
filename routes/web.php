<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NekoController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\store;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/weather', function () {

    if (Cache::has('key') === false) {
        $response = Http::get('https://api.openweathermap.org/data/2.5/weather?lat=58.025842&lon=22.089151&appid=fb66fb3d5a8a7748bb11b05017d1de77&units=metric');
        Cache::put('key', $response->json(), now()->addMinutes(15));
    }
    return Inertia::render('Weather', [
        'weather' => Cache::get('key')
    ]);
})->name('weather');

Route::prefix('/getapi')->group(function () {
    Route::get('/ralf', function () {

        if (Cache::has('ralf') === false) {
            $response = Http::get('https://hajus.ta19heinsoo.itmajakas.ee/api/movies');
            Cache::put('ralf', $response->json(), now()->addMinutes(15));
        }
        return Inertia::render('Ralf', [
            'ralf' => Cache::get('ralf')
        ]);
    })->name('ralf');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(MapController::class)->name('map. ')->group(function () {
    Route::get('/map', 'index')->name('index');
    Route::post('/add-marker', 'store')->name('store');
    Route::put('/update-marker', 'update')->name('update');
    Route::delete('/destroy-marker', 'destroy')->name('destroy');
});
Route::resource('maps', MapController::class);
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::resource('comments', CommentController::class)
    ->middleware(['auth', 'verified']);

Route::get('/store', [store::class, 'index'])->name('store');
Route::post('/addtocart', [store::class, 'addtocart'])->name('addcart');
Route::get('/cart', [store::class, 'cart'])->name('cart');
Route::post('/updatecart', [store::class, 'updatecart'])->name('updatecart');
Route::post('/deleteitem', [store::class, 'deleteitem'])->name('deleteitem');
Route::post('/subscribe', [store::class, 'subscribe'])->name('subscribe');
Route::post('/success', [store::class, 'success'])->name('success');



Route::get('/products', [ProductsController::class, 'index'])->middleware(['auth'])->name('products');
Route::get('/products/add', [ProductsController::class, 'create'])->middleware(['auth'])->name('products.add');
Route::post('/products/store', [ProductsController::class, 'store'])->middleware(['auth'])->name('products.store');
Route::get('/products/edit/{id}', [ProductsController::class, 'edit'])->middleware(['auth'])->name('products.edit');
Route::post('/products/update', [ProductsController::class, 'update'])->middleware(['auth'])->name('products.update');
Route::post('/products/delete', [ProductsController::class, 'destroy'])->middleware(['auth'])->name('products.delete');


require __DIR__ . '/auth.php';
