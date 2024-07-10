<?php

namespace App\Admin\Controllers;

use App\Models\Mapel;
use App\Models\Muatan;
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

        $grid->filter(function ($filter) {

            $filter->disableIdFilter();

            $filter->where(function ($query) {

                $query->where('nama_mapel', 'like', "%{$this->input}%")
                      ->orWhereHas('muatan', function ($query) {
                        $query->where('nama_muatan', 'like', "%{$this->input}%");
                });

            }, 'Search');
        });

        $grid->column('nama_mapel',__('Nama Mata Pelajaran'));
        $grid->column('muatan.nama_muatan',__('Muatan'));

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
        $show->field('muatan_id',__('Muatan'));

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

        $daftar_muatan = Muatan::all()->pluck('nama_muatan','id');

        $form->text('nama_mapel',__('Nama Mapel'))->required();
        $form->select('muatan_id',__('Muatan'))->options($daftar_muatan)->required();

        return $form;
    }
}
