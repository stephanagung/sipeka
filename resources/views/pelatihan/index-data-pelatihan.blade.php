@extends('layout.app')

@section('content')
    <div class="page-header">
        <h3 class="fw-bold">Data Pelatihan</h3>
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
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Data Pelatihan</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="display: flex; align-items: center; justify-content: space-between;">
                    <h4 class="card-title" style="margin: 0;">Data Pelatihan</h4>
                    <div class="btn-group">
                        <a href="{{ url('/index-rekap-pelatihan') }}">
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
                            data-bs-target="#addDataPelatihanModal">
                            <i class="fa fa-plus"></i> Tambah Data
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="GET"
                        action="{{ route('dataPelatihan.index', ['id_rekap_pelatihan' => $rekapPelatihan->id_rekap_pelatihan]) }}">
                        <div class="row">
                            <!-- Filter Departemen -->
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
                                    <th>Departemen</th>
                                    <th>Nama Pelatihan</th>
                                    <th>Jumlah Plan Partisipan</th>
                                    <th>Jumlah Act Partisipan</th>
                                    <th>Tanggal Pelatihan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataPelatihans as $index => $pelatihan)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary btn-small dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <div class="dropdown-menu">
                                                    <!-- Tombol Edit -->
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#editDataPelatihanModal"
                                                        data-id="{{ $pelatihan->id_data_pelatihan }}"
                                                        data-departemen="{{ $pelatihan->id_departemen }}"
                                                        data-nama="{{ $pelatihan->nama_pelatihan }}"
                                                        data-jumlah-plan="{{ $pelatihan->jumlah_plan_partisipan }}"
                                                        data-jumlah-act="{{ $pelatihan->jumlah_act_partisipan }}"
                                                        data-tanggal="{{ $pelatihan->tanggal_pelatihan }}"
                                                        data-periode-bulan="{{ $rekapPelatihan->periode_bulan_pelatihan }}"
                                                        data-periode-tahun="{{ $rekapPelatihan->periode_tahun_pelatihan }}">
                                                        <i class="fas fa-edit"></i> Edit Data
                                                    </a>

                                                    <!-- Tombol Hapus -->
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#confirmDeleteModal"
                                                        data-id="{{ $pelatihan->id_data_pelatihan }}">
                                                        <i class="fas fa-trash"></i> Hapus Data
                                                    </a>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Menampilkan Departemen -->
                                        <td>{{ $pelatihan->departemen->nama_departemen ?? '-' }}</td>

                                        <!-- Menampilkan Nama Pelatihan -->
                                        <td>{{ $pelatihan->nama_pelatihan }}</td>

                                        <!-- Menampilkan Jumlah Plan Partisipan -->
                                        <td>{{ $pelatihan->jumlah_plan_partisipan ?? '-' }}</td>

                                        <!-- Menampilkan Jumlah Act Partisipan -->
                                        <td>{{ $pelatihan->jumlah_act_partisipan ?? '-' }}</td>

                                        <!-- Menampilkan Tanggal Pelatihan dalam format dd-mm-yyyy -->
                                        <td>{{ \Carbon\Carbon::parse($pelatihan->tanggal_pelatihan)->format('d-m-Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Data Pelatihan -->
    <div class="modal fade" id="addDataPelatihanModal" tabindex="-1" aria-labelledby="addDataPelatihanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="addDataPelatihanModalLabel">Tambah Data Pelatihan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('dataPelatihan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id_rekap_pelatihan" value="{{ $rekapPelatihan->id_rekap_pelatihan }}">

                        <!-- Departemen -->
                        <div class="form-group">
                            <label for="id_departemen" class="fw-bold">Departemen <span class="text-danger">*</span></label>
                            <select name="id_departemen" class="form-control" required>
                                <option value="" disabled selected>-- Pilih Departemen --</option>
                                @foreach($departemens as $dept)
                                    <option value="{{ $dept->id_departemen }}">{{ $dept->nama_departemen }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nama Pelatihan -->
                        <div class="form-group">
                            <label for="nama_pelatihan" class="fw-bold">Nama Pelatihan <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="nama_pelatihan" class="form-control" required
                                placeholder="Masukkan Nama Pelatihan" />
                        </div>

                        <!-- Jumlah Plan Partisipan -->
                        <div class="form-group">
                            <label for="jumlah_plan_partisipan" class="fw-bold">Jumlah Plan Partisipan <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="jumlah_plan_partisipan" class="form-control" required
                                placeholder="Masukkan Jumlah Plan Partisipan" />
                        </div>

                        <!-- Tanggal Pelatihan -->
                        <div class="form-group">
                            <label for="tanggal_pelatihan" class="fw-bold">Tanggal Pelatihan <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pelatihan" id="tanggal_pelatihan" class="form-control"
                                required />
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Data Pelatihan -->
    <div class="modal fade" id="editDataPelatihanModal" tabindex="-1" aria-labelledby="editDataPelatihanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="editDataPelatihanModalLabel">Edit Data Pelatihan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="formEditDataPelatihan" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="id_data_pelatihan" id="edit-id-data-pelatihan" />

                        <!-- Departemen -->
                        <div class="form-group">
                            <label for="edit-id-departemen" class="fw-bold">Departemen <span
                                    class="text-danger">*</span></label>
                            <select name="id_departemen" id="edit-id-departemen" class="form-control" required>
                                <option value="" disabled>-- Pilih Departemen --</option>
                                @foreach($departemens as $dept)
                                    <option value="{{ $dept->id_departemen }}">{{ $dept->nama_departemen }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nama Pelatihan -->
                        <div class="form-group">
                            <label for="edit-nama-pelatihan" class="fw-bold">Nama Pelatihan <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="nama_pelatihan" id="edit-nama-pelatihan" class="form-control"
                                required />
                        </div>

                        <!-- Jumlah Plan Partisipan -->
                        <div class="form-group">
                            <label for="edit-jumlah-plan-partisipan" class="fw-bold">Jumlah Plan Partisipan <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="jumlah_plan_partisipan" id="edit-jumlah-plan-partisipan"
                                class="form-control" required />
                        </div>

                        <!-- Jumlah Act Partisipan -->
                        <div class="form-group">
                            <label for="edit-jumlah-act-partisipan" class="fw-bold">Jumlah Act Partisipan</label>
                            <input type="number" name="jumlah_act_partisipan" id="edit-jumlah-act-partisipan"
                                class="form-control" />
                        </div>

                        <!-- Tanggal Pelatihan -->
                        <div class="form-group">
                            <label for="edit-tanggal-pelatihan" class="fw-bold">Tanggal Pelatihan <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pelatihan" id="edit-tanggal-pelatihan" class="form-control"
                                required />
                        </div>
                    </div>

                    <div class="modal-footer">
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
            // Ambil periode bulan dan tahun dari rekap pelatihan
            const periodeBulan = "{{ $rekapPelatihan->periode_bulan_pelatihan }}";
            const periodeTahun = "{{ $rekapPelatihan->periode_tahun_pelatihan }}";

            // Mapping nama bulan ke angka
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

            // Atur atribut min dan max pada input tanggal
            const tanggalInput = document.getElementById("tanggal_pelatihan");
            tanggalInput.setAttribute("min", minDate);
            tanggalInput.setAttribute("max", maxDate);
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const editDataPelatihanModal = document.getElementById("editDataPelatihanModal");

            editDataPelatihanModal.addEventListener("show.bs.modal", function (event) {
                const button = event.relatedTarget;

                // Ambil data dari tombol
                const idPelatihan = button.getAttribute("data-id");
                const idDepartemen = button.getAttribute("data-departemen");
                const namaPelatihan = button.getAttribute("data-nama");
                const jumlahPlan = button.getAttribute("data-jumlah-plan");
                const jumlahAct = button.getAttribute("data-jumlah-act");
                const tanggalPelatihan = button.getAttribute("data-tanggal");
                const periodeBulan = button.getAttribute("data-periode-bulan");
                const periodeTahun = button.getAttribute("data-periode-tahun");

                const bulanMapping = {
                    "Januari": "01", "Februari": "02", "Maret": "03", "April": "04",
                    "Mei": "05", "Juni": "06", "Juli": "07", "Agustus": "08",
                    "September": "09", "Oktober": "10", "November": "11", "Desember": "12"
                };

                const bulan = bulanMapping[periodeBulan] || "01";  // Default ke Januari jika tidak dikenali
                const tahun = periodeTahun;

                const minDate = `${tahun}-${bulan}-01`;
                const maxDate = new Date(tahun, bulan, 0).toISOString().split('T')[0];

                // Isi form dengan data lama
                document.getElementById("edit-id-data-pelatihan").value = idPelatihan;
                document.getElementById("edit-id-departemen").value = idDepartemen;
                document.getElementById("edit-nama-pelatihan").value = namaPelatihan;
                document.getElementById("edit-jumlah-plan-partisipan").value = jumlahPlan;
                document.getElementById("edit-jumlah-act-partisipan").value = jumlahAct || '';
                document.getElementById("edit-tanggal-pelatihan").value = tanggalPelatihan;

                // Batasi tanggal sesuai dengan periode
                const tanggalInput = document.getElementById("edit-tanggal-pelatihan");
                tanggalInput.setAttribute("min", minDate);
                tanggalInput.setAttribute("max", maxDate);

                // Set form action
                document.getElementById("formEditDataPelatihan").action = `/update-data-pelatihan/${idPelatihan}`;
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const confirmDeleteModal = document.getElementById("confirmDeleteModal");
            const deleteForm = document.getElementById("deleteForm");

            confirmDeleteModal.addEventListener("show.bs.modal", function (event) {
                const button = event.relatedTarget; // Button yang membuka modal
                const idPelatihan = button.getAttribute("data-id"); // Ambil ID Data Kaizen

                // Atur action form ke endpoint delete yang sesuai
                deleteForm.action = `/delete-data-pelatihan/${idPelatihan}`;
            });
        });
    </script>

@endsection