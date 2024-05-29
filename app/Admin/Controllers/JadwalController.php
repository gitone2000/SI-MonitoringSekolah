<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\CheckRow;
use App\Admin\Actions\Post\JurnalEdit;
use App\Models\Guru;
use App\Models\Jam;
use App\Models\Jurnal;
use App\Models\Kelas;
use App\Models\Mapel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class JadwalController extends AdminController
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

        // $grid->column('id',__('Id'));
        $grid->column('guru.nama_guru',__('Nama Guru'));
        $grid->column('kelas.nama_kelas',__('Kelas'));
        $grid->column('jam.nama_jam',__('Jam Ke-'));
        $grid->column('hari',__('Hari'));
        $grid->column('mapel.nama_mapel',__('Mapel'));

        $Tahunajaran = config('Tahun Ajaran');
        $grid->model()->where('tahunajaran','=',$Tahunajaran);
        $grid->column('tahunajaran','Tahun Ajaran');

        // $grid->column('edit', __('Jurnal'))->display(function () {
        //     return "<a href='" . route('admin.jadwal.edit', ['jadwal' => $this->getKey()]) . "' class='btn btn-xs btn-success'><i class='fa fa-edit'></i> Jurnal</a>";
        // });

        // $grid->actions(function ($actions) {
        //     $actions->add(new JurnalEdit());
        // });

        // $grid->column('title')->display(function ($actions) {

        //     return $actions->add(new JurnalEdit());

        // });

        // $grid->actions(function ($actions) {

        //     // add action
        //     $actions->append(new CheckRow($actions->getKey()));
        // });

        // $grid->column('id', __('Edit'))->display(function () {
        //     // Menggunakan $this->id untuk mendapatkan ID dari model
        //     $url = route('admin.jadwal.edit', ['jadwal' => $this->getKey()]);
        //     return "<a href='{{$url}}' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>";
        // });
        // $grid->column('title')->editable();

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
        $show->field('kelas.nama_kelas',__('Kelas'));
        $show->field('jam.nama_jam',__('Jam Mengajar'));
        $show->field('mapel.nama_mapel',__('Mapel'));


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

        $form -> select('guru_id',__('Guru'))->options($daftar_guru);
        $form -> select('kelas_id',__('Kelas'))->options($daftar_kelas);
        $form -> select('jam_id',__('Jam Mengajar'))->options($daftar_jam);
        $form -> text('hari',__('Hari'));
        $form -> select('mapel_id',__('Mapel'))->options($daftar_mapel);

        $form -> text('tahunajaran','Tahun Ajaran');

        });

        $form->column(1/2, function ($form) {
        $form -> date('tanggal',__('Tgl'));
        $form -> textarea('materi',__('Materi'));
        });

        $form->hidden('user_id',__('User ID'))->value(Admin::user()->id);

        return $form;
    }
}
