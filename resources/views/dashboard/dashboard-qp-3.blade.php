@extends('layout.app')

@section('content')
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Dashboard HRD Quality Procedure Point 3</h3>
        </div>
    </div>

    <!-- Tabs Section -->
    <ul class="nav nav-tabs" id="dashboardTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="rekap-sdm-tab" data-bs-toggle="tab" href="#rekap-sdm" role="tab">Rekap SDM</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="rekap-cuti-tab" data-bs-toggle="tab" href="#rekap-cuti" role="tab">Rekap Cuti &
                Absensi</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="rekap-kaizen-tab" data-bs-toggle="tab" href="#rekap-kaizen" role="tab">Rekap Kaizen</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="rekap-overtime-tab" data-bs-toggle="tab" href="#rekap-overtime" role="tab">Rekap
                Overtime</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="rekap-asesmen-tab" data-bs-toggle="tab" href="#rekap-asesmen" role="tab">Rekap
                Asesmen</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="rekap-kecelakaan-tab" data-bs-toggle="tab" href="#rekap-kecelakaan" role="tab">Rekap
                Kecelakaan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="rekap-pelatihan-tab" data-bs-toggle="tab" href="#rekap-pelatihan" role="tab">Rekap
                Pelatihan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="rekap-pemenuhan-tk-tab" data-bs-toggle="tab" href="#rekap-pemenuhan-tk" role="tab">Rekap
                Pemenuhan TK</a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content mt-3" id="dashboardTabsContent">
        <!-- Rekap SDM -->
        <div class="tab-pane fade show active" id="rekap-sdm" role="tabpanel">
            <h4 class="fw-bold mt-4 mb-4">Rekap Sumber Daya Manusia (SDM)</h4>
            <div class="row">
                @foreach ($rekapSDM as $key => $value)
                    <div class="col-sm-6 col-md-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-success bubble-shadow-small">
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">{{ ucwords(str_replace('_', ' ', $key)) }}</p>
                                            <h4 class="card-title">{{ $value }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Grafik Pendidikan -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="card card-round">
                        <div class="card-body">
                            <h6 class="fw-bold text-center">Distribusi Karyawan Berdasarkan Pendidikan</h6>
                            <div class="chart-container" style="min-height: 300px;">
                                <canvas id="chart_pendidikan"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafik Status Pekerjaan -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="card card-round">
                        <div class="card-body">
                            <h6 class="fw-bold text-center">Distribusi Karyawan Berdasarkan Status Pekerjaan</h6>
                            <div class="chart-container" style="min-height: 300px;">
                                <canvas id="chart_status_pekerjaan"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafik Domisili -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="card card-round">
                        <div class="card-body">
                            <h6 class="fw-bold text-center">Distribusi Karyawan Berdasarkan Domisili</h6>
                            <div class="chart-container" style="min-height: 300px;">
                                <canvas id="chart_domisili"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafik Departemen -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="card card-round">
                        <div class="card-body">
                            <h6 class="fw-bold text-center">Distribusi Karyawan Berdasarkan Departemen</h6>
                            <div class="chart-container" style="min-height: 300px;">
                                <canvas id="chart_departemen"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Tab Kosong Sementara -->
        <div class="tab-pane fade" id="rekap-cuti" role="tabpanel">
            <h4 class="fw-bold mt-4 mb-4">Rekap Cuti & Absensi</h4>
            <p class="text-muted">Belum ada data untuk Rekap Cuti & Absensi.</p>
        </div>

        <div class="tab-pane fade" id="rekap-kaizen" role="tabpanel">
            <h4 class="fw-bold mt-4 mb-4">Rekap Kaizen</h4>

            <!-- Cards -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="numbers">
                                <p class="card-category">Kaizen Bulan Ini</p>
                                <h4 class="card-title">{{ $kaizenBulanIni }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="numbers">
                                <p class="card-category">Kaizen Tahun Ini</p>
                                <h4 class="card-title">{{ $kaizenTahunIni }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="numbers">
                                <p class="card-category">Total Kaizen Keseluruhan</p>
                                <h4 class="card-title">{{ $kaizenKeseluruhan }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafik Kaizen Per Tahun -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="card card-round">
                        <div class="card-body">
                            <h6 class="fw-bold text-center">Kaizen Per Tahun</h6>
                            <div class="chart-container" style="min-height: 300px;">
                                <canvas id="chart_kaizen_tahun"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafik Kaizen Per Bulan Tahun Ini (Per Pengguna) -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="card card-round">
                        <div class="card-body">
                            <h6 class="fw-bold text-center">Kaizen Per Bulan Tahun Ini (Per Pengguna)</h6>
                            <div class="chart-container" style="min-height: 300px;">
                                <canvas id="chart_kaizen_per_pengguna"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="rekap-overtime" role="tabpanel">
                <h4 class="fw-bold mt-4 mb-4">Rekap Overtime</h4>
                <p class="text-muted">Belum ada data untuk Rekap Overtime.</p>
            </div>

            <div class="tab-pane fade" id="rekap-asesmen" role="tabpanel">
                <h4 class="fw-bold mt-4 mb-4">Rekap Asesmen</h4>
                <p class="text-muted">Belum ada data untuk Rekap Asesmen.</p>
            </div>

            <div class="tab-pane fade" id="rekap-kecelakaan" role="tabpanel">
                <h4 class="fw-bold mt-4 mb-4">Rekap Kecelakaan</h4>
                <p class="text-muted">Belum ada data untuk Rekap Kecelakaan.</p>
            </div>

            <div class="tab-pane fade" id="rekap-pelatihan" role="tabpanel">
                <h4 class="fw-bold mt-4 mb-4">Rekap Pelatihan</h4>
                <p class="text-muted">Belum ada data untuk Rekap Pelatihan.</p>
            </div>

            <div class="tab-pane fade" id="rekap-pemenuhan-tk" role="tabpanel">
                <h4 class="fw-bold mt-4 mb-4">Rekap Pemenuhan Tenaga Kerja (TK)</h4>
                <p class="text-muted">Belum ada data untuk Rekap Pemenuhan TK.</p>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const ctx = document.getElementById('chart_pendidikan').getContext('2d');

                @isset($rekapPendidikan)
                    const pendidikanLabels = @json(array_keys($rekapPendidikan));
                    const pendidikanValues = @json(array_values($rekapPendidikan));

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: pendidikanLabels,
                            datasets: [{
                                label: 'Jumlah Karyawan',
                                data: pendidikanValues,
                                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    callbacks: {
                                        label: function (context) {
                                            return context.label + ': ' + context.raw;
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: { beginAtZero: true },
                                y: { beginAtZero: true, precision: 0 }
                            }
                        }
                    });
                @endisset
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Status Pekerjaan (Bar Chart)
                const ctxStatusPekerjaan = document.getElementById('chart_status_pekerjaan').getContext('2d');
                const statusPekerjaanLabels = @json(array_keys($rekapStatusPekerjaan));
                const statusPekerjaanValues = @json(array_values($rekapStatusPekerjaan));

                new Chart(ctxStatusPekerjaan, {
                    type: 'bar',
                    data: {
                        labels: statusPekerjaanLabels,
                        datasets: [{
                            label: 'Jumlah Karyawan',
                            data: statusPekerjaanValues,
                            backgroundColor: '#4CAF50',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: { y: { beginAtZero: true } }
                    }
                });

                // Domisili (Bar Chart)
                const ctxDomisili = document.getElementById('chart_domisili').getContext('2d');
                const domisiliLabels = @json(array_keys($rekapDomisili));
                const domisiliValues = @json(array_values($rekapDomisili));

                new Chart(ctxDomisili, {
                    type: 'bar',
                    data: {
                        labels: domisiliLabels,
                        datasets: [{
                            label: 'Jumlah Karyawan',
                            data: domisiliValues,
                            backgroundColor: '#3F51B5',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: { y: { beginAtZero: true } }
                    }
                });

                // Departemen (Horizontal Bar Chart)
                const ctxDepartemen = document.getElementById('chart_departemen').getContext('2d');
                const departemenLabels = @json(array_keys($departemenData));
                const departemenValues = @json(array_values($departemenData));

                new Chart(ctxDepartemen, {
                    type: 'bar',
                    data: {
                        labels: departemenLabels,
                        datasets: [{
                            label: 'Jumlah Karyawan',
                            data: departemenValues,
                            backgroundColor: '#FF8C42',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        indexAxis: 'y', // Grafik horizontal
                        responsive: true,
                        maintainAspectRatio: false, // Supaya bisa lebih fleksibel
                        scales: {
                            x: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah Karyawan', // Judul di bawah
                                    font: { weight: 'bold' }
                                },
                                ticks: {
                                    stepSize: 10 // Sesuaikan supaya angka lebih jelas
                                }
                            },
                            y: {
                                ticks: {
                                    autoSkip: false, // Pastikan semua departemen tampil
                                    maxRotation: 0, // Biar teks tetap horizontal
                                    minRotation: 0,
                                    font: { weight: 'bold' }
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false // Hilangkan label legend di atas
                            }
                        }
                    }
                });
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Grafik Kaizen Per Tahun
                const ctxKaizenTahun = document.getElementById('chart_kaizen_tahun').getContext('2d');
                const kaizenTahunLabels = @json($rekapKaizenPerTahun->pluck('tahun'));
                const kaizenTahunValues = @json($rekapKaizenPerTahun->pluck('total'));

                new Chart(ctxKaizenTahun, {
                    type: 'bar',
                    data: {
                        labels: kaizenTahunLabels,
                        datasets: [{
                            label: 'Total Kaizen',
                            data: kaizenTahunValues,
                            backgroundColor: '#FF6384',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: { y: { beginAtZero: true } }
                    }
                });

                // Grafik Kaizen Per Bulan (Jumlah Pengguna & Total Kaizen)
                const ctxKaizenBulan = document.getElementById('chart_kaizen_bulan').getContext('2d');
                const kaizenBulanLabels = @json($rekapKaizenPerBulan->pluck('bulan'));
                const kaizenJumlahPengguna = @json($rekapKaizenPerBulan->pluck('jumlah_pengguna'));
                const kaizenTotal = @json($rekapKaizenPerBulan->pluck('total_kaizen'));

                new Chart(ctxKaizenBulan, {
                    type: 'bar',
                    data: {
                        labels: kaizenBulanLabels,
                        datasets: [
                            {
                                label: 'Jumlah Pengguna',
                                data: kaizenJumlahPengguna,
                                backgroundColor: '#36A2EB',
                                borderWidth: 1
                            },
                            {
                                label: 'Total Kaizen',
                                data: kaizenTotal,
                                backgroundColor: '#FFCE56',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: { y: { beginAtZero: true } }
                    }
                });
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const ctxKaizenPengguna = document.getElementById('chart_kaizen_per_pengguna').getContext('2d');

                // Data dari Controller
                const dataKaizenPerPengguna = @json($dataKaizenPerPengguna);

                // Konversi data untuk Chart.js
                const bulanLabels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                const datasets = [];

                // Mapping data ke dalam format yang bisa dipakai oleh Chart.js
                const penggunaKaizenData = {};

                for (const bulan in dataKaizenPerPengguna) {
                    for (const namaPengguna in dataKaizenPerPengguna[bulan]) {
                        if (!penggunaKaizenData[namaPengguna]) {
                            penggunaKaizenData[namaPengguna] = new Array(12).fill(0);
                        }
                        penggunaKaizenData[namaPengguna][bulan - 1] = dataKaizenPerPengguna[bulan][namaPengguna]; // Minus 1 karena index array mulai dari 0
                    }
                }

                // Buat dataset untuk setiap pengguna
                for (const pengguna in penggunaKaizenData) {
                    datasets.push({
                        label: pengguna,
                        data: penggunaKaizenData[pengguna],
                        backgroundColor: `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.6)`,
                        borderColor: `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 1)`,
                        borderWidth: 1
                    });
                }

                // Render Chart.js
                new Chart(ctxKaizenPengguna, {
                    type: 'bar',
                    data: {
                        labels: bulanLabels,
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });
            });
        </script>

@endsection