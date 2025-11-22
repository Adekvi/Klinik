<x-admin.layout.terminal title="Apoteker">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row demo-vertical-spacing">
            <div class="col-md-12">
                <div class="card-title">
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
                                                    <span id="pasienDilayani"
                                                        style="font-size: 25px">{{ $pasienDilayani }}</span>
                                                </span>
                                                <!-- Gambar di bawah -->
                                                <img src="{{ asset('aset/img/periksa.jpg') }}" alt="Pasien DIlayani"
                                                    style="width: 60%; height: auto;">
                                            </div>
                                            <div class="text-center d-flex flex-column align-items-center">
                                                <!-- Teks dan ikon di atas -->
                                                <span class="badge border text-warning fs-6 p-3">
                                                    <i class="fa-solid fa-times-circle"></i> Belum Dilayani:
                                                    <span id="pasienBelumDilayani"
                                                        style="font-size: 25px">{{ $pasienBelumDilayani }}</span>
                                                </span>
                                                <!-- Gambar di bawah -->
                                                <img src="{{ asset('aset/img/check.jpg') }}" alt="Pasien Belum Dilayani"
                                                    style="width: 60%; height: auto;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        {{-- Shift Pagi --}}
                                        <div id="shiftPagi" class="shift-container">
                                            <table class="table table-bordered table-responsive">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th class="text-center">SHIFT PAGI</th>
                                                        <th class="text-center">KET.</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Tanggal</td>
                                                        <td id="tanggalShiftPagi" class="text-center"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pasien Poli UMUM (Bpjs)</td>
                                                        <td id="poliUmumBpjsPagi" class="text-center">
                                                            {{ $countShiftPagiUmumBPJS }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pasien Poli UMUM (Umum)</td>
                                                        <td id="poliUmumUmumPagi" class="text-center">
                                                            {{ $countShiftPagiUmumUmum }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pasien Poli GIGI (Bpjs)</td>
                                                        <td id="poliGigiBpjsPagi" class="text-center">
                                                            {{ $countShiftPagiGigiBPJS }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pasien Poli GIGI (Umum)</td>
                                                        <td id="poliGigiUmumPagi" class="text-center">
                                                            {{ $countShiftPagiGigiUmum }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        {{-- Shift Siang --}}
                                        <div id="shiftSiang" class="shift-container">
                                            <table class="table table-bordered table-responsive">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th class="text-center">SHIFT SIANG</th>
                                                        <th class="text-center">KET.</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Tanggal</td>
                                                        <td id="tanggalShiftSiang" class="text-center"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pasien Poli UMUM (Bpjs)</td>
                                                        <td id="poliUmumBpjsSiang" class="text-center">
                                                            {{ $countShiftSiangUmumBPJS }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pasien Poli UMUM (Umum)</td>
                                                        <td id="poliUmumUmumSiang" class="text-center">
                                                            {{ $countShiftSiangUmumUmum }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pasien Poli GIGI (Bpjs)</td>
                                                        <td id="poliGigiBpjsSiang" class="text-center">
                                                            {{ $countShiftSiangGigiBpjs }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pasien Poli GIGI (Umum)</td>
                                                        <td id="poliGigiUmumSiang" class="text-center">
                                                            {{ $countShiftSiangGigiUmum }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="shift-container" id="shiftReportTotal">
                                            <table class="table table-bordered table-responsive w-100">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th class="text-center">TOTAL PASIEN</th>
                                                        <th class="text-center">KET.</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Pasien Poli UMUM (Bpjs)</td>
                                                        <td id="poliUmumBpjsTotal" style="text-align: center">
                                                            {{ $totalPoliUmumPasienBPJS }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pasien Poli UMUM (Umum)</td>
                                                        <td id="poliUmumUmumTotal" style="text-align: center">
                                                            {{ $totalPoliUmumPasienUmum }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pasien Poli GIGI (Bpjs)</td>
                                                        <td id="poliGigiBpjsTotal" style="text-align: center">
                                                            {{ $totalPoliGigiPasienBPJS }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pasien Poli GIGI (Umum)</td>
                                                        <td id="poliGigiUmumTotal" style="text-align: center">
                                                            {{ $totalPoliGigiPasienUmum }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action=""
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
                                    placeholder="Cari Nama / No. Rm">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-striped table-responsive" style="white-space: nowrap;">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Aksi</th>
                                        <th>Antrian</th>
                                        <th>Dokter Pemeriksa</th>
                                        <th>No. RM</th>
                                        <th>Nama Pasien</th>
                                        <th>Alamat Domisili</th>
                                        <th>Jenis Kelamin</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center" style="text-transform: uppercase">
                                    @if (count($antrianObat) === 0)
                                        <tr>
                                            <td colspan="9" style="text-align: center; font-size: bold">Tidak ada
                                                Pasien
                                            </td>
                                        </tr>
                                    @else
                                        @php $allSoapPatients = []; @endphp
                                        @foreach ($antrianObat as $item)
                                            @php
                                                // Cek apakah 'obat' dan 'resep' ada di $item dan valid
                                                $soapData = isset($item['obat']['resep'])
                                                    ? json_decode($item['obat']['resep'], true)
                                                    : null;

                                                // Pastikan $soapData adalah array sebelum menggunakan array_keys
                                                if (is_array($soapData)) {
                                                    $allSoapPatients = array_merge(
                                                        $allSoapPatients,
                                                        array_keys($soapData),
                                                    );
                                                }
                                            @endphp
                                        @endforeach
                                        @php $allSoapPatients = array_unique($allSoapPatients); @endphp
                                        @foreach ($antrianObat as $item)
                                            <tr id="row_{{ $item->id }}">
                                                <td>{{ $loop->iteration + ($antrianObat->currentPage() - 1) * $antrianObat->perPage() }}
                                                </td>
                                                <td>
                                                    <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-offset="0,4" data-bs-html="true"
                                                        data-bs-original-title="<i class='bx bx-bell bx-xs'></i> <span>Panggil Pasien</span>">
                                                        <button data-nomor-antrian-obat="{{ $item->kode_antrian }}"
                                                            class="btn btn-warning btn-panggil-obat">
                                                            <i class="fas fa-bell"></i>
                                                        </button>
                                                    </span>
                                                    <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-offset="0,4" data-bs-html="true"
                                                        data-bs-original-title="<i class='bx bx-bell bx-xs'></i> <span>Lewati Antrian</span>">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#lewati{{ $item->id }}">
                                                            <i class="fa-solid fa-forward"></i></button>
                                                        </button>
                                                    </span>
                                                    <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-offset="0,4" data-bs-html="true"
                                                        data-bs-original-title="<i class='bx bx-bell bx-xs'></i> <span>Tambah Obat</span>">
                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#tambahObat{{ $item->id }}">
                                                            <i class="fa-solid fa-pills"></i>
                                                        </button>
                                                    </span>
                                                </td>
                                                <td>{{ $item->kode_antrian }}</td>
                                                <td>{{ $item->obat->soap->nama_dokter }}</td>
                                                <td>{{ $item->booking->pasien->no_rm }}</td>
                                                <td>{{ $item->booking->pasien->nama_pasien }}</td>
                                                <td>{{ $item->booking->pasien->domisili }}</td>
                                                <td>{{ $item->booking->pasien->jekel }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3 mb-3">
                            {{ $antrianObat->links() }} <!-- Laravel's built-in pagination links -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($antrianObat as $item)
        @include('obat.ModalTambahResep.ModalResep')

        <script>
            // cetak kartu
            function printCard() {
                // Ambil ID dari data-id pada button atau dari variabel JavaScript lainnya
                const id = '{{ $item->id }}'; // Pastikan $item->id tersedia di view

                // URL untuk halaman cetak
                const url = `/cetak.kartu/${id}`;

                // Buka halaman cetak di tab baru
                const printWindow = window.open(url, '_blank');
                printWindow.addEventListener('load', function() {
                    printWindow.print();
                });
            }

            // Fungsi untuk menghitung total harga obat dari masing-masing obat
            function calculateTotal(element) {
                const row = element.closest('.obat-row');
                const jumlah = parseFloat(row.querySelector('.jumlah').value) || 0;
                const harga_satuan = parseFloat(row.querySelector('.harga_satuan').value) || 0;
                const total_harga = jumlah * harga_satuan;
                row.querySelector('.total_harga').value = total_harga;

                updateTotalKeseluruhan();
            }

            function updateTotalKeseluruhan() {
                const obatRows = document.querySelectorAll('.obat-row');
                let total_keseluruhan = 0;

                obatRows.forEach(row => {
                    const jumlah = parseFloat(row.querySelector('.jumlah').value) || 0;
                    const harga_satuan = parseFloat(row.querySelector('.harga_satuan').value) || 0;
                    const total_harga = parseFloat(row.querySelector('.total_harga').value) || 0;

                    if (jumlah > 0 && harga_satuan > 0) {
                        total_keseluruhan += total_harga;
                    }
                });

                document.querySelector('.total_harga_keseluruhan').value = total_keseluruhan;
            }
        </script>
    @endforeach

    {{-- TAMPILKAN LEWATI --}}
    @foreach ($antrianObat as $item)
        <div class="modal fade" id="lewati{{ $item->id }}" tabindex="-1" data-bs-backdrop="static"
            data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color: rgb(0, 0, 0)">Lewati
                            Pasien
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5>Apakah Anda yakin ingin melewati pasien ini?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                        <form action="{{ url('obat/lewati/' . $item->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <button type="submit" class="btn btn-primary">Lewati</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @push('style')
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <style>
            /* Alert */
            .swal2-container {
                z-index: 9999 !important;
            }
        </style>
    @endpush

    @push('script')
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://code.responsivevoice.org/responsivevoice.js?key=auvTMQpf"></script>
        <script src="{{ asset('assets/js/antrian.script.js') }}"></script>
        <script>
            // SHIFT
            document.addEventListener("DOMContentLoaded", function() {
                function checkShift() {
                    let now = new Date();
                    let hours = now.getHours();

                    let shiftPagi = document.getElementById("shiftPagi");
                    let shiftSiang = document.getElementById("shiftSiang");
                    let shiftTotal = document.getElementById("shiftReportTotal"); // Tambahkan elemen total shift

                    let tanggalHariIni = now.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });

                    // Atur tanggal di tabel shift pagi dan siang
                    document.getElementById("tanggalShiftPagi").innerText = tanggalHariIni;
                    document.getElementById("tanggalShiftSiang").innerText = tanggalHariIni;

                    // Reset tampilan semua shift
                    shiftPagi.style.display = "none";
                    shiftSiang.style.display = "none";
                    shiftTotal.style.display = "none";

                    // Tampilkan tabel sesuai shift
                    if (hours >= 7 && hours < 12) {
                        // Shift Pagi (07:00 - 12:00)
                        shiftPagi.style.display = "block";
                    } else if (hours >= 12 && hours < 17) {
                        // Shift Siang (12:00 - 17:00)
                        shiftSiang.style.display = "block";
                    } else {
                        // Setelah 17:00, tampilkan total pasien
                        shiftTotal.style.display = "block";
                    }
                }

                checkShift(); // Jalankan saat halaman dimuat
                setInterval(checkShift, 60000); // Perbarui setiap 1 menit
            });

            // TANGGAL SHIFT
            function updateTanggal() {
                var now = new Date();

                // Opsi format tanggal dan hari
                var options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'numeric',
                    day: 'numeric'
                };

                // Mengambil elemen HTML untuk shift pagi dan siang
                var tanggalPagiElement = document.getElementById('tanggalShiftPagi');
                var tanggalSiangElement = document.getElementById('tanggalShiftSiang');

                // Format tanggal lengkap dengan nama hari
                var tanggalLengkap = now.toLocaleDateString('id-ID', options);

                // Menampilkan tanggal pada elemen yang sesuai
                tanggalPagiElement.textContent = tanggalLengkap;
                tanggalSiangElement.textContent = tanggalLengkap;
            }

            // Panggil fungsi saat halaman dimuat
            updateTanggal();

            // jam dan tgl
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
                tanggalElement.innerHTML = '<p>' + now.toLocaleDateString('id-ID', options) + '</p>';

                var jamElement = document.getElementById('jam');
                var jamString = now.getHours().toString().padStart(2, '0') + ':' +
                    now.getMinutes().toString().padStart(2, '0');
                jamElement.innerHTML = '<p>' + jamString + '</p>';
            }
            setInterval(updateClock, 1000);
            updateClock();

            // Tampilkan modal jumlah pasien
            function togglePopup() {
                $('#jmlhpasien').modal('toggle');
                // Anda bisa menambahkan logika tambahan di sini jika diperlukan
            }

            var i = 0;
            $('#tambah').click(function() {
                ++i;
                $('#obat').append(
                    `<tr id="remove">
                <td>
                    <input type="text" name="obat[` + i + `]"  class="form-control">
                </td>
                <td>
                    <input type="number" name="jumlah[` + i + `]" class="form-control" required>
                </td>
                <td>
                    <div class="input-group">
                        <input type="number" class="form-control" name="harga[` + i + `]" required>
                    </div>
                </td>
            </tr>`
                );
            });

            $(document).on('click', '.remove-resep', function() {
                $(this).parents('#remove').remove();
            });
        </script>
    @endpush

</x-admin.layout.terminal>
