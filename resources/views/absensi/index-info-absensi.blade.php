@extends('layout.app')

@section('content')
<div class="page-header">
    <h3 class="fw-bold">Data Detail Cuti & Absensi</h3>
    <ul class="breadcrumbs">
        <li class="nav-home">
            <a href="{{ url('/dashboard.dashboard-qp-1') }}">
                <i class="icon-home"></i>
            </a>
        </li>
        <li class="separator">
            <i class="icon-arrow-right"></i>
        </li>
        <li class="nav-item">
            <a href="{{ url('/index-absensi') }}">Rekap Cuti & Absensi</a>
        </li>
        <li class="separator">
            <i class="icon-arrow-right"></i>
        </li>
        <li class="nav-item">
            <a href="#">Data Detail Cuti & Absensi </a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="display: flex; align-items: center; justify-content: space-between;">
                <h4 class="card-title" style="margin: 0;">Informasi Cuti & Absensi</h4>
                <div class="btn-group">
                    <button onclick="refreshPage()" class="btn btn-black btn-small">
                        <span class="btn-label">
                            <i class="fas fa-undo-alt"></i>
                        </span>
                        Refresh Data
                    </button>
                    &nbsp;&nbsp;
                    <a href="{{ url('/index-absensi') }}">
                        <button class="btn btn-secondary btn-small">
                            <span class="btn-label">
                                <i class="fas fa-long-arrow-alt-left"></i>
                            </span>
                            Kembali
                        </button>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Nama Pengguna:</th>
                            <td>{{ $absensi->jatahAbsensi->pengguna->nama_lengkap ?? '-' }} (NIK:
                                {{ $absensi->jatahAbsensi->pengguna->nik ?? '-' }})
                            </td>
                        </tr>
                        <tr>
                            <th>Departemen:</th>
                            <td>{{ $absensi->jatahAbsensi->pengguna->departemen->nama_departemen ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kategori Absensi:</th>
                            <td>{{ $absensi->kategori->nama_kategori_absensi }}
                                ({{ $absensi->kategori->kode_kategori_absensi }})</td>
                        </tr>
                        <tr>
                            <th>Tanggal Absensi Mulai:</th>
                            <td>{{ $absensi->tanggal_absensi_mulai }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Absensi Akhir:</th>
                            <td>{{ $absensi->tanggal_absensi_akhir }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Absensi:</th>
                            <td>{{ $absensi->jumlah_absensi ?? '-' }} hari</td>
                        </tr>
                        <tr>
                            <th>Alasan:</th>
                            <td>{{ $absensi->alasan }}</td>
                        </tr>
                        <tr>
                            <th>Catatan:</th>
                            <td>{{ $absensi->catatan }}</td>
                        </tr>
                        <tr>
                            <th>Status Disetujui Atasan:</th>
                            <td>{{ $absensi->disetujui_atasan ? 'Disetujui' : 'Belum Disetujui' }}</td>
                        </tr>
                        <tr>
                            <th>Status Disetujui HRD:</th>
                            <td>{{ $absensi->disetujui_hrd ? 'Disetujui' : 'Belum Disetujui' }}</td>
                        </tr>
                        @if ($absensi->dokumen_pendukung)
                            <tr>
                                <th>Dokumen Pendukung:</th>
                                <td>
                                    <a href="{{ Storage::url($absensi->dokumen_pendukung) }}" target="_blank">
                                        Lihat Dokumen
                                    </a>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection