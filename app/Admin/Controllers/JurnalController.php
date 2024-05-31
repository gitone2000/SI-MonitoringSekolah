<?php

namespace App\Admin\Controllers;

use App\Models\Guru;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\AdminController;
use App\Models\Jam;
use App\Models\Jurnal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\DB;

class JurnalController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Jurnal';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {


        $grid = new Grid(new Jurnal());

        // $grid->export(function ($export) {

        //     $export->filename('up.csv');

        //     $export->except(['validasi']);

        //     // $export->only(['column3', 'column4']);

        //     // $export->originalValue(['column1', 'column2']);

        //     // $export->column('column_5', function ($value, $original) {
        //     //     return $value;
        //     // });
        // });
        $grid->quickSearch(function ($model, $query) {
            $model->where('guru', $query)->orWhere('nama_guru', 'like', "%{$query}%");
        });

        $grid->filter(function($filter)
        {
            // Remove the default id filter
            $filter->disableIdFilter();

            $guru= Guru::all()->pluck('nama_guru','id');
            $filter->equal('guru_id', 'Guru')->select($guru);

            $kelas= Kelas::all()->pluck('nama_kelas','id');
            $filter->equal('kelas_id', 'Kelas')->select($kelas);

            $filter->scope('new', 'Recently modified')
            ->whereDate('tanggal', date('Y-m-d'))
            ->orWhere('tanggal', date('Y-m-d'));

            // $filter->scope('male', 'Male')->where('gender', 'm');

            // $filter->equal('jurnal.guru_id','Guru')->placeholder('Please input...');


            // $gurujurnal = DB::table('jurnal')
            //     ->join('guru','jurnal.guru_id', '=', 'guru_id')
            //     ->select('jurnal','nama_guru')
            //     ->get();

            $gurujurnal = Jurnal::join('guru', 'jurnal.guru_id', '=', 'guru.id')
            ->pluck('guru.nama_guru', 'guru.id');

            // $filter->where(function ($query) {
            //     $query->whereHas('guru', function ($query) {
            //         $query->where('nama_guru', 'like', "%{$gurujurnal->input}%");
            //     });
            // }, 'Nama Guru')->placeholder('Please input...');

            // $filter->where(function ($query) use ($filter) {
            //     $query->where('nama_guru', 'LIKE', "{$filter->input}%");
            // }, 'Nama Guru')->placeholder('Masukkan');

            // $filter->equal('guru_id','Nama Guru')->select($gurujurnal);

            // Add a column filter
            // $filter->like('name', 'name');
        });

        // $grid->column('id',__('Id'));
        $grid->column('tanggal',__('Tgl'));
        $grid->column('guru.nama_guru',__('Nama Guru'));
        $grid->column('kelas.nama_kelas',__('Kelas'));
        $grid->column('jam.nama_jam',__('Jam Ke-'));
        $grid->column('hari',__('Hari'));
        $grid->column('mapel.nama_mapel',__('Mapel'));
        $grid->column('materi',__('Materi'));

        $grid->column('id', 'Ijin')->display(function ($id) {
            $jurnal = Jurnal::with('ijin')->find($id);
            if ($jurnal && $jurnal->ijin) {
                $siswaNames = $jurnal->ijin->pluck('nama_siswa')->toArray();
                return implode(', ', $siswaNames);
            }
            return 'Tidak ada siswa';
        });

        // $grid->column('siswa.nama_siswa',__('I'));
        // $grid->column('siswa.nama_siswa',__('S'));
        // $grid->column('siswa.nama_siswa',__('A'));

        $grid->column('admin.name',__('Inputer'));

        $states = [
            'on' => ['value' => 1, 'text' => 'Yes', 'color' => 'primary'],
            'off' => ['value' => 2, 'text' => 'No', 'color' => 'danger'],
        ];
        $grid->column('validasi','Approved')->switch($states);

        $grid->model()->where('validasi', '=', '1');

        $Tahunajaran = config('Tahun Ajaran');
        $grid->model()->where('tahunajaran','=',$Tahunajaran);
        $grid->column('tahunajaran','Tahun Ajaran');

        // $grid->footer(function ($query) {

        //     // Query the total amount of the order with the paid status
        //     $data = $query->where('status', 2)->sum('amount');

        //     return "<div style='padding: 10px;'>Total revenue ： $data</div>";
        // });


        // $grid->column('validasi',__('Validasi'))->switch();
        // $grid->column('User')->display(function(){
        // });

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
        $show -> field('kelas.nama_kelas',__('Kelas ID'));
        $show -> field('jam.nama_jam',__('Jam Mengajar'));
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

        // $form->hidden('user_id',__('User ID'))->value(Admin::user()->id);

        // // $form->display('updated_at', 'Updated time');
        // // $form -> switch('validasi',__('Validasi'));
        // // Jurnal::create(['user_id'=>1]);

        return $form;
    }
}
