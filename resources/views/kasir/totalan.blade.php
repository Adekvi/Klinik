@extends('admin.layout.dasbrod')
@section('title', 'Kasir Total')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row demo-vertical-spacing">
            <div class="col-md-12">
                <div class="card-title">
                    <div class="judul d-flex justify-content-between align-items-center">
                        <h4><strong>Kasir / Pembayaran</strong></h4>
                        {{-- <hr> --}}
                        <div class="date-time d-flex align-items-center gap-2 text-center">
                            <div class="tanggal text-muted" id="tanggal"></div>
                            <div class="jam text-muted" id="jam"></div>
                        </div>
                    </div>
                </div>
                <form action="{{ url('kasir/tambah/' . $antrianKasir->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="text-muted">
                                        <strong>Data Kasir</strong>
                                    </h5>
                                    <hr>
                                    <table class="table" style="width: 100%; border-collapse: separate">
                                        <tr>
                                            <th scope="row" style="padding: 4px; text-align: left;">Tanggal</th>
                                            <td style="padding: 4px; width: 10px;">:</td>
                                            <td style="padding: 4px;">
                                                <input type="date" name="tanggal" id="tanggal" class="form-control"
                                                    value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                    style="margin-left: 5px; text-align: end" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row" style="padding: 4px; text-align: left;">Nama Pasien</th>
                                            <td style="padding: 4px; width: 10px;">:</td>
                                            <td style="padding: 4px;"><input type="text" name="nama_kasir"
                                                    id="nama_kasir" class="form-control" value="{{ Auth::user()->name }}"
                                                    style="margin-left: 5px; text-align: end" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row" style="padding: 4px; text-align: left;">Jenis Pasien</th>
                                            <td style="padding: 4px; width: 10px;">:</td>
                                            <td style="padding: 4px;">
                                                @php
                                                    // Mengambil waktu sekarang sebagai objek Carbon
                                                    $currentTime = \Carbon\Carbon::now();

                                                    // Mendefinisikan batasan waktu shift pagi dan siang sebagai objek Carbon
                                                    $startPagi = \Carbon\Carbon::createFromTime(7, 0);
                                                    $endPagi = \Carbon\Carbon::createFromTime(12, 0);
                                                    $startSiang = \Carbon\Carbon::createFromTime(12, 0);
                                                    $endSiang = \Carbon\Carbon::createFromTime(17, 0);

                                                    // Default shift value
                                                    $shift = '-';

                                                    // Menentukan shift berdasarkan waktu sekarang
                                                    if ($currentTime->between($startPagi, $endPagi)) {
                                                        $shift = 'Pagi';
                                                    } elseif ($currentTime->between($startSiang, $endSiang)) {
                                                        $shift = 'Siang';
                                                    }
                                                @endphp
                                                <input type="text" name="shift" id="shift" class="form-control"
                                                    style="margin-left: 5px; text-align: end" value="{{ $shift }}"
                                                    readonly>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="gmbr text-center">
                                <img src="{{ asset('aset/img/kasir2.png') }}" alt="Pasien Baru"
                                    style="width: 70%; height: auto;">
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-muted">
                                <strong>Rincian Pembayaran</strong>
                            </h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-container border rounded shadow-sm mb-4">
                                        <div class="info-item mb-2">
                                            <label style="min-width: 120px;">No. Transaksi</label>
                                            <span>:</span>
                                            <input type="text" name="no_transaksi" id="no_transaksi"
                                                style="margin-left: 5px; text-align: end" class="form-control"
                                                value="{{ $noTransaksi }}" readonly>
                                        </div>
                                        <div class="info-item mb-2">
                                            <label style="min-width: 120px;">No. RM Pasien</label>
                                            <span>:</span>
                                            <input type="text" name="no_rm" id="no_rm"
                                                style="margin-left: 5px; text-align: end" class="form-control"
                                                value="{{ $antrianKasir->booking->pasien->no_rm }}" readonly>
                                        </div>
                                        <div class="info-item mb-2">
                                            <label style="min-width: 120px;">Nama Pasien</label>
                                            <span>:</span>
                                            <input type="text" name="nama_pasien" id="nama_pasien"
                                                style="margin-left: 5px; text-align: end" class="form-control"
                                                value="{{ $antrianKasir->booking->pasien->nama_pasien }}" readonly>
                                        </div>
                                        <div class="info-item mb-2">
                                            <label style="min-width: 120px;">Jenis Pasien</label>
                                            <span>:</span>
                                            <input type="text" name="jenis_pasien" id="jenis_pasien" class="form-control"
                                                value="{{ $antrianKasir->booking->pasien->jenis_pasien }}"
                                                style="margin-left: 5px; text-align: end" readonly>
                                        </div>
                                        <div class="info-item mb-2">
                                            <label style="min-width: 120px;">ID/NIK/BPJS</label>
                                            <span>:</span>
                                            <input type="text" name="nik_bpjs" id="nik_bpjs" class="form-control"
                                                style="margin-left: 5px; text-align: end"
                                                value="{{ !empty($antrianKasir->pasien->nik) ? $antrianKasir->pasien->nik : '-' }}"
                                                readonly>
                                        </div>
                                        <div class="info-item mb-2">
                                            <label style="min-width: 120px;">Poli</label>
                                            <span>:</span>
                                            <p class="form-control" style="margin-left: 5px; text-align: end" readonly>
                                                {{ $antrianKasir->poli->namapoli }}</p>
                                            {{-- <input type="text" name="" id="id_poli" class="form-control" value="{{ $antrianKasir->poli->namapoli }}" style="margin-left: 5px; text-align: end" readonly> --}}
                                        </div>
                                        <div class="info-item mb-2">
                                            <label style="min-width: 120px;">Dokter</label>
                                            <span>:</span>
                                            <p class="form-control" style="margin-left: 5px; text-align: end" readonly>
                                                {{ $antrianKasir->obat->soap->nama_dokter }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-container p-3 border rounded shadow-sm mb-4">
                                        <div class="info-item mb-3" data-pasien-id="{{ $antrianKasir->id }}">
                                            <div class="d-flex align-items-center">
                                                <h5 class="font-weight-bold" style="min-width: 110px; font-size: 28px">
                                                    TOTAL</h5>
                                                {{-- <span>:</span> --}}
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"
                                                            style="background: rgb(228, 228, 228); font-size: 20px">
                                                            <b>Rp.</b>
                                                        </span>
                                                    </div>
                                                    <input type="number" name="total"
                                                        id="total-{{ $antrianKasir->id }}" class="form-control"
                                                        style="text-align: end; font-size: 20px; font-weight: bold"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="info-item mb-2" data-pasien-id="{{ $antrianKasir->id }}">
                                            <label style="min-width: 110px;">Sub. Total Rincian</label>
                                            <span>:</span>
                                            @foreach ($obatPasien as $item)
                                                <?php
                                                // Fungsi untuk memformat harga ke dalam format Rupiah
                                                if (!function_exists('Rupiah')) {
                                                    function Rupiah($angka)
                                                    {
                                                        return '' . number_format($angka, 0, ',', '.');
                                                    }
                                                }
                                                
                                                // Mendekode nama obat dari soap_p
                                                $namaObat = json_decode($item->obat_Ro_namaObatUpdate, true) ?? [];
                                                $jumlahObat = json_decode($item->obat_Ro_jumlah, true) ?? []; // Ambil jumlah obat dari field yang sesuai
                                                
                                                // Data harga jual yang sudah diurutkan berdasarkan nama obat
                                                $hargaJualData = $reseps->keyBy('nama_obat'); // $reseps ini adalah koleksi harga dari model Resep atau Obat
                                                
                                                // Inisialisasi subtotal
                                                $subTotal = 0;
                                                
                                                // Memastikan nama obat ada dan tidak kosong
                                                if (!empty($namaObat)) {
                                                    foreach ($namaObat as $index => $obat) {
                                                        // Mengecek apakah nama obat ada dalam data harga
                                                        if (isset($hargaJualData[$obat])) {
                                                            // Mendapatkan harga pokok dari data obat
                                                            $hargaPokok = $hargaJualData[$obat]['harga_jual'] ?? 0;
                                                            $jumlah = $jumlahObat[$index] ?? 1; // Ambil jumlah, jika tidak ada nilai default 1
                                                
                                                            // Hitung total harga per obat (harga per tablet * jumlah tablet)
                                                            $hargaTotal = $hargaPokok * $jumlah;
                                                
                                                            // Akumulasi subtotal
                                                            $subTotal += $hargaTotal;
                                                        }
                                                    }
                                                } else {
                                                    echo '0';
                                                }
                                                ?>
                                            @endforeach

                                            <!-- Bagian input Sub Total -->
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" style="background: rgb(228, 228, 228)">
                                                        <b>Rp.</b>
                                                    </span>
                                                </div>
                                                <!-- Menampilkan subtotal yang sudah dihitung -->
                                                <input type="number" value="{{ Rupiah($subTotal) }}"
                                                    name="sub_total_rincian"
                                                    id="sub_total_rincian-{{ $antrianKasir->id }}" class="form-control"
                                                    style="text-align: end" readonly>
                                            </div>
                                        </div>

                                        <div class="info-item mb-2" data-pasien-id="{{ $antrianKasir->id }}">
                                            <label style="min-width: 110px;">Administrasi</label>
                                            <span>:</span>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" style="background: rgb(228, 228, 228)">
                                                        <b>Rp.</b>
                                                    </span>
                                                </div>
                                                <input type="number" value="0"
                                                    id="administrasi-{{ $antrianKasir->id }}" name="administrasi"
                                                    class="form-control" style="text-align: end">
                                            </div>
                                        </div>

                                        <div class="info-item mb-2" data-pasien-id="{{ $antrianKasir->id }}">
                                            <label style="min-width: 110px;">Konsul Dokter</label>
                                            <span>:</span>
                                            <?php
                                            // Fungsi untuk memformat harga ke dalam format Rupiah
                                            if (!function_exists('Rupiah')) {
                                                function Rupiah($angka)
                                                {
                                                    return '' . number_format($angka, 0, ',', '.');
                                                }
                                            }
                                            ?>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" style="background: rgb(228, 228, 228)">
                                                        <b>Rp.</b>
                                                    </span>
                                                </div>
                                                @if ($datadokter->isNotEmpty())
                                                    <input type="number" name="konsul_dokter"
                                                        id="konsul_dokter-{{ $antrianKasir->id }}" class="form-control"
                                                        style="text-align: end"
                                                        value="{{ Rupiah($datadokter->first()->tarif) }}" readonly>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="info-item mb-2" data-pasien-id="{{ $antrianKasir->id }}">
                                            <label style="min-width: 110px;">Embalase</label>
                                            <span>:</span>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" style="background: rgb(228, 228, 228)">
                                                        <b>Rp.</b>
                                                    </span>
                                                </div>
                                                <input type="number" value="0" name="embalase"
                                                    id="embalase-{{ $antrianKasir->id }}" class="form-control"
                                                    style="text-align: end">
                                            </div>
                                        </div>

                                        <div class="info-item mb-2" data-pasien-id="{{ $antrianKasir->id }}">
                                            <label style="min-width: 110px;">Total Obat</label>
                                            <span>:</span>
                                            <?php
                                            // Inisialisasi total jumlah obat
                                            $totalObat = 0;
                                            
                                            // Loop melalui setiap item dalam $kasir
                                            foreach ($obatPasien as $item) {
                                                // Decode jumlah obat dari soap_p_jumlah
                                                $jumlahObat = json_decode($item->obat_Ro_jumlah, true) ?? [];
                                            
                                                // Jika ada jumlah obat, tambahkan ke total
                                                if (!empty($jumlahObat)) {
                                                    foreach ($jumlahObat as $jumlah) {
                                                        $totalObat += $jumlah; // Akumulasi jumlah obat
                                                    }
                                                }
                                            }
                                            ?>

                                            <div class="input-group">
                                                {{-- <div class="input-group-prepend">
                                                            <span class="input-group-text" style="background: rgb(228, 228, 228)">
                                                                <b></b>
                                                            </span>
                                                        </div> --}}
                                                <!-- Menampilkan total jumlah obat yang telah dihitung -->
                                                <input type="text" value="{{ $totalObat }}" name="total_obat"
                                                    id="total_obat-{{ $antrianKasir->id }}" class="form-control"
                                                    style="text-align: end; margin-left: 5px" readonly>
                                            </div>
                                        </div>

                                        <div class="info-item mb-2" data-pasien-id="{{ $antrianKasir->id }}">
                                            <label style="min-width: 110px;">PPN%</label>
                                            <span>:</span>
                                            <div class="input-group">
                                                @foreach ($pajak as $item)
                                                    <input type="number" name="ppn"
                                                        id="ppn-{{ $antrianKasir->id }}" value="{{ $item->tarifPpn }}"
                                                        class="form-control" style="text-align: center; margin-left: 5px"
                                                        readonly>
                                                @endforeach
                                                {{-- {{ dd($pajak) }} --}}
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" style="background: rgb(228, 228, 228)">
                                                        <b><strong>%</strong></b>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <h5 class="text-muted">
                                        <strong>Keterangan Obat</strong>
                                    </h5>
                                    <hr>
                                    <div class="tabel col-md-12" data-pasien-id="{{ $antrianKasir->id }}">
                                        <table class="table table-responsive table-bordered" style="overflow-x: auto">
                                            <thead class="text center table-primary" style="white-space: nowrap">
                                                <th>No</th>
                                                <th>Keterangan</th>
                                                <th>Satuan</th>
                                                <th>Qty</th>
                                                <th>Harga Jual</th>
                                                <th>Total</th>
                                                <th>Tarif</th>
                                            </thead>
                                            <tbody class="text-center">
                                                @foreach ($obatPasien as $item)
                                                    <tr data-pasien-id="{{ $item->id }}">
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td class="text-start">
                                                            @php
                                                                $namaObat = json_decode($item->obat_Ro, true) ?? [];
                                                                foreach ($namaObat as $index => $obat) {
                                                                    echo $index + 1 . '. ' . $obat . '<br><hr>';
                                                                }
                                                            @endphp
                                                        </td>
                                                        <td>
                                                            @php
                                                                $jenisObat =
                                                                    json_decode($item->obat_Ro_jenisObat, true) ?? [];
                                                                foreach ($jenisObat as $JnsObt) {
                                                                    echo $JnsObt . '<hr>';
                                                                }
                                                            @endphp
                                                        </td>
                                                        <td>
                                                            @php
                                                                $jumlahObat =
                                                                    json_decode($item->obat_Ro_jumlah, true) ?? [];
                                                                foreach ($jumlahObat as $jumlah) {
                                                                    echo $jumlah . '<hr>';
                                                                }
                                                            @endphp
                                                        </td>
                                                        <td>
                                                            @php
                                                                $hargaJualData = $reseps->keyBy('nama_obat');
                                                                foreach ($namaObat as $obat) {
                                                                    echo isset($hargaJualData[$obat])
                                                                        ? 'Rp ' .
                                                                            number_format(
                                                                                $hargaJualData[$obat]['harga_jual'],
                                                                                0,
                                                                                ',',
                                                                                '.',
                                                                            ) .
                                                                            '<hr>'
                                                                        : '0<hr>';
                                                                }
                                                            @endphp
                                                        </td>
                                                        <td>
                                                            @php
                                                                foreach ($namaObat as $index => $obat) {
                                                                    $hargaPokok =
                                                                        $hargaJualData[$obat]['harga_jual'] ?? 0;
                                                                    $jumlah = $jumlahObat[$index] ?? 1;
                                                                    echo 'Rp ' .
                                                                        number_format(
                                                                            $hargaPokok * $jumlah,
                                                                            0,
                                                                            ',',
                                                                            '.',
                                                                        ) .
                                                                        '<hr>';
                                                                }
                                                            @endphp
                                                        </td>
                                                        <td>{{ $item->booking->pasien->jenis_pasien }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Tambahkan ROW baru untuk totalan -->
                                <div class="row justify-content-end mt-3">
                                    <h5 class="text-muted text-end">
                                        <strong>Pilihan Pembayaran</strong>
                                    </h5>
                                    <hr>

                                    <div class="col-md-6">
                                        <div class="gmbr text-center">
                                            <img src="{{ asset('aset/img/kasir1.png') }}" alt="Pasien Baru"
                                                style="width: 60%; height: auto;">
                                        </div>
                                    </div>

                                    <div class="totalan col-md-6">
                                        <div class="info-container">
                                            <div class="info-item">
                                                <button type="button" class="btn btn-outline-success">BPJS</button>
                                                <button type="button" class="btn btn-outline-primary"
                                                    style="white-space: nowrap; width: 100%;">Non Kapitasi</button>
                                                <button type="button" class="btn btn-outline-info">UMUM</button>
                                            </div>
                                            <div class="info-item" data-pasien-id="{{ $antrianKasir->id }}">
                                                <label for="" style="padding-left: 15px;">BAYAR</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"
                                                            style="background: rgb(228, 228, 228)"><b>Rp.</b></span>
                                                    </div>
                                                    <input type="number" name="bayar"
                                                        id="bayar-{{ $antrianKasir->id }}" style="text-align: end"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="info-item" data-pasien-id="{{ $antrianKasir->id }}">
                                                <label for="" style="padding-left: 15px;">KEMBALIAN</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"
                                                            style="background: rgb(228, 228, 228)"><b>Rp.</b></span>
                                                    </div>
                                                    <input type="number" name="kembalian"
                                                        id="kembalian-{{ $antrianKasir->id }}" style="text-align: end"
                                                        class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="info-item" style="justify-content: flex-end">
                                    <button type="submit" class="btn btn-primary" id="saveButton"
                                        style="padding-left: 15px;">SIMPAN TRANSAKSI</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('style')
    <style>
        .info-container {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            background-color: #f9f9f9;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
            padding: 5px;
            border-bottom: 1px solid #ddd;
            /* Tambah border bawah untuk gaya tabel */
        }

        .info-item:last-child {
            border-bottom: none;
            /* Hilangkan border bawah untuk item terakhir */
        }

        .info-item label {
            font-weight: bold;
            color: #333;
            min-width: 110px;
            /* Atur lebar minimum untuk label agar konsisten */
        }

        .info-item p {
            margin: 0;
            font-size: 14px;
            color: #555;
            flex: 1;
            text-align: right;
            /* Atur teks paragraf agar rata kanan */
        }

        .info-item h1,
        .info-item h5 {
            margin: 0;
            color: #28a745;
            font-weight: bold;
        }

        .info-item span {
            font-size: 16px;
            margin-left: 5px;
            /* Jarak kecil antara kata dan titik dua */
        }

        .info-item button {
            margin-right: 5px;
            /* Jarak antar tombol */
        }

        .total {
            font-size: 24px;
            color: #dc3545;
        }

        /* Alert */
        .swal2-container {
            z-index: 9999 !important;
        }
    </style>
@endpush

@push('script')
    <script>
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

        // TOTAL BAYAR
        // Fungsi format angka ke format Rupiah
        function formatRupiah(angka) {
            return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Fungsi untuk menghitung total
        function hitungTotal(id) {
            let subTotal = parseFloat(document.getElementById('sub_total_rincian-' + id).value.replace(/\./g, '')) || 0;
            let administrasi = parseFloat(document.getElementById('administrasi-' + id).value) || 0;
            let konsulDokter = parseFloat(document.getElementById('konsul_dokter-' + id).value.replace(/\./g, '')) || 0;
            let embalase = parseFloat(document.getElementById('embalase-' + id).value) || 0;
            let ppnPersen = parseFloat(document.getElementById('ppn-' + id).value) || 0;

            // Total sebelum PPN
            let totalSebelumPPN = subTotal + administrasi + konsulDokter + embalase;

            // Hitung PPN dan total
            let ppn = Math.floor(totalSebelumPPN * (ppnPersen / 100));
            let total = totalSebelumPPN + ppn;

            // Update input total
            document.getElementById('total-' + id).value = formatRupiah(total);
        }

        // Fungsi untuk menghitung kembalian
        function hitungKembalian(id) {
            let total = parseFloat(document.getElementById('total-' + id).value.replace(/\./g, '')) || 0;
            let bayar = parseFloat(document.getElementById('bayar-' + id).value) || 0;

            let kembalian = bayar - total;
            if (kembalian < 0) {
                kembalian = 0;
            }

            // Update input kembalian
            document.getElementById('kembalian-' + id).value = formatRupiah(kembalian);
        }

        // Tambahkan event listener untuk setiap pasien
        document.querySelectorAll('[data-pasien-id]').forEach(function(element) {
            const id = element.getAttribute('data-pasien-id');

            // Tambahkan event listener ke elemen terkait
            document.getElementById('administrasi-' + id).addEventListener('input', function() {
                hitungTotal(id);
            });
            document.getElementById('embalase-' + id).addEventListener('input', function() {
                hitungTotal(id);
            });
            document.getElementById('sub_total_rincian-' + id).addEventListener('input', function() {
                hitungTotal(id);
            });
            document.getElementById('ppn-' + id).addEventListener('input', function() {
                hitungTotal(id); // Hitung total saat PPN berubah
            });
            document.getElementById('bayar-' + id).addEventListener('input', function() {
                hitungKembalian(id);
            });

            // Panggil fungsi saat halaman dimuat untuk setiap pasien
            window.onload = function() {
                hitungTotal(id); // Hitung total awal
                hitungKembalian(id); // Hitung kembalian awal
            };
        });

        // function simpanTransaksi(id) {
        //     const formData = new FormData(document.querySelector('form')); // Ganti dengan selector form Anda jika diperlukan

        //     fetch(`/kasir/tambah/${id}`, { // Menggunakan template string untuk memasukkan ID
        //         method: 'POST',
        //         body: formData,
        //         headers: {
        //             'X-CSRF-TOKEN': '{{ csrf_token() }}', // Sertakan token CSRF jika menggunakan Laravel
        //         }
        //     })
        //     .then(response => {
        //         if (response.ok) {
        //             // Jika berhasil, alihkan ke halaman kasir.index
        //             window.location.href = '{{ route('kasir.index') }}'; // Gunakan route Laravel untuk mengarahkan
        //         } else {
        //             alert('Terjadi kesalahan saat menyimpan transaksi.');
        //         }
        //     })
        //     .catch(error => {
        //         console.error('Error:', error);
        //         alert('Terjadi kesalahan saat menyimpan transaksi.');
        //     });
        // }
    </script>
@endpush

{{-- function formatRupiah(angka) {
    // Format angka ke dalam format Rupiah tanpa .00
    return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function hitungTotal(id) {
    let subTotal = parseFloat(document.getElementById('sub_total_rincian-' + id).value.replace(/\./g, '')) || 0;
    let administrasi = parseFloat(document.getElementById('administrasi-' + id).value) || 0;
    let konsulDokter = parseFloat(document.getElementById('konsul_dokter-' + id).value.replace(/\./g, '')) || 0;
    let embalase = parseFloat(document.getElementById('embalase-' + id).value) || 0;
    let ppnPersen = parseFloat(document.getElementById('ppn-' + id).value) || 0;

    let totalSebelumPPN = subTotal + administrasi + konsulDokter + embalase;
    // Hitung PPN dengan bilangan bulat
    let ppn = Math.floor(totalSebelumPPN * (ppnPersen / 100));
    let total = totalSebelumPPN + ppn;

    document.getElementById('total-' + id).value = formatRupiah(total);
}

function hitungKembalian(id) {
    let total = parseFloat(document.getElementById('total-' + id).value.replace(/\./g, '')) || 0;
    let bayar = parseFloat(document.getElementById('bayar-' + id).value) || 0;

    let kembalian = bayar - total;
    if (kembalian < 0) {
        kembalian = 0;
    }

    document.getElementById('kembalian-' + id).value = formatRupiah(kembalian);
}

// Menambahkan event listener untuk setiap pasien
document.querySelectorAll('[data-pasien-id]').forEach(function (element) {
    const id = element.getAttribute('data-pasien-id');

    document.getElementById('administrasi-' + id).addEventListener('input', function() { hitungTotal(id); });
    document.getElementById('embalase-' + id).addEventListener('input', function() { hitungTotal(id); });
    document.getElementById('sub_total_rincian-' + id).addEventListener('input', function() { hitungTotal(id); });
    document.getElementById('ppn-' + id).addEventListener('input', function() { hitungTotal(id); });
    document.getElementById('bayar-' + id).addEventListener('input', function() { hitungKembalian(id); });

    // Panggil fungsi saat halaman dimuat untuk setiap pasien
    window.onload = function() {
        hitungTotal(id); // Hitung total saat halaman dimuat
        hitungKembalian(id); // Hitung kembalian saat halaman dimuat
    };
}); --}}

{{-- <script>

        // TOTAL BAYAR
        // Fungsi untuk memformat angka ke dalam format Rupiah
        function formatRupiah(angka) {
            return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Fungsi untuk menghitung total
        function hitungTotal() {
            // Ambil nilai dari masing-masing input, jika tidak ada nilai maka diasumsikan 0
            let subTotal = parseFloat(document.getElementById('sub_total_rincian').value.replace(/\./g, '')) || 0;
            let administrasi = parseInt(document.getElementById('administrasi').value) || 0;
            let konsulDokter = parseInt(document.getElementById('konsul_dokter').value.replace(/\./g, '')) || 0;
            let embalase = parseInt(document.getElementById('embalase').value) || 0;
            let ppnPersen = parseInt(document.getElementById('ppn').value) || 0;

            // Hitung PPN berdasarkan subtotal
            let totalSebelumPPN = subTotal + administrasi + konsulDokter + embalase;
            let ppn = totalSebelumPPN * (ppnPersen / 100);

            // Hitung total keseluruhan
            let total = totalSebelumPPN + ppn;

            // Tampilkan hasil di input total
            document.getElementById('total').value = formatRupiah(total.toFixed(0));
        }

        // Menambahkan event listener untuk menghitung total setiap kali input berubah
        document.getElementById('administrasi').addEventListener('input', hitungTotal);
        document.getElementById('embalase').addEventListener('input', hitungTotal);
        document.getElementById('sub_total_rincian').addEventListener('input', hitungTotal);
        document.getElementById('ppn').addEventListener('input', hitungTotal);

        // Panggil fungsi hitungTotal saat halaman dimuat
        window.onload = hitungTotal;

        // KEMBALIAN
        // Fungsi untuk menghitung kembalian
        function hitungKembalian() {
            // Ambil nilai dari input 'bayar' dan 'total'
            let total = parseInt(document.getElementById('total').value.replace(/\./g, '')) || 0;
            let bayar = parseInt(document.getElementById('bayar').value) || 0;

            // Hitung kembalian: bayar - total
            let kembalian = bayar - total;

            // Pastikan kembalian tidak negatif
            if (kembalian < 0) {
                kembalian = 0;
            }

            // Tampilkan kembalian di input kembalian
            document.getElementById('kembalian').value = formatRupiah(kembalian.toFixed(0));
        }

        // Event listener untuk menghitung kembalian saat input 'bayar' berubah
        document.getElementById('bayar').addEventListener('input', hitungKembalian);

        // Panggil fungsi hitungKembalian ketika halaman dimuat (opsional, jika kamu ingin menghitung dari awal)
        window.onload = function() {
            hitungTotal(); // Memastikan total dihitung saat halaman dimuat
            hitungKembalian(); // Menghitung kembalian setelah total dihasilkan
        };

</script> --}}
