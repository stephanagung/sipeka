<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdateJatahAbsensi extends Command
{
    protected $signature = 'update:jatah-absensi';
    protected $description = 'Menambahkan 1 pada total_jatah_absensi untuk pengguna yang telah bekerja selama lebih dari 1 tahun setiap bulan.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $currentDate = Carbon::now();

        // Cari pengguna yang telah bekerja lebih dari 1 tahun
        $jatahAbsensiUsers = DB::table('sipeka_jatah_absensi')
            ->join('sipeka_pengguna', 'sipeka_jatah_absensi.id_pengguna', '=', 'sipeka_pengguna.id_pengguna')
            ->whereDate('sipeka_jatah_absensi.tanggal_bergabung', '<=', $currentDate->copy()->subYear())
            ->select('sipeka_jatah_absensi.id_jatah_absensi')
            ->get();

        foreach ($jatahAbsensiUsers as $jatahAbsensiUser) {
            // Tambahkan 1 ke total_jatah_absensi
            DB::table('sipeka_jatah_absensi')
                ->where('id_jatah_absensi', $jatahAbsensiUser->id_jatah_absensi)
                ->increment('total_jatah_absensi', 1);
        }

        $this->info('Total jatah absensi berhasil diperbarui.');
    }
}

