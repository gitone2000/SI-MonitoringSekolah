<?php

namespace App\Admin\Controllers;

use App\Models\Muatan;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MuatanController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Muatan';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Muatan());

        $grid->filter(function ($filter) {

            $filter->disableIdFilter();

            $filter->where(function ($query) {

                $query->where('nama_muatan', 'like', "%{$this->input}%");

            }, 'Search');
        });

        $grid->column('nama_muatan', __('Nama Muatan'));

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
        $show = new Show(Muatan::findOrFail($id));

        $show->field('nama_muatan', __('Nama Muatan'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Muatan());

        $form->text('nama_muatan', __('Nama Muatan'))->required();

        return $form;
    }
}
