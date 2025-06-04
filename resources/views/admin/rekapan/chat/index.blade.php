@extends('admin.layout.dasbrod')
@section('title', 'Admin | Kelola Pesan')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="datadokter">
                    <div class="card-title">
                        <h5 style="margin-bottom: 20px"><strong>Kelola Pesan</strong></h5>
                        {{-- <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal"
                            data-bs-target="#tambahdokter"><i class="bi bi-plus-lg"></i>Tambah Tenaga Medis</button> --}}
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form method="GET" action="#"
                                class="d-flex justify-content-between align-items-center mb-3">
                                <input type="hidden" name="page" value="1"> {{-- Reset ke halaman 1 saat pencarian --}}
                                <div class="d-flex align-items-center">
                                    <label for="entries" class="me-2">Tampilkan:</label>
                                    <select name="entries" id="entries" class="form-select form-select-sm me-3"
                                        style="width: 80px;" onchange="this.form.submit()">
                                        <option value="10" {{ $entries == 10 ? 'selected' : '' }}>10
                                        </option>
                                        <option value="25" {{ $entries == 25 ? 'selected' : '' }}>25
                                        </option>
                                        <option value="50" {{ $entries == 50 ? 'selected' : '' }}>50
                                        </option>
                                        <option value="100" {{ $entries == 100 ? 'selected' : '' }}>100
                                        </option>
                                    </select>
                                </div>

                                <div class="d-flex align-items-center">
                                    <input type="text" name="search" value="{{ $search }}"
                                        class="form-control form-control-sm me-2" style="width: 400px;"
                                        placeholder="Cari Username">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <div class="tb-umum">
                                    <table class="table table-striped table-bordered" style="white-space: nowrap">
                                        <thead class="table-primary text-center">
                                            <tr>
                                                <th>No</th>
                                                <th>Username</th>
                                                <th>Pesan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($pesan->isEmpty())
                                                <tr>
                                                    <td colspan="4" class="text-center">Tidak ada pesan</td>
                                                </tr>
                                            @else
                                                @foreach ($pesan as $item => $index)
                                                    <tr>
                                                        <td>{{ $pesan->firstItem() + $index }}</td>
                                                        <td>{{ $item->user->username }}</td>
                                                        <td>{{ $item->message }}</td>
                                                        <td>
                                                            <div class="aksi d-flex">
                                                                <button class="btn btn-primary"
                                                                    data-bs-target="#editdokter{{ $item->id }}"
                                                                    data-bs-toggle="modal"><i class="fas fa-info"></i>
                                                                    Edit</button>
                                                                <button type="button" class="btn btn-danger mx-2"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#hapusdokter{{ $item->id }}"><i
                                                                        class="fas fa-trash"></i> Hapus</button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="halaman d-flex justify-content-end">
                                {{ $pesan->appends(request()->only(['search', 'entries']))->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @include('admin.master.datadokter.modaltambah')
    @include('admin.master.datadokter.modaledit')
    @include('admin.master.datadokter.modalhapus') --}}
@endsection
