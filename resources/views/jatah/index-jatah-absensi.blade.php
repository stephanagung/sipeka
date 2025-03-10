@extends('layout.app')

@section('content')
    <div class="page-header">
        <h3 class="fw-bold">Rekap Kuota Cuti & Absensi</h3>
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
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="display: flex; align-items: center; justify-content: space-between;">
                    <h4 class="card-title" style="margin: 0;">Rekap Data Kuota Cuti & Absensi</h4>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('jatah.index') }}">
                        <div class="row">
                            <!-- Filter Departemen -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="departemen_id">Pilih Departemen</label>
                                    <select id="departemen_id" name="departemen_id" class="form-control"
                                        onchange="this.form.submit()">
                                        <option value="">-- All Departemen --</option>
                                        @foreach ($departemen as $dept)
                                            <option value="{{ $dept->id_departemen }}" {{ request('departemen_id') == $dept->id_departemen ? 'selected' : '' }}>
                                                {{ $dept->nama_departemen }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Filter Plant -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="plant_id">Pilih Plant</label>
                                    <select id="plant_id" name="plant_id" class="form-control"
                                        onchange="this.form.submit()">
                                        <option value="">-- All Plant --</option>
                                        @foreach ($plants as $plant)
                                            <option value="{{ $plant->id_plant }}" {{ request('plant_id') == $plant->id_plant ? 'selected' : '' }}>
                                                {{ $plant->nama_plant }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive mt-3">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead class="table-success">
                                <tr>
                                    <th>No.</th>
                                    <th>Aksi</th>
                                    <th>Nama Pengguna</th>
                                    <th>Departemen-Plant</th>
                                    <th>Kuota Cuti</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jatahAbsensi as $index => $jatah)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary btn-small dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="{{ route('absensi.detail', ['id_jatah_absensi' => $jatah->id_jatah_absensi]) }}"><i
                                                            class="fas fa-info-circle"></i> Lihat Detail</a>
                                                    <!-- Tambahkan opsi lain seperti Edit dan Hapus jika diperlukan -->
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $jatah->pengguna->nama_lengkap }}</td>
                                        <td>{{ $jatah->pengguna->departemen->kode_departemen }} -
                                            {{ $jatah->pengguna->plant->kode_plant }}
                                        </td>
                                        <td>{{ $jatah->total_jatah_absensi }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection