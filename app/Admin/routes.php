<?php

use App\Admin\Controllers\GuruController;
use App\Admin\Controllers\JadwalController;
use App\Admin\Controllers\JamController;
use App\Admin\Controllers\JurnalController;
use App\Admin\Controllers\JurnalGuruController;
use App\Admin\Controllers\JurnalSiswaController;
use App\Admin\Controllers\JurusanController;
use App\Admin\Controllers\KelasController;
use App\Admin\Controllers\TugasController;
use App\Admin\Controllers\KeteranganController;
use App\Admin\Controllers\MapelController;
use App\Admin\Controllers\MuatanController;
use App\Admin\Controllers\SemesterController;
use App\Admin\Controllers\SiswaController;
use App\Models\Muatan;
use Illuminate\Routing\Router;


Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('mapel', MapelController::class);
    $router->resource('guru', GuruController::class);
    $router->resource('kelas', KelasController::class);
    $router->resource('siswa', SiswaController::class);
    $router->resource('jurnal', JurnalController::class);
    $router->resource('jurnalguru', JurnalGuruController::class);
    $router->resource('jurnalsiswa', JurnalSiswaController::class);
    $router->resource('jam', JamController::class);
    $router->resource('jadwal', JadwalController::class);
    $router->resource('semester', SemesterController::class);
    $router->resource('muatan', MuatanController::class);
    $router->resource('jurusan', JurusanController::class);
    $router->resource('tugas', TugasController::class);     

    // $router->put('admin/jadwal/{jadwal}', [JadwalController::class, 'update'])->name('admin.jadwal.update');

});
