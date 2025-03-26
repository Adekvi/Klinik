@extends('admin.layout.dasbrod')
@section('title', 'Admin | Data Poli')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5 style="margin-bottom: 20px"><strong>Data Poli</strong></h5>
                        <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal"
                            data-bs-target="#tambahpoli"><i class="bi bi-plus-lg"></i>Tambah Poli</button>
                    </div>
                    <div class="tb-umum">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Poli</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($poli as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->namapoli }}</td>
                                        <td>
                                            <div class="aksi d-flex">
                                                <button class="btn btn-primary"
                                                    data-bs-target="#editpoli{{ $item->KdPoli }}" data-bs-toggle="modal"><i
                                                        class="fas fa-pen"></i> Edit</button>
                                                <button type="button" class="btn btn-danger mx-2" data-bs-toggle="modal"
                                                    data-bs-target="#hapuspoli{{ $item->KdPoli }}"><i
                                                        class="fas fa-trash"></i> Hapus</button>
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
    @include('admin.master.datapoli.modaltambah')
    @include('admin.master.datapoli.modaledit')
    @include('admin.master.datapoli.modalhapus')
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
    </script>
@endpush
