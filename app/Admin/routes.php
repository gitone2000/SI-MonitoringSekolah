<?php

use App\Admin\Controllers\GuruController;
use App\Admin\Controllers\JadwalController;
use App\Admin\Controllers\JamController;
use App\Admin\Controllers\JurnalController;
use App\Admin\Controllers\JurnalGuruController;
use App\Admin\Controllers\JurnalSiswaController;
use App\Admin\Controllers\KelasController;
use App\Admin\Controllers\KeteranganController;
use App\Admin\Controllers\MapelController;
use App\Admin\Controllers\SiswaController;
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
    // $router->resource('keterangan', KeteranganController::class);
    $router->resource('siswa', SiswaController::class);
    $router->resource('jurnal', JurnalController::class);
    $router->resource('jurnalguru', JurnalGuruController::class);
    // $router->get('jurnalguru/edit/{jurnal}',[JurnalGuruController::class,'editJurnal'])->name('jurnalguru.editJurnal');
    // $router->put('jurnalguru/update/{jurnal}',[JurnalGuruController::class,'updateJurnal'])->name('jurnalguru.updateJurnal');
    // $router->post('jurnalguru/createjurnal',[JurnalGuruController::class,'createJurnal'])->name('jurnalguru.createJurnal');
    $router->resource('jurnalsiswa', JurnalSiswaController::class);
    $router->resource('jam', JamController::class);
    $router->resource('jadwal', JadwalController::class);

    // $router->put('admin/jadwal/{jadwal}', [JadwalController::class, 'update'])->name('admin.jadwal.update');

});
