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
        <li class="separator">
            <i class="icon-arrow-right"></i>
        </li>
        <li class="nav-item">
            <a href="#">Data Detail Pengguna</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="display: flex; align-items: center; justify-content: space-between;">
                <h4 class="card-title" style="margin: 0;">Informasi Detail Pengguna</h4>
                <div class="btn-group">
                    <button onclick="refreshPage()" class="btn btn-black btn-small">
                        <span class="btn-label">
                            <i class="fas fa-undo-alt"></i>
                        </span>
                        Refresh Data
                    </button>
                    &nbsp;&nbsp;
                    <a href="{{ url('/index-pengguna') }}">
                        <button class="btn btn-black btn-small">
                            <span class="btn-label">
                                <i class="fas fa-long-arrow-alt-left"></i>
                            </span>
                            Kembali
                        </button>
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <!-- Bagian Kiri -->
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="nik" class="label-bold">NIK</label>
                            <input type="text" class="form-control input-disabled" id="nik"
                                value="<?php echo $pengguna['nik']; ?>" disabled />
                        </div>
                        <div class="form-group">
                            <label for="nama_lengkap" class="label-bold">Nama Lengkap</label>
                            <input type="text" class="form-control input-disabled" id="nama_lengkap"
                                value="<?php echo $pengguna['nama_lengkap']; ?>" disabled />
                        </div>
                        <div class="form-group">
                            <label for="departemen" class="label-bold">Departemen</label>
                            <input type="text" class="form-control input-disabled" id="departemen"
                                value="<?php echo $pengguna['departemen']['nama_departemen']; ?>" disabled />
                        </div>
                        <div class="form-group">
                            <label for="plant" class="label-bold">Plant</label>
                            <input type="text" class="form-control input-disabled" id="plant"
                                value="<?php echo $pengguna['plant']['nama_plant']; ?>" disabled />
                        </div>
                        <div class="form-group">
                            <label for="jabatan" class="label-bold">Jabatan</label>
                            <input type="text" class="form-control input-disabled" id="jabatan"
                                value="<?php echo $pengguna['jabatan']; ?>" disabled />
                        </div>
                        <div class="form-group">
                            <label for="status_pekerjaan" class="label-bold">Status Pekerjaan</label>
                            <input type="text" class="form-control input-disabled" id="status_pekerjaan"
                                value="<?php echo $pengguna['status_pekerjaan']; ?>" disabled />
                        </div>
                        <div class="form-group">
                            <label for="jenis_lemburan" class="label-bold">Jenis Lemburan</label>
                            <input type="text" class="form-control input-disabled" id="jenis_lemburan"
                                value="<?php echo $pengguna['jenis_lemburan']; ?>" disabled />
                        </div>
                    </div>

                    <!-- Bagian Kanan -->
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="jenis_kelamin" class="label-bold">Jenis Kelamin</label>
                            <input type="text" class="form-control input-disabled" id="jenis_kelamin"
                                value="<?php echo $pengguna['jenis_kelamin']; ?>" disabled />
                        </div>
                        <div class="form-group">
                            <label for="pendidikan_terakhir" class="label-bold">Pendidikan Terakhir</label>
                            <input type="text" class="form-control input-disabled" id="pendidikan_terakhir"
                                value="<?php echo $pengguna['pendidikan_terakhir']; ?>" disabled />
                        </div>
                        <div class="form-group">
                            <label for="domisili" class="label-bold">Domisili</label>
                            <input type="text" class="form-control input-disabled" id="domisili"
                                value="<?php echo $pengguna['domisili']; ?>" disabled />
                        </div>
                        <div class="form-group">
                            <label for="username" class="label-bold">Username</label>
                            <input type="text" class="form-control input-disabled" id="username"
                                value="<?php echo $pengguna['username']; ?>" disabled />
                        </div>
                        <div class="form-group">
                            <label for="password" class="label-bold">Password</label>
                            <input type="password" class="form-control input-disabled" id="password"
                                value="<?php echo $pengguna['password']; ?>" disabled />
                        </div>
                        <div class="form-group">
                            <label for="level" class="label-bold">Level</label>
                            <input type="text" class="form-control input-disabled" id="level"
                                value="<?php echo $pengguna['level']; ?>" disabled />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection