@extends('layout.app')

@section('content')
    <div class="page-header">
        <h3 class="fw-bold">Rekap Cuti & Absensi</h3>
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
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="display: flex; align-items: center; justify-content: space-between;">
                    <h4 class="card-title" style="margin: 0;">Rekap Data Cuti & Absensi</h4>
                    <div class="btn-group">
                        <button onclick="refreshPage()" class="btn btn-black btn-small">
                            <span class="btn-label">
                                <i class="fas fa-undo-alt"></i>
                            </span>
                            Refresh Data
                        </button>
                        &nbsp;&nbsp;
                        <button type="button" class="btn btn-small btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addAbsensiModal">
                            <i class="fa fa-plus"></i> Tambah Data
                        </button>
                    </div>
                </div>

                <div class="card-body">

                    <form method="GET" action="{{ route('absensi.index') }}">
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
                                    <th>Kategori Absensi</th>
                                    <th>Tanggal Absensi Mulai</th>
                                    <th>Tanggal Absensi Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($absensi as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary btn-small dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="{{ route('absensi.show', $item->id_absensi) }}">
                                                        <i class="fas fa-info-circle"></i> Lihat Detail
                                                    </a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#editAbsensiModal"
                                                        data-id_absensi="{{ $item->id_absensi }}"
                                                        data-shift="{{ $item->shift }}"
                                                        data-tanggal_absensi_mulai="{{ $item->tanggal_absensi_mulai }}"
                                                        data-tanggal_absensi_akhir="{{ $item->tanggal_absensi_akhir }}"
                                                        data-jumlah_absensi="{{ $item->jumlah_absensi }}"
                                                        data-total-jatah="{{ $item->jatahAbsensi->total_jatah_absensi }}"
                                                        data-jumlah-absensi-sebelumnya="{{ $item->jumlah_absensi }}"
                                                        data-alasan="{{ $item->alasan }}" data-catatan="{{ $item->catatan }}"
                                                        data-dokumen_pendukung="{{ $item->dokumen_pendukung }}"
                                                        data-id_kategori_absensi="{{ $item->id_kategori_absensi }}"
                                                        data-kategori_absensi="{{ $item->kategori->nama_kategori_absensi }}">
                                                        <i class="fas fa-edit"></i> Edit Data
                                                    </a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#confirmDeleteModal"
                                                        data-id_absensi="{{ $item->id_absensi }}">
                                                        <i class="fas fa-trash"></i> Hapus Data
                                                    </a>

                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $item->jatahAbsensi->pengguna->nama_lengkap ?? '-' }}
                                            (NIK: {{ $item->jatahAbsensi->pengguna->nik ?? '-' }})
                                        </td>
                                        <td>{{ $item->kategori->nama_kategori_absensi }}
                                            ({{ $item->kategori->kode_kategori_absensi }})
                                        </td>
                                        <td>{{ $item->tanggal_absensi_mulai }}</td>
                                        <td>{{ $item->tanggal_absensi_akhir }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="addAbsensiModal" tabindex="-1" aria-labelledby="addAbsensiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAbsensiModalLabel"><strong>Tambah Data Absensi</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('absensi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="departemen"><strong>Departemen <span
                                                class="text-danger">*</span></strong></label>
                                    <select id="departemen" class="form-control" onchange="filterPengguna(this.value)"
                                        required>
                                        <option value="">Pilih Departemen</option>
                                        @foreach ($departemen as $dept)
                                            <option value="{{ $dept->id_departemen }}">{{ $dept->nama_departemen }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="id_jatah_absensi"><strong>Nama Pengguna <span
                                                class="text-danger">*</span></strong></label>
                                    <select id="id_jatah_absensi" name="id_jatah_absensi" class="form-control" required>
                                        <option value="">Pilih Pengguna</option>
                                        @foreach ($jatahAbsensi as $jatah)
                                            <option value="{{ $jatah->id_jatah_absensi }}"
                                                data-departemen="{{ $jatah->pengguna->id_departemen }}"
                                                data-total-jatah="{{ $jatah->total_jatah_absensi }}">
                                                {{ $jatah->pengguna->nama_lengkap }} - {{ $jatah->pengguna->nik }}
                                                (Jatah: {{ $jatah->total_jatah_absensi }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="shift"><strong>Shift <span class="text-danger">*</span></strong></label>
                                    <select name="shift" id="shift" class="form-control" required>
                                        <option value="">Pilih Shift</option>
                                        <option value="1">Shift 1</option>
                                        <option value="2">Shift 2</option>
                                        <option value="3">Shift 3</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="alasan"><strong>Alasan <span class="text-danger">*</span></strong></label>
                                    <textarea id="alasan" name="alasan" class="form-control" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="catatan"><strong>Catatan <span class="text-danger">*</span></strong></label>
                                    <textarea id="catatan" name="catatan" class="form-control" required></textarea>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_kategori_absensi"><strong>Kategori Absensi <span
                                                class="text-danger">*</span></strong></label>
                                    <select id="id_kategori_absensi" name="id_kategori_absensi" class="form-control"
                                        required>
                                        <option value="">Pilih Kategori Absensi</option>
                                        @foreach ($kategori as $cat)
                                            <option value="{{ $cat->id_kategori_absensi }}">{{ $cat->nama_kategori_absensi }}
                                                ({{ $cat->kode_kategori_absensi }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="dokumen_pendukung"><strong>Dokumen Pendukung</strong></label>
                                    <input type="file" id="dokumen_pendukung" name="dokumen_pendukung" class="form-control">
                                </div>

                                <div class="form-group" id="tanggal-absen-div" style="display: none;">
                                    <label for="tanggal_absen"><strong>Tanggal Absen <span
                                                class="text-danger">*</span></strong></label>
                                    <input type="datetime-local" id="tanggal_absen" name="tanggal_absen"
                                        class="form-control">
                                </div>

                                <div class="form-group" id="tanggal-mulai-div" style="display: none;">
                                    <label for="tanggal_absensi_mulai"><strong>Tanggal Mulai Absensi <span
                                                class="text-danger">*</span></strong></label>
                                    <input type="datetime-local" id="tanggal_absensi_mulai" name="tanggal_absensi_mulai"
                                        class="form-control">
                                </div>

                                <div class="form-group" id="tanggal-akhir-div" style="display: none;">
                                    <label for="tanggal_absensi_akhir"><strong>Tanggal Akhir Absensi <span
                                                class="text-danger">*</span></strong></label>
                                    <input type="datetime-local" id="tanggal_absensi_akhir" name="tanggal_absensi_akhir"
                                        class="form-control">
                                </div>

                                <div class="form-group" id="jumlah-absensi-div" style="display: none;">
                                    <label for="jumlah_absensi"><strong>Jumlah Absensi</strong></label>
                                    <input type="number" class="form-control" id="jumlah_absensi" name="jumlah_absensi"
                                        readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Input otomatis dengan nilai default -->
                        <input type="hidden" name="status_absensi" value="1">
                        <input type="hidden" name="disetujui_atasan" value="1">
                        <input type="hidden" name="disetujui_hrd" value="1">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editAbsensiModal" tabindex="-1" aria-labelledby="editAbsensiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAbsensiModalLabel"><strong>Edit Data Absensi</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="edit-absensi-form" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit-id_absensi" name="id_absensi">

                    <div class="modal-body">
                        <div class="row">
                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit-shift"><strong>Shift <span
                                                class="text-danger">*</span></strong></label>
                                    <select id="edit-shift" name="shift" class="form-control" required>
                                        <option value="">-- Pilih Shift --</option>
                                        <option value="1">Shift 1</option>
                                        <option value="2">Shift 2</option>
                                        <option value="3">Shift 3</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="edit-alasan"><strong>Alasan <span
                                                class="text-danger">*</span></strong></label>
                                    <textarea id="edit-alasan" name="alasan" class="form-control" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="edit-catatan"><strong>Catatan <span
                                                class="text-danger">*</span></strong></label>
                                    <textarea id="edit-catatan" name="catatan" class="form-control"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="edit-dokumen_pendukung"><strong>Dokumen Pendukung</strong></label>
                                    <input type="file" id="edit-dokumen_pendukung" name="dokumen_pendukung"
                                        class="form-control mb-2">
                                    <span id="existing-file"></span>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
                                <!-- Menampilkan nama kategori absensi -->
                                <div class="form-group">
                                    <label for="edit-kategori_absensi"><strong>Kategori Absensi</strong></label>
                                    <input type="text" id="edit-kategori_absensi" class="form-control" disabled>
                                    <input type="hidden" id="edit-id_kategori_absensi" name="id_kategori_absensi">
                                </div>

                                <!-- Tanggal Absensi (Perubahan) -->
                                <div class="form-group" id="tanggal-absensi-multiple">
                                    <label for="edit-tanggal_absensi_mulai"><strong>Tanggal Absensi Mulai <span
                                                class="text-danger">*</span></strong></label>
                                    <input type="datetime-local" id="edit-tanggal_absensi_mulai"
                                        name="tanggal_absensi_mulai" class="form-control">
                                </div>

                                <div class="form-group" id="tanggal-absensi-akhir">
                                    <label for="edit-tanggal_absensi_akhir"><strong>Tanggal Absensi Akhir <span
                                                class="text-danger">*</span></strong></label>
                                    <input type="datetime-local" id="edit-tanggal_absensi_akhir"
                                        name="tanggal_absensi_akhir" class="form-control">
                                </div>

                                <!-- Tanggal Absensi (Satu Input) -->
                                <div class="form-group" id="tanggal-absensi-single" style="display: none;">
                                    <label for="edit-tanggal_absensi"><strong>Tanggal Absensi <span
                                                class="text-danger">*</span></strong></label>
                                    <input type="datetime-local" id="edit-tanggal_absensi" name="tanggal_absensi"
                                        class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="edit-jumlah_absensi"><strong>Jumlah Absensi</strong></label>
                                    <input type="number" id="edit-jumlah_absensi" name="jumlah_absensi" class="form-control"
                                        readonly>
                                </div>

                                <div class="form-group">
                                    <label for="edit-sisa-jatah"><strong>Sisa Jatah Absensi</strong></label>
                                    <input type="number" id="edit-sisa-jatah" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel"><strong>Konfirmasi Hapus</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data absensi ini?</p>
                </div>
                <div class="modal-footer">
                    <form id="delete-absensi-form" action="" method="POST">
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
        function filterPengguna(departemenId) {
            let penggunaSelect = document.getElementById('id_jatah_absensi');
            let options = penggunaSelect.options;

            for (let i = 0; i < options.length; i++) {
                let option = options[i];
                let penggunaDepartemen = option.getAttribute('data-departemen');

                if (departemenId === '' || penggunaDepartemen == departemenId) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            }

            penggunaSelect.selectedIndex = 0;
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const kategoriSelect = document.getElementById('id_kategori_absensi');
            const jumlahAbsensiDiv = document.getElementById('jumlah-absensi-div');
            const jumlahAbsensiInput = document.getElementById('jumlah_absensi');
            const tanggalAbsenDiv = document.getElementById('tanggal-absen-div');
            const tanggalAbsenInput = document.getElementById('tanggal_absen');
            const tanggalMulaiDiv = document.getElementById('tanggal-mulai-div');
            const tanggalAkhirDiv = document.getElementById('tanggal-akhir-div');
            const tanggalMulaiInput = document.getElementById('tanggal_absensi_mulai');
            const tanggalAkhirInput = document.getElementById('tanggal_absensi_akhir');

            function toggleJumlahAbsensiDiv() {
                const selectedKategoriId = parseInt(kategoriSelect.value);

                if (!selectedKategoriId || [6, 8, 11].includes(selectedKategoriId)) {
                    jumlahAbsensiDiv.style.display = 'none'; // Sembunyikan div jumlah_absensi
                } else {
                    jumlahAbsensiDiv.style.display = 'block'; // Tampilkan div jumlah_absensi
                }

                if (selectedKategoriId === 6) {
                    jumlahAbsensiInput.value = 1;
                    jumlahAbsensiInput.disabled = true;
                    tanggalAbsenDiv.style.display = 'block';
                    tanggalMulaiDiv.style.display = 'none';
                    tanggalAkhirDiv.style.display = 'none';
                } else if (selectedKategoriId === 8 || selectedKategoriId === 11) {
                    jumlahAbsensiInput.value = 0;
                    jumlahAbsensiInput.disabled = true;
                    tanggalAbsenDiv.style.display = 'block';
                    tanggalMulaiDiv.style.display = 'none';
                    tanggalAkhirDiv.style.display = 'none';
                } else if (selectedKategoriId) {
                    jumlahAbsensiInput.disabled = false;
                    tanggalAbsenDiv.style.display = 'none';
                    tanggalMulaiDiv.style.display = 'block';
                    tanggalAkhirDiv.style.display = 'block';
                } else {
                    tanggalAbsenDiv.style.display = 'none';
                    tanggalMulaiDiv.style.display = 'none';
                    tanggalAkhirDiv.style.display = 'none';
                    jumlahAbsensiInput.value = '';
                }
            }

            kategoriSelect.addEventListener('change', toggleJumlahAbsensiDiv);

            tanggalMulaiInput.addEventListener('change', calculateJumlahAbsensi);
            tanggalAkhirInput.addEventListener('change', calculateJumlahAbsensi);

            function calculateJumlahAbsensi() {
                const tanggalMulai = new Date(tanggalMulaiInput.value);
                const tanggalAkhir = new Date(tanggalAkhirInput.value);

                if (tanggalMulai && tanggalAkhir && !isNaN(tanggalMulai) && !isNaN(tanggalAkhir)) {
                    const diffInTime = tanggalAkhir.getTime() - tanggalMulai.getTime();
                    const diffInDays = Math.ceil(diffInTime / (1000 * 3600 * 24)) + 1;
                    jumlahAbsensiInput.value = diffInDays > 0 ? diffInDays : 0;
                } else {
                    jumlahAbsensiInput.value = '';
                }
            }

            // Panggil fungsi saat halaman dimuat
            toggleJumlahAbsensiDiv();

        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tanggalMulaiInput = document.getElementById('edit-tanggal_absensi_mulai');
            const tanggalAkhirInput = document.getElementById('edit-tanggal_absensi_akhir');
            const jumlahAbsensiInput = document.getElementById('edit-jumlah_absensi');
            const tanggalAbsensiSingle = document.getElementById('edit-tanggal_absensi');
            const tanggalAbsensiMultiple = document.getElementById('tanggal-absensi-multiple');
            const tanggalAbsensiAkhir = document.getElementById('tanggal-absensi-akhir');
            const tanggalAbsensiSingleDiv = document.getElementById('tanggal-absensi-single');

            function calculateJumlahAbsensi() {
                const tanggalMulai = new Date(tanggalMulaiInput.value);
                const tanggalAkhir = new Date(tanggalAkhirInput.value);

                if (tanggalMulai && tanggalAkhir && !isNaN(tanggalMulai) && !isNaN(tanggalAkhir)) {
                    const diffInTime = tanggalAkhir.getTime() - tanggalMulai.getTime();
                    const diffInDays = Math.ceil(diffInTime / (1000 * 3600 * 24)) + 1;
                    jumlahAbsensiInput.value = diffInDays > 0 ? diffInDays : 0;
                } else {
                    jumlahAbsensiInput.value = '';
                }
            }

            tanggalMulaiInput.addEventListener('change', calculateJumlahAbsensi);
            tanggalAkhirInput.addEventListener('change', calculateJumlahAbsensi);

            document.querySelectorAll('.dropdown-item[data-bs-target="#editAbsensiModal"]').forEach(item => {
                item.addEventListener('click', function () {
                    const modalForm = document.getElementById('edit-absensi-form');

                    // Set form action dynamically based on absensi ID
                    const absensiId = this.getAttribute("data-id_absensi");
                    modalForm.action = "/update-absensi/" + absensiId;

                    // Fill the form with data from the clicked item
                    document.getElementById('edit-id_absensi').value = absensiId;
                    document.getElementById('edit-shift').value = this.getAttribute("data-shift");
                    document.getElementById('edit-tanggal_absensi_mulai').value = this.getAttribute("data-tanggal_absensi_mulai");
                    document.getElementById('edit-tanggal_absensi_akhir').value = this.getAttribute("data-tanggal_absensi_akhir");
                    document.getElementById('edit-jumlah_absensi').value = this.getAttribute("data-jumlah_absensi");
                    document.getElementById('edit-alasan').value = this.getAttribute("data-alasan");
                    document.getElementById('edit-catatan').value = this.getAttribute("data-catatan");

                    // Set kategori absensi
                    const kategoriAbsensi = this.getAttribute("data-kategori_absensi");
                    const idKategoriAbsensi = this.getAttribute("data-id_kategori_absensi");
                    document.getElementById('edit-kategori_absensi').value = kategoriAbsensi;
                    document.getElementById('edit-id_kategori_absensi').value = idKategoriAbsensi;

                    // Adjust the display of the date fields based on the category
                    if ([6, 8, 11].includes(parseInt(idKategoriAbsensi)) || ["MANGKIR", "TERLAMBAT", "PULANG CEPAT"].includes(kategoriAbsensi)) {
                        tanggalAbsensiMultiple.style.display = 'none'; // Hide multiple date inputs
                        tanggalAbsensiAkhir.style.display = 'none'; // Hide the end date
                        tanggalAbsensiSingleDiv.style.display = 'block'; // Show the single date input
                        tanggalAbsensiSingle.value = this.getAttribute("data-tanggal_absensi_mulai"); // Set the date
                    } else {
                        tanggalAbsensiMultiple.style.display = 'block'; // Show multiple date inputs
                        tanggalAbsensiAkhir.style.display = 'block'; // Show the end date
                        tanggalAbsensiSingleDiv.style.display = 'none'; // Hide the single date input
                    }

                    // Show existing file link if available
                    const existingFile = this.getAttribute("data-dokumen_pendukung");
                    const existingFileElement = document.getElementById('existing-file');
                    if (existingFile) {
                        existingFileElement.innerHTML = `File sebelumnya: <a href="/storage/${existingFile}" target="_blank">Lihat Dokumen</a>`;
                    } else {
                        existingFileElement.innerHTML = "Tidak ada file sebelumnya";
                    }
                });
            });
        });

    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function validateDate(startInput, endInput, prevEndValue, jumlahAbsensiInput, prevJumlahAbsensi) {
                if (startInput && endInput) {
                    endInput.min = startInput.value;

                    if (new Date(endInput.value) < new Date(startInput.value)) {
                        alert("Tanggal akhir absensi tidak boleh sebelum tanggal mulai absensi.");
                        endInput.value = prevEndValue; // Kembalikan ke nilai sebelumnya
                        jumlahAbsensiInput.value = prevJumlahAbsensi; // Jaga agar jumlah absensi tidak berubah
                    } else {
                        updateJumlahAbsensi(startInput, endInput, jumlahAbsensiInput); // Hitung jumlah absensi jika valid
                    }
                }
            }

            function updateJumlahAbsensi(startInput, endInput, jumlahAbsensiInput) {
                const tanggalMulai = new Date(startInput.value);
                const tanggalAkhir = new Date(endInput.value);

                if (tanggalMulai && tanggalAkhir && !isNaN(tanggalMulai) && !isNaN(tanggalAkhir)) {
                    const diffInTime = tanggalAkhir.getTime() - tanggalMulai.getTime();
                    const diffInDays = Math.ceil(diffInTime / (1000 * 3600 * 24)) + 1;
                    jumlahAbsensiInput.value = diffInDays > 0 ? diffInDays : 1; // Minimal 1 hari
                }
            }

            // Tambah Absensi
            const tanggalMulaiTambah = document.getElementById("tanggal_absensi_mulai");
            const tanggalAkhirTambah = document.getElementById("tanggal_absensi_akhir");
            const jumlahAbsensiTambah = document.getElementById("jumlah_absensi");

            if (tanggalMulaiTambah && tanggalAkhirTambah) {
                tanggalMulaiTambah.addEventListener("change", function () {
                    updateJumlahAbsensi(tanggalMulaiTambah, tanggalAkhirTambah, jumlahAbsensiTambah);
                });

                tanggalAkhirTambah.addEventListener("change", function () {
                    updateJumlahAbsensi(tanggalMulaiTambah, tanggalAkhirTambah, jumlahAbsensiTambah);
                });
            }

            // Edit Absensi
            const tanggalMulaiEdit = document.getElementById("edit-tanggal_absensi_mulai");
            const tanggalAkhirEdit = document.getElementById("edit-tanggal_absensi_akhir");
            const jumlahAbsensiEdit = document.getElementById("edit-jumlah_absensi");
            let prevEndDate = "";
            let prevJumlahAbsensi = "";

            if (tanggalMulaiEdit && tanggalAkhirEdit) {
                // Simpan nilai awal saat modal edit dibuka
                document.querySelectorAll('.dropdown-item[data-bs-target="#editAbsensiModal"]').forEach(item => {
                    item.addEventListener('click', function () {
                        prevEndDate = tanggalAkhirEdit.value; // Simpan tanggal akhir sebelumnya
                        prevJumlahAbsensi = jumlahAbsensiEdit.value; // Simpan jumlah absensi sebelumnya
                    });
                });

                tanggalMulaiEdit.addEventListener("change", function () {
                    validateDate(tanggalMulaiEdit, tanggalAkhirEdit, prevEndDate, jumlahAbsensiEdit, prevJumlahAbsensi);
                });

                tanggalAkhirEdit.addEventListener("change", function () {
                    validateDate(tanggalMulaiEdit, tanggalAkhirEdit, prevEndDate, jumlahAbsensiEdit, prevJumlahAbsensi);
                    prevEndDate = tanggalAkhirEdit.value; // Update nilai sebelumnya jika valid
                    prevJumlahAbsensi = jumlahAbsensiEdit.value; // Update jumlah absensi jika valid
                });
            }

            // Pastikan validasi tetap berjalan saat submit form
            document.querySelectorAll("form").forEach((form) => {
                form.addEventListener("submit", function (event) {
                    const startInput = form.querySelector('[name="tanggal_absensi_mulai"]');
                    const endInput = form.querySelector('[name="tanggal_absensi_akhir"]');
                    const jumlahAbsensiInput = form.querySelector('[name="jumlah_absensi"]');

                    if (startInput && endInput && new Date(endInput.value) < new Date(startInput.value)) {
                        event.preventDefault();
                        alert("Tanggal akhir absensi tidak boleh sebelum tanggal mulai absensi.");
                        endInput.value = prevEndDate; // Kembalikan ke nilai sebelumnya
                        jumlahAbsensiInput.value = prevJumlahAbsensi; // Jaga jumlah absensi tetap sama
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const jumlahAbsensiInput = document.getElementById('jumlah_absensi');
            const idJatahAbsensiSelect = document.getElementById('id_jatah_absensi');
            const tanggalMulaiInput = document.getElementById('tanggal_absensi_mulai');
            const tanggalAkhirInput = document.getElementById('tanggal_absensi_akhir');
            const formTambahAbsensi = document.querySelector('#addAbsensiModal form'); // Form modal tambah
            const submitButton = formTambahAbsensi.querySelector('button[type="submit"]');

            // Buat elemen error
            let jumlahAbsensiError = document.createElement('small');
            jumlahAbsensiError.style.color = 'red';
            jumlahAbsensiError.style.display = 'block';
            jumlahAbsensiInput.parentNode.appendChild(jumlahAbsensiError);

            function validateJumlahAbsensi() {
                const selectedOption = idJatahAbsensiSelect.options[idJatahAbsensiSelect.selectedIndex];
                const totalJatahAbsensi = parseInt(selectedOption.getAttribute('data-total-jatah')) || 0;
                const jumlahAbsensi = parseInt(jumlahAbsensiInput.value) || 0;

                if (jumlahAbsensi > totalJatahAbsensi) {
                    jumlahAbsensiError.textContent = 'Jumlah cuti melebihi total jatah absensi!';
                    jumlahAbsensiInput.setCustomValidity('Jumlah cuti melebihi jatah!');
                    return false; // Tidak valid
                } else {
                    jumlahAbsensiError.textContent = '';
                    jumlahAbsensiInput.setCustomValidity('');
                    return true; // Valid
                }
            }

            function calculateJumlahAbsensi() {
                const tanggalMulai = new Date(tanggalMulaiInput.value);
                const tanggalAkhir = new Date(tanggalAkhirInput.value);

                if (tanggalMulai && tanggalAkhir && !isNaN(tanggalMulai) && !isNaN(tanggalAkhir)) {
                    const diffInTime = tanggalAkhir.getTime() - tanggalMulai.getTime();
                    const diffInDays = Math.ceil(diffInTime / (1000 * 3600 * 24)) + 1;
                    jumlahAbsensiInput.value = diffInDays > 0 ? diffInDays : 0;
                    validateJumlahAbsensi(); // Jalankan validasi setelah menghitung jumlah absensi
                }
            }

            jumlahAbsensiInput.addEventListener('input', validateJumlahAbsensi);
            idJatahAbsensiSelect.addEventListener('change', function () {
                const selectedOption = idJatahAbsensiSelect.options[idJatahAbsensiSelect.selectedIndex];
                jumlahAbsensiInput.setAttribute('max', selectedOption.getAttribute('data-total-jatah') || 0);
                validateJumlahAbsensi();
            });

            tanggalMulaiInput.addEventListener('change', calculateJumlahAbsensi);
            tanggalAkhirInput.addEventListener('change', calculateJumlahAbsensi);

            // **Blokir submit form jika jumlah absensi tidak valid**
            formTambahAbsensi.addEventListener('submit', function (event) {
                if (!validateJumlahAbsensi()) {
                    event.preventDefault(); // **Blokir form jika jumlah cuti melebihi jatah**
                    alert('Jumlah cuti melebihi jatah! Mohon perbaiki sebelum menyimpan.');
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const jumlahAbsensiEditInput = document.getElementById('edit-jumlah_absensi');
            const sisaJatahEditInput = document.getElementById('edit-sisa-jatah'); // Input readonly untuk sisa jatah
            const tanggalMulaiEditInput = document.getElementById('edit-tanggal_absensi_mulai');
            const tanggalAkhirEditInput = document.getElementById('edit-tanggal_absensi_akhir');
            const formEditAbsensi = document.querySelector('#edit-absensi-form');

            let jumlahAbsensiEditError = document.getElementById('edit-jumlah-absensi-error');
            if (!jumlahAbsensiEditError) {
                jumlahAbsensiEditError = document.createElement('small');
                jumlahAbsensiEditError.id = 'edit-jumlah-absensi-error';
                jumlahAbsensiEditError.style.color = 'red';
                jumlahAbsensiEditError.style.display = 'none';
                jumlahAbsensiEditInput.parentNode.appendChild(jumlahAbsensiEditError);
            }

            function validateJumlahAbsensiEdit() {
                const totalJatahAbsensi = parseInt(jumlahAbsensiEditInput.getAttribute('data-total-jatah')) || 0;
                const jumlahAbsensiSebelumnya = parseInt(jumlahAbsensiEditInput.getAttribute('data-jumlah-absensi-sebelumnya')) || 0;
                const jumlahAbsensiBaru = parseInt(jumlahAbsensiEditInput.value) || 0;

                // Hitung kembali jatah total sebelum cuti sebelumnya dikurangi
                const totalJatahAbsensiSebenarnya = totalJatahAbsensi + jumlahAbsensiSebelumnya;

                // Hitung sisa jatah absensi
                const sisaJatah = totalJatahAbsensiSebenarnya - jumlahAbsensiBaru;
                sisaJatahEditInput.value = sisaJatah >= 0 ? sisaJatah : 0; // Jangan sampai negatif

                if (jumlahAbsensiBaru > totalJatahAbsensiSebenarnya) {
                    jumlahAbsensiEditError.textContent = 'Jumlah cuti melebihi total jatah absensi!';
                    jumlahAbsensiEditError.style.display = 'block';
                    jumlahAbsensiEditInput.setCustomValidity('Jumlah cuti melebihi jatah!');
                    return false;
                } else {
                    jumlahAbsensiEditError.textContent = '';
                    jumlahAbsensiEditError.style.display = 'none';
                    jumlahAbsensiEditInput.setCustomValidity('');
                    return true;
                }
            }

            function calculateJumlahAbsensiEdit() {
                const tanggalMulai = new Date(tanggalMulaiEditInput.value);
                const tanggalAkhir = new Date(tanggalAkhirEditInput.value);

                if (tanggalMulai && tanggalAkhir && !isNaN(tanggalMulai) && !isNaN(tanggalAkhir)) {
                    const diffInTime = tanggalAkhir.getTime() - tanggalMulai.getTime();
                    const diffInDays = Math.ceil(diffInTime / (1000 * 3600 * 24)) + 1;
                    jumlahAbsensiEditInput.value = diffInDays > 0 ? diffInDays : 0;
                    validateJumlahAbsensiEdit();
                }
            }

            jumlahAbsensiEditInput.addEventListener('input', validateJumlahAbsensiEdit);
            tanggalMulaiEditInput.addEventListener('change', calculateJumlahAbsensiEdit);
            tanggalAkhirEditInput.addEventListener('change', calculateJumlahAbsensiEdit);

            // **Set total jatah absensi saat modal edit dibuka**
            document.querySelectorAll('.dropdown-item[data-bs-target="#editAbsensiModal"]').forEach(item => {
                item.addEventListener('click', function () {
                    const totalJatahAbsensi = this.getAttribute("data-total-jatah") || 0;
                    const jumlahAbsensiSebelumnya = this.getAttribute("data-jumlah-absensi-sebelumnya") || 0;

                    jumlahAbsensiEditInput.setAttribute('data-total-jatah', totalJatahAbsensi);
                    jumlahAbsensiEditInput.setAttribute('data-jumlah-absensi-sebelumnya', jumlahAbsensiSebelumnya);

                    // Hitung sisa jatah absensi saat modal dibuka
                    const sisaJatah = (parseInt(totalJatahAbsensi) + parseInt(jumlahAbsensiSebelumnya)) - parseInt(jumlahAbsensiEditInput.value);
                    sisaJatahEditInput.value = sisaJatah >= 0 ? sisaJatah : 0;

                    validateJumlahAbsensiEdit();
                });
            });

            // **Blokir submit jika jumlah absensi melebihi jatah**
            formEditAbsensi.addEventListener('submit', function (event) {
                if (!validateJumlahAbsensiEdit()) {
                    event.preventDefault();
                    alert('Jumlah cuti melebihi jatah! Mohon perbaiki sebelum menyimpan.');
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.dropdown-item[data-bs-target="#confirmDeleteModal"]').forEach(item => {
                item.addEventListener('click', function () {
                    const absensiId = this.getAttribute("data-id_absensi");
                    const deleteForm = document.getElementById('delete-absensi-form');
                    deleteForm.action = "/delete-absensi/" + absensiId;
                });
            });
        });

    </script>

@endsection