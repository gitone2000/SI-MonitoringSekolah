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

        $grid->column('nip',__('NIP'));
        $grid->column('nama_guru',__('Nama'));
        $grid->column('gol_ruang',__('Gol/Ruang'));
        $grid->column('jabatan',__('Jabatan'));
        $grid->column('mapel.nama_mapel',__('Mapel'));;
        $grid->column('gender',__('Jenis Kelamin'));

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
        $show->field('jabatan',__('Jabatan'));
        $show->field('mapel.nama_mapel',__('Mapel'));
        $show->field('gender',__('Jenis Kelamin'));

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
        $form->text('nama_guru',__('Nama'))->required();
        $form->text('gol_ruang',__('Gol/Ruang'));
        $form->text('jabatan',__('Jabatan'));
        $form->select('mapel_id',__('Mapel'))->options($daftar_mapel)->required();
        $form->radio('gender',__('Jenis Kelamin'))
            ->options(['L' => 'Laki-laki', "P" => 'Perempuan'])->required();
        $users = Administrator::all()->pluck('name','id');
        $form->select('user_id',__('User'))->options($users)->required();

        return $form;
    }
}
