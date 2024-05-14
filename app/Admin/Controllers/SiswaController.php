<?php

namespace App\Admin\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SiswaController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Siswa';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Siswa());

        $grid->column('id',__('Id'));
        $grid->column('nis',__('NIS'));
        $grid->column('nama_siswa',__('Nama'));
        $grid->column('kelas.nama_kelas',__('Kelas'));

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
        $show = new Show(Siswa::findOrFail($id));

        $show->field('id',__("Id"));
        $show->field('nis',__('NIS'));
        $show->field('nama_siswa',__('Nama'));
        $show->field('kelas_id',__('Kelas'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Siswa());

        $daftar_kelas = Kelas::all()->pluck('nama_kelas','id');

        $form->text('nis',__('NIS'));
        $form->text('nama_siswa',__('Name'));
        $form -> select('kelas_id',__('Kelas'))->options($daftar_kelas);

        return $form;
    }
}
