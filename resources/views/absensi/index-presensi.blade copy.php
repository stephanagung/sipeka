@extends('layout.app')

@section('content')
    <div class="page-header">
        <h3 class="fw-bold">Master Data</h3>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ url('/dashboard.dashboard-admin') }}">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="{{ url('/index-presensi') }}">Data Presensi</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="display: flex; align-items: center; justify-content: space-between;">
                    <h4 class="card-title" style="margin: 0;">Data Presensi</h4>
                    <div class="btn-group">
                        <button onclick="refreshPage()" class="btn btn-black btn-small">
                            <span class="btn-label">
                                <i class="fas fa-undo-alt"></i>
                            </span>
                            Refresh Data
                        </button>
                        &nbsp;&nbsp;
                        <button type="button" class="btn btn-small btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addPresensiModal">
                            <i class="fa fa-plus"></i> Tambah Data
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Aksi</th>
                                    <th>Nama Pengguna</th>
                                    <th>Kategori</th>
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
                                                        href="{{ route('presensi.show', $item->id_presensi) }}">
                                                        <i class="fas fa-info-circle"></i> Lihat Detail
                                                    </a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#editPresensiModal"
                                                        data-id_presensi="{{ $item->id_presensi }}"
                                                        data-id_jatah_absensi="{{ $item->id_jatah_absensi }}"
                                                        data-shift="{{ $item->shift }}"
                                                        data-id_kategori="{{ $item->id_kategori }}"
                                                        data-dokumen_pendukung="{{ $item->dokumen_pendukung }}"
                                                        data-tanggal_absen="{{ $item->tanggal_absen }}"
                                                        data-tanggal_absensi_mulai="{{ $item->tanggal_absensi_mulai }}"
                                                        data-tanggal_absensi_akhir="{{ $item->tanggal_absensi_akhir }}"
                                                        data-jumlah_absensi="{{ $item->jumlah_absensi }}"
                                                        data-alasan="{{ $item->alasan }}"
                                                        data-catatan="{{ $item->catatan }}"
                                                        data-disetujui_atasan="{{ $item->disetujui_atasan }}"
                                                        data-disetujui_hrd="{{ $item->disetujui_hrd }}">
                                                        <i class="fas fa-edit"></i> Edit Data
                                                    </a>

                                                    <a class="dropdown-item" href="#"
                                                        onclick="confirmDelete('{{ $item->id_presensi }}')"><i
                                                            class="fas fa-trash"></i>
                                                        Hapus Data</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $item->jatahAbsensi->pengguna->nama_lengkap ?? '-' }}
                                            (NIK: {{ $item->jatahAbsensi->pengguna->nik ?? '-' }})
                                        </td>
                                        <td>{{ $item->kategori->nama_kategori }} ({{ $item->kategori->kode_kategori }})
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
    <div class="modal fade" id="addPresensiModal" tabindex="-1" aria-labelledby="addPresensiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPresensiModalLabel">Tambah Data Presensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('presensi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="departemen" class="form-label">Departemen</label>
                            <select id="departemen" class="form-control" onchange="filterPengguna(this.value)">
                                <option value="">Pilih Departemen</option>
                                @foreach ($departemen as $dept)
                                    <option value="{{ $dept->id_departemen }}">{{ $dept->nama_departemen }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_jatah_absensi">Nama Pengguna</label>
                            <select id="id_jatah_absensi" name="id_jatah_absensi" class="form-control">
                                <option value="">Pilih Pengguna</option>
                                @foreach ($jatahAbsensi as $jatah)
                                    <option value="{{ $jatah->id_jatah_absensi }}"
                                        data-departemen="{{ $jatah->pengguna->id_departemen }}">
                                        {{ $jatah->pengguna->nama_lengkap }} - {{ $jatah->pengguna->nik }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="shift">Shift</label>
                            <select name="shift" id="edit-shift" class="form-control" required>
                                <option value="">Pilih Shift</option>
                                <option value="1">Shift 1</option>
                                <option value="2">Shift 2</option>
                                <option value="3">Shift 3</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_kategori">Kategori</label>
                            <select id="id_kategori" name="id_kategori" class="form-control" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori as $cat)
                                    <option value="{{ $cat->id_kategori }}">{{ $cat->nama_kategori }}
                                        ({{ $cat->kode_kategori }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="dokumen_pendukung">Dokumen Pendukung</label>
                            <input type="file" id="dokumen_pendukung" name="dokumen_pendukung" class="form-control">
                        </div>
                        <div class="form-group" id="tanggal-absen-div" style="display: none;">
                            <label for="tanggal_absen">Tanggal Absen</label>
                            <input type="datetime-local" id="tanggal_absen" name="tanggal_absen" class="form-control">
                        </div>

                        <div class="form-group" id="tanggal-mulai-div" style="display: none;">
                            <!-- awalnya tersembunyi -->
                            <label for="tanggal_absensi_mulai">Tanggal Mulai Absensi</label>
                            <input type="datetime-local" id="tanggal_absensi_mulai" name="tanggal_absensi_mulai"
                                class="form-control">
                        </div>

                        <div class="form-group" id="tanggal-akhir-div" style="display: none;">
                            <!-- awalnya tersembunyi -->
                            <label for="tanggal_absensi_akhir">Tanggal Akhir Absensi</label>
                            <input type="datetime-local" id="tanggal_absensi_akhir" name="tanggal_absensi_akhir"
                                class="form-control">
                        </div>

                        <div class="form-group" id="jumlah-absensi-div" style="display: none;">
                            <label for="jumlah_absensi">Jumlah Absensi</label>
                            <input type="number" class="form-control" id="jumlah_absensi" name="jumlah_absensi"
                                readonly>
                        </div>

                        <div class="form-group">
                            <label for="alasan">Alasan</label>
                            <textarea id="alasan" name="alasan" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="alasan">Catatan</label>
                            <textarea id="catatan" name="catatan" class="form-control" required></textarea>
                        </div>
                        <!-- Input otomatis dengan nilai default -->
                        <input type="hidden" name="status_presensi" value="1">
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
    <div class="modal fade" id="editPresensiModal" tabindex="-1" aria-labelledby="editPresensiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPresensiModalLabel">Edit Data Presensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="edit-presensi-form" action="{{ route('presensi.update', $item->id_presensi) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit-id_presensi" name="id_presensi">
                    <input type="hidden" id="edit-id_jatah_absensi" name="id_jatah_absensi">

                    <div class="modal-body">

                        <div class="form-group">
                            <label for="edit-shift">Shift</label>
                            <select id="edit-shift" name="shift" class="form-control" required>
                                <option value="1" {{ $item->shift == 1 ? 'selected' : '' }}>1</option>
                                <option value="2" {{ $item->shift == 2 ? 'selected' : '' }}>2</option>
                                <option value="3" {{ $item->shift == 3 ? 'selected' : '' }}>3</option>
                            </select>
                        </div>                        

                        <div class="form-group">
                            <label for="edit-id_kategori">Kategori</label>
                            <select id="edit-id_kategori" name="id_kategori" class="form-control" required readonly disabled>
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori as $cat)
                                    <option value="{{ $cat->id_kategori }}">{{ $cat->nama_kategori }}
                                        ({{ $cat->kode_kategori }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit-dokumen_pendukung">Dokumen Pendukung</label>
                            <input type="file" id="edit-dokumen_pendukung" name="dokumen_pendukung"
                                class="form-control">
                            <label class="mt-2">File Sebelumnya : </label>
                        </div>
                        <div class="form-group" id="edit-tanggal-absen-div" style="display: none;">
                            <label for="edit-tanggal_absen">Tanggal Absen</label>
                            <input type="datetime-local" id="edit-tanggal_absen" name="tanggal_absen"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="edit-tanggal_absensi_mulai">Tanggal Absensi Mulai</label>
                            <input type="datetime-local" id="edit-tanggal_absensi_mulai" name="tanggal_absensi_mulai"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="edit-tanggal_absensi_akhir">Tanggal Absensi Akhir</label>
                            <input type="datetime-local" id="edit-tanggal_absensi_akhir" name="tanggal_absensi_akhir"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="edit-jumlah_absensi">Jumlah Absensi</label>
                            <input type="number" id="edit-jumlah_absensi" name="jumlah_absensi" class="form-control" readonly disabled>
                        </div>
                        <div class="form-group">
                            <label for="edit-alasan">Alasan</label>
                            <textarea id="edit-alasan" name="alasan" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit-catatan">Catatan</label>
                            <textarea id="edit-catatan" name="catatan" class="form-control"></textarea>
                        </div>
                        <!-- Input otomatis dengan nilai default -->
                        <input type="hidden" name="status_presensi" id="edit-status_presensi">
                        <input type="hidden" name="disetujui_atasan" id="edit-disetujui_atasan">
                        <input type="hidden" name="disetujui_hrd" id="edit-disetujui_hrd">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Data</button>
                    </div>
                </form>
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
        document.addEventListener('DOMContentLoaded', function() {
            const kategoriSelect = document.getElementById('id_kategori');
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
        document.addEventListener('DOMContentLoaded', function() {
            var editPresensiModal = document.getElementById('editPresensiModal');
            editPresensiModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var idKategori = button.getAttribute('data-id_kategori');
                var shift = button.getAttribute('data-shift');
                var dokumenPendukung = button.getAttribute('data-dokumen_pendukung');
                var tanggalAbsen = button.getAttribute('data-tanggal_absen');
                var tanggalAbsensiMulai = button.getAttribute('data-tanggal_absensi_mulai');
                var tanggalAbsensiAkhir = button.getAttribute('data-tanggal_absensi_akhir');
                var jumlahAbsensi = button.getAttribute('data-jumlah_absensi');
                var alasan = button.getAttribute('data-alasan');
                var catatan = button.getAttribute('data-catatan');
                var disetujuiAtasan = button.getAttribute('data-disetujui_atasan');
                var disetujuiHrd = button.getAttribute('data-disetujui_hrd');

                // Set value hidden inputs
                document.getElementById('edit-id_presensi').value = button.getAttribute('data-id_presensi');
                document.getElementById('edit-id_jatah_absensi').value = button.getAttribute(
                    'data-id_jatah_absensi');

                // Set value kategori
                var kategoriSelect = document.getElementById('edit-id_kategori');
                kategoriSelect.value = idKategori; // Set value

                // Set value shift
                var shiftSelect = document.getElementById('edit-shift');
                shiftSelect.value = shift;

                // Set value dokumen pendukung
                document.getElementById('edit-dokumen_pendukung').value = dokumenPendukung;

                // Set value tanggal absensi
                document.getElementById('edit-tanggal_absen').value = tanggalAbsen;
                document.getElementById('edit-tanggal_absensi_mulai').value = tanggalAbsensiMulai;
                document.getElementById('edit-tanggal_absensi_akhir').value = tanggalAbsensiAkhir;

                // Set value jumlah absensi
                document.getElementById('edit-jumlah_absensi').value = jumlahAbsensi;

                // Set value alasan
                document.getElementById('edit-alasan').value = alasan;
                document.getElementById('edit-catatan').value = catatan;

                // Set value disetujui
                document.getElementById('edit-status_presensi').value = disetujuiAtasan;
                document.getElementById('edit-disetujui_atasan').value = disetujuiAtasan;
                document.getElementById('edit-disetujui_hrd').value = disetujuiHrd;
            });
        });
    </script>
@endsection
