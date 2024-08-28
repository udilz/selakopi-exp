<?php


use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\FoodController;
use App\Http\Controllers\backend\OrderController;
use App\Http\Controllers\backend\TableController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\frontend\CustomerOrderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;


//Route Configure
Route::get('storage-link', function () {
    Artisan::call('storage:link');
    return 'Berhasil Di Storage Link !';
});

Route::get('config-cache', function () {
    Artisan::call('config:cache');
    return 'Berhasil Di Config Cache !';
});

Route::get('route-cache', function () {
    Artisan::call('route:cache');
    return 'Berhasil Di Route Cache !';
});

Route::get('cache-clear', function () {
    Artisan::call('cache:clear');
    return 'Berhasil Di Cache Clear !';
});

Route::get('route-cache', function () {
    Artisan::call('route:cache');
    return 'Berhasil Di Route Cache !';
});

//Route Frontend Orderan Pelanggan;
Route::get('orderan-pelanggan/no_meja/{no_meja}', [CustomerOrderController::class, 'meja1'])->name('pelanggan.meja1');
Route::post('orderan-pelanggan/checkout', [CustomerOrderController::class, 'store'])->name('pelanggan.store');
Route::get('status-orderan-pelanggan/no-meja/{no_meja}', [CustomerOrderController::class, 'status_orderan'])->name('pelanggan.status_orderan');
Route::get('detail-orderan-pelanggan/no_meja/{no_meja}/{created_at}', [CustomerOrderController::class, 'detail'])->name('pelanggan.detail_orderan');

//Route Backend
Route::get('/home', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('laporanPenjualan', [DashboardController::class, 'laporanPenjualan'])->name('dashboard.laporanPenjualan');


//Route Backend Kategori Makanan
Route::get('kategori', [CategoryController::class, 'index'])->name('kategori')->middleware('auth');
Route::get('fetch-kategori', [CategoryController::class, 'fetch_category'])->name('kategori.fetch')->middleware('auth');
Route::post('kategori', [CategoryController::class, 'store'])->name('kategori.store');
Route::get('edit-kategori', [CategoryController::class, 'edit'])->name('kategori.edit');
Route::post('edit-kategori', [CategoryController::class, 'update'])->name('kategori.update');
Route::post('delete-kategori', [CategoryController::class, 'destroy'])->name('kategori.destroy');
Route::get('ajax-categories-search', [CategoryController::class, 'ajaxSearch'])->name('kategori.ajaxSearch');

//Route Backend Makanan & Minuman
Route::get('makanan-dan-minuman', [FoodController::class, 'index'])->name('makanan');
Route::get('fetch-makanan-dan-minuman', [FoodController::class, 'fetch_makanan'])->name('makanan.fetch');
Route::post('makanan-dan-minuman', [FoodController::class, 'store'])->name('makanan.store');
Route::get('edit-makanan-dan-minuman', [FoodController::class, 'edit'])->name('makanan.edit');
Route::post('edit-makanan-dan-minuman', [FoodController::class, 'update'])->name('makanan.update');
Route::post('delete-makanan-dan-minuman', [FoodController::class, 'destroy'])->name('makanan.destroy');
Route::get('ajax-makanan-dan-minuman-search', [FoodController::class, 'ajaxSearch'])->name('makanan.ajaxSearch');
Route::get('kategori-makanan/{slug}', [FoodController::class, 'kategori_makanan'])->name('makanan.kategori');

//Route Backend Table;
Route::get('meja-makan', [TableController::class, 'index'])->name('meja');
Route::get('fetch-meja-makan', [TableController::class, 'fetch_meja_makan'])->name('meja.fetch');
Route::post('meja-makan', [TableController::class, 'store'])->name('meja.store');
Route::get('edit-meja-makan', [TableController::class, 'edit'])->name('meja.edit');
Route::post('edit-meja-makan', [TableController::class, 'update'])->name('meja.update');
Route::post('delete-meja-makan', [TableController::class, 'destroy'])->name('meja.destroy');
Route::get('ajax-meja-makan-search', [TableController::class, 'ajaxSearch'])->name('meja.ajaxSearch');
//Route Backend Order;
Route::controller(OrderController::class)->middleware('auth')->group(function () {
    Route::get('orderan', 'index')->name('orderan');
    Route::get('orderan/pesananDihidangkan', 'pesananDihidangkan')->name('orderan.pesananDihidangkan');
    Route::get('orderan/bayar', 'bayar')->name('orderan.bayar');
    Route::get('orderan/pesananSelesai', 'pesananSelesai')->name('orderan.pesananSelesai');
    Route::get('orderan/nomor_meja/{no_meja}', 'no_meja')->name('orderan.no_meja');
    Route::post('orderan', 'store')->name('orderan.store');
    Route::get('orderan/edit/{id}', 'edit')->name('orderan.edit');
    Route::post('orderan/edit/{id}', 'update')->name('orderan.update');
    Route::post('delete-orderan/{id}', 'destroy')->name('orderan.destroy');
    Route::get('detail-orderan/{id}', 'detail')->name('orderan.detail');
    Route::get('detail-orderan/pdf/{id}', 'pdf')->name('orderan.pdf');
    Route::get('orderan/status/{id}', 'changeStatus')->name('orderan.changeStatus');
    Route::get('orderan/selectTables', 'selectTables')->name('orderan.selectTables');
    Route::get('orderan/addOrderan', 'addOrderan')->name('orderan.addOrderan');
    Route::post('orderan/storeOrderan', 'storeOrderan')->name('orderan.storeOrderan');
    Route::post('orderan/getLaporan', 'getLaporan')->name('orderan.getLaporan');
});
Route::controller(UserController::class)->middleware('auth')->group(function () {
    Route::get('users', 'index')->name('users');
    Route::post('users', 'store')->name('users.store');
    Route::get('fetch-users', 'fetchUsers')->name('users.fetch');
    Route::get('edit-users', 'edit')->name('users.edit');
    Route::post('edit-users', 'update')->name('users.update');
    Route::post('delete-users', 'destroy')->name('users.destroy');
});
