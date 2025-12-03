<x-admin.layout.terminal title="Admin | Data User">

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <div class="judul d-flex justify-content-between align-items-center">
                            <h4><strong>Data Akses User</strong></h4>
                            <div class="date-time d-flex align-items-center gap-2 text-center">
                                <div class="tanggal text-muted" id="tanggal"></div>
                                <div class="jam text-muted" id="jam"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal"
                                data-bs-target="#tambahuser"><i class="fas fa-plus"></i> Tambah User</button>
                            <hr>
                            <div class="tb-perawat mt-3">
                                <h5 class="text-center"><strong>Akses User Perawat</strong></h5>
                                <div class="table-responsive">
                                    <table id="example2" class="table table-striped table-bordered mt-2 mb-2"
                                        style="width:100%">
                                        <thead class="table-primary">
                                            <tr>
                                                <th colspan="5" style="text-align: center; font-weight: bold">Akses
                                                    Perawat
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Perawat</th>
                                                <th>Username</th>
                                                <th>Password</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $counter = 1 @endphp
                                            @foreach ($user as $item)
                                                @if ($item->role === 'perawat')
                                                    <tr>
                                                        <td>{{ $counter++ }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->username }}</td>
                                                        <td>{{ $item->password }}</td>
                                                        <td>
                                                            <div class="aksi d-flex">
                                                                <button class="btn btn-primary"
                                                                    data-bs-target="#editperawat{{ $item->id }}"
                                                                    data-bs-toggle="modal"><i class="fas fa-pen"></i>
                                                                    Edit</button>
                                                                <button type="button" class="btn btn-danger mx-2"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#hapususer{{ $item->id }}"><i
                                                                        class="fas fa-trash"></i> Hapus</button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card dokter mb-3">
                        <div class="card-body">
                            <div class="tb-dokter mt-3">
                                <h5 class="text-center"><strong>Akses User Dokter</strong></h5>
                                <div class="table-responsive">
                                    <table id="example3" class="table table-striped table-bordered mt-2 mb-2"
                                        style="width:100%">
                                        <thead class="table-info">
                                            <tr>
                                                <th colspan="6" style="text-align: center; font-weight: bold">Akses
                                                    Dokter
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Dokter</th>
                                                <th>Username</th>
                                                <th>Password</th>
                                                <th>Profesi</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $counter = 1 @endphp
                                            @foreach ($user as $item)
                                                @if ($item->role === 'dokter')
                                                    <tr>
                                                        <td>{{ $counter++ }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->username }}</td>
                                                        <td>{{ $item->password }}</td>
                                                        <td>{{ $item->dokter->profesi }}</td>
                                                        <td>
                                                            <div class="aksi d-flex">
                                                                <button class="btn btn-primary"
                                                                    data-bs-target="#editperawat{{ $item->id }}"
                                                                    data-bs-toggle="modal"><i class="fas fa-pen"></i>
                                                                    Edit</button>
                                                                <button type="button" class="btn btn-danger mx-2"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#hapususer{{ $item->id }}"><i
                                                                        class="fas fa-trash"></i> Hapus</button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card apotek mb-3">
                        <div class="card-body">
                            <div class="tb-dokter mt-3">
                                <h5 class="text-center"><strong>Akses User Apoteker</strong></h5>
                                <div class="table-responsive">
                                    <table id="example4" class="table table-striped table-bordered mt-2 mb-2"
                                        style="width:100%">
                                        <thead class="table-success">
                                            <tr>
                                                <th colspan="5" style="text-align: center; font-weight: bold">Akses
                                                    Apoteker
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Apoteker</th>
                                                <th>Username</th>
                                                <th>Password</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $counter = 1 @endphp
                                            @foreach ($user as $item)
                                                @if ($item->role === 'apoteker')
                                                    <tr>
                                                        <td>{{ $counter++ }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->username }}</td>
                                                        <td>{{ $item->password }}</td>
                                                        <td>
                                                            <div class="aksi d-flex">
                                                                <button class="btn btn-primary"
                                                                    data-bs-target="#editperawat{{ $item->id }}"
                                                                    data-bs-toggle="modal"><i class="fas fa-pen"></i>
                                                                    Edit</button>
                                                                <button type="button" class="btn btn-danger mx-2"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#hapususer{{ $item->id }}"><i
                                                                        class="fas fa-trash"></i> Hapus</button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card kasir mb-3">
                        <div class="card-body">
                            <div class="tb-dokter mt-3">
                                <h5 class="text-center"><strong>Akses User Kasir</strong></h5>
                                <div class="table-responsive">
                                    <table id="example4" class="table table-striped table-bordered mt-2 mb-2"
                                        style="width:100%">
                                        <thead class="table-warning">
                                            <tr>
                                                <th colspan="5" style="text-align: center; font-weight: bold">Akses
                                                    Kasir
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Kasir</th>
                                                <th>Username</th>
                                                <th>Password</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $counter = 1 @endphp
                                            @foreach ($user as $item)
                                                @if ($item->role === 'kasir')
                                                    <tr>
                                                        <td>{{ $counter++ }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->username }}</td>
                                                        <td>{{ $item->password }}</td>
                                                        <td>
                                                            <div class="aksi d-flex">
                                                                <button class="btn btn-primary"
                                                                    data-bs-target="#editperawat{{ $item->id }}"
                                                                    data-bs-toggle="modal"><i class="fas fa-pen"></i>
                                                                    Edit</button>
                                                                <button type="button" class="btn btn-danger mx-2"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#hapususer{{ $item->id }}"><i
                                                                        class="fas fa-trash"></i> Hapus</button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.master.user.modalTambah')
    @include('admin.master.user.edit.modaleditPasien')
    @include('admin.master.user.edit.modaleditPerawat')
    @include('admin.master.user.modalhapus')

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
            new DataTable('#example');
            new DataTable('#example2');
            new DataTable('#example3');
            new DataTable('#example4');

            function updateTanggal() {
                var now = new Date();
                var options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'numeric',
                    day: 'numeric'
                };

                var tanggalPagiElement = document.getElementById('tanggalShiftPagi');
                var tanggalSiangElement = document.getElementById('tanggalShiftSiang');

                if (tanggalPagiElement && tanggalSiangElement) {
                    var tanggalLengkap = now.toLocaleDateString('id-ID', options);
                    tanggalPagiElement.textContent = tanggalLengkap;
                    tanggalSiangElement.textContent = tanggalLengkap;
                } else {
                    console.error("Elemen tanggal shift tidak ditemukan: tanggalShiftPagi atau tanggalShiftSiang");
                }
            }

            // Panggil fungsi saat halaman dimuat
            document.addEventListener("DOMContentLoaded", updateTanggal);

            // JAM DAN TANGGAL
            function updateClock() {
                var now = new Date();
                var tanggalElement = document.getElementById('tanggal');
                var jamElement = document.getElementById('jam');

                if (!tanggalElement || !jamElement) {
                    console.error("Elemen tanggal atau jam tidak ditemukan: tanggal atau jam");
                    return;
                }

                var options = {
                    weekday: 'short',
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                };
                tanggalElement.innerHTML = '<h6>' + now.toLocaleDateString('id-ID', options) + '</h6>';

                var jamString = now.getHours().toString().padStart(2, '0') + ':' +
                    now.getMinutes().toString().padStart(2, '0') + ':' +
                    now.getSeconds().toString().padStart(2, '0');
                jamElement.innerHTML = '<h6>' + jamString + '</h6>';
            }

            document.addEventListener("DOMContentLoaded", function() {
                updateClock();
                setInterval(updateClock, 1000);
            });
        </script>
    @endpush

</x-admin.layout.terminal>
