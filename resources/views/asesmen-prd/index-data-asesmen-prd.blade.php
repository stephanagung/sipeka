@extends('layout.app')

@section('content')
    <div class="page-header">
        <h3 class="fw-bold">Data Asesmen Produksi</h3>
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
                <a href="{{ url('/index-rekap-asesmen-prd') }}">Rekap Asesmen Produksi</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Data Asesmen Produksi</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="display: flex; align-items: center; justify-content: space-between;">
                    <h4 class="card-title" style="margin: 0;">Data Asesmen Produksi</h4>
                    <div class="btn-group">
                        <a href="{{ url('/index-rekap-asesmen-prd') }}">
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
                            data-bs-target="#addDataAsesmenPrdModal">
                            <i class="fa fa-plus"></i> Tambah Data
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="GET"
                        action="{{ route('dataAsesmenPrd.index', ['id_rekap_asesmen_prd' => $rekapAsesmen->id_rekap_asesmen_prd]) }}">
                        <div class="row">
                            <!-- Filter Grup Asesmen -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="grup_asesmen">Pilih Grup Asesmen</label>
                                    <select id="grup_asesmen" name="grup_asesmen" class="form-control"
                                        onchange="this.form.submit()">
                                        <option value="">-- All Grup Asesmen --</option>
                                        @foreach ($grupAsesmenEnum as $grup)
                                            <option value="{{ $grup }}" {{ request('grup_asesmen') == $grup ? 'selected' : '' }}>
                                                {{ $grup }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive mt-3">
                        <!-- Tabel Data Asesmen Produksi -->
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead class="table-success">
                                <tr>
                                    <th>No.</th>
                                    <th>Aksi</th>
                                    <th>Grup Asesmen</th>
                                    <th>Jumlah Plan Asesmen</th>
                                    <th>Jumlah Actual Asesmen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataAsesmen as $index => $asesmen)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary btn-small dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item edit-btn" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#editDataAsesmenPrdModal"
                                                        data-id="{{ $asesmen->id_data_asesmen_prd }}"
                                                        data-grup="{{ $asesmen->grup_asesmen }}"
                                                        data-jumlah-plan="{{ $asesmen->jumlah_plan_asesmen }}"
                                                        data-jumlah-act="{{ $asesmen->jumlah_act_asesmen }}">
                                                        <i class="fas fa-edit"></i> Edit Data
                                                    </a>
                                                    <a class="dropdown-item delete-btn" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#confirmDeleteModal"
                                                        data-id="{{ $asesmen->id_data_asesmen_prd }}"><i
                                                            class="fas fa-trash"></i> Hapus Data</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $asesmen->grup_asesmen }}</td>
                                        <td>{{ $asesmen->jumlah_plan_asesmen ?? '-' }}</td>
                                        <td>{{ $asesmen->jumlah_act_asesmen ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Data Asesmen -->
    <div class="modal fade" id="addDataAsesmenPrdModal" tabindex="-1" aria-labelledby="addDataAsesmenPrdModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Data Asesmen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('dataAsesmenPrd.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id_rekap_asesmen_prd" value="{{ $rekapAsesmen->id_rekap_asesmen_prd }}">

                        <div class="form-group">
                            <label for="grup_asesmen" class="fw-bold">Grup Asesmen <span
                                    class="text-danger">*</span></label>
                            <select name="grup_asesmen" class="form-control" required>
                                <option value="" disabled selected>-- Pilih Grup Asesmen --</option>
                                @php
                                    $grupAsesmenYangSudahAda = $dataAsesmen->pluck('grup_asesmen')->toArray();
                                @endphp
                                @foreach ($grupAsesmenEnum as $grup)
                                    @if (!in_array($grup, $grupAsesmenYangSudahAda))
                                        <option value="{{ $grup }}">{{ $grup }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="jumlah_plan_asesmen" class="fw-bold">Jumlah Plan Asesmen</label>
                            <input type="number" name="jumlah_plan_asesmen" class="form-control"
                                placeholder="Masukkan Jumlah Plan">
                        </div>

                        <div class="form-group">
                            <label for="jumlah_act_asesmen" class="fw-bold">Jumlah Actual Asesmen</label>
                            <input type="number" name="jumlah_act_asesmen" class="form-control"
                                placeholder="Masukkan Jumlah Actual">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Data Asesmen -->
    <div class="modal fade" id="editDataAsesmenPrdModal" tabindex="-1" aria-labelledby="editDataAsesmenPrdModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Data Asesmen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditDataAsesmenPrd" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="id_data_asesmen_prd" id="edit-id-asesmen-prd" />

                        <div class="form-group">
                            <label for="edit-grup-asesmen" class="fw-bold">Grup Asesmen</label>
                            <select name="grup_asesmen" id="edit-grup-asesmen" class="form-control" required>
                                <option value="" disabled selected>-- Pilih Grup Asesmen --</option>
                                @php
                                    $grupAsesmenYangSudahAda = $dataAsesmen->pluck('grup_asesmen')->toArray();
                                @endphp
                                @foreach ($grupAsesmenEnum as $grup)
                                    @if (!in_array($grup, $grupAsesmenYangSudahAda) || $grup == old('grup_asesmen'))
                                        <option value="{{ $grup }}">{{ $grup }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="edit-jumlah-plan-asesmen" class="fw-bold">Jumlah Plan Asesmen</label>
                            <input type="number" name="jumlah_plan_asesmen" id="edit-jumlah-plan-asesmen"
                                class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="edit-jumlah-act-asesmen" class="fw-bold">Jumlah Actual Asesmen</label>
                            <input type="number" name="jumlah_act_asesmen" id="edit-jumlah-act-asesmen"
                                class="form-control">
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
            // Ambil periode bulan dan tahun dari rekap asesmen
            const periodeBulan = "{{ $rekapAsesmen->periode_bulan_asesmen_prd }}";
            const periodeTahun = "{{ $rekapAsesmen->periode_tahun_asesmen_prd }}";

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
            const tanggalInput = document.getElementById("tanggal_asesmen_produksi");
            tanggalInput.setAttribute("min", minDate);
            tanggalInput.setAttribute("max", maxDate);
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const editDataAsesmenModal = document.getElementById("editDataAsesmenPrdModal");

            editDataAsesmenModal.addEventListener("show.bs.modal", function (event) {
                const button = event.relatedTarget;
                const idAsesmen = button.getAttribute("data-id");
                const grupAsesmen = button.getAttribute("data-grup");
                const jumlahPlanAsesmen = button.getAttribute("data-jumlah-plan");
                const jumlahActAsesmen = button.getAttribute("data-jumlah-act");

                // Isi form modal dengan data dari tabel
                document.getElementById("edit-id-asesmen-prd").value = idAsesmen;
                document.getElementById("edit-jumlah-plan-asesmen").value = jumlahPlanAsesmen || '';
                document.getElementById("edit-jumlah-act-asesmen").value = jumlahActAsesmen || '';

                // Set action form ke endpoint update yang sesuai
                document.getElementById("formEditDataAsesmenPrd").action = `/update-data-asesmen-prd/${idAsesmen}`;

                // Filter opsi select agar hanya grup yang belum dibuat yang muncul
                const selectGrup = document.getElementById("edit-grup-asesmen");
                const existingGrup = {!! json_encode($dataAsesmen->pluck('grup_asesmen')->toArray()) !!};

                // Hapus semua opsi dulu
                while (selectGrup.options.length > 0) {
                    selectGrup.remove(0);
                }

                // Tambahkan opsi yang belum digunakan atau opsi yang sedang diedit
                const grupAsesmenEnum = {!! json_encode($grupAsesmenEnum) !!};
                grupAsesmenEnum.forEach(grup => {
                    if (!existingGrup.includes(grup) || grup === grupAsesmen) {
                        const option = new Option(grup, grup);
                        if (grup === grupAsesmen) {
                            option.selected = true;
                        }
                        selectGrup.add(option);
                    }
                });
            });
        });

    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const confirmDeleteModal = document.getElementById("confirmDeleteModal");
            const deleteForm = document.getElementById("deleteForm");

            confirmDeleteModal.addEventListener("show.bs.modal", function (event) {
                const button = event.relatedTarget; // Button yang membuka modal
                const idAsesmenPrd = button.getAttribute("data-id"); // Ambil ID Data Kaizen

                // Atur action form ke endpoint delete yang sesuai
                deleteForm.action = `/delete-data-asesmen-prd/${idAsesmenPrd}`;
            });
        });
    </script>

@endsection