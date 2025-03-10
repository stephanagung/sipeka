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
            <a href="{{ url('/index-departemen') }}">Data Departemen</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="display: flex; align-items: center; justify-content: space-between;">
                <h4 class="card-title" style="margin: 0;">Data Departemen</h4>
                <div class="btn-group">
                    <button onclick="refreshPage()" class="btn btn-black btn-small">
                        <span class="btn-label">
                            <i class="fas fa-undo-alt"></i>
                        </span>
                        Refresh Data
                    </button>
                    &nbsp;&nbsp;
                    <button type="button" class="btn btn-small btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addDepartemenModal">
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
                                <th>Nama Departemen</th>
                                <th>Kode Departemen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departemen as $index => $dept)
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
                                                    data-bs-target="#editDepartemenModal"
                                                    data-id="{{ $dept->id_departemen }}"
                                                    data-nama="{{ $dept->nama_departemen }}"
                                                    data-kode="{{ $dept->kode_departemen }}"><i class="fas fa-edit"></i>
                                                    Edit Data</a>
                                                <a class="dropdown-item" href="#"
                                                    onclick="confirmDelete('{{ $dept->id_departemen }}')"><i
                                                        class="fas fa-trash"></i> Hapus Data</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $dept->nama_departemen }}</td>
                                    <td>{{ $dept->kode_departemen }}</td>
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
<div class="modal fade" id="addDepartemenModal" tabindex="-1" aria-labelledby="addDepartemenModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDepartemenModalLabel"><strong>Tambah Data Departemen</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAddDepartemen" action="{{ route('departemen.store') }}" method="POST">
                    @csrf
                    <div class="form-group form-group-default mb-3">
                        <label><strong>Nama Departemen <span class="text-danger">*</span></strong></label>
                        <input type="text" name="nama_departemen" class="form-control"
                            placeholder="Masukkan Nama Departemen" required />
                    </div>
                    <div class="form-group form-group-default mb-3">
                        <label><strong>Kode Departemen <span class="text-danger">*</span></strong></label>
                        <input type="text" name="kode_departemen" class="form-control"
                            placeholder="Masukkan Kode Departemen" required />
                    </div>
                    <button type="submit" class="btn btn-small btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editDepartemenModal" tabindex="-1" aria-labelledby="editDepartemenModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDepartemenModalLabel"><strong>Edit Data Departemen</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditDepartemen" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_departemen" id="edit-id-departemen" />
                    <div class="form-group form-group-default mb-3">
                        <label><strong>Nama Departemen <span class="text-danger">*</span></strong></label>
                        <input type="text" name="nama_departemen" id="edit-nama-departemen" class="form-control"
                            placeholder="Masukkan Nama Departemen" required />
                    </div>
                    <div class="form-group form-group-default mb-3">
                        <label><strong>Kode Departemen <span class="text-danger">*</span></strong></label>
                        <input type="text" name="kode_departemen" id="edit-kode-departemen" class="form-control"
                            placeholder="Masukkan Kode Departemen" required />
                    </div>
                    <button type="submit" class="btn btn-small btn-primary">Simpan</button>
                </form>
            </div>
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
    document.addEventListener('DOMContentLoaded', function () {
        // Fungsi untuk menampilkan modal konfirmasi hapus
        function showConfirmDeleteModal(id) {
            var modal = $('#confirmDeleteModal');
            modal.find('#deleteForm').attr('action', '{{ route('departemen.destroy', ':id_departemen') }}'
                .replace(':id_departemen', id));
            modal.modal('show');
        }

        // Event listener untuk modal edit
        $('#editDepartemenModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var nama = button.data('nama');
            var kode = button.data('kode');

            var modal = $(this);
            modal.find('#edit-id-departemen').val(id);
            modal.find('#edit-nama-departemen').val(nama);
            modal.find('#edit-kode-departemen').val(kode);

            var form = modal.find('#formEditDepartemen');
            form.attr('action', '{{ route('departemen.update', ':id_departemen') }}'.replace(
                ':id_departemen', id));
        });

        // Event listener untuk tombol hapus
        window.confirmDelete = function (id) {
            showConfirmDeleteModal(id);
        };
    });
</script>
@endsection