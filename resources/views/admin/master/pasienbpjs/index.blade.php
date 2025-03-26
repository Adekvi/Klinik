@extends('admin.layout.dasbrod')
@section('title', 'Admin | Data Pasien BPJS')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5 style="margin-bottom: 20px"><strong>Daftar Pasien BPJS</strong></h3>
                            <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal"
                                data-bs-target="#pasienbaru"><i class="bi bi-plus-lg"></i> Tambah Pasien</button>
                    </div>

                    <form method="GET" action="{{ route('master.pasienbpjs') }}"
                        class="d-flex justify-content-between align-items-center mb-3">
                        <input type="hidden" name="page" value="1"> {{-- Reset ke halaman 1 saat pencarian --}}
                        <div class="d-flex align-items-center">
                            <label for="entries" class="me-2">Tampilkan:</label>
                            <select name="entries" id="entries" class="form-select form-select-sm me-3"
                                style="width: 80px;" onchange="this.form.submit()">
                                <option value="10" {{ request('entries', 10) == 10 ? 'selected' : '' }}>10
                                </option>
                                <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25
                                </option>
                                <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50
                                </option>
                                <option value="100" {{ request('entries') == 100 ? 'selected' : '' }}>100
                                </option>
                            </select>
                        </div>

                        <div class="d-flex align-items-center">
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="form-control form-control-sm me-2" style="width: 400px;"
                                placeholder="Cari Nama/NIK/No. Rm">
                            <button type="submit" class="btn btn-sm btn-primary">Cari</button>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%;">
                            <thead class="table-primary" style="text-align: center;  white-space: nowrap">
                                <tr>
                                    <th>No</th>
                                    <th>No. RM</th>
                                    <th>Nama Pasien</th>
                                    <th>NIK</th>
                                    <th>Nama Kepala Keluarga</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Pekerjaan</th>
                                    <th>Alamat</th>
                                    <th>No. HP</th>
                                    <th>Jenis Pasien</th>
                                    <th>No. BPJS</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pasien as $index => $item)
                                    <tr>
                                        <td>{{ $pasien->firstItem() + $index }}</td>
                                        <td>{{ $item->no_rm }}</td>
                                        <td>{{ $item->nama_pasien }}</td>
                                        <td>{{ $item->nik }}</td>
                                        <td>{{ $item->nama_kk }}</td>
                                        <td>{{ $item->tgllahir }}</td>
                                        <td>{{ $item->pekerjaan }}</td>
                                        <td>{{ $item->alamat_asal }}</td>
                                        <td>{{ $item->noHP }}</td>
                                        <td>{{ $item->jenis_pasien }}</td>
                                        <td class="text-center">{{ !empty($item->bpjs) ? $item->bpjs : '-' }}</td>
                                        <td>
                                            <div class="aksi d-flex">
                                                <button class="btn btn-primary"
                                                    data-bs-target="#editbpjs{{ $item->id }}" data-bs-toggle="modal"><i
                                                        class="fas fa-info"></i>Edit</button>
                                                <button type="button" class="btn btn-danger mx-2" data-bs-toggle="modal"
                                                    data-bs-target="#hapusbpjs{{ $item->id }}">Hapus</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="halaman d-flex justify-content-end">
                        {{ $pasien->appends(request()->only(['search', 'entries']))->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
    @include('admin.master.pasienbpjs.modaltambah')
    @include('admin.master.pasienbpjs.modaledit')
    @include('admin.master.pasienbpjs.modalhapus')
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
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                "scrollY": "65vh", // Sesuaikan tinggi scroll sesuai kebutuhan Anda
                "scrollCollapse": true,
                "paging": true // Aktifkan paginasi
            });
        });
        // new DataTable('#example');
    </script>
@endpush
