@extends('layout.app')

@section('content')
    <div class="page-header">
        <h3 class="fw-bold">Data Pemenuhan Tenaga Kerja</h3>
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
                <a href="{{ url('/index-rekap-pemenuhan-tk') }}">Rekap Pemenuhan TK</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Data Pemenuhan TK</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="display: flex; align-items: center; justify-content: space-between;">
                    <h4 class="card-title" style="margin: 0;">Data Pemenuhan Tenaga Kerja</h4>
                    <div class="btn-group">
                        <a href="{{ url('/index-rekap-pemenuhan-tk') }}">
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
                            data-bs-target="#addDataPemenuhanTKModal">
                            <i class="fa fa-plus"></i> Tambah Data
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="GET"
                        action="{{ route('dataPemenuhanTK.index', ['id_rekap_pemenuhan_tk' => $rekapPemenuhanTK->id_rekap_pemenuhan_tk]) }}">
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
                                    <th>Posisi TK</th>
                                    <th>Jumlah Plan Pemenuhan TK</th>
                                    <th>Jumlah Act Pemenuhan TK</th>
                                    <th>Tanggal Pemenuhan TK</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataPemenuhans as $index => $pemenuhan)
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
                                                        data-bs-target="#editDataPemenuhanTKModal"
                                                        data-id="{{ $pemenuhan->id_data_pemenuhan_tk }}"
                                                        data-departemen="{{ $pemenuhan->id_departemen }}"
                                                        data-posisi="{{ $pemenuhan->posisi_tk }}"
                                                        data-jumlah-plan="{{ $pemenuhan->jumlah_plan_pemenuhan_tk }}"
                                                        data-jumlah-act="{{ $pemenuhan->jumlah_act_pemenuhan_tk }}"
                                                        data-tanggal="{{ $pemenuhan->tanggal_pemenuhan_tk }}"
                                                        data-periode-bulan="{{ $rekapPemenuhanTK->periode_bulan_pemenuhan_tk }}"
                                                        data-periode-tahun="{{ $rekapPemenuhanTK->periode_tahun_pemenuhan_tk }}">
                                                        <i class="fas fa-edit"></i> Edit Data
                                                    </a>

                                                    <!-- Tombol Hapus -->
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#confirmDeleteModal"
                                                        data-id="{{ $pemenuhan->id_data_pemenuhan_tk }}">
                                                        <i class="fas fa-trash"></i> Hapus Data
                                                    </a>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Menampilkan Departemen -->
                                        <td>{{ $pemenuhan->departemen->nama_departemen ?? '-' }}</td>

                                        <!-- Menampilkan Posisi TK -->
                                        <td>{{ $pemenuhan->posisi_tk ?? '-' }}</td>

                                        <!-- Menampilkan Jumlah Plan Pemenuhan TK -->
                                        <td>{{ $pemenuhan->jumlah_plan_pemenuhan_tk ?? '-' }}</td>

                                        <!-- Menampilkan Jumlah Act Pemenuhan TK -->
                                        <td>{{ $pemenuhan->jumlah_act_pemenuhan_tk ?? '-' }}</td>

                                        <!-- Menampilkan Tanggal Pemenuhan TK dalam format dd-mm-yyyy -->
                                        <td>{{ \Carbon\Carbon::parse($pemenuhan->tanggal_pemenuhan_tk)->format('d-m-Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Data Pemenuhan TK -->
    <div class="modal fade" id="addDataPemenuhanTKModal" tabindex="-1" aria-labelledby="addDataPemenuhanTKModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="addDataPemenuhanTKModalLabel">Tambah Data Pemenuhan TK</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('dataPemenuhanTK.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id_rekap_pemenuhan_tk"
                            value="{{ $rekapPemenuhanTK->id_rekap_pemenuhan_tk }}">

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

                        <!-- Posisi Tenaga Kerja -->
                        <div class="form-group">
                            <label for="posisi_tk" class="fw-bold">Posisi TK <span class="text-danger">*</span></label>
                            <input type="text" name="posisi_tk" class="form-control" required
                                placeholder="Masukkan Posisi TK" />
                        </div>

                        <!-- Jumlah Plan Pemenuhan TK -->
                        <div class="form-group">
                            <label for="jumlah_plan_pemenuhan_tk" class="fw-bold">Jumlah Plan Pemenuhan TK <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="jumlah_plan_pemenuhan_tk" class="form-control" required
                                placeholder="Masukkan Jumlah Plan Pemenuhan TK" />
                        </div>

                        <!-- Jumlah Act Pemenuhan TK -->
                        <div class="form-group">
                            <label for="jumlah_act_pemenuhan_tk" class="fw-bold">Jumlah Act Pemenuhan TK</label>
                            <input type="number" name="jumlah_act_pemenuhan_tk" class="form-control"
                                placeholder="Masukkan Jumlah Act Pemenuhan TK (Opsional)" />
                        </div>

                        <!-- Tanggal Pemenuhan TK -->
                        <div class="form-group">
                            <label for="tanggal_pemenuhan_tk" class="fw-bold">Tanggal Pemenuhan TK <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pemenuhan_tk" id="tanggal_pemenuhan_tk" class="form-control"
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

    <!-- Modal Edit Data Pemenuhan TK -->
    <div class="modal fade" id="editDataPemenuhanTKModal" tabindex="-1" aria-labelledby="editDataPemenuhanTKModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="editDataPemenuhanTKModalLabel">Edit Data Pemenuhan TK</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="formEditDataPemenuhanTK" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="id_data_pemenuhan_tk" id="edit-id-data-pemenuhan-tk" />

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

                        <!-- Posisi Tenaga Kerja -->
                        <div class="form-group">
                            <label for="edit-posisi-tk" class="fw-bold">Posisi TK <span class="text-danger">*</span></label>
                            <input type="text" name="posisi_tk" id="edit-posisi-tk" class="form-control" required />
                        </div>

                        <!-- Jumlah Plan Pemenuhan TK -->
                        <div class="form-group">
                            <label for="edit-jumlah-plan-pemenuhan-tk" class="fw-bold">Jumlah Plan Pemenuhan TK <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="jumlah_plan_pemenuhan_tk" id="edit-jumlah-plan-pemenuhan-tk"
                                class="form-control" required />
                        </div>

                        <!-- Jumlah Act Pemenuhan TK -->
                        <div class="form-group">
                            <label for="edit-jumlah-act-pemenuhan-tk" class="fw-bold">Jumlah Act Pemenuhan TK</label>
                            <input type="number" name="jumlah_act_pemenuhan_tk" id="edit-jumlah-act-pemenuhan-tk"
                                class="form-control" />
                        </div>

                        <!-- Tanggal Pemenuhan TK -->
                        <div class="form-group">
                            <label for="edit-tanggal-pemenuhan-tk" class="fw-bold">Tanggal Pemenuhan TK <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pemenuhan_tk" id="edit-tanggal-pemenuhan-tk"
                                class="form-control" required />
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
            // Ambil periode bulan dan tahun dari rekap pemenuhan TK
            const periodeBulan = "{{ $rekapPemenuhanTK->periode_bulan_pemenuhan_tk }}";
            const periodeTahun = "{{ $rekapPemenuhanTK->periode_tahun_pemenuhan_tk }}";

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
            const tanggalInput = document.getElementById("tanggal_pemenuhan_tk");
            tanggalInput.setAttribute("min", minDate);
            tanggalInput.setAttribute("max", maxDate);
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const editDataPemenuhanTKModal = document.getElementById("editDataPemenuhanTKModal");

            editDataPemenuhanTKModal.addEventListener("show.bs.modal", function (event) {
                const button = event.relatedTarget;
                const idDataPemenuhan = button.getAttribute("data-id");
                const idDepartemen = button.getAttribute("data-departemen");
                const posisiTK = button.getAttribute("data-posisi");
                const jumlahPlan = button.getAttribute("data-jumlah-plan");
                const jumlahAct = button.getAttribute("data-jumlah-act");
                const tanggalPemenuhan = button.getAttribute("data-tanggal");
                const periodeBulan = button.getAttribute("data-periode-bulan");
                const periodeTahun = button.getAttribute("data-periode-tahun");

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

                const minDate = `${tahun}-${bulan}-01`;
                const maxDate = new Date(tahun, bulan, 0).toISOString().split('T')[0];

                document.getElementById("edit-id-data-pemenuhan-tk").value = idDataPemenuhan;
                document.getElementById("edit-id-departemen").value = idDepartemen;
                document.getElementById("edit-posisi-tk").value = posisiTK;
                document.getElementById("edit-jumlah-plan-pemenuhan-tk").value = jumlahPlan;
                document.getElementById("edit-jumlah-act-pemenuhan-tk").value = jumlahAct || '';
                document.getElementById("edit-tanggal-pemenuhan-tk").value = tanggalPemenuhan;

                // Batasi tanggal agar sesuai dengan periode yang ditentukan
                const tanggalInput = document.getElementById("edit-tanggal-pemenuhan-tk");
                tanggalInput.setAttribute("min", minDate);
                tanggalInput.setAttribute("max", maxDate);

                // Atur form action ke endpoint update yang sesuai
                document.getElementById("formEditDataPemenuhanTK").action = `/update-data-pemenuhan-tk/${idDataPemenuhan}`;
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const confirmDeleteModal = document.getElementById("confirmDeleteModal");
            const deleteForm = document.getElementById("deleteForm");

            confirmDeleteModal.addEventListener("show.bs.modal", function (event) {
                const button = event.relatedTarget; // Button yang membuka modal
                const idPemenuhanTK = button.getAttribute("data-id"); // Ambil ID Data Kaizen

                // Atur action form ke endpoint delete yang sesuai
                deleteForm.action = `/delete-data-pemenuhan-tk/${idPemenuhanTK}`;
            });
        });
    </script>

@endsection