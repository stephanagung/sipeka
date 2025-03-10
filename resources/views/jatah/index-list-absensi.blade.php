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
                <a href="{{ url('/index-jatah-absensi') }}">Rekap Kuota Cuti & Absensi</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Data Detail Cuti & Absensi</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="display: flex; align-items: center; justify-content: space-between;">
                    <h4 class="card-title" style="margin: 0;">Detail Informasi Pengguna</h4>
                    <div class="btn-group">
                        <button onclick="refreshPage()" class="btn btn-black btn-small">
                            <span class="btn-label">
                                <i class="fas fa-undo-alt"></i>
                            </span>
                            Refresh Data
                        </button>
                        &nbsp;&nbsp;
                        <button class="btn btn-primary btn-small" data-bs-toggle="modal" data-bs-target="#updateKuotaModal">
                            <span class="btn-label">
                                <i class="fas fa-edit"></i>
                            </span>
                            Update Kuota Cuti
                        </button>

                        &nbsp;&nbsp;
                        <a href="{{ url('/index-jatah-absensi') }}">
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
                    <div class="row">
                        <!-- Bagian Kiri -->
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="nik" class="label-bold">NIK</label>
                                <input type="text" class="form-control input-disabled" id="nik" value="{{ $pengguna->nik }}"
                                    disabled />
                            </div>
                            <div class="form-group">
                                <label for="nama_lengkap" class="label-bold">Nama Lengkap</label>
                                <input type="text" class="form-control input-disabled" id="nama_lengkap"
                                    value="{{ $pengguna->nama_lengkap }}" disabled />
                            </div>
                            <div class="form-group">
                                <label for="departemen" class="label-bold">Departemen</label>
                                <input type="text" class="form-control input-disabled" id="departemen"
                                    value="{{ $pengguna->departemen->nama_departemen }}" disabled />
                            </div>
                            <div class="form-group">
                                <label for="plant" class="label-bold">Plant</label>
                                <input type="text" class="form-control input-disabled" id="plant"
                                    value="{{ $pengguna->plant->nama_plant }}" disabled />
                            </div>
                            <div class="form-group">
                                <label for="jabatan" class="label-bold">Jabatan</label>
                                <input type="text" class="form-control input-disabled" id="jabatan"
                                    value="{{ $pengguna->jabatan }}" disabled />
                            </div>
                            <div class="form-group">
                                <label for="status_pekerjaan" class="label-bold">Status Pekerjaan</label>
                                <input type="text" class="form-control input-disabled" id="status_pekerjaan"
                                    value="{{ $pengguna->status_pekerjaan }}" disabled />
                            </div>
                            <div class="form-group">
                                <label for="jenis_lemburan" class="label-bold">Jenis Lemburan</label>
                                <input type="text" class="form-control input-disabled" id="jenis_lemburan"
                                    value="{{ $pengguna->jenis_lemburan }}" disabled />
                            </div>
                            <div class="form-group">
                                <label for="domisili" class="label-bold">Domisili</label>
                                <input type="text" class="form-control input-disabled" id="domisili"
                                    value="{{ $pengguna->domisili }}" disabled />
                            </div>
                        </div>

                        <!-- Bagian Kanan -->
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="tanggal_bergabung" class="label-bold">Tanggal Bergabung</label>
                                <input type="text" class="form-control input-disabled" id="tanggal_bergabung"
                                    value="{{ $jatahAbsensi->tanggal_bergabung }}" disabled />
                            </div>
                            <div class="form-group">
                                <label for="total_jatah_absensi" class="label-bold">Total Jatah Absensi</label>
                                <input type="text" class="form-control input-disabled" id="total_jatah_absensi"
                                    value="{{ $jatahAbsensi->total_jatah_absensi }}" disabled />
                            </div>
                            <div class="form-group">
                                <label for="jenis_kelamin" class="label-bold">Jenis Kelamin</label>
                                <input type="text" class="form-control input-disabled" id="jenis_kelamin"
                                    value="{{ $pengguna->jenis_kelamin }}" disabled />
                            </div>
                            <div class="form-group">
                                <label for="pendidikan_terakhir" class="label-bold">Pendidikan Terakhir</label>
                                <input type="text" class="form-control input-disabled" id="pendidikan_terakhir"
                                    value="{{ $pengguna->pendidikan_terakhir }}" disabled />
                            </div>
                            <div class="form-group">
                                <label for="username" class="label-bold">Username</label>
                                <input type="text" class="form-control input-disabled" id="username"
                                    value="{{ $pengguna->username }}" disabled />
                            </div>
                            <div class="form-group">
                                <label for="password" class="label-bold">Password</label>
                                <input type="password" class="form-control input-disabled" id="password"
                                    value="{{ $pengguna->password }}" disabled />
                            </div>
                            <div class="form-group">
                                <label for="level" class="label-bold">Level</label>
                                <input type="text" class="form-control input-disabled" id="level"
                                    value="{{ $pengguna->level }}" disabled />
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="display: flex; align-items: center; justify-content: space-between;">
                    <h4 class="card-title" style="margin: 0;">Histori Informasi Cuti & Absensi</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive mt-3">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead class="table-success">
                                <tr>
                                    <th>No.</th>
                                    <th>Dokumen Pendukung</th>
                                    <th>Status Presensi</th>
                                    <th>Tanggal Absensi Mulai</th>
                                    <th>Tanggal Absensi Akhir</th>
                                    <th>Jumlah Absensi</th>
                                    <th>Alasan</th>
                                    <th>Catatan</th>
                                    <th>Disetujui Atasan</th>
                                    <th>Disetujui HRD</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($absensi as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <a href="{{ Storage::url($item->dokumen_pendukung) }}" target="_blank">
                                                Lihat Dokumen
                                            </a>
                                        </td>
                                        <td>{{ $item->status_absensi }}</td>
                                        <td>{{ $item->tanggal_absensi_mulai }}</td>
                                        <td>{{ $item->tanggal_absensi_akhir }}</td>
                                        <td>{{ $item->jumlah_absensi }}</td>
                                        <td>{{ $item->alasan }}</td>
                                        <td>{{ $item->catatan }}</td>
                                        <td>{{ $item->disetujui_atasan }}</td>
                                        <td>{{ $item->disetujui_hrd }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Update Kuota Cuti -->
    <div class="modal fade" id="updateKuotaModal" tabindex="-1" aria-labelledby="updateKuotaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateKuotaModalLabel"><strong>Update Kuota Cuti</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk update kuota cuti -->
                    <form id="updateKuotaForm"
                        action="{{ route('jatah.update', ['id_jatah_absensi' => $jatahAbsensi->id_jatah_absensi]) }}"
                        method="POST">
                        @csrf
                        @method('PUT') <!-- Menggunakan method PUT -->

                        <!-- Mengirimkan id_jatah_absensi melalui hidden input -->
                        <div class="form-group">
                            <label for="total_jatah_absensi" class="label-bold">Total Jatah Absensi</label>
                            <input type="number" class="form-control" id="total_jatah_absensi" name="total_jatah_absensi"
                                value="{{ $jatahAbsensi->total_jatah_absensi }}" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
                </form>
            </div>
        </div>
    </div>



@endsection