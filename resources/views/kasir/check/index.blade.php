@extends('admin.layout.dasbrod')
@section('title', 'Kasir Antrian')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row demo-vertical-spacing">
            <div class="col-md-12">
                <div class="card-title">
                    <div class="judul">
                        <h4><strong>Pasien telah Bayar</strong></h4>
                        <div class="date-time d-flex align-items-center gap-2 text-center">
                            <div class="tanggal text-muted" id="tanggal"></div>
                            <div class="jam text-muted" id="jam"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="" class="d-flex justify-content-between align-items-center mb-3">
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
                                    placeholder="Cari Nama / No. Rm">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-striped" style="white-space: nowrap;">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Antrian</th>
                                        <th>Dokter Pemeriksa</th>
                                        <th>No. RM</th>
                                        <th>Nama Pasien</th>
                                        <th>Alamat Domisili</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @if (count($antrianKasir) === 0)
                                        <tr>
                                            <td colspan="9" style="text-align: center; font-size: bold">Tidak ada data
                                            </td>
                                        </tr>
                                    @else
                                        @php $allSoapPatients = []; @endphp
                                        @foreach ($antrianKasir as $item)
                                            @php
                                                $soapData = isset($item['obat']['resep'])
                                                    ? json_decode($item['obat']['resep'], true)
                                                    : [];

                                                if (is_array($soapData)) {
                                                    $allSoapPatients = array_merge(
                                                        $allSoapPatients,
                                                        array_keys($soapData),
                                                    );
                                                }
                                            @endphp
                                        @endforeach
                                        @php $allSoapPatients = array_unique($allSoapPatients); @endphp
                                        @foreach ($antrianKasir as $item)
                                            @if ($item->status == 'U')
                                                <tr id="row_{{ $item->id }}">
                                                    <td>{{ $loop->iteration + ($antrianKasir->currentPage() - 1) * $antrianKasir->perPage() }}
                                                    </td>
                                                    <td>{{ $item->kode_antrian }}</td>
                                                    <td>{{ $item->obat->soap->nama_dokter }}</td>
                                                    <td>{{ $item->booking->pasien->no_rm }}</td>
                                                    <td>{{ $item->booking->pasien->nama_pasien }}</td>
                                                    <td>{{ $item->booking->pasien->alamat_asal }}</td>
                                                    <td>{{ $item->booking->pasien->jekel }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- Paginasi -->
                        <div class="d-flex justify-content-center mt-3 mb-3">
                            {{ $antrianKasir->links() }} <!-- Laravel's built-in pagination links -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('style')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endpush

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://code.responsivevoice.org/responsivevoice.js?key=jQZ2zcdq"></script>
    <script src="{{ asset('assets/responsivevoice.js') }}"></script>
    <script src="{{ asset('assets/js/antrian.script.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>

    <script>
        // tanggal dan jam
        function updateClock() {
            var now = new Date();
            var tanggalElement =
                document.getElementById('tanggal');
            var options = {
                weekday: 'short',
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            };
            tanggalElement.innerHTML = '<h6>' + now.toLocaleDateString('id-ID', options) + '</h6>';

            var jamElement = document.getElementById('jam');
            var jamString = now.getHours().toString().padStart(2, '0') + ':' +
                now.getMinutes().toString().padStart(2, '0') + ':' +
                now.getSeconds().toString().padStart(2, '0');
            jamElement.innerHTML = '<h6>' + jamString + '</h6>';
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
@endpush
