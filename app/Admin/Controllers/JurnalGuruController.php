<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Post\JurnalEdit;
use App\Models\Guru;
use App\Models\Jam;
use App\Models\Jurnal;
use App\Models\JurnalChild;
use App\Models\JurnalSiswa;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Semester;
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
            $filter->disableIdFilter();

            $guru= Guru::all()->pluck('nama_guru','id');
            $filter->equal('guru_id', 'Guru')->select($guru);

            $kelas= Kelas::all()->pluck('kode','id');
            $filter->equal('kelas_id', 'Kelas')->select($kelas);
        });

        if(!Admin::user()->isRole('administrator')){
            $username = Admin::user()->id;
            $guru = Guru::where('user_id','=',$username)->first();

            $grid->model()->where('guru_id','=',$guru->id);
        }

        $grid->model()->join('semester', 'jurnal.semester_id', '=', 'semester.id')
            ->select('jurnal.*')
            ->where('semester.validasi', 1);

        $grid->column('guru.nama_guru',__('Nama Guru'));
        $grid->column('kelas.kode',__('Kelas'));
        $grid->column('jam', 'Jam Mengajar')->display(function () {
            return "| {$this->jam->jam_ke} | {$this->jam->waktu_awal} - {$this->jam->waktu_akhir} |";
        });
        $grid->column('hari',__('Hari'));
        $grid->column('mapel.nama_mapel',__('Mapel'));
        $grid->column('semester.semester',__('Semester'));

        $grid->column('edit', __('Input-Jurnal'))->display(function () {
            return "<a href='" . route('admin.jurnalguru.edit', ['jurnalguru' => $this->getKey()]) . "' class='btn btn-xs btn-success'><i class='fa fa-edit'></i> Jurnal</a>";
        });

        // $grid->column('tahunajaran','Tahun Ajaran');
        // $Tahunajaran = config('Tahun Ajaran');
        // $grid->model()->where('tahunajaran','=',$Tahunajaran);
        // $grid->column('admin.name',__('Guru'));

        $grid->disableCreateButton();
        $grid->disableExport();
        $grid->disableActions();

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
        $show->field('jam.jam_ke',__('Jam Mengajar'));
        $show->field('hari',__('Hari'));
        $show->field('mapel.nama_mapel',__('Mapel'));
        $show->field('semester.semester',__('Semester'));

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
        $id = request()->route('jurnalguru');
        $jurnal = Jurnal::findOrFail($id);
        $id_kelas = $jurnal->kelas_id;
        // dd($id_kelas);

        $daftar_guru = Guru::all()->pluck('nama_guru','id');
        $daftar_jam = Jam::all()->pluck('jam_ke','id');
        $daftar_kelas = Kelas::all()->pluck('kode','id');
        $daftar_mapel = Mapel::all()->pluck('nama_mapel','id');

        // $jurnal_siswa = DB::table('siswa')
        // ->join('kelas', 'siswa.kelas_id', '=', 'kelas.id')
        // ->join('jurnal', 'kelas.id', '=', 'jurnal.kelas_id')
        // ->select('siswa.id', 'siswa.nama_siswa')
        // ->where('jurnal.kelas_id', $id_kelas)
        // ->groupBy('siswa.id', 'siswa.nama_siswa')
        // ->get()
        // ->pluck('nama_siswa', 'id')
        // ->toArray();
        // dd($jurnal_siswa);

        $jurnal_siswa = Siswa::where('kelas_id',strval($id_kelas))->pluck('nama_siswa','id');
        $daftar_semester = Semester::where('validasi','=',1)->pluck('semester','id');

        $form -> select('guru_id',__('Guru'))->options($daftar_guru)->readonly();
        $form -> select('kelas_id',__('Kelas'))->options($daftar_kelas)->readonly();
        $form -> select('jam_id',__('Jam Mengajar'))->options($daftar_jam)->readonly();
        $form -> text('hari',__('Hari'))->readonly();
        $form -> select('mapel_id',__('Mapel'))->options($daftar_mapel)->readonly();
        $form -> text('semester.semester',__('Semester'))->options($daftar_semester)->readonly();

        $form->hasMany('childs', __('Jurnal'), function (Form\NestedForm $form) use ($jurnal_siswa) {

            $form->date('tanggal', __('Tanggal'))->required();
            $form->textarea('materi', __('Materi'))->required();

            $form->multipleSelect('izin',__('Izin'))->options($jurnal_siswa);
            $form->multipleSelect('sakit',__('Sakit'))->options($jurnal_siswa);
            $form->multipleSelect('alpha',__('Alpha'))->options($jurnal_siswa);

        });

        $form -> disableViewCheck();
        $form -> disableCreatingCheck();
        $form -> disableEditingCheck();

        return $form;
    }
 }
