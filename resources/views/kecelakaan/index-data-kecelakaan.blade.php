@extends('layout.app')

@section('content')
    <div class="page-header">
        <h3 class="fw-bold">Data Kecelakaan</h3>
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
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Data Kecelakaan</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="display: flex; align-items: center; justify-content: space-between;">
                    <h4 class="card-title" style="margin: 0;">Data Kecelakaan</h4>
                    <div class="btn-group">
                        <a href="{{ url('/index-rekap-kecelakaan') }}">
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
                            data-bs-target="#addDataKecelakaanModal">
                            <i class="fa fa-plus"></i> Tambah Data
                        </button>
                    </div>
                </div>

                <div class="card-body">

                    <!-- Filter Form -->
                    <form method="GET"
                        action="{{ route('dataKecelakaan.index', ['id_rekap_kecelakaan' => $rekapKecelakaan->id_rekap_kecelakaan]) }}">
                        <div class="row">
                            <div class="col-md-12">
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
                        </div>
                    </form>

                    <div class="table-responsive mt-3">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead class="table-success">
                                <tr>
                                    <th>No.</th>
                                    <th>Aksi</th>
                                    <th>Departemen</th>
                                    <th>Nama Kecelakaan</th>
                                    <th>Jumlah Korban</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal Kecelakaan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataKecelakaans as $index => $kecelakaan)
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
                                                        data-bs-target="#editDataKecelakaanModal"
                                                        data-id="{{ $kecelakaan->id_data_kecelakaan }}"
                                                        data-nama="{{ $kecelakaan->nama_kecelakaan }}"
                                                        data-jumlah="{{ $kecelakaan->jumlah_korban_kecelakaan }}"
                                                        data-deskripsi="{{ $kecelakaan->deskripsi_kecelakaan }}"
                                                        data-tanggal="{{ $kecelakaan->tanggal_kecelakaan }}"
                                                        data-departemen="{{ $kecelakaan->id_departemen }}"
                                                        data-periode-bulan="{{ $rekapKecelakaan->periode_bulan_kecelakaan }}"
                                                        data-periode-tahun="{{ $rekapKecelakaan->periode_tahun_kecelakaan }}">
                                                        <i class="fas fa-edit"></i> Edit Data
                                                    </a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#confirmDeleteModal"
                                                        data-id="{{ $kecelakaan->id_data_kecelakaan }}">
                                                        <i class="fas fa-trash"></i> Hapus Data
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $kecelakaan->departemen->nama_departemen ?? '-' }}</td>
                                        <td>{{ $kecelakaan->nama_kecelakaan }}</td>
                                        <td>{{ $kecelakaan->jumlah_korban_kecelakaan ?? '-' }}</td>
                                        <td>{{ $kecelakaan->deskripsi_kecelakaan ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($kecelakaan->tanggal_kecelakaan)->format('d-m-Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Data Kecelakaan -->
    <div class="modal fade" id="addDataKecelakaanModal" tabindex="-1" aria-labelledby="addDataKecelakaanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="addDataKecelakaanModalLabel">Tambah Data Kecelakaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('dataKecelakaan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <!-- Pilih Rekap Kecelakaan -->
                        <input type="hidden" name="id_rekap_kecelakaan" value="{{ $rekapKecelakaan->id_rekap_kecelakaan }}">

                        <!-- Pilih Departemen -->
                        <div class="form-group">
                            <label for="id_departemen" class="fw-bold">Departemen <span class="text-danger">*</span></label>
                            <select name="id_departemen" class="form-control" required>
                                <option value="" disabled selected>Pilih Departemen</option>
                                @foreach ($departemen as $depart)
                                    <option value="{{ $depart->id_departemen }}">{{ $depart->nama_departemen }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nama Kecelakaan -->
                        <div class="form-group">
                            <label for="nama_kecelakaan" class="fw-bold">Nama Kecelakaan <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="nama_kecelakaan" class="form-control" required
                                placeholder="Masukkan Nama Kecelakaan" />
                        </div>

                        <!-- Jumlah Korban -->
                        <div class="form-group">
                            <label for="jumlah_korban_kecelakaan" class="fw-bold">Jumlah Korban</label>
                            <input type="number" name="jumlah_korban_kecelakaan" class="form-control"
                                placeholder="Masukkan Jumlah Korban" />
                        </div>

                        <!-- Deskripsi Kecelakaan -->
                        <div class="form-group">
                            <label for="deskripsi_kecelakaan" class="fw-bold">Deskripsi Kecelakaan</label>
                            <textarea name="deskripsi_kecelakaan" class="form-control"
                                placeholder="Masukkan Deskripsi Kecelakaan"></textarea>
                        </div>

                        <!-- Tanggal Kecelakaan -->
                        <div class="form-group">
                            <label for="tanggal_kecelakaan" class="fw-bold">Tanggal Kecelakaan <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="tanggal_kecelakaan" class="form-control" id="tanggal-kecelakaan"
                                required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Data Kecelakaan -->
    <div class="modal fade" id="editDataKecelakaanModal" tabindex="-1" aria-labelledby="editDataKecelakaanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="editDataKecelakaanModalLabel">Edit Data Kecelakaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditDataKecelakaan" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="id_data_kecelakaan" id="edit-id-data-kecelakaan">

                        <!-- Departemen (pindah ke atas) -->
                        <div class="form-group">
                            <label for="edit-id-departemen" class="fw-bold">Departemen</label>
                            <select name="id_departemen" id="edit-id-departemen" class="form-control" required>
                                @foreach ($departemen as $dept)
                                    <option value="{{ $dept->id_departemen }}">{{ $dept->nama_departemen }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nama Kecelakaan -->
                        <div class="form-group">
                            <label for="edit-nama-kecelakaan" class="fw-bold">Nama Kecelakaan <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="nama_kecelakaan" id="edit-nama-kecelakaan" class="form-control"
                                required />
                        </div>

                        <!-- Jumlah Korban -->
                        <div class="form-group">
                            <label for="edit-jumlah-korban" class="fw-bold">Jumlah Korban Kecelakaan</label>
                            <input type="number" name="jumlah_korban_kecelakaan" id="edit-jumlah-korban"
                                class="form-control" />
                        </div>

                        <!-- Deskripsi Kecelakaan -->
                        <div class="form-group">
                            <label for="edit-deskripsi-kecelakaan" class="fw-bold">Deskripsi Kecelakaan</label>
                            <textarea name="deskripsi_kecelakaan" id="edit-deskripsi-kecelakaan"
                                class="form-control"></textarea>
                        </div>

                        <!-- Tanggal Kecelakaan -->
                        <div class="form-group">
                            <label for="edit-tanggal-kecelakaan" class="fw-bold">Tanggal Kecelakaan <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="tanggal_kecelakaan" id="edit-tanggal-kecelakaan" class="form-control"
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
            const periodeBulan = "{{ $rekapKecelakaan->periode_bulan_kecelakaan }}";
            const periodeTahun = "{{ $rekapKecelakaan->periode_tahun_kecelakaan }}";

            // Mapping nama bulan ke angka
            const bulanMapping = {
                "January": "01", "February": "02", "March": "03",
                "April": "04", "May": "05", "June": "06",
                "July": "07", "August": "08", "September": "09",
                "October": "10", "November": "11", "December": "12"
            };

            const bulan = bulanMapping[periodeBulan];
            const tahun = periodeTahun;

            // Set batas minimum dan maksimum tanggal berdasarkan bulan dan tahun
            const minDate = `${tahun}-${bulan}-01`;
            const maxDate = new Date(tahun, bulan, 0).toISOString().split('T')[0];

            // Atur atribut min dan max pada input tanggal
            const tanggalInput = document.getElementById("tanggal-kecelakaan");
            tanggalInput.setAttribute("min", minDate);
            tanggalInput.setAttribute("max", maxDate);

            // Disable bulan dan tahun di input tanggal
            tanggalInput.setAttribute("value", `${tahun}-${bulan}-01`);
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const editDataKecelakaanModal = document.getElementById("editDataKecelakaanModal");

            editDataKecelakaanModal.addEventListener("show.bs.modal", function (event) {
                const button = event.relatedTarget;
                const idKecelakaan = button.getAttribute("data-id");
                const namaKecelakaan = button.getAttribute("data-nama");
                const jumlahKorban = button.getAttribute("data-jumlah");
                const deskripsiKecelakaan = button.getAttribute("data-deskripsi");
                const tanggalKecelakaan = button.getAttribute("data-tanggal");
                const idDepartemen = button.getAttribute("data-departemen");
                const periodeBulan = button.getAttribute("data-periode-bulan"); // Ambil periode bulan
                const periodeTahun = button.getAttribute("data-periode-tahun"); // Ambil periode tahun

                // Isi form modal dengan data dari tabel
                document.getElementById("edit-id-data-kecelakaan").value = idKecelakaan;
                document.getElementById("edit-nama-kecelakaan").value = namaKecelakaan;
                document.getElementById("edit-jumlah-korban").value = jumlahKorban || '';
                document.getElementById("edit-deskripsi-kecelakaan").value = deskripsiKecelakaan || '';
                document.getElementById("edit-tanggal-kecelakaan").value = tanggalKecelakaan;

                // Set Departemen berdasarkan data yang ada
                document.getElementById("edit-id-departemen").value = idDepartemen;

                // Mapping nama bulan ke angka
                const bulanMapping = {
                    "January": "01", "February": "02", "March": "03",
                    "April": "04", "May": "05", "June": "06",
                    "July": "07", "August": "08", "September": "09",
                    "October": "10", "November": "11", "December": "12"
                };

                // Mendapatkan bulan dan tahun dari data atribut
                const bulan = bulanMapping[periodeBulan];
                const tahun = periodeTahun;

                // Set batas minimum dan maksimum tanggal berdasarkan bulan dan tahun
                const minDate = `${tahun}-${bulan}-01`;
                const maxDate = new Date(tahun, bulan, 0).toISOString().split('T')[0];

                // Set atribut min dan max pada input tanggal
                const tanggalInput = document.getElementById("edit-tanggal-kecelakaan");
                tanggalInput.setAttribute("min", minDate);
                tanggalInput.setAttribute("max", maxDate);

                // Mengatur tanggal yang ditampilkan pada input sesuai bulan dan tahun yang terpilih
                const currentDate = new Date(tanggalKecelakaan);
                const currentYear = currentDate.getFullYear();
                const currentMonth = ("0" + (currentDate.getMonth() + 1)).slice(-2);
                const currentDay = ("0" + currentDate.getDate()).slice(-2);

                // Membatasi inputan tanggal hanya dapat memilih tanggal pada bulan dan tahun yang sudah terpilih
                tanggalInput.value = `${currentYear}-${currentMonth}-${currentDay}`;

                // Set form action ke endpoint update yang sesuai
                document.getElementById("formEditDataKecelakaan").action = `/update-data-kecelakaan/${idKecelakaan}`;
            });
        });

    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const confirmDeleteModal = document.getElementById("confirmDeleteModal");
            const deleteForm = document.getElementById("deleteForm");

            confirmDeleteModal.addEventListener("show.bs.modal", function (event) {
                const button = event.relatedTarget; // Button yang membuka modal
                const idKecelakaan = button.getAttribute("data-id"); // Ambil ID Data Kaizen

                // Atur action form ke endpoint delete yang sesuai
                deleteForm.action = `/delete-data-kecelakaan/${idKecelakaan}`;
            });
        });
    </script>

@endsection