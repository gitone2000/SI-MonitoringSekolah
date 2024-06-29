<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Post\JurnalEdit;
use App\Models\Guru;
use App\Models\Jam;
use App\Models\Jurnal;
use App\Models\JurnalSiswa;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class JurnalGuruController extends AdminController
{
    public function edit($id, Content $content)
    {
        return $content
            ->header(trans('admin.edit'))
            ->description(trans('admin.description'))
            ->body($this->form()->edit($id));
    }
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Jurnal Guru';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Jurnal());


        $grid->filter(function($filter)
        {
            // Remove the default id filter
            $filter->disableIdFilter();

            $guru= Guru::all()->pluck('nama_guru','id');
            $filter->equal('guru_id', 'Guru')->select($guru);

            $kelas= Kelas::all()->pluck('kode','id');
            $filter->equal('kelas_id', 'Kelas')->select($kelas);

            $filter->scope('new', 'Recently modified')
            ->whereDate('tanggal', date('Y-m-d'))
            ->orWhere('tanggal', date('Y-m-d'));
        });

        if(!Admin::user()->isRole('administrator')){
            $username = Admin::user()->id;
            $guru = Guru::where('user_id','=',$username)->first();

            $grid->model()->where('guru_id','=',$guru->id);
        }

        // // $grid->column('id',__('Id'));
        $grid->column('guru.nama_guru',__('Nama Guru'));
        $grid->column('kelas.kode',__('Kelas'));
        // $grid->column('jam.jam_ke',__('Jam Ke-'));
        $grid->column('jam', 'Jam Pelajaran')->display(function () {
            return "| {$this->jam->jam_ke} | {$this->jam->waktu_awal} - {$this->jam->waktu_akhir} |";
        });
        $grid->column('hari',__('Hari'));
        $grid->column('mapel.nama_mapel',__('Mapel'));

        $grid->column('tahunajaran','Tahun Ajaran');

        $grid->column('edit', __('Input-Jurnal'))->display(function () {
            return "<a href='" . route('admin.jurnalguru.edit', ['jurnalguru' => $this->getKey()]) . "' class='btn btn-xs btn-success'><i class='fa fa-edit'></i> Jurnal</a>";
        });
        $Tahunajaran = config('Tahun Ajaran');
        $grid->model()->where('tahunajaran','=',$Tahunajaran);

        $grid->disableCreateButton();
        $grid->disableExport();
        $grid->disableActions();

        // $grid->actions(function ($actions) {
        //     $actions->add(new JurnalEdit());
        // });

        // $grid->column('admin.name',__('Guru'));

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
        $show = new Show(Jurnal::findOrFail($id));

        $show->field('id',__('Id'));
        $show->field('guru.nama_guru',__('Nama Guru'));
        $show->field('kelas.kode',__('Kelas'));
        $show->field('jam.jam_ke',__('Jam Ke-'));
        $show->field('hari',__('Hari'));
        $show->field('mapel.nama_mapel',__('Mapel'));
        $show->field('tahunajaran',__('Tahun Ajaran'));

        // $show->field('siswa.nama_siswa',__('Absen'));
        // $show->field('validasi',__('Validasi'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Jurnal());

        $daftar_guru = Guru::all()->pluck('nama_guru','id');
        $daftar_jam = Jam::all()->pluck('jam_ke','id');
        $daftar_kelas = Kelas::all()->pluck('kode','id');
        $daftar_mapel = Mapel::all()->pluck('nama_mapel','id');
        $daftar_siswa = Siswa::all()->pluck('nama_siswa', 'id');

        $form -> select('guru_id',__('Guru'))->options($daftar_guru)->readonly();
        $form -> select('kelas_id',__('Kelas'))->options($daftar_kelas)->readonly();
        $form -> select('jam_id',__('Jam Ke-'))->options($daftar_jam)->readonly();
        $form -> text('hari',__('Hari'))->readonly();
        $form -> select('mapel_id',__('Mapel'))->options($daftar_mapel)->readonly();

        $form->hasMany('childs', __('Jurnal'), function (Form\NestedForm $form) use ($daftar_siswa) {

            $form->date('tanggal', __('Tanggal'));
            $form->textarea('materi', __('Materi'));

            $form->multipleSelect('izin',__('Izin'))->options($daftar_siswa);
            $form->multipleSelect('sakit',__('Sakit'))->options($daftar_siswa);
            $form->multipleSelect('alpha',__('Alpha'))->options($daftar_siswa);

        });

        return $form;
    }
 }
