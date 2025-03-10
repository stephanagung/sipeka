@extends('layout.app')

@section('content')
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h3 class="fw-bold mb-3">Dashboard HRD Quality Procedure Point 1</h3>
    </div>
</div>
<div class="row">
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round" data-bs-toggle="modal" data-bs-target="#karyawanModal"
            style="cursor: pointer;">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-primary bubble-shadow-small">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Karyawan</p>
                            <h4 class="card-title">{{ $pengguna->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Karyawan -->
    <div class="modal fade" id="karyawanModal" tabindex="-1" aria-labelledby="karyawanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="karyawanModalLabel">Detail Total Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h6>Total Karyawan <span class="badge bg-primary">{{ $pengguna->count() }}</span></h6>
                    </div>

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
                                                        data-bs-target="#editPenggunaModal"
                                                        data-id="{{ $user->id_pengguna }}"
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
                                                        data-password="{{ $user->password }}"
                                                        data-level="{{ $user->level }}">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round" data-bs-toggle="modal" data-bs-target="#absensiModal"
            style="cursor: pointer;">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-info bubble-shadow-small">
                            <i class="fas fa-user-check"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Lapor Absensi</p>
                            <h4 class="card-title">1,303</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Lapor Absensi -->
    <div class="modal fade" id="absensiModal" tabindex="-1" aria-labelledby="absensiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="absensiModalLabel">Detail Pelaporan Absensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h6>Total Pelaporan Absensi <span class="badge bg-info">1,303</span></h6>
                    </div>

                    <div class="mb-4">
                        <h6>Pelaporan Keseluruhan</h6>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Waktu Absensi</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>John Doe</td>
                                    <td>2025-01-19 08:00</td>
                                    <td>Hadir</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Jane Smith</td>
                                    <td>2025-01-19 08:05</td>
                                    <td>Hadir</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mb-4">
                        <h6>Pelaporan Hari Ini</h6>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Waktu Absensi</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Michael Brown</td>
                                    <td>2025-01-20 08:00</td>
                                    <td>Hadir</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Emily Davis</td>
                                    <td>2025-01-20 08:10</td>
                                    <td>Hadir</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round" data-bs-toggle="modal" data-bs-target="#keluarPabrikModal"
            style="cursor: pointer;">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-success bubble-shadow-small">
                            <i class="fas fa-door-open"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Keluar Pabrik</p>
                            <h4 class="card-title">1,345</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Keluar Pabrik-->
    <div class="modal fade" id="keluarPabrikModal" tabindex="-1" aria-labelledby="keluarPabrikModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="keluarPabrikModalLabel">Detail Keluar Pabrik</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h6>Total Keluar Pabrik <span class="badge bg-success">1,345</span></h6>
                    </div>

                    <div class="mb-4">
                        <h6>Total Keluar Pabrik Keseluruhan</h6>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Waktu Keluar</th>
                                    <th>Alasan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>John Doe</td>
                                    <td>2025-01-18 14:00</td>
                                    <td>Urusan Keluarga</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Jane Smith</td>
                                    <td>2025-01-18 15:30</td>
                                    <td>Keperluan Medis</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mb-4">
                        <h6>Total Keluar Pabrik Hari Ini</h6>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Waktu Keluar</th>
                                    <th>Alasan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Michael Brown</td>
                                    <td>2025-01-20 09:00</td>
                                    <td>Meeting Eksternal</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Emily Davis</td>
                                    <td>2025-01-20 10:15</td>
                                    <td>Keperluan Darurat</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round" data-bs-toggle="modal" data-bs-target="#trainingModal"
            style="cursor: pointer;">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-secondary bubble-shadow-small">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Pelatihan</p>
                            <h4 class="card-title">576</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Training-->
    <div class="modal fade" id="trainingModal" tabindex="-1" aria-labelledby="trainingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="trainingModalLabel">Detail Pelatihan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h6>Total Training <span class="badge bg-secondary">576</span></h6>
                    </div>

                    <div class="mb-4">
                        <h6>Total Training Keseluruhan</h6>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Training</th>
                                    <th>Peserta</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Leadership Development</td>
                                    <td>25</td>
                                    <td>2025-01-10</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Safety Training</td>
                                    <td>30</td>
                                    <td>2025-01-12</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mb-4">
                        <h6>Total Training Hari Ini</h6>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Training</th>
                                    <th>Peserta</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Project Management</td>
                                    <td>20</td>
                                    <td>09:00 - 12:00</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Advanced Excel</td>
                                    <td>15</td>
                                    <td>13:00 - 16:00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-round">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">Data Grafik</div>
                    <div class="card-tools d-flex align-items-center">
                        <!-- Dropdown for Chart Selection -->
                        <select id="chartSelector" class="form-select form-select-sm me-2" style="width: auto;">
                            <option value="karyawan">Karyawan</option>
                            <option value="lapor_absensi">Lapor Absensi</option>
                            <option value="keluar_pabrik">Keluar Pabrik</option>
                            <option value="training">Training</option>
                        </select>
                        <a href="#" class="btn btn-label-success btn-round btn-sm me-2">
                            <span class="btn-label">
                                <i class="fa fa-pencil"></i>
                            </span>
                            Export
                        </a>
                        <a href="#" class="btn btn-label-info btn-round btn-sm">
                            <span class="btn-label">
                                <i class="fa fa-print"></i>
                            </span>
                            Print
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container" style="min-height: 375px">
                    <canvas id="statisticsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script>
    const ctx = document.getElementById('statisticsChart').getContext('2d');

    const initialData = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: 'Karyawan',
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            data: [120, 150, 180, 200, 220, 230, 250, 260, 270, 300, 310, 320]
        }]
    };

    let chart = new Chart(ctx, {
        type: 'bar',
        data: initialData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return context.dataset.label + ': ' + context.raw;
                        }
                    }
                },
                datalabels: {
                    color: '#000', // Warna teks
                    anchor: 'end', // Posisi di atas
                    align: 'end', // Selaraskan di atas batang
                    offset: 10, // Jarak dari batang
                    formatter: (value) => value // Format nilai
                }
            },
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    const chartData = {
        karyawan: [120, 150, 180, 200, 220, 230, 250, 260, 270, 300, 310, 320],
        lapor_absensi: [100, 120, 130, 140, 150, 160, 170, 180, 190, 200, 210, 220],
        keluar_pabrik: [50, 60, 70, 80, 90, 100, 110, 120, 130, 140, 150, 160],
        training: [30, 40, 50, 60, 70, 80, 90, 100, 110, 120, 130, 140]
    };

    document.getElementById('chartSelector').addEventListener('change', function () {
        const selectedOption = this.value;
        chart.data.datasets[0].data = chartData[selectedOption];
        chart.data.datasets[0].label = selectedOption.charAt(0).toUpperCase() + selectedOption.slice(1);
        chart.update();
    });
</script>


@endsection