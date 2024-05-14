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

        $grid->column('id', __('Id'));
        $grid->column('nama_kelas', __('Nama kelas'));

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
        $show->field('nama_kelas', __('Nama kelas'));

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

        $form->text('nama_kelas', __('Nama kelas'));

        return $form;
    }
}
