@extends('layout.app')

@section('content')
    <div class="page-header">
        <h3 class="fw-bold">Rekap Kecelakaan</h3>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ url('/dashboard-qp-1') }}">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="{{ url('/index-rekap-kecelakaan') }}">Rekap Kecelakaan</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Rekap Data Kecelakaan</h4>
                    <div class="btn-group">
                        <button onclick="refreshPage()" class="btn btn-black btn-small">
                            <span class="btn-label">
                                <i class="fas fa-undo-alt"></i>
                            </span>
                            Refresh Data
                        </button>
                        &nbsp;&nbsp;
                        <button type="button" class="btn btn-small btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addRekapKecelakaanModal">
                            <i class="fa fa-plus"></i> Tambah Data
                        </button>
                    </div>
                </div>

                <div class="card-body">

                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('rekapKecelakaan.index') }}">
                        <div class="row">
                            <!-- Filter Plant -->
                            <div class="col-md-4">
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

                            <!-- Filter Periode Bulan -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="periode_bulan">Pilih Periode Bulan</label>
                                    <select id="periode_bulan" name="periode_bulan" class="form-control"
                                        onchange="this.form.submit()">
                                        <option value="">-- All Bulan --</option>
                                        @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $bulan)
                                            <option value="{{ $bulan }}" {{ request('periode_bulan') == $bulan ? 'selected' : '' }}>
                                                {{ $bulan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Filter Periode Tahun -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="periode_tahun">Pilih Periode Tahun</label>
                                    <select id="periode_tahun" name="periode_tahun" class="form-control"
                                        onchange="this.form.submit()">
                                        <option value="">-- All Tahun --</option>
                                        @for ($tahun = date('Y'); $tahun >= date('Y') - 5; $tahun--)
                                            <option value="{{ $tahun }}" {{ request('periode_tahun') == $tahun ? 'selected' : '' }}>
                                                {{ $tahun }}
                                            </option>
                                        @endfor
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
                                    <th>Plant</th>
                                    <th>Total Kecelakaan</th>
                                    <th>Total Korban Kecelakaan</th>
                                    <th>Periode Bulan</th>
                                    <th>Periode Tahun</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rekapKecelakaan as $index => $rekap)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary btn-small dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <div class="dropdown-menu">
                                                    <!-- Lihat Detail -->
                                                    <a class="dropdown-item"
                                                        href="{{ route('dataKecelakaan.index', ['id_rekap_kecelakaan' => $rekap->id_rekap_kecelakaan]) }}">
                                                        <i class="fas fa-eye"></i> Lihat Detail
                                                    </a>

                                                    <!-- Tombol Hapus -->
                                                    <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#confirmDeleteModal"
                                                        data-id="{{ $rekap->id_rekap_kecelakaan }}">
                                                        <i class="fas fa-trash"></i> Hapus Data
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Menampilkan data sesuai kolom yang ada di tabel -->
                                        <td>{{ $rekap->plant->nama_plant ?? '-' }}</td>
                                        <td>{{ $rekap->total_kecelakaan ?? '-' }}</td>
                                        <td>{{ $rekap->total_korban_kecelakaan ?? '-' }}</td>
                                        <td>{{ $rekap->periode_bulan_kecelakaan }}</td>
                                        <td>{{ $rekap->periode_tahun_kecelakaan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Rekap Kecelakaan -->
    <div class="modal fade" id="addRekapKecelakaanModal" tabindex="-1" aria-labelledby="addRekapKecelakaanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="addRekapKecelakaanModalLabel">Tambah Rekap Kecelakaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('rekapKecelakaan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <!-- Pilih Plant -->
                        <div class="form-group">
                            <label for="id_plant" class="fw-bold">Plant</label>
                            <select name="id_plant" class="form-control" required>
                                <option value="" disabled selected>-- Pilih Plant --</option>
                                @foreach($plants as $plant)
                                    <option value="{{ $plant->id_plant }}">{{ $plant->nama_plant }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Periode Bulan -->
                        <div class="form-group">
                            <label for="periode_bulan_kecelakaan" class="fw-bold">Periode Bulan</label>
                            <select name="periode_bulan_kecelakaan" class="form-control" required>
                                <option value="" disabled selected>-- Pilih Bulan --</option>
                                @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                    <option value="{{ $month }}">{{ $month }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Periode Tahun -->
                        <div class="form-group">
                            <label for="periode_tahun_kecelakaan" class="fw-bold">Periode Tahun</label>
                            <input type="number" name="periode_tahun_kecelakaan" class="form-control" required>
                        </div>

                        <!-- Total Kecelakaan -->
                        <div class="form-group">
                            <label for="total_kecelakaan" class="fw-bold">Total Kecelakaan</label>
                            <input type="number" name="total_kecelakaan" class="form-control" required>
                        </div>

                        <!-- Total Korban Kecelakaan -->
                        <div class="form-group">
                            <label for="total_korban_kecelakaan" class="fw-bold">Total Korban Kecelakaan</label>
                            <input type="number" name="total_korban_kecelakaan" class="form-control" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const confirmDeleteModal = document.getElementById("confirmDeleteModal");
            const deleteForm = document.getElementById("deleteForm");

            confirmDeleteModal.addEventListener("show.bs.modal", function (event) {
                const button = event.relatedTarget; // Link yang membuka modal
                const idRekapKecelakaan = button.getAttribute("data-id"); // Ambil ID data yang dipilih

                // Set action form ke endpoint yang sesuai
                deleteForm.action = `/delete-rekap-kecelakaan/${idRekapKecelakaan}`;
            });
        });
    </script>

@endsection