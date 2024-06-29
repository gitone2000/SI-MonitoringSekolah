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

        $grid->model()->select('jurnal.*', 'jurnalchild.tanggal', 'jurnalchild.materi', 'jurnalchild.izin', 'jurnalchild.sakit', 'jurnalchild.alpha',)
                      ->leftJoin('jurnalchild', 'jurnal.id', '=', 'jurnalchild.jurnal_id');

        // $grid->column('id',__('Id'));

        $grid->model()->with('childs');

        $grid->column('tanggal',__('Tgl'));
        $grid->column('guru.nama_guru',__('Nama Guru'));
        $grid->column('kelas.kode',__('Kelas'));
        // $grid->column('jam.jam_ke',__('Jam Ke-'));
        $grid->column('jam', 'Jam Pelajaran')->display(function () {
            return "| {$this->jam->jam_ke} | {$this->jam->waktu_awal} - {$this->jam->waktu_akhir} |";
        });
        $grid->column('hari',__('Hari'));
        $grid->column('mapel.nama_mapel',__('Mapel'));
        $grid->column('materi',__('Materi'));


        // dd($izin);
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

        $Tahunajaran = config('Tahun Ajaran');
        $grid->model()->where('tahunajaran','=',$Tahunajaran);
        $grid->column('tahunajaran','Tahun Ajaran');

        // $grid->column('admin.name',__('Inputer'));
        // $states = [
        //     'on' => ['value' => 1, 'text' => 'Yes', 'color' => 'primary'],
        //     'off' => ['value' => 2, 'text' => 'No', 'color' => 'danger'],
        // ];
        // $grid->column('validasi','Approved')->switch($states);

        // $grid->model()->where('validasi', '=', 1);

        // $grid->footer(function ($query) {

        //     // Query the total amount of the order with the paid status
        //     $data = $query->where('status', 2)->sum('amount');

        //     return "<div style='padding: 10px;'>Total revenue ： $data</div>";
        // });

        // $grid->column('User')->display(function(){
        // });
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
        $show -> field('jam.jam_ke',__('Jam Ke-'));
        $show -> field('hari',__('Hari'));
        $show -> field('mapel.nama_mapel',__('Mapel'));
        $show -> field('materi',__('Materi'));
        // $show -> field('siswa.nama_siswa',__('Absen'));
        $show -> field('admin.name',__('Inputer'));
        $show->field('validasi',__('Validasi'));
        $show->field('tahunajaran',__('Tahun Ajaran'));

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

        // $daftar_kelas = Kelas::all()->pluck('nama_kelas','id');
        // $daftar_mapel = Mapel::all()->pluck('nama_mapel','id');
        // $daftar_jam = Jam::all()->pluck('nama_jam','id');

        // // $daftar_siswa = Siswa::all()->pluck('nama_siswa','id');

        // $form -> date('tanggal',__('Tgl'));
        // $form -> select('kelas_id',__('Kelas'))->options($daftar_kelas);
        // $form -> select('jam_id',__('Jam Mengajar'))->options($daftar_jam);
        // $form -> select('mapel_id',__('Mapel'))->options($daftar_mapel);
        // $form -> text  ('materi',__('Materi'));

        // // $form->multipleSelect('siswa_id','siswa')->options(Siswa::all()->pluck('nama_siswa', 'id'));
        // // $form -> multipleSelect('siswa_id',trans('siswa'))->options($daftar_siswa);

        // $form->text('user_id',__('User ID'))->value(Admin::user()->id);

        // // $form->display('updated_at', 'Updated time');
        // // $form -> switch('validasi',__('Validasi'));
        // // Jurnal::create(['user_id'=>1]);

        return $form;
    }
}
