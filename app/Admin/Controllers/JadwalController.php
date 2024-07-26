<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\CheckRow;
use App\Admin\Actions\Post\JurnalEdit;
use App\Models\Guru;
use App\Models\Jam;
use App\Models\Jurnal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Semester;
use Encore\Admin\Config\Config;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\DB;

class JadwalController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Jadwal';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Jurnal());

        $grid->filter(function($filter)
        {
            $filter->disableIdFilter();

            $guru= Guru::all()->pluck('nama_guru','id');
            $filter->equal('guru_id', 'Guru')->select($guru);

            $kelas= Kelas::all()->pluck('kode','id');
            $filter->equal('kelas_id', 'Kelas')->select($kelas);
        });

        $grid->model()->join('semester', 'jurnal.semester_id', '=', 'semester.id')
        ->select('jurnal.*')
        ->where('semester.validasi', 1);

        $grid->column('guru.nama_guru',__('Nama Guru'));
        $grid->column('kelas.kode',__('Kelas'));
        
        // $grid->column('jam', 'Jam Mengajar')->display(function () {
        //     return "| {$this->jam->jam_ke} | {$this->jam->waktu_awal} - {$this->jam->waktu_akhir} |";
        // });
        $grid->column('jam_mulai_id', __('Jam Ke-'))->display(function () {
            return $this->jam_mulai_id . ' - ' . $this->jam_akhir_id;
        });

        $grid->column('jam_akhir_id', __('Jam Mengajar'))->display(function () {
            $jamMulai = Jam::find($this->jam_mulai_id);
            $jamAkhir = Jam::find($this->jam_akhir_id);

            if ($jamMulai && $jamAkhir) {
                return $jamMulai->waktu_awal . ' - ' . $jamAkhir->waktu_akhir;
            }

            return '-';
        });

        $grid->column('hari',__('Hari'));
        $grid->column('mapel.nama_mapel',__('Mapel'));
        $grid->column('semester.semester',__('Semester'));

        // $Tahunajaran = config('Tahun Ajaran');
        // $grid->model()->where('tahunajaran','=',$Tahunajaran);
        // $grid->column('tahunajaran','Tahun Ajaran');

        return $grid;
    }


    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {

        $show = new Show(Jurnal::findOrFail($id));
        $show->field('id',__('Id'));
        $show->field('guru.nama_guru',__('Nama Guru'));
        $show->field('kelas.kode',__('Kelas'));

        // $show -> field('jam.jam_ke',__('Jam Mengajar'));
        $show->field('jam_mulai_id',__('Jam Mulai'));
        $show->field('jam_akhir_id',__('Jam Akhir'));

        $show->field('hari',__('Hari'));
        $show->field('mapel.nama_mapel',__('Mapel'));
        $show->field('semester.semester',__('Semester'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Jurnal());

        $daftar_guru = Guru::all()->pluck('nama_guru','id');
        $daftar_jam = Jam::all()->pluck('jam_ke','id');

        $daftar_jam_awal = Jam::selectRaw("id, CONCAT(jam_ke, ' - ', waktu_awal) as jam_awal")->pluck('jam_awal', 'id');
        $daftar_jam_akhir = Jam::selectRaw("id, CONCAT(jam_ke, ' - ', waktu_akhir) as jam_akhir")->pluck('jam_akhir', 'id');

        $daftar_kelas = Kelas::all()->pluck('kode','id');
        $daftar_mapel = Mapel::all()->pluck('nama_mapel','id');
        $daftar_semester = Semester::where('validasi','=',1)->pluck('semester','id');

        $form -> select('guru_id',__('Guru'))->options($daftar_guru)->required();
        $form -> select('kelas_id',__('Kelas'))->options($daftar_kelas)->required();

        // $form -> select('jam_id',__('Jam Mengajar'))->options($daftar_jam)->readonly();
        $form -> select('jam_mulai_id',__('Jam Mulai'))->options($daftar_jam_awal)->required();
        $form -> select('jam_akhir_id',__('Jam Akhir'))->options($daftar_jam_akhir)->required();

        $form->select('hari',__('Hari'))
            ->options(['Senin' => 'Senin', "Selasa" => 'Selasa', 'Rabu' => 'Rabu', 'Kamis' => 'Kamis', 'Jumat' => 'Jumat'])->required();

        $form -> select('mapel_id',__('Mapel'))->options($daftar_mapel)->required();
        $form -> select('semester_id',__('Semester'))->options($daftar_semester)->required();
        $form -> hidden('user_id',__('User ID'))->value(Admin::user()->id);

           // $Tahunajaran = config('value');
        // // $ajaran= Config::load()->pluck('value','id');
        // $form -> select('tahunajaran',__('Tahun Ajaran'))->options($Tahunajaran);
        // // $form -> text('tahunajaran','Tahun Ajaran');

        return $form;
    }
}
