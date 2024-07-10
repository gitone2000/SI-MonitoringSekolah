<?php

namespace App\Admin\Controllers;

use App\Models\Jurusan;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class JurusanController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Jurusan';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Jurusan());

        $grid->filter(function ($filter) {

            $filter->disableIdFilter();

            $filter->where(function ($query) {

                $query->where('nama_jurusan', 'like', "%{$this->input}%")
                      ->orWhere('kode_jurusan', 'like', "%{$this->input}%");

            }, 'Search');
        });

        $grid->column('nama_jurusan', __('Nama Jurusan'));
        $grid->column('kode_jurusan', __('Kode Jurusan'));

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
        $show = new Show(Jurusan::findOrFail($id));

        $show->field('nama_jurusan', __('Nama Jurusan'));
        $show->field('kode_jurusan', __('Kode Jurusan'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Jurusan());

        $form->text('nama_jurusan', __('Nama Jurusan'))->required();
        $form->text('kode_jurusan', __('Kode Jurusan'))->required();

        return $form;
    }
}
