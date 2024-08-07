<?php

namespace App\Admin\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SiswaController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Siswa';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Siswa());

        $grid->filter(function ($filter) {

            $filter->disableIdFilter();

            $filter->where(function ($query) {

                $query->where('nis', 'like', "%{$this->input}%")
                      ->orWhere('nama_siswa', 'like', "%{$this->input}%")
                      ->orWhere('gender', 'like', "%{$this->input}%")
                      ->orWhereHas('kelas', function ($query) {
                        $query->where('kode', 'like', "%{$this->input}%");
                });

            }, 'Search');
        });

        $grid->column('nis',__('NIS'));
        $grid->column('nama_siswa',__('Nama'));
        $grid->column('kelas.kode',__('Kelas'));
        $grid->column('gender',__('Jenis Kelamin'));

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
        $show = new Show(Siswa::findOrFail($id));

        $show->field('id',__("Id"));
        $show->field('nis',__('NIS'));
        $show->field('nama_siswa',__('Nama'));
        $show->field('kelas_id',__('Kelas'));
        $show->field('gender',__('Jenis Kelamin'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Siswa());

        $daftar_kelas = Kelas::all()->pluck('kode','id');

        $form->text('nis',__('NIS'))->required();
        $form->text('nama_siswa',__('Nama'))->required();
        $form -> select('kelas_id',__('Kelas'))->options($daftar_kelas)->required();
        $form->radio('gender',__('Jenis Kelamin'))
            ->options(['L' => 'Laki-laki', "P" => 'Perempuan'])->required();

        return $form;
    }
}
