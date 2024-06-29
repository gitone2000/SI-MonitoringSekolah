<?php

namespace App\Admin\Controllers;

use App\Models\Guru;
use App\Models\Mapel;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Auth;

class GuruController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Guru';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Guru());

        // $grid->column('id',__('Id'));
        $grid->column('nip',__('NIP'));
        $grid->column('nama_guru',__('Nama'));
        $grid->column('gol_ruang',__('Gol/Ruang'));
        $grid->column('mata_pelajaran',__('Mapel'));
        $grid->column('no_tlp',__('No Telepon'));
        $grid->column('gender',__('Jenis Kelamin'));

        // $grid->column('mapel.nama_mapel',__('Mapel Diajar'));

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
        $show = new Show(Guru::findOrFail($id));

        $show->field('id',__("Id"));
        $show->field('nip',__('NIP'));
        $show->field('nama_guru',__('Nama'));
        $show->field('gol_ruang',__('Gol/Ruang'));
        $show->field('mata_pelajaran',__('Mapel'));
        $show->field('no_tlp',__('NO Telepon'));
        $show->field('gender',__('Jenis Kelamin'));


        // $show->field('mapel_id',__('Mapel Diajar'));


        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Guru());

        $daftar_mapel = Mapel::all()->pluck('nama_mapel','id');

        $form->text('nip',__('NIP'));
        $form->text('nama_guru',__('Nama'));
        $form->text('gol_ruang',__('Gol/Ruang'));
        $form->text('mata_pelajaran',__('Mapel'));
        $form->text('no_tlp',__('NO Telepon'));
        $form->text('gender',__('Jenis Kelamin'));

        $users = Administrator::all()->pluck('name','id');
        $form->select('user_id',__('User'))->options($users);

        // $form->select('mapel_id',__('Mapel'))->options($daftar_mapel);

        return $form;
    }
}
