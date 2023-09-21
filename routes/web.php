<?php

use App\Models\Kursus;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\KursusController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\UserImportController;
use App\Http\Controllers\Admin\SampleController;
use App\Http\Controllers\Lecture\AssignController;
use App\Http\Controllers\Lecture\StudentController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\RegisteredDosenController;
use App\Http\Controllers\Admin\ContactAssistantController;
use App\Http\Controllers\Lecture\AssignCompleteController;
use App\Http\Controllers\Lecture\AssignInCompleteController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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
    $kursuses = Kursus::withCount('users')->get();
    return view('home', compact('kursuses'));
});

Route::get('/learning', function () {
    return view('learning');
})->name('learning');

Route::get('/activate-token', function () {
    return view('activate-token');
})->name('activate-token');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Admin Space Routing
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');

    Route::get('/register-dosen', [RegisteredDosenController::class, 'create'])->name('register-dosen');;
    Route::post('/register-dosen', [RegisteredDosenController::class, 'store']);

    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::name('admin.')->prefix('admin')->group(function () {
        Route::get('/', [DosenController::class, 'index']);
        Route::resource('contact-assistant', ContactAssistantController::class);
        // Route::get('student', [App\Http\Controllers\Admin\StudentController::class, 'index']);
        // Route::get('lecture', [App\Http\Controllers\Admin\LectureController::class, 'index']);

        Route::resource('student', App\Http\Controllers\Admin\StudentController::class);
        Route::resource('lecture', App\Http\Controllers\Admin\LectureController::class);

    });
});
// End Admin Space Routing

Route::group(['middleware' => ['role:dosen']], function () {
    Route::get('daftar-kelola', [DosenController::class, 'showDaftarDanKelolaMahasiswa']);
    Route::get('daftar-materi', [DosenController::class, 'showDaftarMateri']);
    Route::get('log-aktivitas', [DosenController::class, 'showLogAktivitas']);
    Route::get('kontak-asisten', [DosenController::class, 'showKontakAsisten']);
    Route::name('lecture.')->prefix('lecture')->group(function () {
        Route::get('/', [DosenController::class, 'index'])->name('index');
        Route::resource('student', StudentController::class);
        Route::resource('assign', AssignController::class);
        Route::resource('assignincomplete', AssignInCompleteController::class);
        Route::resource('assigncomplete', AssignCompleteController::class);
        Route::resource('assignment', AssignmentController::class);
    });
    // Route::get('/dosen', function(){
    //     return 'ini halaman dosen';
    // });
});

Route::group(['middleware' => ['role:mahasiswa']], function () {
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('logs', LogController::class);
    Route::get('dipelajari', [MahasiswaController::class, 'showMateriDipelajari']);
    Route::get('diselesaikan', [MahasiswaController::class, 'showMateriDiselesaikan']);
    Route::get('kumpulkan', [MahasiswaController::class, 'showKumpulkanTugas']);
    Route::get('daftar-nilai', [MahasiswaController::class, 'showDaftarNilai']);
    Route::get('kontak', [MahasiswaController::class, 'showKontakAsisten']);
    Route::post('simpan-tugas', [TugasController::class, 'store'])->name('simpan-tugas');
    Route::post('submit-tugas', [TugasController::class, 'submitTugas'])->name('submit-tugas');

    Route::post('/update-kursus', [MahasiswaController::class, 'updateKursus'])->name('update.kursus');

    // Route::get('/mahasiswa', function(){
    //     return 'ini halaman mhs via role';
    // });
});

// Route for kursus / module learning in admin?
Route::resource('kursus', KursusController::class)->except('edit');
Route::resource('section', SectionController::class);
Route::resource('artikel', ArtikelController::class);



// debuging data kursus
Route::get('/modul', [ModulController::class, 'index']);
Route::get('/modul/{kursusId}/section/{sectionId}', [ModulController::class, 'showSection']);
Route::get('/modul/{kursusId}/section/{sectionId}/artikel/{artikelId}', [ModulController::class, 'showArtikel'])->name('modul.artikel');

// Route::group(['middleware' => ['permission:edit modul|delete modul']], function () {
//     Route::get('/permission', function(){
//         return 'ini halaman ian via permission';
//     });
// });

// import csv
Route::get('/import', [UserImportController::class, 'showForm']);
Route::post('/import', [UserImportController::class, 'import']);

require __DIR__ . '/auth.php';
