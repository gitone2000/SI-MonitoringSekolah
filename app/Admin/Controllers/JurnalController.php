<?php

namespace App\Admin\Controllers;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\AdminController;
use App\Models\Jam;
use App\Models\Jurnal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Keterangan;
use App\Models\Siswa;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class JurnalController extends AdminController
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

        // $grid->export(function ($export) {

        //     $export->filename('up.csv');

        //     $export->except(['validasi']);

        //     // $export->only(['column3', 'column4']);

        //     // $export->originalValue(['column1', 'column2']);

        //     // $export->column('column_5', function ($value, $original) {
        //     //     return $value;
        //     // });
        // });

        $grid->filter(function($filter)
        {
            // Remove the default id filter
            $filter->disableIdFilter();

            $kelas= Kelas::all()->pluck('nama_kelas','id');
            $filter->equal('kelas_id', 'kelas')->select($kelas);
            // $filter->scope('male', 'Male')->where('gender', 'm');

            $filter->scope('new', 'Recently modified')
            ->whereDate('tanggal', date('Y-m-d'))
            ->orWhere('tanggal', date('Y-m-d'));

            // $filter->equal('column')->placeholder('Please input...');

            // Add a column filter
            // $filter->like('name', 'name');
        });

        $grid->column('id',__('Id'));
        $grid->column('tanggal',__('Tgl'));
        // $grid->column('nama_guru',__('Nama Guru'));
        $grid->column('kelas.nama_kelas',__('Kelas'));
        $grid->column('jam.nama_jam',__('Jam Mengajar'));
        $grid->column('mapel.nama_mapel',__('Mapel'));
        $grid->column('materi',__('Materi'));
        $grid->column('siswa.nama_siswa',__('Absen'));
        $grid->column('keterangan.nama_keterangan',__('Keterangan'));
        $grid->column('admin.name',__('Guru'));

        $states = [
            'on' => ['value' => 1, 'text' => 'Approved', 'color' => 'primary'],
            'off' => ['value' => 2, 'text' => 'Not', 'color' => 'danger'],
        ];
        $grid->column('validasi')->switch($states);

        // $grid->column('validasi',__('Validasi'))->switch();

        // $grid->column('User')->display(function(){

        // });

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

        $show -> field('id',__('Id'));
        $show -> field('tanggal',__('Tgl'));
        $show -> field('nama_guru',__('Nama Guru'));
        $show -> field('kelas.kelas_id',__('Kelas ID'));
        $show -> field('jam.nama_jam',__('Jam Mengajar'));
        $show -> field('mapel.mapel_id',__('Mapel'));
        $show -> field('materi',__('Materi'));
        $show -> field('siswa.nama_siswa',__('Absen'));
        $show -> field('keterangan.nama_keterangan',__('Keterangan'));
        $show -> field('admin.name',__('Guru'));

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
        $daftar_keterangan = Keterangan::all()->pluck('nama_keterangan','id');
        $daftar_jam = Jam::all()->pluck('nama_jam','id');
        $daftar_siswa = Siswa::all()->pluck('nama_siswa','id');

        $form -> date('tanggal',__('Tgl'));
        $form -> select('kelas_id',__('Kelas'))->options($daftar_kelas);
        $form -> select('jam_id',__('Jam Mengajar'))->options($daftar_jam);
        $form -> select('mapel_id',__('Mapel'))->options($daftar_mapel);
        $form -> text  ('materi',__('Materi'));
        $form -> select('siswa_id',__('Absen'))->options($daftar_siswa);
        $form -> select('keterangan_id',__('Keterangan'))->options($daftar_keterangan);

        $form->hidden('user_id',__('User ID'))->value(Admin::user()->id);

        // $form->display('updated_at', 'Updated time');
        // $form -> switch('validasi',__('Validasi'));
        // Jurnal::create(['user_id'=>1]);

        return $form;
    }
}
