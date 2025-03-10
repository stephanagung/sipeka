@extends('layout.app')

@section('content')
<div class="page-header">
    <h3 class="fw-bold">Master Data</h3>
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
            <a href="{{ url('/index-pengguna') }}">Data Pengguna</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="display: flex; align-items: center; justify-content: space-between;">
                <h4 class="card-title" style="margin: 0;">Data Pengguna</h4>
                <div class="btn-group">
                    <button onclick="refreshPage()" class="btn btn-black btn-small">
                        <span class="btn-label">
                            <i class="fas fa-undo-alt"></i>
                        </span>
                        Refresh Data
                    </button>
                    &nbsp;&nbsp;
                    <button type="button" class="btn btn-small btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addPenggunaModal">
                        <i class="fa fa-plus"></i> Tambah Data
                    </button>
                    &nbsp;&nbsp;
                    <button type="button" class="btn btn-small btn-success" data-bs-toggle="modal"
                        data-bs-target="#importExcelModal">
                        <i class="fa fa-file-excel"></i> Import Excel
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="basic-datatables" class="display table table-striped table-hover">
                        <thead class="table-success">
                            <tr>
                                <th>No.</th>
                                <th>Aksi</th>
                                <th>NIK</th>
                                <th>Nama Lengkap</th>
                                <th>Jabatan</th>
                                <th>Departemen</th>
                                <th>Plant</th>
                                <th>Status Pekerjaan</th>
                                <th>Jenis Kelamin</th>
                                <th>Username</th>
                                <th>Level</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengguna as $index => $user)
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
                                                    href="{{ route('pengguna.show', $user->id_pengguna) }}">
                                                    <i class="fas fa-info-circle"></i> Lihat Detail
                                                </a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#editPenggunaModal" data-id="{{ $user->id_pengguna }}"
                                                    data-departemen="{{ $user->id_departemen }}"
                                                    data-plant="{{ $user->id_plant }}" data-nik="{{ $user->nik }}"
                                                    data-nama="{{ $user->nama_lengkap }}"
                                                    data-jabatan="{{ $user->jabatan }}"
                                                    data-domisili="{{ $user->domisili }}"
                                                    data-lemburan="{{ $user->jenis_lemburan }}"
                                                    data-status="{{ $user->status_pekerjaan }}"
                                                    data-pendidikan="{{ $user->pendidikan_terakhir }}"
                                                    data-kelamin="{{ $user->jenis_kelamin }}"
                                                    data-username="{{ $user->username }}"
                                                    data-password="{{ $user->password }}" data-level="{{ $user->level }}">
                                                    <i class="fas fa-edit"></i> Edit Data
                                                </a>
                                                <a class="dropdown-item" href="#"
                                                    onclick="confirmDelete('{{ $user->id_pengguna }}')"><i
                                                        class="fas fa-trash"></i> Hapus Data</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->nik }}</td>
                                    <td>{{ $user->nama_lengkap }}</td>
                                    <td>{{ $user->jabatan }}</td>
                                    <td>{{ $user->departemen->nama_departemen }}</td>
                                    <td>{{ $user->plant->nama_plant }}</td>
                                    <td>{{ $user->status_pekerjaan }}</td>
                                    <td>{{ $user->jenis_kelamin }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->level }}</td>
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
<div class="modal fade" id="addPenggunaModal" tabindex="-1" aria-labelledby="addPenggunaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPenggunaModalLabel"><strong>Tambah Data Pengguna</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAddPengguna" action="{{ route('pengguna.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6">
                            <div class="form-group form-group-default mb-3">
                                <label><strong>Departemen <span class="text-danger">*</span></strong></label>
                                <select name="id_departemen" class="form-control" required>
                                    <option value="" disabled selected>-- Pilih Departemen --</option>
                                    @foreach ($departemen as $dept)
                                        <option value="{{ $dept->id_departemen }}">{{ $dept->nama_departemen }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group form-group-default mb-3">
                                <label><strong>Plant <span class="text-danger">*</span></strong></label>
                                <select name="id_plant" class="form-control" required>
                                    <option value="" disabled selected>-- Pilih Plant --</option>
                                    @foreach ($plants as $plant)
                                        <option value="{{ $plant->id_plant }}">{{ $plant->nama_plant }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group form-group-default mb-3">
                                <label><strong>NIK <span class="text-danger">*</span></strong></label>
                                <input type="text" name="nik" class="form-control" placeholder="Masukkan NIK"
                                    required />
                            </div>

                            <div class="form-group form-group-default mb-3">
                                <label><strong>Nama Lengkap <span class="text-danger">*</span></strong></label>
                                <input type="text" name="nama_lengkap" class="form-control"
                                    placeholder="Masukkan Nama Lengkap" required />
                            </div>

                            <div class="form-group form-group-default mb-3">
                                <label><strong>Jabatan <span class="text-danger">*</span></strong></label>
                                <input type="text" name="jabatan" class="form-control" placeholder="Masukkan Jabatan"
                                    required />
                            </div>

                            <div class="form-group form-group-default mb-3">
                                <label><strong>Domisili <span class="text-danger">*</span></strong></label>
                                <select name="domisili" class="form-control" required>
                                    <option value="" disabled selected>-- Pilih Domisili --</option>
                                    <option value="Bekasi">Bekasi</option>
                                    <option value="LuarBekasi">Luar Bekasi</option>
                                </select>
                            </div>

                            <div class="form-group form-group-default mb-3">
                                <label><strong>Jenis Lemburan <span class="text-danger">*</span></strong></label>
                                <select name="jenis_lemburan" class="form-control" required>
                                    <option value="" disabled selected>-- Pilih Jenis Lemburan --</option>
                                    <option value="Flat">Flat</option>
                                    <option value="NonFlat">Non Flat</option>
                                </select>
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            <div class="form-group form-group-default mb-3">
                                <label><strong>Status Pekerjaan <span class="text-danger">*</span></strong></label>
                                <select name="status_pekerjaan" class="form-control" required>
                                    <option value="" disabled selected>-- Pilih Status Pekerjaan --</option>
                                    <option value="Tetap">Tetap</option>
                                    <option value="Kontrak">Kontrak</option>
                                    <option value="Magang/PKL">Magang/PKL</option>
                                </select>
                            </div>

                            <div class="form-group form-group-default mb-3">
                                <label><strong>Pendidikan Terakhir <span class="text-danger">*</span></strong></label>
                                <select name="pendidikan_terakhir" class="form-control" required>
                                    <option value="" disabled selected>-- Pilih Pendidikan Terakhir --</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="SMK">SMK</option>
                                    <option value="D1">D1</option>
                                    <option value="D2">D2</option>
                                    <option value="D3">D3</option>
                                    <option value="D4">D4</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                </select>
                            </div>

                            <div class="form-group form-group-default mb-3">
                                <label><strong>Jenis Kelamin <span class="text-danger">*</span></strong></label>
                                <select name="jenis_kelamin" class="form-control" required>
                                    <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                    <option value="Pria">Pria</option>
                                    <option value="Wanita">Wanita</option>
                                </select>
                            </div>

                            <div class="form-group form-group-default mb-3">
                                <label><strong>Tanggal Bergabung <span class="text-danger">*</span></strong></label>
                                <input type="date" name="tanggal_bergabung" class="form-control" required />
                            </div>

                            <div class="form-group form-group-default mb-3">
                                <label><strong>Username <span class="text-danger">*</span></strong></label>
                                <div class="input-group">
                                    <input type="text" name="username" id="username-input" class="form-control"
                                        placeholder="Masukkan Username"
                                        onkeyup="cekUsername('username-input', 'username-status')" required />
                                    <span class="input-group-text" id="username-status"
                                        style="background: transparent !important; border: none;">
                                        <i class="fas fa-spinner fa-spin d-none"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group form-group-default mb-3">
                                <label><strong>Password <span class="text-danger">*</span></strong></label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Masukkan Password" required />
                            </div>

                            <div class="form-group form-group-default mb-3">
                                <label><strong>Level <span class="text-danger">*</span></strong></label>
                                <select name="level" class="form-control" required>
                                    <option value="" disabled selected>-- Pilih Level --</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Atasan">Atasan</option>
                                    <option value="Karyawan">Karyawan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editPenggunaModal" tabindex="-1" aria-labelledby="editPenggunaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPenggunaModalLabel"><strong>Edit Data Pengguna</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditPengguna" action="{{ route('pengguna.update', $user->id_pengguna) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_pengguna" id="edit-id-pengguna" />

                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6">
                            <div class="form-group form-group-default mb-3">
                                <label><strong>Departemen <span class="text-danger">*</span></strong></label>
                                <select name="id_departemen" id="edit-departemen" class="form-control" required>
                                    @foreach ($departemen as $dept)
                                        <option value="{{ $dept->id_departemen }}">{{ $dept->nama_departemen }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group form-group-default mb-3">
                                <label><strong>Plant <span class="text-danger">*</span></strong></label>
                                <select name="id_plant" id="edit-plant" class="form-control" required>
                                    @foreach ($plants as $plant)
                                        <option value="{{ $plant->id_plant }}">{{ $plant->nama_plant }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group form-group-default mb-3">
                                <label><strong>NIK <span class="text-danger">*</span></strong></label>
                                <input type="text" name="nik" id="edit-nik" class="form-control"
                                    placeholder="Masukkan NIK" required />
                            </div>

                            <div class="form-group form-group-default mb-3">
                                <label><strong>Nama Lengkap <span class="text-danger">*</span></strong></label>
                                <input type="text" name="nama_lengkap" id="edit-nama-lengkap" class="form-control"
                                    placeholder="Masukkan Nama Lengkap" required />
                            </div>

                            <div class="form-group form-group-default mb-3">
                                <label><strong>Jabatan <span class="text-danger">*</span></strong></label>
                                <input type="text" name="jabatan" id="edit-jabatan" class="form-control"
                                    placeholder="Masukkan Jabatan" required />
                            </div>

                            <div class="form-group form-group-default mb-3">
                                <label><strong>Domisili <span class="text-danger">*</span></strong></label>
                                <select name="domisili" id="edit-domisili" class="form-control" required>
                                    <option value="" disabled selected>-- Pilih Domisili --</option>
                                    <option value="Bekasi">Bekasi</option>
                                    <option value="LuarBekasi">Luar Bekasi</option>
                                </select>
                            </div>

                            <div class="form-group form-group-default mb-3">
                                <label><strong>Jenis Lemburan <span class="text-danger">*</span></strong></label>
                                <select name="jenis_lemburan" id="edit-jenis-lemburan" class="form-control" required>
                                    <option value="" disabled selected>-- Pilih Jenis Lemburan --</option>
                                    <option value="Flat">Flat</option>
                                    <option value="NonFlat">Non Flat</option>
                                </select>
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            <div class="form-group form-group-default mb-3">
                                <label><strong>Status Pekerjaan <span class="text-danger">*</span></strong></label>
                                <select name="status_pekerjaan" id="edit-status-pekerjaan" class="form-control"
                                    required>
                                    <option value="" disabled selected>-- Pilih Status Pekerjaan --</option>
                                    <option value="Tetap">Tetap</option>
                                    <option value="Kontrak">Kontrak</option>
                                    <option value="Magang/PKL">Magang/PKL</option>
                                </select>
                            </div>

                            <div class="form-group form-group-default mb-3">
                                <label><strong>Pendidikan Terakhir <span class="text-danger">*</span></strong></label>
                                <select name="pendidikan_terakhir" id="edit-pendidikan-terakhir" class="form-control"
                                    required>
                                    <option value="" disabled selected>-- Pilih Pendidikan Terakhir --</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="SMK">SMK</option>
                                    <option value="D1">D1</option>
                                    <option value="D2">D2</option>
                                    <option value="D3">D3</option>
                                    <option value="D4">D4</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                </select>
                            </div>

                            <div class="form-group form-group-default mb-3">
                                <label><strong>Jenis Kelamin <span class="text-danger">*</span></strong></label>
                                <select name="jenis_kelamin" id="edit-jenis-kelamin" class="form-control" required>
                                    <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                    <option value="Pria">Pria</option>
                                    <option value="Wanita">Wanita</option>
                                </select>
                            </div>

                            <div class="form-group form-group-default mb-3">
                                <label><strong>Username <span class="text-danger">*</span></strong></label>
                                <div class="input-group">
                                    <input type="text" name="username" id="edit-username" class="form-control"
                                        placeholder="Masukkan Username" onkeyup="cekUsernameEdit()" required />
                                    <span class="input-group-text" id="edit-username-status"
                                        style="background: transparent !important; border: none;">
                                        <i class="fas fa-spinner fa-spin d-none"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group form-group-default mb-3">
                                <label><strong>Password <span class="text-danger">*</span></strong></label>
                                <input type="text" name="password" id="edit-password" class="form-control"
                                    placeholder="Masukkan Password" required />
                            </div>

                            <div class="form-group form-group-default mb-3">
                                <label><strong>Level <span class="text-danger">*</span></strong></label>
                                <select name="level" id="edit-level" class="form-control" required>
                                    <option value="" disabled selected>-- Pilih Level --</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Atasan">Atasan</option>
                                    <option value="Karyawan">Karyawan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmModalLabel"><strong>Konfirmasi Hapus</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data ini?
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Import Excel -->
<div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importExcelModalLabel"><strong>Import Data Pengguna dari Excel</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="importExcelForm" action="{{ route('pengguna.import') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group form-group-default mb-3">
                        <label>Pilih File Excel</label>
                        <input type="file" name="file" class="form-control" required accept=".xlsx, .xls, .csv">
                    </div>
                    <button type="submit" class="btn btn-small btn-success">Import</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let usernameLama = ""; // Variabel untuk menyimpan username sebelumnya di modal edit

    function cekUsername(inputId, statusId) {
        var username = document.getElementById(inputId).value;
        var statusElement = document.getElementById(statusId);

        if (username.length < 3) {
            statusElement.innerHTML = "";
            return;
        }

        // Khusus untuk Modal Edit, cek apakah username tidak berubah
        if (inputId === "edit-username" && username === usernameLama) {
            statusElement.innerHTML = '<i class="fas fa-check-circle text-success"></i>'; // Tetap hijau
            return;
        }

        // Tampilkan spinner loading
        statusElement.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

        fetch(`/cek-username?username=${username}`)
            .then(response => response.json())
            .then(data => {
                if (data.available) {
                    statusElement.innerHTML = '<i class="fas fa-check-circle text-success"></i>'; // Centang hijau
                } else {
                    statusElement.innerHTML = '<i class="fas fa-times-circle text-danger"></i>'; // Silang merah
                }
            })
            .catch(error => {
                console.error("Error checking username:", error);
                statusElement.innerHTML = '<i class="fas fa-exclamation-circle text-warning"></i>'; // Ikon error
            });
    }

    // Saat modal edit dibuka, simpan username lama
    document.getElementById('editPenggunaModal').addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        usernameLama = button.getAttribute('data-username'); // Simpan username sebelumnya
        document.getElementById('edit-username').value = usernameLama;
        document.getElementById('edit-username-status').innerHTML = '<i class="fas fa-check-circle text-success"></i>'; // Default centang hijau
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editPenggunaModal = document.getElementById('editPenggunaModal');
        editPenggunaModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var idPengguna = button.getAttribute('data-id');

            var form = document.getElementById('formEditPengguna');
            var action = "{{ url('update-pengguna') }}/" + idPengguna;
            form.setAttribute('action', action);

            // Set the values in the form fields
            document.getElementById('edit-id-pengguna').value = idPengguna;
            document.getElementById('edit-departemen').value = button.getAttribute('data-departemen');
            document.getElementById('edit-plant').value = button.getAttribute('data-plant');
            document.getElementById('edit-nik').value = button.getAttribute('data-nik');
            document.getElementById('edit-nama-lengkap').value = button.getAttribute('data-nama');
            document.getElementById('edit-jabatan').value = button.getAttribute('data-jabatan');
            document.getElementById('edit-domisili').value = button.getAttribute('data-domisili');
            document.getElementById('edit-jenis-lemburan').value = button.getAttribute('data-lemburan');
            document.getElementById('edit-status-pekerjaan').value = button.getAttribute('data-status');
            document.getElementById('edit-pendidikan-terakhir').value = button.getAttribute('data-pendidikan');
            document.getElementById('edit-jenis-kelamin').value = button.getAttribute('data-kelamin');
            document.getElementById('edit-username').value = button.getAttribute('data-username');
            document.getElementById('edit-password').value = button.getAttribute('data-password');
            document.getElementById('edit-level').value = button.getAttribute('data-level');
        });
    });

    function confirmDelete(id) {
        const form = document.getElementById('deleteForm');
        form.action = '/delete-pengguna/' + id;
        new bootstrap.Modal(document.getElementById('deleteConfirmModal')).show();
    }
</script>


@endsection