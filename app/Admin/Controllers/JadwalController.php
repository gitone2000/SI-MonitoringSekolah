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
        $grid->column('guru.nama_guru',__('Nama Guru'));
        $grid->column('kelas.kode',__('Kelas'));

        // $grid->columns('jam.waktu_awal','jam.waktu_akhir');

        $grid->column('jam', 'Jam Pelajaran')->display(function () {
            return "| {$this->jam->jam_ke} | {$this->jam->waktu_awal} - {$this->jam->waktu_akhir} |";
        });

        $grid->column('hari',__('Hari'));
        $grid->column('mapel.nama_mapel',__('Mapel'));

        $Tahunajaran = config('Tahun Ajaran');
        $grid->model()->where('tahunajaran','=',$Tahunajaran);
        $grid->column('tahunajaran','Tahun Ajaran');

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
        $show->field('jam.jam_ke',__('Jam Mengajar'));
        $show->field('hari',__('Hari'));
        $show->field('mapel.nama_mapel',__('Mapel'));

        $show->field('tahunajaran',__('Tahun Ajaran'));

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
        $daftar_kelas = Kelas::all()->pluck('kode','id');
        $daftar_mapel = Mapel::all()->pluck('nama_mapel','id');

        $form -> select('guru_id',__('Guru'))->options($daftar_guru);
        $form -> select('kelas_id',__('Kelas'))->options($daftar_kelas);
        $form -> select('jam_id',__('Jam Mengajar'))->options($daftar_jam);
        $form -> text('hari',__('Hari'));
        $form -> select('mapel_id',__('Mapel'))->options($daftar_mapel);

        $form -> text('tahunajaran','Tahun Ajaran');
        $form -> hidden('user_id',__('User ID'))->value(Admin::user()->id);

        return $form;
    }
}
