<?php
use App\Http\Controllers\AuthController;
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

Route::view('/', 'welcome');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');


Route::middleware([

    ])->group(function () {
         Route::get('/dashboard', function () {
           if (auth()->user()->role == 1) {
            return redirect()->route('admin-dashboard');
           }
           if (auth()->user()->role == 2) {
            return redirect()->route('rider-dashboard');
           }
           else{
            return redirect()->route('user-dashboard');
           }
         })->name('userdashboard');

    });

    Route::prefix('admin')->middleware('admin')->group(function(){

        Route::get('/admin', function(){
            return view('admin.index');
        })->name('admin-dashboard');

        Route::get('/add-products', function(){
            return view('admin.add-products');
        })->name('add-products');

        Route::get('/add-rider', function(){
            return view('admin.add-rider');
        })->name('add-rider');

        Route::get('/orders', function(){
            return view('admin.orders');
        })->name('orders');

        Route::get('/assignorders', function(){
            return view('admin.assignorders');
        })->name('assignorders');

        Route::get('/pos', function(){
            return view('admin.pos');
        })->name('pos');

        Route::get('/feeback', function(){
            return view('admin.feedback');
        })->name('feedback');

        Route::get('/inventory', function(){
            return view('admin.inventory');
        })->name('inventory');

     });

     Route::prefix('rider')->middleware('rider')->group(function(){

        Route::get('/rider', function(){
            return view('rider.index');
        })->name('rider-dashboard');

        Route::get('/assignorders', function(){
            return view('rider.assignorders');
        })->name('assign');




     });

     Route::prefix('user')->middleware('user')->group(function(){

        Route::get('/user', function(){
            return view('user.index');
        })->name('user-dashboard');

        Route::get('/products', function(){
            return view('user.products');
        })->name('products');

        Route::get('/carts', function(){
            return view('user.carts');
        })->name('carts');

        Route::get('/order', function(){
            return view('user.order');
        })->name('order');

        Route::get('/promos', function(){
            return view('user.promos');
        })->name('promos');


     });

     Route::get('/', function () {
        return redirect()->route('login');
    });
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
require __DIR__.'/auth.php';
