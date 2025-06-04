@extends('admin.layout.dasbrod')
@section('title', 'Admin | Aktifitas User')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5 style="margin-bottom: 20px"><strong>Aktifitas User</strong></h5>
                        {{-- <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#tambahpoli"><i class="bi bi-plus-lg"></i>Tambah Poli</button> --}}
                    </div>
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Nama User</th>
                                    <th>Status</th>
                                    <th>Aktifitas</th>
                                    <th>Keterangan</th>
                                    {{-- <th>Aksi</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($akses as $user)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td>
                                            @if ($user->is_online)
                                                <span class="badge border border-success text-success">
                                                    <i class="fa-solid fa-plug-circle-check"></i>
                                                    <span class="text-dark">
                                                        <strong>Online</strong>
                                                    </span>
                                                </span>
                                            @else
                                                <span class="badge border border-danger text-danger">
                                                    <i class="fa-solid fa-power-off"></i>
                                                    <span class="text-dark">
                                                        <strong>Offline</strong>
                                                    </span>
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->last_seen)
                                                <span>
                                                    <i class="fa-solid fa-circle-info text-success"></i>
                                                    {{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}
                                                </span>
                                            @else
                                                User sedang Offline
                                            @endif
                                        </td>
                                        {{-- <td>-</td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap4.css">
@endpush
@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap4.js"></script>
@endpush
