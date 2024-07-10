<?php

namespace App\Admin\Controllers;

use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Tugas;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;

class GuruController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Guru';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Guru());

        $grid->filter(function ($filter) {

            $filter->disableIdFilter();

            $filter->where(function ($query) {

            $mapelIds = Mapel::where('nama_mapel', 'like', "%{$this->input}%")->pluck('id')->toArray();
            $tugasIds = Tugas::where('nama_tugas', 'like', "%{$this->input}%")->pluck('id')->toArray();

                $query->where('nip', 'like', "%{$this->input}%")
                      ->orWhere('nama_guru', 'like', "%{$this->input}%")
                      ->orWhere('gol_ruang', 'like', "%{$this->input}%")
                      ->orWhere('jabatan', 'like', "%{$this->input}%")
                      ->orWhere('gender', 'like', "%{$this->input}%")
                      
                      ->orWhere(function ($query) use ($mapelIds) {
                        foreach ($mapelIds as $mapelId) {
                            $query->orWhere('mapel', 'like', "%{$mapelId}%");
                        }
                    })
                      ->orWhere(function ($query) use ($tugasIds) {
                        foreach ($tugasIds as $tugasId) {
                            $query->orWhere('tugas', 'like', "%{$tugasId}%");
                        }
                    });

            }, 'Search');
        });

        $grid->column('nip',__('NIP'));
        $grid->column('nama_guru',__('Nama'));
        $grid->column('gol_ruang',__('Gol/Ruang'));
        $grid->column('jabatan',__('Jabatan'));

        $grid->column('mapel', __('Mapel'))->display(function ($mapel) {
            if (is_array($mapel)) {
                $mapel_names = Mapel::whereIn('id', $mapel)->pluck('nama_mapel')->toArray();
                return implode(', ', $mapel_names);
            }
            return '';
        });

        $grid->column('tugas', __('Tugas Tambahan'))->display(function ($tugas) {
            if (is_array($tugas)) {
                $tugas_names = Tugas::whereIn('id', $tugas)->pluck('nama_tugas')->toArray();
                return implode(', ', $tugas_names);
            }
            return '';
        });

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
        $show = new Show(Guru::findOrFail($id));

        $show->field('id',__("Id"));
        $show->field('nip',__('NIP'));
        $show->field('nama_guru',__('Nama'));
        $show->field('gol_ruang',__('Gol/Ruang'));
        $show->field('jabatan',__('Jabatan'));
        $show->field('mapel_names',__('Mapel'));
        $show->field('tugas_names',__('Tugas Tambahan'));
        $show->field('gender',__('Jenis Kelamin'));
        $show->field('user_id',__('User'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Guru());

        $daftar_mapel = Mapel::all()->pluck('nama_mapel','id');
        $daftar_tugas = Tugas::all()->pluck('nama_tugas','id'); 

        $form->text('nip',__('NIP'));
        $form->text('nama_guru',__('Nama'))->required();

        $form->select('gol_ruang',__('Gol/Ruang'))
            ->options(['Juru Muda / Ia' => 'Juru Muda / Ia',
                       'Juru Muda Tk I / Ib' => 'Juru Muda Tk I / Ib',
                       'Juru / Ic' => 'Juru / Ic',
                       'Juru Tingkat I / Id' => 'Juru Tingkat I / Id',
                       'Pengatur Muda / IIa' => 'Pengatur Muda / IIa',
                       'Pengatur Muda Tk I / IIb' => 'Pengatur Muda Tk I / IIb',
                       'Pengatur / IIc' => 'Pengatur / IIc',
                       'Pengatur Tingkat I / IId' => 'Pengatur Tingkat I / IId',
                       'Penata Muda / IIIa' => 'Penata Muda / IIIa',
                       'Penata Muda Tk 1 / IIIb' => 'Penata Muda Tk 1 / IIIb',
                       'Penata / IIIc' => 'Penata / IIIc',
                       'Penata Tingkat I / IIId' => 'Penata Tingkat I / IIId',
                       'Pembina / IVa' => 'Pembina / IVa',
                       'Pembina Tingkat I / IVb' => 'Pembina Tingkat I / IVb',
                       'Pembina Utama Muda / IVc' => 'Pembina Utama Muda / IVc',
                       'Pembina Utama / IVd' => 'Pembina Utama / IVd']);

        $form->select('jabatan',__('Jabatan'))
            ->options(['Guru Ahli Pertama'=>'Guru Ahli Pertama',
                       'Guru Ahli Muda'=> 'Guru Ahli Muda',
                       'Guru Ahli Madya'=>'Guru Ahli Madya',
                       'Guru Ahli Utama'=>'Guru Ahli Utama']);

        $form->multipleSelect('mapel',__('Mapel'))->options($daftar_mapel);
        $form->multipleSelect('tugas',__('Tugas Tambahan'))->options($daftar_tugas);

        $form->radio('gender',__('Jenis Kelamin'))
            ->options(['L' => 'Laki-laki', "P" => 'Perempuan'])->required();

        $users = Administrator::all()->pluck('name','id');
        $form->select('user_id',__('User'))->options($users);

        return $form;
    }
}
