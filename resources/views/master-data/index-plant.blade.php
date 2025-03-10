@extends('layout.app')

@section('content')
<div class="page-header">
    <h3 class="fw-bold">Master Data</h3>
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
            <a href="{{ url('/index-plant') }}">Data Plant</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="display: flex; align-items: center; justify-content: space-between;">
                <h4 class="card-title" style="margin: 0;">Data Plant</h4>
                <div class="btn-group">
                    <button onclick="refreshPage()" class="btn btn-black btn-small">
                        <span class="btn-label">
                            <i class="fas fa-undo-alt"></i>
                        </span>
                        Refresh Data
                    </button>
                    &nbsp;&nbsp;
                    <button type="button" class="btn btn-small btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addPlantModal">
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
                                <th>Nama Plant</th>
                                <th>Kode Plant</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($plant as $index => $plan)
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
                                                    data-bs-target="#editPlantModal" data-id="{{ $plan->id_plant }}"
                                                    data-nama="{{ $plan->nama_plant }}"
                                                    data-kode="{{ $plan->kode_plant }}"><i class="fas fa-edit"></i>
                                                    Edit Data</a>
                                                <a class="dropdown-item" href="#"
                                                    onclick="confirmDelete('{{ $plan->id_plant }}')"><i
                                                        class="fas fa-trash"></i> Hapus Data</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $plan->nama_plant }}</td>
                                    <td>{{ $plan->kode_plant }}</td>
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
<div class="modal fade" id="addPlantModal" tabindex="-1" aria-labelledby="addPlantModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPlantModalLabel"><strong>Tambah Data Plant</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAddPlant" action="{{ route('plant.store') }}" method="POST">
                    @csrf
                    <div class="form-group form-group-default mb-3">
                        <label><strong>Nama Plant <span class="text-danger">*</span></strong></label>
                        <input type="text" name="nama_plant" class="form-control" placeholder="Masukkan Nama Plant"
                            required />
                    </div>
                    <div class="form-group form-group-default mb-3">
                        <label><strong>Kode Plant <span class="text-danger">*</span></strong></label>
                        <input type="text" name="kode_plant" class="form-control" placeholder="Masukkan Kode Plant"
                            required />
                    </div>
                    <button type="submit" class="btn btn-small btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editPlantModal" tabindex="-1" aria-labelledby="editPlantModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPlantModalLabel"><strong>Edit Data Plant</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditPlant" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_plant" id="edit-id-plant" />
                    <div class="form-group form-group-default mb-3">
                        <label><strong>Nama Plant <span class="text-danger">*</span></strong></label>
                        <input type="text" name="nama_plant" id="edit-nama-plant" class="form-control"
                            placeholder="Masukkan Nama Plant" required />
                    </div>
                    <div class="form-group form-group-default mb-3">
                        <label><strong>Kode Plant <span class="text-danger">*</span></strong></label>
                        <input type="text" name="kode_plant" id="edit-kode-plant" class="form-control"
                            placeholder="Masukkan Kode Plant" required />
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
            modal.find('#deleteForm').attr('action', '{{ route('plant.destroy', ':id_plant') }}'
                .replace(':id_plant', id));
            modal.modal('show');
        }

        // Event listener untuk modal edit
        $('#editPlantModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var nama = button.data('nama');
            var kode = button.data('kode');

            var modal = $(this);
            modal.find('#edit-id-plant').val(id);
            modal.find('#edit-nama-plant').val(nama);
            modal.find('#edit-kode-plant').val(kode);

            var form = modal.find('#formEditPlant');
            form.attr('action', '{{ route('plant.update', ':id_plant') }}'.replace(
                ':id_plant', id));
        });

        // Event listener untuk tombol hapus
        window.confirmDelete = function (id) {
            showConfirmDeleteModal(id);
        };
    });
</script>
@endsection