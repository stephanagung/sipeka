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
            <a href="{{ url('/index-kategori-absensi') }}">Data Kategori Absensi</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="display: flex; align-items: center; justify-content: space-between;">
                <h4 class="card-title" style="margin: 0;">Data Kategori Absensi</h4>
                <div class="btn-group">
                    <button onclick="refreshPage()" class="btn btn-black btn-small">
                        <span class="btn-label">
                            <i class="fas fa-undo-alt"></i>
                        </span>
                        Refresh Data
                    </button>
                    &nbsp;&nbsp;
                    <button type="button" class="btn btn-small btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addKategoriAbsensiModal">
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
                                <th>Nama Kategori Absensi</th>
                                <th>Kode Kategori Absensi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kategoriAbsensi as $index => $kat)
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
                                                    data-bs-target="#editKategoriAbsensiModal"
                                                    data-id="{{ $kat->id_kategori_absensi }}"
                                                    data-nama="{{ $kat->nama_kategori_absensi }}"
                                                    data-kode="{{ $kat->kode_kategori_absensi }}"><i
                                                        class="fas fa-edit"></i>
                                                    Edit Data</a>
                                                <a class="dropdown-item" href="#"
                                                    onclick="confirmDelete('{{ $kat->id_kategori_absensi }}')"><i
                                                        class="fas fa-trash"></i> Hapus Data</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $kat->nama_kategori_absensi }}</td>
                                    <td>{{ $kat->kode_kategori_absensi }}</td>
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
<div class="modal fade" id="addKategoriAbsensiModal" tabindex="-1" aria-labelledby="addKategoriAbsensiModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addKategoriAbsensiModalLabel"><strong>Tambah Data Kategori Absensi</strong>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAddKategoriAbsensi" action="{{ route('kategoriAbsensi.store') }}" method="POST">
                    @csrf
                    <div class="form-group form-group-default mb-3">
                        <label><strong>Nama Kategori Absensi <span class="text-danger">*</span></strong></label>
                        <input type="text" name="nama_kategori_absensi" class="form-control"
                            placeholder="Masukkan Nama Kategori Absensi" required />
                    </div>
                    <div class="form-group form-group-default mb-3">
                        <label><strong>Kode Kategori Absensi <span class="text-danger">*</span></strong></label>
                        <input type="text" name="kode_kategori_absensi" class="form-control"
                            placeholder="Masukkan Kode Kategori Absensi" required />
                    </div>
                    <button type="submit" class="btn btn-small btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editKategoriAbsensiModal" tabindex="-1" aria-labelledby="editKategoriAbsensiModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editKategoriAbsensiModalLabel"><strong>Edit Data Kategori Absensi</strong>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditKategoriAbsensi" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_kategori_absensi" id="edit-id-kategori-absensi" />
                    <div class="form-group form-group-default mb-3">
                        <label><strong>Nama Kategori Absensi <span class="text-danger">*</span></strong></label>
                        <input type="text" name="nama_kategori_absensi" id="edit-nama-kategori-absensi"
                            class="form-control" placeholder="Masukkan Nama Kategori Absensi" required />
                    </div>
                    <div class="form-group form-group-default mb-3">
                        <label><strong>Kode Kategori Absensi <span class="text-danger">*</span></strong></label>
                        <input type="text" name="kode_kategori_absensi" id="edit-kode-kategori-absensi"
                            class="form-control" placeholder="Masukkan Kode Kategori Absensi" required />
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
            modal.find('#deleteForm').attr('action', '{{ route('kategoriAbsensi.destroy', ':id_kategori_absensi') }}'
                .replace(':id_kategori_absensi', id));
            modal.modal('show');
        }

        // Event listener untuk modal edit
        $('#editKategoriAbsensiModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var nama = button.data('nama');
            var kode = button.data('kode');

            var modal = $(this);
            modal.find('#edit-id-kategori-absensi').val(id);
            modal.find('#edit-nama-kategori-absensi').val(nama);
            modal.find('#edit-kode-kategori-absensi').val(kode);

            var form = modal.find('#formEditKategoriAbsensi');
            form.attr('action', '{{ route('kategoriAbsensi.update', ':id_kategori_absensi') }}'.replace(
                ':id_kategori_absensi', id));
        });

        // Event listener untuk tombol hapus
        window.confirmDelete = function (id) {
            showConfirmDeleteModal(id);
        };
    });
</script>
@endsection