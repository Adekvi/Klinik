@extends('admin.layout.dasbrod')
@section('title', 'Admin | Foto')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5 style="margin-bottom: 20px"><strong>Foto</strong></h5>
                        <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal"
                            data-bs-target="#poto"><i class="bi bi-plus-lg"></i>Tambah Foto</button>
                    </div>
                    <div class="tb-umum">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>Judul</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($poto as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{ Storage::url($item->foto) }}" class="card-img-top"
                                                style="width: 120px; height: 100px; cursor: pointer;"
                                                onclick="openModal('{{ $item->id }}')" alt="image">
                                        </td>
                                        <td>{{ $item->judul }}</td>
                                        <td>{{ $item->tgl }}</td>
                                        <td>
                                            <div class="aksi d-flex">
                                                <button class="btn btn-primary"
                                                    data-bs-target="#editpoli{{ $item->id }}" data-bs-toggle="modal"><i
                                                        class="fas fa-info"></i> Edit</button>
                                                <button type="button" class="btn btn-danger mx-2" data-bs-toggle="modal"
                                                    data-bs-target="#hapuspoli{{ $item->id }}"><i
                                                        class="fa fa-trash"></i> Hapus</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.master.poto.modaltambah')
    @include('admin.master.poto.modaledit')
    @include('admin.master.poto.modalhapus')
@endsection
@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap4.css">
@endpush
@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap4.js"></script>

    <script>
        new DataTable('#example');
        // Ambil elemen input file
        var inputFoto = document.getElementById('exampleInputFoto');

        // Tambahkan event listener untuk 'change' event
        inputFoto.addEventListener('change', function(event) {
            // Ambil nama file yang dipilih
            var namaFile = event.target.files[0].name;

            // Tampilkan nama file di dalam elemen dengan id 'namaFoto'
            document.getElementById('foto').textContent = namaFile;
        });
    </script>
@endpush
