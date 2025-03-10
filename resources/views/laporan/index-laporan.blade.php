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
      <a href="{{ url('/index-sto') }}">Data Stock</a>
    </li>
  </ul>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header" style="display: flex; align-items: center; justify-content: space-between;">
        <h4 class="card-title" style="margin: 0;">Data Stock</h4>
        <div class="btn-group">
          <button onclick="refreshPage()" class="btn btn-black btn-small">
            <span class="btn-label">
              <i class="fas fa-undo-alt"></i>
            </span>
            Refresh Data
          </button>
          &nbsp;&nbsp;
          <button type="button" class="btn btn-small btn-primary" data-bs-toggle="modal"
            data-bs-target="#addStockModal">
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
                <th>Foto</th>
                <th>Nama Stock</th>
              </tr>
            </thead>
            <tbody>
              <td>1</td>
              <td>
                <div class="input-group-append">
                  <button class="btn btn-primary btn-small dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Aksi
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="#"><i class="fas fa-info-circle"></i> Lihat Detail</a>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editStockModal"><i
                        class="fas fa-edit"></i> Edit Data</a>
                    <a class="dropdown-item" href="#" onclick="confirmDelete('stockID')"><i class="fas fa-trash"></i>
                      Hapus Data</a>
                  </div>
                </div>
              </td>
              <td></td>
              <td>EXXON</td>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addStockModal" tabindex="-1" aria-labelledby="addStockModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addStockModalLabel">Tambah Data Stock</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formAddStock">
          <div class="form-group form-group-default mb-3">
            <label>Input</label>
            <input id="Name" type="text" class="form-control" placeholder="Fill Name" />
          </div>
          <div class="form-group form-group-default mb-3">
            <label>Input</label>
            <input id="Name" type="text" class="form-control" placeholder="Fill Name" />
          </div>
          <button type="submit" class="btn btn-small btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editStockModal" tabindex="-1" aria-labelledby="editStockModalLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editStockModalLabel">Edit Data Stock</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formEditStock">
          <div class="form-group form-group-default mb-3">
            <label>Input</label>
            <input id="Name" type="text" class="form-control" placeholder="Fill Name" />
          </div>
          <div class="form-group form-group-default mb-3">
            <label>Input</label>
            <input id="Name" type="text" class="form-control" placeholder="Fill Name" />
          </div>
          <button type="submit" class="btn btn-small btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection