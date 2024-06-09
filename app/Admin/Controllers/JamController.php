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
        $grid->column('jam-ke',__('Jam Ke-'));
        $grid->column('waktu_awal',__('Waktu Awal'));
        $grid->column('waktu_akhir',__('Waktu Akhir'));

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
        $show->field('jam_ke',__('Jam Ke-'));
        $show->field('waktu_awal',__('Waktu Awal'));
        $show->field('waktu_akhir',__('Waktu Akhir '));

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

        $form->text('id',__('Id'));
        $form->text('jam_ke',__('Jam Ke-'));
        $form->text('waktu_awal',__('Waktu Awal'));
        $form->text('waktu_akhir',__('Waktu Akhir'));

        return $form;
    }
}
