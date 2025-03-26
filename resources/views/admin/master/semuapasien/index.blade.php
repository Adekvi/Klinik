@extends('admin.layout.dasbrod')
@section('title', 'Admin | Data Semua Pasien')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5 style="margin-bottom: 20px"><strong>Uploud Data Pasien</strong></h5>
                        <form action="{{ route('pasien.import') }}" method="POST" enctype="multipart/form-data"
                            id="uploadForm">
                            @csrf
                            <div class="d-flex align-items-end">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="">Upload File Excel</label>
                                        <p style="font-size: 15px; font-style: italic; color: red">
                                            *Silahkan masukkan data pasien terbaru dengan format xlsx, xls, csv. <br>
                                            *Silahkan donwload file excelnya untuk menyesuaikan kolomnya!</p>
                                        <input type="file" name="file" id="file" class="form-control" required>
                                    </div>
                                </div>
                                <div class="ms-2">
                                    <button type="submit" class="btn btn-primary" id="uploadButton">
                                        <i class="fa-solid fa-upload"></i> Upload</button>
                                    <a href="{{ route('pasien.downloadTemplate') }}" class="btn btn-success ms-2">
                                        <i class="fa-solid fa-file-excel"></i> Download Format Excel
                                    </a>
                                </div>
                            </div>
                        </form>

                        <!-- Animasi Loading -->
                        <div id="loading" class="mt-3 text-primary d-none">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Mengunggah...</span>
                            </div>
                            <span class="ms-2">Mengunggah file, mohon tunggu...</span>
                        </div>

                    </div>

                    <h3 class="mt-3 d-flex justify-content-between align-items-center">
                        <strong>Data Pasien baru diunggah</strong>
                        <span class="text-muted" style="font-size: 17px">{{ $uploadStatus }}</span>
                    </h3>

                    @if ($recentPatients->count() > 0)
                        <form method="GET" action="{{ route('master.semuadata') }}"
                            class="d-flex justify-content-between align-items-center mb-3">
                            <input type="hidden" name="recent_page" value="1"> {{-- Reset ke halaman 1 saat pencarian --}}
                            <div class="d-flex align-items-center">
                                <label for="recent_entries" class="me-2">Tampilkan:</label>
                                <select name="recent_entries" id="recent_entries" class="form-select form-select-sm me-3"
                                    style="width: 80px;" onchange="this.form.submit()">
                                    <option value="10" {{ request('recent_entries', 10) == 10 ? 'selected' : '' }}>10
                                    </option>
                                    <option value="25" {{ request('recent_entries') == 25 ? 'selected' : '' }}>25
                                    </option>
                                    <option value="50" {{ request('recent_entries') == 50 ? 'selected' : '' }}>50
                                    </option>
                                    <option value="100" {{ request('recent_entries') == 100 ? 'selected' : '' }}>100
                                    </option>
                                </select>
                            </div>

                            <div class="d-flex align-items-center">
                                <input type="text" name="recent_search" value="{{ request('recent_search') }}"
                                    class="form-control form-control-sm me-2" style="width: 400px;"
                                    placeholder="Cari Nama/NIK/No. Rm (Data Baru)">
                                <button type="submit" class="btn btn-sm btn-primary">Cari</button>
                            </div>
                        </form>

                        <div class="table-responsive mb-2">
                            <table id="example" class="table table-striped table-bordered"
                                style="width:100%; margin-top: 10px;">
                                <thead class="table-primary" style="text-align: center; white-space: nowrap">
                                    <tr>
                                        <th>No</th>
                                        <th>No. RM</th>
                                        <th>Nama Pasien</th>
                                        <th>NIK</th>
                                        <th>Nama Kepala Keluarga</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Pekerjaan</th>
                                        <th>Alamat</th>
                                        <th>No. HP</th>
                                        <th>Jenis Pasien</th>
                                        <th>No. BPJS</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach ($recentPatients as $index => $record)
                                        <tr>
                                            <td>{{ $recentPatients->firstItem() + $index }}</td>
                                            <td>{{ $record->no_rm }}</td>
                                            <td>{{ !empty($record->nama_pasien) ? $record->nama_pasien : '-' }}</td>
                                            <td>{{ !empty($record->nik) ? $record->nik : '-' }}</td>
                                            <td>{{ !empty($record->nama_kk) ? $record->nama_kk : '-' }}</td>
                                            <td>{{ !empty($record->tgllahir) ? $record->tgllahir : '-' }}</td>
                                            <td>{{ !empty($record->jekel) ? $record->jekel : '-' }}</td>
                                            <td>{{ !empty($record->pekerjaan) ? $record->pekerjaan : '-' }}</td>
                                            <td>{{ !empty($record->alamat_asal) ? $record->alamat_asal : '-' }}</td>
                                            <td>{{ !empty($record->noHP) ? $record->noHP : '-' }}</td>
                                            <td>{{ !empty($record->jenis_pasien) ? $record->jenis_pasien : '-' }}</td>
                                            <td>{{ !empty($record->bpjs) ? $record->bpjs : '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="page d-flex justify-content-end">
                            {{ $recentPatients->appends(request()->only(['recent_search', 'recent_entries']))->links() }}
                        </div>
                    @else
                        {{-- Pesan jika tidak ada data dalam 24 jam terakhir --}}
                        <div class="alert alert-warning mt-3 text-center">
                            <h5 class="mt-3 mb-3">
                                <strong>
                                    <i class="fa-solid fa-bell"></i> Belum ada data pasien yang diunggah dalam 24 jam
                                    terakhir.
                                </strong>
                            </h5>
                        </div>
                    @endif

                    <h3 class="mt-3"><strong>Data Semua Pasien</strong></h3>
                    {{-- Halaman dan Pencarian --}}
                    <form method="GET" action="{{ route('master.semuadata') }}"
                        class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <label for="entries" class="me-2">Tampilkan:</label>
                            <select name="entries" id="entries" class="form-select form-select-sm me-3"
                                style="width: 80px;" onchange="this.form.submit()">
                                <option value="10" {{ $entries == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ $entries == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ $entries == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ $entries == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </div>

                        <div class="d-flex align-items-center">
                            <input type="text" name="search" value="{{ $search }}"
                                class="form-control form-control-sm me-2" style="width: 400px;" placeholder="Cari Nama/NIK">
                            <button type="submit" class="btn btn-sm btn-primary">Cari</button>
                        </div>
                    </form>
                    <div class="table-responsive mb-2">
                        <table id="example" class="table table-striped table-bordered"
                            style="width:100%; margin-top: 10px;">
                            <thead class="table-primary" style="text-align: center; white-space: nowrap">
                                <tr>
                                    <th>No</th>
                                    <th>No. RM</th>
                                    <th>Nama Pasien</th>
                                    <th>NIK</th>
                                    <th>Nama Kepala Keluarga</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Pekerjaan</th>
                                    <th>Alamat</th>
                                    <th>No. HP</th>
                                    <th>Jenis Pasien</th>
                                    <th>No. BPJS</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse ($pasien as $index => $item)
                                    <tr>
                                        <td>{{ $pasien->firstItem() + $index }}</td>
                                        <td>{{ $item->no_rm }}</td>
                                        <td>{{ !empty($item->nama_pasien) ? $item->nama_pasien : '-' }}</td>
                                        <td>{{ !empty($item->nik) ? $item->nik : '-' }}</td>
                                        <td>{{ !empty($item->nama_kk) ? $item->nama_kk : '-' }}</td>
                                        <td>{{ !empty($item->tgllahir) ? $item->tgllahir : '-' }}</td>
                                        <td>{{ !empty($item->jekel) ? $item->jekel : '-' }}</td>
                                        <td>{{ !empty($item->pekerjaan) ? $item->pekerjaan : '-' }}</td>
                                        <td>{{ !empty($item->alamat_asal) ? $item->alamat_asal : '-' }}</td>
                                        <td>{{ !empty($item->noHP) ? $item->noHP : '-' }}</td>
                                        <td>{{ !empty($item->jenis_pasien) ? $item->jenis_pasien : '-' }}</td>
                                        <td>{{ !empty($item->bpjs) ? $item->bpjs : '-' }}</td>
                                        <td>
                                            <div class="aksi d-flex">
                                                {{-- <button class="btn btn-primary"
                                                data-bs-target="#editumum{{ $item->id }}" data-bs-toggle="modal"><i
                                                    class="fas fa-info"></i> Edit</button> --}}
                                                <button type="button" class="btn btn-danger mx-2" data-bs-toggle="modal"
                                                    data-bs-target="#hapusbpjs{{ $item->id }}">
                                                    <i class="fas fa-trash"></i> Hapus</button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="13" class="text-center">Tidak ada data ditemukan</td>
                                    </tr>
                                @endforelse
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

    @include('admin.master.semuapasien.modalhapus')
@endsection

@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap4.css">
@endpush

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap4.js"></script>
    <script>
        document.getElementById('uploadForm').addEventListener('submit', function() {
            // Nonaktifkan tombol upload agar tidak diklik berulang
            document.getElementById('uploadButton').disabled = true;

            // Tampilkan animasi loading
            document.getElementById('loading').classList.remove('d-none');
        });

        // Simulasi notifikasi sukses setelah upload (Opsional)
        setTimeout(() => {
            document.getElementById('loading').classList.add('d-none');
            document.getElementById('notifSuccess').classList.remove('d-none');
        }, 5000); // Simulasi 5 detik setelah upload dimulai
    </script>
@endpush
