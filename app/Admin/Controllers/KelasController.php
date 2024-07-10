<?php

namespace App\Admin\Controllers;

use App\Models\Jurusan;
use App\Models\Kelas;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class KelasController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Kelas';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Kelas());

        $grid->filter(function ($filter) {

            $filter->disableIdFilter();

            $filter->where(function ($query) {

                $query->where('kode', 'like', "%{$this->input}%")
                      ->orWhere('kelas', 'like', "%{$this->input}%")
                      ->orWhere('keterangan_kelas', 'like', "%{$this->input}%")
                      ->orWhereHas('jurusan', function ($query) {
                        $query->where('nama_jurusan', 'like', "%{$this->input}%");
                });

            }, 'Search');
        });

        $grid->column('kode', __('Kode'));
        $grid->column('kelas', __('Kelas'));
        $grid->column('keterangan_kelas', __('Keterangan Kelas'));
        $grid->column('jurusan.nama_jurusan', __('Jurusan'));

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
        $show = new Show(Kelas::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('kode', __('Kode'));
        $show->field('kelas', __('Kelas'));
        $show->field('keterangan_kelas', __('Keterangan Kelas'));
        $show->field('jurusan_id', __('Jurusan'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Kelas());

        $daftar_jurusan = Jurusan::all()->pluck('nama_jurusan','id');

        $form->text('kode', __('Kode'))->required();
        $form->text('kelas', __('Kelas'))->required();
        $form->text('keterangan_kelas', __('Keterangan Kelas'))->required();
        $form->select('jurusan_id', __('Jurusan'))->options($daftar_jurusan)->required();

        return $form;
    }
}
