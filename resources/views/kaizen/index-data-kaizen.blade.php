@extends('layout.app')

@section('content')
    <div class="page-header">
        <h3 class="fw-bold">Data Kaizen</h3>
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
                <a href="{{ url('/index-rekap-kaizen') }}">Rekap Kaizen</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Data Kaizen</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="display: flex; align-items: center; justify-content: space-between;">
                    <h4 class="card-title" style="margin: 0;">Data Kaizen</h4>
                    <div class="btn-group">
                        <a href="{{ url('/index-rekap-kaizen') }}">
                            <button class="btn btn-black btn-small">
                                <span class="btn-label">
                                    <i class="fas fa-long-arrow-alt-left"></i>
                                </span>
                                Kembali
                            </button>
                        </a>
                        &nbsp;&nbsp;
                        <button onclick="refreshPage()" class="btn btn-black btn-small">
                            <span class="btn-label">
                                <i class="fas fa-undo-alt"></i>
                            </span>
                            Refresh Data
                        </button>
                        &nbsp;&nbsp;
                        <button type="button" class="btn btn-small btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addKaizenModal">
                            <i class="fa fa-plus"></i> Tambah Data
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('dataKaizen.index', ['id_rekap_kaizen' => $id_rekap_kaizen]) }}">
                        <div class="row">
                            <!-- Filter Departemen - Full Width -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="departemen_id">Pilih Departemen</label>
                                    <select id="departemen_id" name="departemen_id" class="form-control"
                                        onchange="this.form.submit()">
                                        <option value="">-- All Departemen --</option>
                                        @foreach ($departemens as $departemen)
                                            <option value="{{ $departemen->id_departemen }}" {{ request('departemen_id') == $departemen->id_departemen ? 'selected' : '' }}>
                                                {{ $departemen->nama_departemen }}
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
                                    <th>Nama Kaizen</th>
                                    <th>Nama Lengkap</th>
                                    <th>Jumlah Kaizen</th>
                                    <th>Tanggal Penerbitan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataKaizen as $index => $kaizen)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary btn-small dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#editKaizenModal"
                                                        data-id="{{ $kaizen->id_data_kaizen }}"
                                                        data-id-pengguna="{{ $kaizen->id_pengguna }}"
                                                        data-nama-pengguna="{{ $kaizen->pengguna->nama_lengkap ?? '-' }}"
                                                        data-nama="{{ $kaizen->nama_kaizen }}"
                                                        data-jumlah="{{ $kaizen->jumlah_kaizen }}"
                                                        data-tanggal="{{ $kaizen->tanggal_penerbitan_kaizen }}"><i
                                                            class="fas fa-edit"></i>
                                                        Edit Data
                                                    </a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#confirmDeleteModal"
                                                        data-id="{{ $kaizen->id_data_kaizen }}"><i class="fas fa-trash"></i>
                                                        Hapus Data</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $kaizen->nama_kaizen }}</td>
                                        <td>{{ $kaizen->pengguna->nama_lengkap ?? '-' }}</td>
                                        <td>{{ $kaizen->jumlah_kaizen ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($kaizen->tanggal_penerbitan_kaizen)->format('d-m-Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Data Kaizen -->
    <div class="modal fade" id="addKaizenModal" tabindex="-1" aria-labelledby="addKaizenModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="addKaizenModalLabel">Tambah Data Kaizen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAddKaizen" action="{{ route('dataKaizen.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_rekap_kaizen" value="{{ $id_rekap_kaizen }}" />
                        <input type="hidden" id="periodeBulan" value="{{ $periode_bulan }}">
                        <input type="hidden" id="periodeTahun" value="{{ $periode_tahun }}">

                        <!-- Menampilkan Plant dari Rekap Kaizen -->
                        <div class="form-group">
                            <label class="fw-bold">Plant <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="{{ $rekapKaizen->plant->nama_plant }}" readonly>
                        </div>

                        <!-- Pilih Departemen (untuk filter pengguna) -->
                        <div class="form-group">
                            <label class="fw-bold">Pilih Departemen <span class="text-danger">*</span></label>
                            <select id="departemenFilter" class="form-control">
                                <option value="" disabled selected>Pilih Departemen</option>
                                @foreach ($departemens as $departemen)
                                    <option value="{{ $departemen->id_departemen }}">{{ $departemen->nama_departemen }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Pilih Pengguna berdasarkan Plant & Departemen -->
                        <div class="form-group">
                            <label class="fw-bold">Pilih Pengguna <span class="text-danger">*</span></label>
                            <select name="id_pengguna" id="penggunaDropdown" class="form-control" required>
                                <option value="" disabled selected>Pilih Pengguna</option>
                                @foreach ($pengguna as $user)
                                    <option value="{{ $user->id_pengguna }}" data-departemen="{{ $user->id_departemen }}">
                                        {{ $user->nama_lengkap }} - {{ $user->nik }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nama Kaizen -->
                        <div class="form-group">
                            <label class="fw-bold">Nama Kaizen <span class="text-danger">*</span></label>
                            <input type="text" name="nama_kaizen" class="form-control" placeholder="Masukkan Nama Kaizen"
                                required />
                        </div>

                        <!-- Jumlah Kaizen -->
                        <div class="form-group">
                            <label class="fw-bold">Jumlah Kaizen</label>
                            <input type="number" name="jumlah_kaizen" class="form-control"
                                placeholder="Masukkan Jumlah Kaizen" />
                        </div>

                        <!-- Tanggal Penerbitan Kaizen -->
                        <div class="form-group">
                            <label class="fw-bold">Tanggal Penerbitan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_penerbitan_kaizen" id="tanggalPenerbitan" class="form-control"
                                required />
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Data Kaizen -->
    <div class="modal fade" id="editKaizenModal" tabindex="-1" aria-labelledby="editKaizenModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="editKaizenModalLabel">Edit Data Kaizen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditKaizen" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id_data_kaizen" id="edit-id-kaizen" />

                        <!-- Pilih Pengguna (Readonly) -->
                        <div class="form-group">
                            <label class="fw-bold">Pengguna <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit-nama-pengguna" readonly />
                            <input type="hidden" name="id_pengguna" id="edit-id-pengguna" />
                        </div>

                        <!-- Nama Kaizen -->
                        <div class="form-group">
                            <label class="fw-bold">Nama Kaizen <span class="text-danger">*</span></label>
                            <input type="text" name="nama_kaizen" id="edit-nama-kaizen" class="form-control"
                                placeholder="Masukkan Nama Kaizen" required />
                        </div>

                        <!-- Jumlah Kaizen -->
                        <div class="form-group">
                            <label class="fw-bold">Jumlah Kaizen</label>
                            <input type="number" name="jumlah_kaizen" id="edit-jumlah-kaizen" class="form-control"
                                placeholder="Masukkan Jumlah Kaizen" />
                        </div>

                        <!-- Tanggal Penerbitan Kaizen -->
                        <div class="form-group">
                            <label class="fw-bold">Tanggal Penerbitan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_penerbitan_kaizen" id="edit-tanggal-penerbitan-kaizen"
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
                    <h5 class="modal-title" id="confirmDeleteModalLabel"><strong>Konfirmasi Hapus</strong></h5>
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
            const departemenFilter = document.getElementById("departemenFilter");
            const penggunaDropdown = document.getElementById("penggunaDropdown");

            function filterPengguna() {
                const selectedDepartemen = departemenFilter.value;

                Array.from(penggunaDropdown.options).forEach(option => {
                    const departemen = option.getAttribute("data-departemen");

                    if (selectedDepartemen === "" || departemen === selectedDepartemen) {
                        option.style.display = "block";
                    } else {
                        option.style.display = "none";
                    }
                });

                // Reset dropdown pengguna jika filter berubah
                penggunaDropdown.value = "";
            }

            departemenFilter.addEventListener("change", filterPengguna);
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const tanggalInput = document.getElementById("tanggalPenerbitan");
            const periodeBulan = document.getElementById("periodeBulan").value;
            const periodeTahun = document.getElementById("periodeTahun").value;

            // Konversi nama bulan ke angka
            const bulanMapping = {
                "January": "01",
                "February": "02",
                "March": "03",
                "April": "04",
                "May": "05",
                "June": "06",
                "July": "07",
                "August": "08",
                "September": "09",
                "October": "10",
                "November": "11",
                "December": "12"
            };

            const bulan = bulanMapping[periodeBulan];
            const tahun = periodeTahun;

            // Set batas minimum dan maksimum tanggal
            const minDate = `${tahun}-${bulan}-01`;
            const maxDate = new Date(tahun, bulan, 0).toISOString().split('T')[0];

            tanggalInput.setAttribute("min", minDate);
            tanggalInput.setAttribute("max", maxDate);
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const editKaizenModal = document.getElementById("editKaizenModal");

            editKaizenModal.addEventListener("show.bs.modal", function (event) {
                const button = event.relatedTarget;
                const idKaizen = button.getAttribute("data-id");
                const idPengguna = button.getAttribute("data-id-pengguna");
                const namaPengguna = button.getAttribute("data-nama-pengguna");
                const namaKaizen = button.getAttribute("data-nama");
                const jumlahKaizen = button.getAttribute("data-jumlah");
                const tanggalPenerbitan = button.getAttribute("data-tanggal");

                // Isi form modal dengan data dari tabel
                document.getElementById("edit-id-kaizen").value = idKaizen;
                document.getElementById("edit-id-pengguna").value = idPengguna;
                document.getElementById("edit-nama-pengguna").value = namaPengguna;
                document.getElementById("edit-nama-kaizen").value = namaKaizen;
                document.getElementById("edit-jumlah-kaizen").value = jumlahKaizen || '';
                document.getElementById("edit-tanggal-penerbitan-kaizen").value = tanggalPenerbitan;

                // Atur batas tanggal penerbitan
                const periodeBulan = document.getElementById("periodeBulan").value;
                const periodeTahun = document.getElementById("periodeTahun").value;

                const bulanMapping = {
                    "January": "01", "February": "02", "March": "03",
                    "April": "04", "May": "05", "June": "06",
                    "July": "07", "August": "08", "September": "09",
                    "October": "10", "November": "11", "December": "12"
                };

                const bulan = bulanMapping[periodeBulan];
                const tahun = periodeTahun;

                document.getElementById("edit-tanggal-penerbitan-kaizen").setAttribute("min", `${tahun}-${bulan}-01`);
                document.getElementById("edit-tanggal-penerbitan-kaizen").setAttribute("max", new Date(tahun, bulan, 0).toISOString().split('T')[0]);

                // Set form action ke URL yang benar
                document.getElementById("formEditKaizen").action = `/update-data-kaizen/${idKaizen}`;
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const confirmDeleteModal = document.getElementById("confirmDeleteModal");
            const deleteForm = document.getElementById("deleteForm");

            confirmDeleteModal.addEventListener("show.bs.modal", function (event) {
                const button = event.relatedTarget; // Button yang membuka modal
                const idKaizen = button.getAttribute("data-id"); // Ambil ID Data Kaizen

                // Atur action form ke endpoint delete yang sesuai
                deleteForm.action = `/delete-data-kaizen/${idKaizen}`;
            });
        });
    </script>

@endsection