@extends('admin.layout.dasbrod')
@section('title', 'Admin | Video')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5 style="margin-bottom: 20px"><strong>Video</strong></h5>
                        <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal"
                            data-bs-target="#pidio"><i class="bi bi-plus-lg"></i>Tambah Video</button>
                    </div>
                    <div class="tb-umum">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Video</th>
                                    <th>Judul</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pidio as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div
                                                style="position: relative; width: 100%; height: 0; padding-bottom: 56.25%;">
                                                <video
                                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                                                    controls>
                                                    <source src="{{ Storage::url($item->vidio) }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
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
    @include('admin.master.pidio.modaltambah')
    @include('admin.master.pidio.modaledit')
    @include('admin.master.pidio.modalhapus')
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
        var inputFoto = document.getElementById('exampleInputVidio');

        // Tambahkan event listener untuk 'change' event
        inputFoto.addEventListener('change', function(event) {
            // Ambil nama file yang dipilih
            var namaFile = event.target.files[0].name;

            // Tampilkan nama file di dalam elemen dengan id 'namaFoto'
            document.getElementById('vidio').textContent = namaFile;
        });
    </script>
@endpush
