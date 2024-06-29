<?php

namespace App\Admin\Controllers;

use App\Models\Kelas;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class KelasController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Kelas';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Kelas());

        // $grid->column('id', __('Id'));
        $grid->column('kode', __('Kode'));
        $grid->column('kelas', __('Kelas'));
        $grid->column('keterangan_kelas', __('Keterangan Kelas'));
        $grid->column('jurusan', __('Jurusan'));

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
        $show = new Show(Kelas::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('kode', __('Kode'));
        $show->field('kelas', __('Kelas'));
        $show->field('keterangan_kelas', __('Keterangan Kelas'));
        $show->field('jurusan', __('Jurusan'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Kelas());

        $form->text('kode', __('Kode'));
        $form->text('kelas', __('Kelas'));
        $form->text('keterangan_kelas', __('Keterangan Kelas'));
        $form->text('jurusan', __('Jurusan'));

        return $form;
    }
}
