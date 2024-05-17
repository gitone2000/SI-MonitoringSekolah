<?php

namespace App\Admin\Controllers;

use App\Models\Jam;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class JamController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Jam';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Jam());

        $grid->column('id',__('Id'));
        $grid->column('nama_jam',__('Name'));
        $grid->column('waktu',__('Waktu'));

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
        $show = new Show(Jam::findOrFail($id));
        $show->field('id',__('Id'));
        $show->field('nama_jam',__('Name'));
        $show->field('waktu',__('Waktu'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Jam());

        $form -> text('nama_jam',__('Nama Jam'));
        $form -> time('waktu',__('Waktu'));

        return $form;
    }
}
