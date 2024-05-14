<?php

namespace App\Admin\Controllers;

use App\Models\Keterangan;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class KeteranganController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Keterangan';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Keterangan());

        $grid->column('id',__('Id'));
        $grid->column('nama_keterangan',__('Name'));

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
        $show = new Show(Keterangan::findOrFail($id));

        $show->field('id',__("Id"));
        $show->field('nama_keterangan',__('Name'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Keterangan());

        $form->text('nama_keterangan',__('Name'));

        return $form;
    }
}
