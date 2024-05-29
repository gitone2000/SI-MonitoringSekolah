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

            $kelas= Kelas::all()->pluck('nama_kelas','id');
            $filter->equal('kelas_id', 'Kelas')->select($kelas);

            $filter->scope('new', 'Recently modified')
            ->whereDate('tanggal', date('Y-m-d'))
            ->orWhere('tanggal', date('Y-m-d'));
        });

        // $grid->column('id',__('Id'));
        $grid->column('tanggal',__('Tgl'));
        $grid->column('guru.nama_guru',__('Nama Guru'));
        $grid->column('kelas.nama_kelas',__('Kelas'));
        $grid->column('jam.nama_jam',__('Jam Ke-'));
        $grid->column('hari',__('Hari'));
        $grid->column('mapel.nama_mapel',__('Mapel'));
        $grid->column('materi',__('Materi'));

        $grid->column('id', 'Ijin')->display(function ($id) {
            $jurnal = Jurnal::with('ijin')->find($id);
            if ($jurnal && $jurnal->ijin) {
                $siswaNames = $jurnal->ijin->pluck('nama_siswa')->toArray();
                return implode(', ', $siswaNames);
            }
            return 'Tidak ada siswa';
        });

        // $grid->column('siswa.nama_siswa',__('I'));
        // $grid->column('siswa.nama_siswa',__('S'));
        // $grid->column('siswa.nama_siswa',__('A'));

        // $grid->column('admin.name',__('Guru'));

        $states = [
            'on' => ['value' => 1, 'text' => 'Yes', 'color' => 'primary'],
            'off' => ['value' => 2, 'text' => 'No', 'color' => 'danger'],
        ];
        $grid->column('validasi','Approved')->switch($states);

        $Tahunajaran = config('Tahun Ajaran');
        $grid->model()->where('tahunajaran','=',$Tahunajaran);

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

        $show->field('id',__('Id'));
        $show->field('tanggal',__('Tgl'));
        $show->field('nama_guru',__('Nama Guru'));
        $show->field('kelas.kelas_id',__('Kelas ID'));
        $show->field('jam.nama_jam',__('Jam Mengajar'));
        $show->field('mapel.mapel_id',__('Mapel ID'));
        $show->field('materi',__('Materi'));
        $show->field('siswa.nama_siswa',__('Absen'));
        $show->field('validasi',__('Validasi'));

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

        $daftar_kelas = Kelas::all()->pluck('nama_kelas','id');
        $daftar_mapel = Mapel::all()->pluck('nama_mapel','id');
        $daftar_jam = Jam::all()->pluck('nama_jam','id');
        $daftar_siswa = Siswa::all()->pluck('nama_siswa','id');

        $form -> date('tanggal',__('Tgl'));
        $form -> select('kelas_id',__('Kelas'))->options($daftar_kelas);
        $form -> select('jam_id',__('Jam Mengajar'))->options($daftar_jam);
        $form -> select('mapel_id',__('Mapel'))->options($daftar_mapel);
        $form -> text  ('materi',__('Materi'));
        $form -> select('siswa_id',__('Absen'))->options($daftar_siswa);

        // $form -> select('keterangan_id',__('Keterangan'))->options($daftar_keterangan);
        // $form->hidden('user_id',__('User ID'))->value(Admin::user()->id);
        $form -> switch('validasi',__('Validasi'));


        return $form;
    }
}
