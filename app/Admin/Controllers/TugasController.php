<?php

namespace App\Admin\Controllers;

use App\Models\Tugas;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TugasController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Tugas Tambahan';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Tugas());

        $grid->filter(function ($filter) {

            $filter->disableIdFilter();

            $filter->where(function ($query) {

                $query->where('nama_tugas', 'like', "%{$this->input}%");

            }, 'Search');
        });

        $grid->column('nama_tugas', __('Nama Tugas Tambahan'));

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
        $show = new Show(Tugas::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('nama_tugas', __('Nama Tugas Tambahan'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Tugas());

        $form->text('nama_tugas', __('Nama Tugas Tambahan'))->required();

        return $form;
    }
}
