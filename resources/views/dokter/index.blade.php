@extends('admin.layout.dasbrod')
@section('title', 'Dokter')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card-title mt-3">
                    <div class="judul d-flex justify-content-between align-items-center">
                        <h4><strong>Antrian Pasien</strong></h4>
                        <div class="date-time d-flex align-items-center gap-2 text-center">
                            <div class="tanggal text-muted" id="tanggal"></div>
                            <div class="jam text-muted" id="jam"></div>
                        </div>
                    </div>
                    <div class="status" style="justify-content: start">
                        <div class="col-lg-12 col-md-6">
                            <button class="btn btn-info" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasEnd" aria-controls="offcanvasBoth">
                                <i class="fa-solid fa-house-medical-circle-check"></i> Status Pasien
                            </button>
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEnd"
                                aria-labelledby="offcanvasEndLabel" style="width: 600px">
                                <div class="offcanvas-header">
                                    <h5 id="offcanvasEndLabel" class="offcanvas-title">Status Pasien</h5>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body my-auto mx-0 flex-grow-0">
                                    <div class="text-center mb-3 mt-3">
                                        <h4 class="mb-3"><strong>Rekap Pasien</strong></h4>
                                        <div class="d-flex justify-content-between mb-3">
                                            <div class="text-center d-flex flex-column align-items-center">
                                                <!-- Teks dan ikon di atas -->
                                                <span class="badge border text-success fs-6 p-3">
                                                    <i class="fa-solid fa-check-circle"></i> Dilayani:
                                                    <span id="pasienDilayani">0</span>
                                                </span>
                                                <!-- Gambar di bawah -->
                                                <img src="{{ asset('aset/img/periksa.jpg') }}" alt="Pasien DIlayani"
                                                    style="width: 60%; height: auto;">
                                            </div>
                                            <div class="text-center d-flex flex-column align-items-center">
                                                <!-- Teks dan ikon di atas -->
                                                <span class="badge border text-warning fs-6 p-3">
                                                    <i class="fa-solid fa-times-circle"></i> Belum Dilayani:
                                                    <span id="pasienBelumDilayani">0</span>
                                                </span>
                                                <!-- Gambar di bawah -->
                                                <img src="{{ asset('aset/img/check.jpg') }}" alt="Pasien Belum Dilayani"
                                                    style="width: 60%; height: auto;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="shift-container" id="shiftReportTotal">
                                            <table class="table table-bordered table-responsive w-100">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th class="text-center">TOTAL PASIEN SUDAH DIPERIKSA (/hari ini)
                                                        </th>
                                                        <th class="text-center">KET.</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($groupedAntrian->isEmpty())
                                                        <tr>
                                                            <td colspan="2" class="text-center">Belum ada data</td>
                                                        </tr>
                                                    @else
                                                        @foreach ($groupedAntrian as $namapoli => $antrian)
                                                            @if ($namapoli === 'Umum')
                                                                <tr>
                                                                    <td>Pasien Poli UMUM (Bpjs)</td>
                                                                    <td id="poliUmumBpjsTotal" style="text-align: center">0
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Pasien Poli UMUM (Umum)</td>
                                                                    <td id="poliUmumUmumTotal" style="text-align: center">0
                                                                    </td>
                                                                </tr>
                                                            @elseif ($namapoli === 'Gigi')
                                                                <tr>
                                                                    <td>Pasien Poli GIGI (Bpjs)</td>
                                                                    <td id="poliGigiBpjsTotal" style="text-align: center">0
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Pasien Poli GIGI (Umum)</td>
                                                                    <td id="poliGigiUmumTotal" style="text-align: center">0
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <button type="button" class="btn btn-outline-secondary w-100"
                                                data-bs-dismiss="offcanvas">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                            <table class="table table-striped table-bordered" style="white-space: nowrap;">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>No.</th>
                                        <th>Aksi</th>
                                        <th>No. Antrian</th>
                                        <th>No. RM</th>
                                        <th>Nama Pasien</th>
                                        <th>Nama KK</th>
                                        <th>Alamat Domisili</th>
                                        <th>Pekerjaan</th>
                                        <th>Jenis Pasien</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @if (count($antrianDokter) === 0)
                                        <tr>
                                            <td colspan="9" style="text-align: center; font-size: bold">Tidak ada data
                                            </td>
                                        </tr>
                                    @else
                                        {{-- <?php $no = 1; ?> --}}
                                        @foreach ($antrianDokter as $item)
                                            <tr>
                                                <td>{{ $loop->iteration + ($antrianDokter->currentPage() - 1) * $antrianDokter->perPage() }}
                                                </td>
                                                <td>
                                                    <a href="{{ url('dokter/soap/' . $item->id) }}"
                                                        class="btn btn-primary" data-bs-toggle="tooltip"
                                                        data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                                                        data-bs-original-title="<i class='bx bx-bell bx-xs'></i> <span>Asesmen</span>">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-offset="0,4" data-bs-html="true"
                                                        data-bs-original-title="<i class='bx bx-bell bx-xs'></i> <span>Riwayat Pasien</span>">
                                                        <button type="button" class="btn btn-info"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#detailPasien{{ $item->id }}">
                                                            <i class="fas fa-info"></i>
                                                        </button>
                                                    </span>
                                                    <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-offset="0,4" data-bs-html="true"
                                                        data-bs-original-title="<i class='bx bx-bell bx-xs'></i> <span>Lewati Pasien</span>">
                                                        <button type="button" class="btn btn-secondary btn-lewati"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#lewati{{ $item->id }}">
                                                            <i class="fa-solid fa-forward"></i>
                                                        </button>
                                                    </span>
                                                </td>
                                                <td style="font-size: 24px">
                                                    <strong>{{ $item->kode_antrian }}</strong> <br>
                                                    <button data-nomor-antrian="{{ $item->kode_antrian }}"
                                                        class="btn btn-success btn-panggil" data-bs-toggle="tooltip"
                                                        data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                                                        data-bs-original-title="<i class='bx bx-bell bx-xs'></i> <span>Panggil Pasien</span>">
                                                        <i class="fas fa-bell"></i>
                                                    </button>
                                                </td>
                                                <td>{{ $item->booking->pasien->no_rm }}</td>
                                                <td>{{ $item->booking->pasien->nama_pasien }}</td>
                                                <td>{{ $item->booking->pasien->nama_kk }}</td>
                                                <td>{{ $item->booking->pasien->domisili }}</td>
                                                <td>{{ $item->booking->pasien->pekerjaan }}</td>
                                                <td>{{ $item->booking->pasien->jenis_pasien }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-3 mb-3">
                            {{ $antrianDokter->links() }} <!-- Laravel's built-in pagination links -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TAMPILKAN LEWATI --}}
    @foreach ($antrianDokter as $item)
        <div class="modal fade" id="lewati{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color: rgb(0, 0, 0)">Lewati
                            Pasien</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5>Apakah Anda yakin ingin melewati pasien ini?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <form action="{{ url('dokter/lewati/' . $item->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <button type="submit" class="btn btn-primary">Lewati</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- modal riwayat --}}
    @foreach ($antrianDokter as $item)
        <div class="modal fade" id="detailPasien{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-5" id="modalScrollableTitle" style="color: rgb(0, 0, 0)">Riwayat
                            Pasien
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body">
                            <div class="form-group" style="margin-bottom: 20px">
                                <label for="profesi" style="font-weight: 600">Perawat Penanggung Jawab Pasien</label>
                                <input type="text" value="{{ $item->rm->ttd->nama ?? '-' }}"
                                    class="form-control mt-2" disabled>
                                {{-- @foreach ($ttd as $row)
                                    <input type="text" value="{{ $row->nama }}" class="form-control mt-2"
                                        disabled>
                                @endforeach --}}
                            </div>
                            <div class="tanda-vital">
                                <h4 style="text-align: center">TANDA VITAL</h4>
                                <table class="table table-bordered">
                                    <tbody style="padding: 5px; width: 90%">
                                        <tr>
                                            <th style="padding-right: 260px">TENSI</th>
                                            <td style="text-align: end">
                                                <b>{{ $item->isian->p_tensi }}</b>
                                            </td>
                                            <td>
                                                /mmHg
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>RR</th>
                                            <td style="text-align: end">
                                                <b>{{ $item->isian->p_rr }}</b>
                                            </td>
                                            <td>
                                                /minute
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>SUHU</th>
                                            <td style="text-align: end">
                                                <b>{{ $item->isian->p_suhu }}</b>
                                            </td>
                                            <td>
                                                /mmHg
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>NADI</th>
                                            <td style="text-align: end">
                                                <b>{{ $item->isian->p_nadi }}</b>
                                            </td>
                                            <td>
                                                °C
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>TB</th>
                                            <td style="text-align: end">
                                                <b>{{ $item->isian->p_tb }}</b>
                                            </td>
                                            <td>
                                                cm
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>BB</th>
                                            <td style="text-align: end">
                                                <b>{{ $item->isian->p_bb }}</b>
                                            </td>
                                            <td>
                                                Kg
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <h4 style="text-align: center; margin-top: 10px">PEMERIKSAAN FISIK UMUM (O)</h4>
                                <table class="detail table table-bordered" style="width: 100%;">
                                    <tbody>
                                        <tr>
                                            <th scope="keluhan">KEADAAN UMUM</th>
                                            @if (!empty($item->rm->o_keadaan_umum))
                                                <td style="text-align: end">
                                                    <b>{{ $item->rm->o_keadaan_umum }}</b>
                                                </td>
                                            @else
                                                <td>
                                                    -
                                                </td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th scope="kesadaran">KESADARAN</th>
                                            <td style="text-align: end"><b>{{ $item->rm->o_kesadaran ?? '-' }}</b></td>
                                        </tr>
                                        <tr>
                                            <th scope="Kepala">KEPALA</th>
                                            <td style="text-align: end"><b>{{ $item->rm->o_kepala }}</b></td>
                                        </tr>
                                        @if ($item->rm->o_kepala_uraian)
                                            <tr>
                                                <td><b> Keterangan : {{ $item->rm->o_kepala_uraian }}</b></td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th scope="mata">MATA</th>
                                            <td style="text-align: end"><b>{{ $item->rm->o_mata }}</b></td>
                                        </tr>
                                        @if ($item->rm->o_mata_uraian)
                                            <tr>
                                                <td><b> Keterangan : {{ $item->rm->o_mata_uraian }}</b></td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th scope="tht">LEHER</th>
                                            <td style="text-align: end"><b>{{ $item->rm->o_leher }}</b></td>
                                        </tr>
                                        @if ($item->rm->o_leher_uraian)
                                            <tr>
                                                <td><b> Keterangan : {{ $item->rm->o_leher_uraian }}</b></td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th scope="leher">THT (TELINGA HIDUNG TERNGGOROKAN)</th>
                                            <td style="text-align: end"><b>{{ $item->rm->o_tht }}</b></td>
                                        </tr>
                                        @if ($item->rm->o_tht_uraian)
                                            <tr>
                                                <td><b> Keterangan : {{ $item->rm->o_tht_uraian }}</b></td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th scope="thorax">THORAX</th>
                                            <td style="text-align: end"><b>{{ $item->rm->o_thorax }}</b></td>
                                        </tr>
                                        @if ($item->rm->o_thorax_uraian)
                                            <tr>
                                                <td><b> Keterangan : {{ $item->rm->o_thorax_uraian }}</b></td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th scope="paru">PARU-PARU</th>
                                            <td style="text-align: end"><b>{{ $item->rm->o_paru }}</b></td>
                                        </tr>
                                        @if ($item->rm->o_paru_uraian)
                                            <tr>
                                                <td><b> Keterangan : {{ $item->rm->o_paru_uraian }}</b></td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th scope="jantung">JANTUNG</th>
                                            <td style="text-align: end"><b>{{ $item->rm->o_jantung }}</b></td>
                                        </tr>
                                        @if ($item->rm->o_jantung_uraian)
                                            <tr>
                                                <td><b> Keterangan : {{ $item->rm->o_jantung_uraian }}</b></td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th scope="abdomen">ABDOMEN</th>
                                            <td style="text-align: end"><b>{{ $item->rm->o_abdomen }}</b></td>
                                        </tr>
                                        @if ($item->rm->o_abdomen_uraian)
                                            <tr>
                                                <td><b> Keterangan : {{ $item->rm->o_abdomen_uraian }}</b></td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th scope="ekstremitas">EKSTREMITAS / ANGGOTA GERAK</th>
                                            <td style="text-align: end"><b>{{ $item->rm->o_ekstremitas }}</b></td>
                                        </tr>
                                        @if ($item->rm->o_ekstremitas_uraian)
                                            <tr>
                                                <td><b> Keterangan : {{ $item->rm->o_ekstremitas_uraian }}</b></td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th scope="kulit">KULIT</th>
                                            <td style="text-align: end"><b>{{ $item->rm->o_kulit }}</b></td>
                                        </tr>
                                        @if ($item->rm->o_kulit_uraian)
                                            <tr>
                                                <td><b> Keterangan : {{ $item->rm->o_kulit_uraian }}</b></td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <a href="{{ url('dokter/soap/' . $item->id) }}" class="btn btn-primary">
                            Asesmen
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection

@push('style')
    <style>
        /* Alert */
        .swal2-container {
            z-index: 9999 !important;
        }
    </style>
@endpush

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.responsivevoice.org/responsivevoice.js?key=jQZ2zcdq"></script>
    <script src="{{ asset('assets/js/antrian.script.js') }}"></script>
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

        $(document).ready(function() {
            // Fungsi untuk melakukan polling setiap beberapa detik
            function autoRefresh() {
                $.ajax({
                    url: '{{ route('dokter.index') }}', // Ganti dengan URL yang sesuai untuk mengambil data antrian baru
                    type: 'GET',
                    success: function(response) {
                        // Periksa apakah terdapat data antrian yang baru
                        if (response.data.length > 0) {
                            // Kosongkan tabel terlebih dahulu
                            $('tbody').empty();

                            // Loop data antrian baru dan tambahkan ke tabel
                            $.each(response.data, function(index, item) {
                                var row = '<tr>' +
                                    '<td>' + (index + 1) + '</td>' +
                                    '<td><strong>' + item.kode_antrian + '</strong><br>' +
                                    '<button data-nomor-antrian="' + item.kode_antrian +
                                    '" class="btn btn-success btn-panggil" data-toggle="tooltip" data-bs-placement="top" title="Panggil Pasien"><i class="fas fa-bell"></i></button></td>' +
                                    '<td>' + item.booking.pasien.no_rm + '</td>' +
                                    '<td>' + item.booking.pasien.nama_pasien + '</td>' +
                                    '<td>' + item.booking.pasien.nama_kk + '</td>' +
                                    '<td>' + item.booking.pasien.domisili + '</td>' +
                                    '<td>' + item.booking.pasien.pekerjaan + '</td>' +
                                    '<td>' + item.booking.pasien.jenis_pasien + '</td>' +
                                    '<td colspan="2"><div>' +
                                    '<a href="{{ url('dokter/soap/') }}/' + item.id +
                                    '" class="btn btn-primary" data-toggle="tooltip" data-bs-placement="top" title="Asesmen"><i class="bi bi-pen"></i></a>' +
                                    '<button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailPasien' +
                                    item.id +
                                    '" data-toggle="tooltip" data-bs-placement="top" title="Riwayat Pasien" style="font-size: 18px; color: white"><i class="bi bi-info"></i></button>' +
                                    '<button type="button" class="btn btn-secondary btn-lewati" data-toggle="tooltip" data-bs-placement="top" data-bs-toggle="modal" data-bs-target="#lewati' +
                                    item.id +
                                    '" title="Lewati Antrian"><i class="fa-solid fa-forward"></i></button></div></td>' +
                                    '</tr>';
                                $('tbody').append(row);
                            });
                        }
                    },
                    complete: function() {
                        // Set timeout untuk memanggil fungsi autoRefresh setelah 5 detik
                        setTimeout(autoRefresh, 5000); // 5000 milliseconds = 5 detik
                    }
                });
            }

            // Panggil fungsi autoRefresh pertama kali
            autoRefresh();
        });
    </script>
@endpush
