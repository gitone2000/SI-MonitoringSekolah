<?php

namespace App\Admin\Controllers;

use App\Models\Semester;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SemesterController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Semester';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Semester());

        $grid -> column('semester',__('Semester'));

        $states = [
                'on' => ['value' => 1, 'text' => 'Ya', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => 'Tidak', 'color' => 'danger'],
            ];
        $grid -> column('validasi','Status')->switch($states);


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
        $show = new Show(Semester::findOrFail($id));

        $show -> field('id',__('ID'));
        $show -> field('semester',__('Semester'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Semester());

        $form -> text('semester',__('Semester'))->required();
        $form -> hidden('validasi',__('Validasi'));


        return $form;
    }
}
