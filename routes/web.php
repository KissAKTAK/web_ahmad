
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\LawController;
use App\Http\Controllers\Admin\ComplaintController;

// الصفحات العامة
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/news', [HomeController::class, 'news'])->name('news');
Route::get('/news/{id}', [HomeController::class, 'newsShow'])->name('news.show');
Route::get('/laws', [HomeController::class, 'laws'])->name('laws');
Route::get('/laws/search', [HomeController::class, 'lawsSearch'])->name('laws.search');
Route::get('/complaints', [HomeController::class, 'complaints'])->name('complaints');
Route::post('/complaints', [HomeController::class, 'complaintsStore'])->name('complaints.store');

// نظام المصادقة
Auth::routes();

// لوحة الإدارة
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // الصفحة الرئيسية للإدارة
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // إدارة الأخبار
    Route::resource('news', NewsController::class);
    
    // إدارة القوانين
    Route::resource('laws', LawController::class);

    // إدارة الشكاوى
    Route::get('complaints', [ComplaintController::class, 'index'])->name('complaints.index');
    Route::get('complaints/{complaint}', [ComplaintController::class, 'show'])->name('complaints.show');
    Route::patch('complaints/{complaint}/status', [ComplaintController::class, 'updateStatus'])->name('complaints.update-status');
    Route::post('complaints/{complaint}/notes', [ComplaintController::class, 'addNote'])->name('complaints.add-note');
});
