<?php

namespace App\Http\Controllers;
use App\Models\SipekaPengguna;
use App\Models\SipekaRekapKaizen;
use App\Models\SipekaDataKaizen;
use App\Models\SipekaDepartemen;
use App\Models\SipekaPlant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SipekaDashboardQP3Controller extends Controller
{
    public function index()
    {
        $rekapSDM = $this->getRekapSDM();
        $rekapKaizen = $this->getRekapKaizen();

        return view('dashboard.dashboard-qp-3', array_merge($rekapSDM, $rekapKaizen));
    }

    public function getRekapSDM()
    {
        $user = Session::get('user');
        if (!$user) {
            return redirect()->route('login')->withErrors(['msg' => 'Harap login terlebih dahulu.']);
        }

        $id_plant = $user->id_plant;

        // Data Statistik SDM
        $rekapSDM = [
            'total_karyawan' => SipekaPengguna::where('id_plant', $id_plant)->count(),
            'total_tetap' => SipekaPengguna::where('id_plant', $id_plant)->where('status_pekerjaan', 'Tetap')->count(),
            'total_kontrak' => SipekaPengguna::where('id_plant', $id_plant)->where('status_pekerjaan', 'Kontrak')->count(),
            'total_magang' => SipekaPengguna::where('id_plant', $id_plant)->where('status_pekerjaan', 'Magang/PKL')->count(),
            'total_pria' => SipekaPengguna::where('id_plant', $id_plant)->where('jenis_kelamin', 'Pria')->count(),
            'total_wanita' => SipekaPengguna::where('id_plant', $id_plant)->where('jenis_kelamin', 'Wanita')->count(),
            'total_bekasi' => SipekaPengguna::where('id_plant', $id_plant)->where('domisili', 'Bekasi')->count(),
            'total_luar_bekasi' => SipekaPengguna::where('id_plant', $id_plant)->where('domisili', 'LuarBekasi')->count(),
        ];

        // Data Pendidikan
        $pendidikanEnum = ['SD', 'SMP', 'SMA', 'SMK', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'];
        $rekapPendidikan = [];

        foreach ($pendidikanEnum as $pendidikan) {
            $rekapPendidikan[$pendidikan] = SipekaPengguna::where('id_plant', $id_plant)
                ->where('pendidikan_terakhir', $pendidikan)
                ->count();
        }

        // Data Status Pekerjaan
        $statusPekerjaanEnum = ['Tetap', 'Kontrak', 'Magang/PKL'];
        $rekapStatusPekerjaan = [];

        foreach ($statusPekerjaanEnum as $status) {
            $rekapStatusPekerjaan[$status] = SipekaPengguna::where('id_plant', $id_plant)
                ->where('status_pekerjaan', $status)
                ->count();
        }

        // Data Domisili
        $domisiliEnum = ['Bekasi', 'LuarBekasi'];
        $rekapDomisili = [];

        foreach ($domisiliEnum as $domisili) {
            $rekapDomisili[$domisili] = SipekaPengguna::where('id_plant', $id_plant)
                ->where('domisili', $domisili)
                ->count();
        }

        // Ambil semua departemen
        $allDepartemen = SipekaDepartemen::pluck('nama_departemen', 'id_departemen')->toArray();

        // Ambil jumlah karyawan per departemen
        $rekapDepartemen = SipekaPengguna::where('id_plant', $id_plant)
            ->selectRaw('id_departemen, COUNT(*) as jumlah')
            ->groupBy('id_departemen')
            ->pluck('jumlah', 'id_departemen')
            ->toArray();

        // Pastikan semua departemen tampil (meskipun kosong)
        $departemenData = [];
        foreach ($allDepartemen as $id_departemen => $nama) {
            $departemenData[$nama] = $rekapDepartemen[$id_departemen] ?? 0;
        }

        return compact('rekapSDM', 'rekapPendidikan', 'rekapStatusPekerjaan', 'rekapDomisili', 'departemenData');
    }

    public function getRekapKaizen()
    {
        $user = Session::get('user');
        if (!$user) {
            return redirect()->route('login')->withErrors(['msg' => 'Harap login terlebih dahulu.']);
        }

        $id_plant = $user->id_plant;
        $id_departemen = $user->id_departemen;
        $currentYear = date('Y');
        $currentMonth = date('m');

        // Data untuk Card
        $kaizenBulanIni = SipekaDataKaizen::whereHas('pengguna', function ($query) use ($id_departemen, $id_plant) {
            $query->where('id_departemen', $id_departemen)->where('id_plant', $id_plant);
        })
            ->whereMonth('tanggal_penerbitan_kaizen', $currentMonth)
            ->whereYear('tanggal_penerbitan_kaizen', $currentYear)
            ->sum('jumlah_kaizen');

        $kaizenTahunIni = SipekaDataKaizen::whereHas('pengguna', function ($query) use ($id_departemen, $id_plant) {
            $query->where('id_departemen', $id_departemen)->where('id_plant', $id_plant);
        })
            ->whereYear('tanggal_penerbitan_kaizen', $currentYear)
            ->sum('jumlah_kaizen');

        $kaizenKeseluruhan = SipekaDataKaizen::whereHas('pengguna', function ($query) use ($id_departemen, $id_plant) {
            $query->where('id_departemen', $id_departemen)->where('id_plant', $id_plant);
        })
            ->sum('jumlah_kaizen');

        // Grafik Kaizen per Tahun
        $rekapKaizenPerTahun = SipekaDataKaizen::whereHas('pengguna', function ($query) use ($id_departemen, $id_plant) {
            $query->where('id_departemen', $id_departemen)->where('id_plant', $id_plant);
        })
            ->selectRaw('YEAR(tanggal_penerbitan_kaizen) as tahun, SUM(jumlah_kaizen) as total')
            ->groupBy('tahun')
            ->orderBy('tahun', 'ASC')
            ->get();

        // Grafik Kaizen per Bulan Tahun Ini (Menampilkan jumlah Kaizen & jumlah pengguna yang melakukan Kaizen)
        $rekapKaizenPerBulan = SipekaDataKaizen::whereHas('pengguna', function ($query) use ($id_departemen, $id_plant) {
            $query->where('id_departemen', $id_departemen)->where('id_plant', $id_plant);
        })
            ->whereYear('tanggal_penerbitan_kaizen', $currentYear)
            ->selectRaw('MONTH(tanggal_penerbitan_kaizen) as bulan, COUNT(DISTINCT id_pengguna) as jumlah_pengguna, SUM(jumlah_kaizen) as total_kaizen')
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC')
            ->get();

        // **Perbaikan: Grafik Kaizen per Bulan Tahun Ini berdasarkan Pengguna (Nama Lengkap)**
        $rekapKaizenPenggunaPerBulan = SipekaDataKaizen::whereHas('pengguna', function ($query) use ($id_departemen, $id_plant) {
            $query->where('id_departemen', $id_departemen)->where('id_plant', $id_plant);
        })
            ->whereYear('tanggal_penerbitan_kaizen', $currentYear)
            ->selectRaw('MONTH(tanggal_penerbitan_kaizen) as bulan, id_pengguna, SUM(jumlah_kaizen) as total_kaizen')
            ->groupBy('bulan', 'id_pengguna')
            ->orderBy('bulan', 'ASC')
            ->get();

        // **Mengelompokkan data untuk chart (bulan -> nama lengkap pengguna -> jumlah Kaizen)**
        $dataKaizenPerPengguna = [];
        foreach ($rekapKaizenPenggunaPerBulan as $data) {
            $namaPengguna = SipekaPengguna::where('id_pengguna', $data->id_pengguna)->value('nama_lengkap'); // **Gunakan nama_lengkap**
            $bulan = $data->bulan;

            if (!isset($dataKaizenPerPengguna[$bulan])) {
                $dataKaizenPerPengguna[$bulan] = [];
            }

            $dataKaizenPerPengguna[$bulan][$namaPengguna] = $data->total_kaizen;
        }

        return compact(
            'kaizenBulanIni',
            'kaizenTahunIni',
            'kaizenKeseluruhan',
            'rekapKaizenPerTahun',
            'rekapKaizenPerBulan',
            'dataKaizenPerPengguna' // **Tambahan baru**
        );
    }

}
