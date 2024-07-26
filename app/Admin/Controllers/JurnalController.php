<?php

namespace App\Admin\Controllers;

use App\Models\Guru;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\AdminController;
use App\Models\Jam;
use App\Models\Jurnal;
use App\Models\JurnalChild;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class JurnalController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Rekap Jurnal';

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
            $filter->disableIdFilter();

            $guru= Guru::all()->pluck('nama_guru','id');
            $filter->equal('guru_id', 'Guru')->select($guru);

            $kelas= Kelas::all()->pluck('kode','id');
            $filter->equal('kelas_id', 'Kelas')->select($kelas);

            $filter->scope('new', 'Recently modified')
            ->whereDate('jurnalchild.tanggal', date('Y-m-d'))
            ->orWhere('jurnalchild.tanggal', date('Y-m-d'));
        });

        if(!Admin::user()->isRole('administrator')){
            $username = Admin::user()->id;
            $guru = Guru::where('user_id','=',$username)->first();

            $grid->model()->where('guru_id','=',$guru->id);
        }

        $grid->model()->select('jurnal.*', 'jurnalchild.tanggal', 'jurnalchild.kompetensi', 'jurnalchild.materi', 'jurnalchild.izin', 'jurnalchild.sakit', 'jurnalchild.alpha',)
                      ->leftJoin('jurnalchild', 'jurnal.id', '=', 'jurnalchild.jurnal_id');
        $grid->model()->join('semester','jurnal.semester_id','=','semester.id')->where('semester.validasi','=',1);
        $grid->model()->whereNotNull('jurnalchild.tanggal');
        $grid->model()->with('childs');

        $grid->column('tanggal',__('Tgl'));
        $grid->column('guru.nama_guru',__('Nama Guru'));
        $grid->column('kelas.kode',__('Kelas'));

        $grid->column('jam_mulai_id', __('Jam Ke-'))->display(function () {
            return $this->jam_mulai_id . ' - ' . $this->jam_akhir_id;
        });

        $grid->column('jam_akhir_id', __('Jam Mengajar'))->display(function () {
            $jamMulai = Jam::find($this->jam_mulai_id);
            $jamAkhir = Jam::find($this->jam_akhir_id);

            if ($jamMulai && $jamAkhir) {
                return $jamMulai->waktu_awal . ' - ' . $jamAkhir->waktu_akhir;
            }

            return '-';
        });

        $grid->column('hari',__('Hari'));
        $grid->column('mapel.nama_mapel',__('Mapel'));
        $grid->column('kompetensi',__('Dasar Kompetensi'));
        $grid->column('materi',__('Materi'));

        $grid->column('izin', 'Izin')->display(function ($izin) {
            if ($izin) {
                $ids = json_decode($izin);
                $siswa = Siswa::whereIn('id', $ids)->pluck('nama_siswa')->join(', ');
                return $siswa ?: '-';
            }
            return '-';
        });
        $grid->column('sakit', 'Sakit')->display(function ($sakit) {
            if ($sakit) {
                $ids = json_decode($sakit);
                $siswa = Siswa::whereIn('id', $ids)->pluck('nama_siswa')->join(', ');
                return $siswa ?: '-';
            }
            return '-';
        });
        $grid->column('alpha', 'Alpha')->display(function ($alpha) {
            if ($alpha) {
                $ids = json_decode($alpha);
                $siswa = Siswa::whereIn('id', $ids)->pluck('nama_siswa')->join(', ');
                return $siswa ?: '-';
            }
            return '-';
        });
        $grid->column('semester.semester',__('Semester'));

        // $Tahunajaran = config('Tahun Ajaran');
        // $grid->model()->where('tahunajaran','=',$Tahunajaran);
        // $grid->column('tahunajaran','Tahun Ajaran');
        // $grid->column('admin.name',__('Inputer'));

        $grid->disableActions();
        $grid->disableCreateButton();

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

        $show -> field('id',__('Id'));
        $show -> field('tanggal',__('Tgl'));
        $show -> field('guru.nama_guru',__('Nama Guru'));
        $show -> field('kelas.kode',__('Kelas'));
        $show -> field('jam_mulai_id',__('Jam Mulai'));
        $show -> field('jam_akhir_id',__('Jam Akhir'));
        $show -> field('hari',__('Hari'));
        $show -> field('mapel.nama_mapel',__('Mapel'));
        $show -> field('kompetensi',__('Dasar Kompetensi'));
        $show -> field('materi',__('Materi'));
        $show -> field('admin.name',__('Inputer'));

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

        return $form;
    }
}
