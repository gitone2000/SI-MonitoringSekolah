<?php

namespace App\Admin\Controllers;

use App\Models\Guru;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\AdminController;
use App\Models\Jam;
use App\Models\Jurnal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class JurnalSiswaController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Jurnal';

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
            // Remove the default id filter
            $filter->disableIdFilter();

            $guru= Guru::all()->pluck('nama_guru','id');
            $filter->equal('guru_id', 'Guru')->select($guru);

            $kelas= Kelas::all()->pluck('kode','id');
            $filter->equal('kelas_id', 'Kelas')->select($kelas);

            $filter->scope('new', 'Recently modified')
            ->whereDate('tanggal', date('Y-m-d'))
            ->orWhere('tanggal', date('Y-m-d'));
        });

        // $grid->column('id',__('Id'));
        $grid->column('tanggal',__('Tgl'));
        $grid->column('guru.nama_guru',__('Nama Guru'));
        $grid->column('kelas.kode',__('Kelas'));
        $grid->column('jam.jam_ke',__('Jam Ke-'));
        $grid->column('hari',__('Hari'));
        $grid->column('mapel.nama_mapel',__('Mapel'));
        $grid->column('materi',__('Materi'));

        $grid->column('izin', 'Izin')->display(function () {
            if ($this->izin->isNotEmpty()) {
                $siswaNames = $this->izin->pluck('nama_siswa')->toArray();
                return implode(', ', $siswaNames);
            }
            return '-';
        });

        $grid->column('sakit', 'Sakit')->display(function () {
            if ($this->sakit->isNotEmpty()) {
                $siswaNames = $this->sakit->pluck('nama_siswa')->toArray();
                return implode(', ', $siswaNames);
            }
            return '-';
        });

        $grid->column('alhpa', 'Alpha')->display(function () {
            if ($this->alpha->isNotEmpty()) {
                $siswaNames = $this->alpha->pluck('nama_siswa')->toArray();
                return implode(', ', $siswaNames);
            }
            return '-';
        });

        // $states = [
        //     'on' => ['value' => 1, 'text' => 'Yes', 'color' => 'primary'],
        //     'off' => ['value' => 2, 'text' => 'No', 'color' => 'danger'],
        // ];
        // $grid->column('validasi','Approved')->switch($states);

        // $grid->model()->where('validasi', '=', 2);

        $Tahunajaran = config('Tahun Ajaran');
        $grid->model()->where('tahunajaran','=',$Tahunajaran);
        $grid->column('tahunajaran','Tahun Ajaran');

        // $grid->column('admin.name',__('Guru'));

        $grid->disableCreateButton();
        $grid->disableExport();
        $grid->disableActions();

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

        // $show->field('id',__('Id'));
        // $show->field('tanggal',__('Tgl'));
        // $show->field('nama_guru',__('Nama Guru'));
        // $show->field('kelas.kelas_id',__('Kelas'));
        // $show->field('jam.jam_ke',__('Jam Mengajar'));
        // $show->field('mapel.mapel_id',__('Mapel'));
        // $show->field('materi',__('Materi'));
        // $show->field('siswa.nama_siswa',__('Absen'));
        // $show->field('validasi',__('Validasi'));

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

        // $daftar_kelas = Kelas::all()->pluck('nama_kelas','id');
        // $daftar_mapel = Mapel::all()->pluck('nama_mapel','id');
        // $daftar_jam = Jam::all()->pluck('nama_jam','id');
        // $daftar_siswa = Siswa::all()->pluck('nama_siswa','id');

        // $form -> date('tanggal',__('Tgl'));
        // $form -> select('kelas_id',__('Kelas'))->options($daftar_kelas);
        // $form -> select('jam_id',__('Jam Mengajar'))->options($daftar_jam);
        // $form -> select('mapel_id',__('Mapel'))->options($daftar_mapel);
        // $form -> text  ('materi',__('Materi'));
        // $form -> select('siswa_id',__('Absen'))->options($daftar_siswa);

        // // $form -> select('keterangan_id',__('Keterangan'))->options($daftar_keterangan);
        // // $form->hidden('user_id',__('User ID'))->value(Admin::user()->id);
        // $form -> switch('validasi',__('Validasi'));


        return $form;
    }
}
