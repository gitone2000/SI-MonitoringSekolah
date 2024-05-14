<?php

namespace App\Admin\Controllers;

use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Jam;
use App\Models\Kelas;
use App\Models\Mapel;
use Encore\Admin\Controllers\AdminController;
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
        $grid = new Grid(new Jadwal());
        $grid->column('id',__('Id'));
        $grid->column('guru.nama_guru',__('Nama Guru'));
        $grid->column('jam.nama_jam',__('Jam Ke-'));
        $grid->column('kelas.nama_kelas',__('Kelas'));
        $grid->column('mapel.nama_mapel',__('Mapel'));

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
        $show = new Show(Jadwal::findOrFail($id));
        $show->field('id',__('Id'));
        $show->field('guru.nama_guru',__('Nama Guru'));
        $show->field('jam.nama_jam',__('Jam Ke-'));
        $show->field('kelas.nama_kelas',__('Kelas'));
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
        $form = new Form(new Jadwal());

        $daftar_guru = Guru::all()->pluck('nama_guru','id');
        $daftar_jam = Jam::all()->pluck('nama_jam','id');
        $daftar_kelas = Kelas::all()->pluck('nama_kelas','id');
        $daftar_mapel = Mapel::all()->pluck('nama_mapel','id');

        $form -> select('guru_id',__('Guru'))->options($daftar_guru);
        $form -> select('jam_id',__('Jam Ke-'))->options($daftar_jam);
        $form -> select('kelas_id',__('Kelas'))->options($daftar_kelas);
        $form -> select('mapel_id',__('Mapel'))->options($daftar_mapel);


        return $form;
    }
}
