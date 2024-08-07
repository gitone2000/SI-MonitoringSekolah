<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jam;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\InfoBox;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        $jumlah_guru = Guru::count();
        $jumlah_kelas = Kelas::count();
        $jumlah_siswa = Siswa::count();
        $jumlah_mapel = Mapel::count();
        $jumlah_jam = Jam::count();
        $jumlah_jurusan = Jurusan::count();


        $infoguru = new InfoBox('Jumlah Guru', 'guru', 'blue', '', $jumlah_guru);
        $infokelas = new Infobox('Jumlah Kelas', 'kelas', 'yellow', '', $jumlah_kelas);
        $infosiswa = new Infobox('Jumlah Siswa', 'siswa', 'red', '', $jumlah_siswa);
        $infomapel = new Infobox('Jumlah Mapel', 'mapel', 'purple', '', $jumlah_mapel);
        $infojam = new Infobox('Jumlah Jam Mengajar', 'jam', 'green', '', $jumlah_jam);
        $infojurusan = new Infobox('Jumlah Jurusan', 'jurusan', 'orange', '', $jumlah_jurusan);

        // $infoguru = new InfoBox('Jumlah Guru', 'guru', 'blue', '/admin/guru', $jumlah_guru);
        // $infokelas = new Infobox('Jumlah Kelas', 'kelas', 'yellow', '/admin/kelas', $jumlah_kelas);
        // $infosiswa = new Infobox('Jumlah Siswa', 'siswa', 'red', '/admin/siswa', $jumlah_siswa);
        // $infomapel = new Infobox('Jumlah Mapel', 'mapel', 'blue', '/admin/mapel', $jumlah_mapel);
        // $infojam = new Infobox('Jumlah Jam Mengajar', 'jam', 'green', '/admin/jam', $jumlah_jam);


        return $content
            ->title('Dashboard')
            ->description('Information')

            ->row(function (Row $row) use ($infoguru,$infokelas,$infosiswa,$infomapel,$infojam,$infojurusan) {

                $row -> column(3, function(Column $column) use($infoguru) {
                    $column->append("<div class='text-center'>".$infoguru->render()."</div>");
                });

                $row -> column(3, function(Column $column) use($infosiswa) {
                    $column->append("<div class='text-center'>".$infosiswa->render()."</div>");
                });

                $row -> column(3, function(Column $column) use($infokelas) {
                    $column->append("<div class='text-center'>".$infokelas->render()."</div>");
                });

                $row -> column(3, function(Column $column) use($infojurusan) {
                    $column->append("<div class='text-center'>".$infojurusan->render()."</div>");
                });

                $row -> column(3, function(Column $column) use($infomapel) {
                    $column->append("<div class='text-center'>".$infomapel->render()."</div>");
                });

                $row -> column(3, function(Column $column) use($infojam) {
                    $column->append("<div class='text-center'>".$infojam->render()."</div>");
                });

            })

            // ->row($infoguru -> render())
            // ->row($infokelas -> render())
            // ->row(Dashboard::title())
            ->row(function (Row $row) {

                // $row->column(4, function (Column $column) {
                //     $column->append(Dashboard::environment());
                // });

                // $row->column(4, function (Column $column) {
                //     $column->append(Dashboard::extensions());
                // });

                // $row->column(4, function (Column $column) {
                //     $column->append(Dashboard::dependencies());
            }
        );
    }
}
