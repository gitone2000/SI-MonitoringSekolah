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

        $grid->filter(function ($filter) {

            $filter->disableIdFilter();

            $filter->where(function ($query) {

                $query->where('jam_ke', 'like', "%{$this->input}%")
                    ->orWhere('waktu_awal', 'like', "%{$this->input}%")
                    ->orWhere('waktu_akhir', 'like', "%{$this->input}%");

            }, 'Search');
        });

        $grid->column('jam_ke',__('Jam Ke-'));
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

        $form->text('jam_ke',__('Jam Ke-'))->required();
        $form->text('waktu_awal',__('Waktu Awal'))->required();
        $form->text('waktu_akhir',__('Waktu Akhir'))->required();

        return $form;
    }
}
