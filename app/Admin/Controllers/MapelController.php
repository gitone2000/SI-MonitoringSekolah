<?php

namespace App\Admin\Controllers;

use App\Models\Mapel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MapelController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Mata Pelajaran';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Mapel());

        $grid->column('nama_mapel',__('Nama Mata Pelajaran'));
        $grid->column('muatan',__('Muatan'));
        $grid->column('jurusan',__('Jurusan'));
        $grid->column('kelas',__('Kelas '));

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
        $show = new Show(Mapel::findOrFail($id));

        $show->field('id',__('Id'));
        $show->field('nama_mapel',__('Mapel'));
        $show->field('muatan',__('Muatan'));
        $show->field('jurusan',__('Jurusan'));
        $show->field('kelas',__('Kelas'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Mapel());

        $form->text('nama_mapel',__('Nama Mapel'))->required();
        $form->text('muatan',__('Muatan'));
        $form->text('jurusan',__('Jurusan'));
        $form->text('kelas',__('Kelas'));

        return $form;
    }
}
