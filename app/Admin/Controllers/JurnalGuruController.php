<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Post\JurnalEdit;
use App\Models\Guru;
use App\Models\Jam;
use App\Models\Jurnal;
use App\Models\JurnalSiswa;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class JurnalGuruController extends AdminController
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

        // $grid->model()->where('validasi', '=', '1');
        // $grid->column('id',__('Id'));

        $grid->column('guru.nama_guru',__('Nama Guru'));
        $grid->column('kelas.nama_kelas',__('Kelas'));
        $grid->column('jam.nama_jam',__('Jam Ke-'));
        $grid->column('hari',__('Hari'));
        $grid->column('mapel.nama_mapel',__('Mapel'));

        // $grid->column('id', 'Ijin')->display(function ($id) {
        //     $jurnal = Jurnal::with('ijin')->find($id);
        //     if ($jurnal && $jurnal->ijin) {
        //         $siswaNames = $jurnal->ijin->pluck('nama_siswa')->toArray();
        //         return implode(', ', $siswaNames);
        //     }
        //     return 'Tidak ada siswa';
        // });

        // $grid->column('id', 'Sakit')->display(function ($id) {
        //     $jurnal = Jurnal::with('sakit')->find($id);
        //     if ($jurnal && $jurnal->sakit) {
        //         $siswaNames = $jurnal->sakit->pluck('nama_siswa')->toArray();
        //         return implode(', ', $siswaNames);
        //     }
        //     return 'Tidak ada siswa';
        // });
        // $grid->column('id', 'Alpha')->display(function ($id) {
        //     $jurnal = Jurnal::with('alpha')->find($id);
        //     if ($jurnal && $jurnal->alpha) {
        //         $siswaNames = $jurnal->alpha->pluck('nama_siswa')->toArray();
        //         return implode(', ', $siswaNames);
        //     }
        //     return 'Tidak ada siswa';
        // });

        $grid->column('edit', __('Input-Jurnal'))->display(function () {
            return "<a href='" . route('admin.jurnalguru.edit', ['jurnalguru' => $this->getKey()]) . "' class='btn btn-xs btn-success'><i class='fa fa-edit'></i> Jurnal</a>";
        });
        $Tahunajaran = config('Tahun Ajaran');
        $grid->model()->where('tahunajaran','=',$Tahunajaran);

        $grid->disableCreateButton();
        $grid->disableExport();
        $grid->disableActions();

                // $grid->actions(function ($actions) {
        //     $actions->add(new JurnalEdit());
        // });

        // $grid->column('admin.name',__('Guru'));

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
        $show->field('guru.nama_guru',__('Nama Guru'));
        $show->field('kelas.nama_kelas',__('Kelas ID'));
        $show->field('jam.nama_jam',__('Jam Mengajar'));
        $show->field('hari',__('Hari'));
        $show->field('mapel.nama_mapel',__('Mapel'));
        $show->field('materi',__('Materi'));
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

        $form->column(1/2, function ($form) {

            $daftar_guru = Guru::all()->pluck('nama_guru','id');
            $daftar_jam = Jam::all()->pluck('nama_jam','id');
            $daftar_kelas = Kelas::all()->pluck('nama_kelas','id');
            $daftar_mapel = Mapel::all()->pluck('nama_mapel','id');

            $form -> select('guru_id',__('Guru'))->options($daftar_guru)->readonly();
            $form -> select('kelas_id',__('Kelas'))->options($daftar_kelas)->readonly();
            $form -> select('jam_id',__('Jam Mengajar'))->options($daftar_jam)->readonly();
            $form -> text('hari',__('Hari'))->readonly();
            $form -> select('mapel_id',__('Mapel'))->options($daftar_mapel)->readonly();
            });

            $form->column(1/2, function ($form) {
            $form -> date('tanggal',__('Tgl'));
            $form -> textarea('materi',__('Materi'));

            $form->multipleSelect('izin','Izin')->options(Siswa::all()->pluck('nama_siswa','id'));
            $form->multipleSelect('sakit','Sakit')->options(Siswa::all()->pluck('nama_siswa','id'));
            $form->multipleSelect('alpha','Alpha')->options(Siswa::all()->pluck('nama_siswa','id'));

            });


        $form->hidden('user_id',__('User ID'))->value(Admin::user()->id);



        $form->footer(function ($footer) {

            // disable reset btn
            $footer->disableReset();

            // disable `View` checkbox
            $footer->disableViewCheck();

            // disable `Continue editing` checkbox
            $footer->disableEditingCheck();

            // disable `Continue Creating` checkbox
            $footer->disableCreatingCheck();

            // $footer->add('<a class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;Tambah</a>');

        });

        // $form -> switch('validasi',__('Validasi'));

        return $form;
    }
}
