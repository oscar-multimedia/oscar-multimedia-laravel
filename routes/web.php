<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PopupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;

// ========== TEMPORARY DEBUG ROUTE - DELETE AFTER USE ==========
Route::get('/debug-ssl', function () {
    $paths = [
        '/etc/ssl/certs/ca-certificates.crt',
        '/etc/ssl/certs/ca-bundle.crt',
        '/etc/pki/tls/certs/ca-bundle.crt',
        '/etc/pki/ca-trust/extracted/pem/tls-ca-bundle.pem',
        '/usr/local/etc/openssl/cert.pem',
        '/usr/local/etc/ssl/cert.pem',
    ];
    
    $result = [
        'php_version'  => PHP_VERSION,
        'openssl_version' => defined('OPENSSL_VERSION_TEXT') ? OPENSSL_VERSION_TEXT : 'N/A',
        'pdo_mysql_loaded' => extension_loaded('pdo_mysql'),
        'MYSQL_ATTR_SSL_CA_const' => defined('PDO::MYSQL_ATTR_SSL_CA') ? PDO::MYSQL_ATTR_SSL_CA : 'N/A',
        'ca_paths_found' => [],
        'env_MYSQL_ATTR_SSL_CA' => env('MYSQL_ATTR_SSL_CA', 'NOT SET'),
    ];
    
    foreach ($paths as $path) {
        $result['ca_paths_found'][$path] = file_exists($path) ? 'EXISTS ✓' : 'NOT FOUND ✗';
    }
    
    // Test koneksi DB
    try {
        DB::connection()->getPdo();
        $result['db_connection'] = 'SUCCESS ✓';
    } catch (\Exception $e) {
        $result['db_connection'] = 'FAILED: ' . $e->getMessage();
    }
    
    return response()->json($result, 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
});
// ========== END DEBUG ROUTE ==========

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/register', function () {
    return redirect('/login');
});

Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
// Route::get('/profile', function () {
//     return view('profile');
// })->name('profile');

Route::get('/kontak', [KontakController::class, 'show'])->name('kontak');
// Route::get('/kontak', function () {
//     return view('kontak');
// })->name('kontak');

Route::get('/produk/{produk}', [ProdukController::class, 'show'])->name('detail');

Route::get('/produk', [ProdukController::class, 'katalog'])->name('produk');

Route::middleware('auth')->group(function () {
    // Halaman dashboard (statistik)
    Route::get('/dashboard', function () {
        $totalProduk = \App\Models\Produk::count();
        $totalKategori = \App\Models\Produk::select('kategori')->distinct()->count();
        return view('dashboard', compact('totalProduk', 'totalKategori'));
    })->name('dashboard');
    
    // Routes untuk Pop-up Management
    Route::get('/popups', [PopupController::class, 'index'])->name('admin.popup.index');
    Route::post('/popups', [PopupController::class, 'store'])->name('admin.popup.store');
    Route::post('/popups/{popup}/set-active', [PopupController::class, 'setActive'])->name('admin.popup.setActive');
    Route::delete('/popups/{popup}', [PopupController::class, 'destroy'])->name('admin.popup.destroy');
    
    // Halaman produk (CRUD) 
    Route::get('/admin/kategori', [KategoriController::class, 'index'])->name('admin.kategori.index');
    Route::post('/admin/kategori', [KategoriController::class, 'store'])->name('admin.kategori.store');
    Route::put('/admin/kategori/{kategori}', [KategoriController::class, 'update'])->name('admin.kategori.update');
    Route::delete('/admin/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('admin.kategori.destroy');

    Route::get('/admin/produk', [ProdukController::class, 'index'])->name('admin.produk.index');
    Route::post('/admin/produk', [ProdukController::class, 'store'])->name('admin.produk.store');
    Route::put('/admin/produk/{produk}', [ProdukController::class, 'update'])->name('admin.produk.update');
    Route::delete('/admin/produk/{produk}', [ProdukController::class, 'destroy'])->name('admin.produk.destroy');

    Route::get('/admin/kontak', [KontakController::class, 'form'])->name('admin.kontak.index');
    Route::post('/admin/kontak', [KontakController::class, 'storeOrUpdate'])->name('admin.kontak.save');

    // Admin profil
    Route::get('/admin/profile', [ProfileController::class, 'form'])->name('admin.profile.index');
    Route::post('/admin/profile', [ProfileController::class, 'storeOrUpdate'])->name('admin.profile.update');

});

require __DIR__.'/auth.php';
