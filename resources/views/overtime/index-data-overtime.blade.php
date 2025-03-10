@extends('layout.app')

@section('content')
    <div class="page-header">
        <h3 class="fw-bold">Data Overtime</h3>
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
                <a href="{{ url('index-rekap-overtime') }}">Rekap Overtime</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Data Overtime</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="display: flex; align-items: center; justify-content: space-between;">
                    <h4 class="card-title" style="margin: 0;">Data Overtime ({{ $rekapOvertime->periode_bulan_overtime }} -
                        {{ $rekapOvertime->periode_tahun_overtime }})
                    </h4>
                    <div class="btn-group">
                        <a href="{{ route('rekapOvertime.index') }}">
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
                            data-bs-target="#addDataOvertimeModal">
                            <i class="fa fa-plus"></i> Tambah Data
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
                                    <th>Jumlah Act Overtime Minggu 1</th>
                                    <th>Jumlah Convert Overtime Minggu 1</th>
                                    <th>Jumlah Act Overtime Minggu 2</th>
                                    <th>Jumlah Convert Overtime Minggu 2</th>
                                    <th>Jumlah Act Overtime Minggu 3</th>
                                    <th>Jumlah Convert Overtime Minggu 3</th>
                                    <th>Jumlah Act Overtime Minggu 4</th>
                                    <th>Jumlah Convert Overtime Minggu 4</th>
                                    <th>Jumlah Act Overtime Minggu 5</th>
                                    <th>Jumlah Convert Overtime Minggu 5</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataOvertimes as $index => $data)
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
                                                        data-bs-target="#editDataOvertimeModal"
                                                        data-id="{{ $data->id_data_overtime }}"
                                                        data-jumlah-act-m1="{{ $data->jumlah_act_overtime_minggu_1 }}"
                                                        data-jumlah-convert-m1="{{ $data->jumlah_convert_overtime_minggu_1 }}"
                                                        data-jumlah-act-m2="{{ $data->jumlah_act_overtime_minggu_2 }}"
                                                        data-jumlah-convert-m2="{{ $data->jumlah_convert_overtime_minggu_2 }}"
                                                        data-jumlah-act-m3="{{ $data->jumlah_act_overtime_minggu_3 }}"
                                                        data-jumlah-convert-m3="{{ $data->jumlah_convert_overtime_minggu_3 }}"
                                                        data-jumlah-act-m4="{{ $data->jumlah_act_overtime_minggu_4 }}"
                                                        data-jumlah-convert-m4="{{ $data->jumlah_convert_overtime_minggu_4 }}"
                                                        data-jumlah-act-m5="{{ $data->jumlah_act_overtime_minggu_5 }}"
                                                        data-jumlah-convert-m5="{{ $data->jumlah_convert_overtime_minggu_5 }}">
                                                        <i class="fas fa-edit"></i> Edit Data
                                                    </a>

                                                    <!-- Tombol Hapus -->
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#confirmDeleteModal"
                                                        data-id="{{ $data->id_data_overtime }}">
                                                        <i class="fas fa-trash"></i> Hapus Data
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $data->jumlah_act_overtime_minggu_1 ?? '-' }}</td>
                                        <td>{{ $data->jumlah_convert_overtime_minggu_1 ?? '-' }}</td>
                                        <td>{{ $data->jumlah_act_overtime_minggu_2 ?? '-' }}</td>
                                        <td>{{ $data->jumlah_convert_overtime_minggu_2 ?? '-' }}</td>
                                        <td>{{ $data->jumlah_act_overtime_minggu_3 ?? '-' }}</td>
                                        <td>{{ $data->jumlah_convert_overtime_minggu_3 ?? '-' }}</td>
                                        <td>{{ $data->jumlah_act_overtime_minggu_4 ?? '-' }}</td>
                                        <td>{{ $data->jumlah_convert_overtime_minggu_4 ?? '-' }}</td>
                                        <td>{{ $data->jumlah_act_overtime_minggu_5 ?? '-' }}</td>
                                        <td>{{ $data->jumlah_convert_overtime_minggu_5 ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Data Overtime -->
    <div class="modal fade" id="addDataOvertimeModal" tabindex="-1" aria-labelledby="addDataOvertimeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- Tambahkan modal-lg agar lebih lebar -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="addDataOvertimeModalLabel">Tambah Data Overtime</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('dataOvertime.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_rekap_overtime" value="{{ $rekapOvertime->id_rekap_overtime }}">

                    <div class="modal-body">
                        <div class="row">
                            <!-- Kolom Kiri: Jumlah Act Overtime -->
                            <div class="col-md-6">
                                <h6 class="fw-bold text-center">Jumlah Act Overtime</h6>
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="form-group">
                                        <label class="fw-bold">Minggu ke-{{ $i }}</label>
                                        <input type="text" name="jumlah_act_overtime_minggu_{{ $i }}" class="form-control"
                                            placeholder="Jumlah act minggu {{ $i }}">
                                    </div>
                                @endfor
                            </div>

                            <!-- Kolom Kanan: Jumlah Convert Overtime -->
                            <div class="col-md-6">
                                <h6 class="fw-bold text-center">Jumlah Convert Overtime</h6>
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="form-group">
                                        <label class="fw-bold">Minggu ke-{{ $i }}</label>
                                        <input type="text" name="jumlah_convert_overtime_minggu_{{ $i }}" class="form-control"
                                            placeholder="Jumlah convert minggu {{ $i }}">
                                    </div>
                                @endfor
                            </div>
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

    <!-- Modal Edit Data Overtime -->
    <div class="modal fade" id="editDataOvertimeModal" tabindex="-1" aria-labelledby="editDataOvertimeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- Tambahkan modal-lg agar lebih lebar -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="editDataOvertimeModalLabel">Edit Data Overtime</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditDataOvertime" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_data_overtime" id="edit-id-data-overtime">

                    <div class="modal-body">
                        <div class="row">
                            <!-- Kolom Kiri: Jumlah Act Overtime -->
                            <div class="col-md-6">
                                <h6 class="fw-bold text-center">Jumlah Act Overtime</h6>
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="form-group">
                                        <label class="fw-bold">Minggu ke-{{ $i }}</label>
                                        <input type="text" name="jumlah_act_overtime_minggu_{{ $i }}"
                                            id="edit-jumlah-act-m{{ $i }}" class="form-control">
                                    </div>
                                @endfor
                            </div>

                            <!-- Kolom Kanan: Jumlah Convert Overtime -->
                            <div class="col-md-6">
                                <h6 class="fw-bold text-center">Jumlah Convert Overtime</h6>
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="form-group">
                                        <label class="fw-bold">Minggu ke-{{ $i }}</label>
                                        <input type="text" name="jumlah_convert_overtime_minggu_{{ $i }}"
                                            id="edit-jumlah-convert-m{{ $i }}" class="form-control">
                                    </div>
                                @endfor
                            </div>
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
            const editDataOvertimeModal = document.getElementById("editDataOvertimeModal");

            editDataOvertimeModal.addEventListener("show.bs.modal", function (event) {
                const button = event.relatedTarget; // Tombol yang membuka modal
                const idDataOvertime = button.getAttribute("data-id");

                // Ambil nilai dari atribut data-* dan isi input form
                document.getElementById("edit-id-data-overtime").value = idDataOvertime;

                for (let i = 1; i <= 5; i++) {
                    document.getElementById(`edit-jumlah-act-m${i}`).value = button.getAttribute(`data-jumlah-act-m${i}`) || '';
                    document.getElementById(`edit-jumlah-convert-m${i}`).value = button.getAttribute(`data-jumlah-convert-m${i}`) || '';
                }

                // Atur action form ke endpoint update yang sesuai
                document.getElementById("formEditDataOvertime").action = `/update-data-overtime/${idDataOvertime}`;
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const confirmDeleteModal = document.getElementById("confirmDeleteModal");
            const deleteForm = document.getElementById("deleteForm");

            confirmDeleteModal.addEventListener("show.bs.modal", function (event) {
                const button = event.relatedTarget; // Button yang membuka modal
                const idOvertime = button.getAttribute("data-id"); // Ambil ID Data Kaizen

                // Atur action form ke endpoint delete yang sesuai
                deleteForm.action = `/delete-data-overtime/${idOvertime}`;
            });
        });
    </script>

@endsection