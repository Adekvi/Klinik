@extends('admin.layout.dasbrod')
@section('title', 'Admin | Setting Margin Obat')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5 style="margin-bottom: 20px"><strong>Setting Margin</strong></h5>
                        {{-- <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal"
                            data-bs-target="#poto"><i class="bi bi-plus-lg"></i>Tambah Margin</button> --}}
                    </div>
                    <div class="tb-umum">
                        <table id="example" class="table table-striped table-responsive"
                            style="width:100%; text-align: center">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Margin</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($potongan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $item->margin }} %
                                        </td>
                                        <td>{{ $item->keterangan ?? '-' }}</td>
                                        <td>
                                            <div class="aksi d-flex justify-content-center">
                                                <button class="btn btn-primary"
                                                    data-bs-target="#editpoli{{ $item->id }}" data-bs-toggle="modal"><i
                                                        class="fas fa-info"></i> Edit</button>
                                                {{-- <button type="button" class="btn btn-danger mx-2" data-bs-toggle="modal"
                                                    data-bs-target="#hapuspoli{{ $item->id }}"><i
                                                        class="fa fa-trash"></i> Hapus</button> --}}
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
    @include('admin.master.margin.tambah')
    @include('admin.master.margin.edit')
    @include('admin.master.margin.hapus')
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
