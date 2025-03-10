@extends('layout.app')

@section('content')
    <div class="page-header">
        <h3 class="fw-bold">Rekap Pelatihan</h3>
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
                <a href="{{ url('/index-rekap-pelatihan') }}">Rekap Pelatihan</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Rekap Data Pelatihan</h4>
                    <div class="btn-group">
                        <button onclick="refreshPage()" class="btn btn-black btn-small">
                            <span class="btn-label">
                                <i class="fas fa-undo-alt"></i>
                            </span>
                            Refresh Data
                        </button>
                        &nbsp;&nbsp;
                        <button type="button" class="btn btn-small btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addRekapPelatihanModal">
                            <i class="fa fa-plus"></i> Tambah Data
                        </button>
                    </div>
                </div>
                <div class="card-body">

                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('rekapPelatihan.index') }}">
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
                                    <th>Total Plan Pelatihan</th>
                                    <th>Total Act Pelatihan</th>
                                    <th>Total Plan Partisipan</th>
                                    <th>Total Act Partisipan</th>
                                    <th>Periode Bulan</th>
                                    <th>Periode Tahun</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rekapPelatihan as $index => $rekap)
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
                                                        href="{{ route('dataPelatihan.index', ['id_rekap_pelatihan' => $rekap->id_rekap_pelatihan]) }}">
                                                        <i class="fas fa-eye"></i> Lihat Detail
                                                    </a>
                                                    <!-- Tombol Edit -->
                                                    <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#editRekapPelatihanModal"
                                                        data-id="{{ $rekap->id_rekap_pelatihan }}"
                                                        data-plant="{{ $rekap->id_plant }}"
                                                        data-plan-pelatihan="{{ $rekap->total_plan_pelatihan }}"
                                                        data-act-pelatihan="{{ $rekap->total_act_pelatihan }}"
                                                        data-plan-partisipan="{{ $rekap->total_plan_partisipan }}"
                                                        data-act-partisipan="{{ $rekap->total_act_partisipan }}"
                                                        data-periode-bulan="{{ $rekap->periode_bulan_pelatihan }}"
                                                        data-periode-tahun="{{ $rekap->periode_tahun_pelatihan }}">
                                                        <i class="fas fa-edit"></i> Edit Data
                                                    </a>

                                                    <!-- Tombol Hapus -->
                                                    <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#confirmDeleteModal"
                                                        data-id="{{ $rekap->id_rekap_pelatihan }}">
                                                        <i class="fas fa-trash"></i> Hapus Data
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Menampilkan data sesuai kolom yang ada di tabel -->
                                        <td>{{ $rekap->plant->nama_plant ?? '-' }}</td>
                                        <td>{{ $rekap->total_plan_pelatihan ?? '-' }}</td>
                                        <td>{{ $rekap->total_act_pelatihan ?? '-' }}</td>
                                        <td>{{ $rekap->total_plan_partisipan ?? '-' }}</td>
                                        <td>{{ $rekap->total_act_partisipan ?? '-' }}</td>
                                        <td>{{ $rekap->periode_bulan_pelatihan }}</td>
                                        <td>{{ $rekap->periode_tahun_pelatihan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Data Rekap Pelatihan -->
    <div class="modal fade" id="addRekapPelatihanModal" tabindex="-1" aria-labelledby="addRekapPelatihanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="addRekapPelatihanModalLabel">Tambah Rekap Pelatihan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('rekapPelatihan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="id_plant" class="fw-bold">Plant</label>
                            <select name="id_plant" class="form-control" required>
                                <option value="" disabled selected>-- Pilih Plant --</option>
                                @foreach($plants as $plant)
                                    <option value="{{ $plant->id_plant }}">{{ $plant->nama_plant }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="total_plan_pelatihan" class="fw-bold">Total Plan Pelatihan</label>
                            <input type="number" name="total_plan_pelatihan" class="form-control"
                                placeholder="Total Plan Pelatihan" required>
                        </div>

                        <div class="form-group">
                            <label for="periode_bulan_pelatihan" class="fw-bold">Periode Bulan</label>
                            <select name="periode_bulan_pelatihan" class="form-control" required>
                                <option value="" disabled selected>-- Pilih Bulan --</option>
                                @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                    <option value="{{ $month }}">{{ $month }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="periode_tahun_pelatihan" class="fw-bold">Periode Tahun</label>
                            <input type="number" name="periode_tahun_pelatihan" class="form-control"
                                placeholder="Periode Tahun" required>
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

    <!-- Modal Edit Data Rekap Pelatihan -->
    <div class="modal fade" id="editRekapPelatihanModal" tabindex="-1" aria-labelledby="editRekapPelatihanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="editRekapPelatihanModalLabel">Edit Rekap Pelatihan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditRekapPelatihan" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id_rekap_pelatihan" id="edit-id-rekap-pelatihan" />

                        <div class="form-group">
                            <label for="edit-total-plan-pelatihan" class="fw-bold">Total Plan Pelatihan <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="total_plan_pelatihan" id="edit-total-plan-pelatihan"
                                class="form-control" required />
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
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
            const editRekapPelatihanModal = document.getElementById("editRekapPelatihanModal");

            editRekapPelatihanModal.addEventListener("show.bs.modal", function (event) {
                const link = event.relatedTarget; // Link yang membuka modal
                const idRekapPelatihan = link.getAttribute("data-id");
                const totalPlanPelatihan = link.getAttribute("data-plan-pelatihan");
                const totalPlanPartisipan = link.getAttribute("data-plan-partisipan");

                // Isi form modal dengan data dari tabel
                document.getElementById("edit-id-rekap-pelatihan").value = idRekapPelatihan;
                document.getElementById("edit-total-plan-pelatihan").value = totalPlanPelatihan;
                document.getElementById("edit-total-plan-partisipan").value = totalPlanPartisipan;

                // Atur action form ke endpoint update yang sesuai
                document.getElementById("formEditRekapPelatihan").action = `/update-rekap-pelatihan/${idRekapPelatihan}`;
            });
        });

    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const confirmDeleteModal = document.getElementById("confirmDeleteModal");
            const deleteForm = document.getElementById("deleteForm");

            confirmDeleteModal.addEventListener("show.bs.modal", function (event) {
                const button = event.relatedTarget; // Link yang membuka modal
                const idRekapPelatihan = button.getAttribute("data-id"); // Ambil ID data yang dipilih

                // Set action form ke endpoint yang sesuai
                deleteForm.action = `/delete-rekap-pelatihan/${idRekapPelatihan}`;
            });
        });
    </script>

@endsection