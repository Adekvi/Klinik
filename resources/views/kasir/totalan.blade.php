<x-admin.layout.terminal title="Kasir | Total">

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
                <form action="{{ url('kasir/tambah/' . $antrianKasir->id) }}" id="transaksiForm" method="post"
                    enctype="multipart/form-data">
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
                                            <th scope="row" style="padding: 4px; text-align: left;">Nama Petugas</th>
                                            <td style="padding: 4px; width: 10px;">:</td>
                                            <td style="padding: 4px;"><input type="text" name="nama_kasir"
                                                    id="nama_kasir" class="form-control"
                                                    value="{{ Auth::user()->name }}"
                                                    style="margin-left: 5px; text-align: end" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row" style="padding: 4px; text-align: left;">Shift</th>
                                            <td style="padding: 4px; width: 10px;">:</td>
                                            <td style="padding: 4px;">
                                                <input type="text" name="shift_display" id="shift_display"
                                                    class="form-control" style="margin-left: 5px; text-align: end"
                                                    value="{{ $namaShift }}" readonly>
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
                                                value="{{ $kasir->no_transaksi ?? '-' }}" readonly>
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
                                            <input type="text" name="jenis_pasien" id="jenis_pasien"
                                                class="form-control"
                                                value="{{ $antrianKasir->booking->pasien->jenis_pasien }}"
                                                style="margin-left: 5px; text-align: end" readonly>
                                        </div>
                                        <div class="info-item mb-2">
                                            <label style="min-width: 120px;">NIK</label>
                                            <span>:</span>
                                            <input type="text" name="nik_bpjs" id="nik_bpjs" class="form-control"
                                                style="margin-left: 5px; text-align: end"
                                                value="{{ $antrianKasir->booking->pasien->nik ?? '-' }}" readonly>
                                        </div>
                                        <div class="info-item mb-2">
                                            <label style="min-width: 120px;">No. BPJS</label>
                                            <span>:</span>
                                            <input type="text" name="nik_bpjs" id="nik_bpjs"
                                                class="form-control" style="margin-left: 5px; text-align: end"
                                                value="{{ $antrianKasir->booking->pasien->bpjs ?? '-' }}" readonly>
                                        </div>
                                        <div class="info-item mb-2">
                                            <label style="min-width: 120px;">Poli</label>
                                            <span>:</span>
                                            <p class="form-control" style="margin-left: 5px; text-align: end"
                                                readonly>
                                                {{ $antrianKasir->poli->namapoli }}</p>
                                            {{-- <input type="text" name="" id="id_poli" class="form-control" value="{{ $antrianKasir->poli->namapoli }}" style="margin-left: 5px; text-align: end" readonly> --}}
                                        </div>
                                        <div class="info-item mb-2">
                                            <label style="min-width: 120px;">Dokter</label>
                                            <span>:</span>
                                            <p class="form-control" style="margin-left: 5px; text-align: end"
                                                readonly>
                                                {{ $antrianKasir->obat->soap->nama_dokter }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-container p-3 border rounded shadow-sm mb-4">
                                        <div class="info-item mb-3" data-pasien-id="{{ $antrianKasir->id }}">
                                            <div class="d-flex align-items-center">
                                                <h5 class="font-weight-bold"
                                                    style="min-width: 110px; font-size: 28px">
                                                    TOTAL</h5>
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
                                                    <!-- Hidden input untuk total asli -->
                                                    <input type="hidden" name="total_hidden"
                                                        id="total_hidden-{{ $antrianKasir->id }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="info-item mb-2" data-pasien-id="{{ $antrianKasir->id }}">
                                            <label style="min-width: 110px;">Sub. Total Rincian</label>
                                            <span>:</span>
                                            @if ($obatPasien)
                                                <?php
                                                // Fungsi untuk memformat harga ke dalam format Rupiah
                                                if (!function_exists('Rupiah')) {
                                                    function Rupiah($angka)
                                                    {
                                                        return '' . number_format($angka, 0, ',', '.');
                                                    }
                                                }
                                                
                                                // Mendekode nama obat dari soap_p
                                                $namaObat = json_decode($obatPasien->obat_Ro_namaObatUpdate, true) ?? [];
                                                $jumlahObat = json_decode($obatPasien->obat_Ro_jumlah, true) ?? []; // Ambil jumlah obat dari field yang sesuai
                                                
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
                                                    echo '';
                                                }
                                                ?>
                                            @endif

                                            <!-- Bagian input Sub Total -->
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"
                                                        style="background: rgb(228, 228, 228)">
                                                        <b>Rp.</b>
                                                    </span>
                                                </div>
                                                <!-- Menampilkan subtotal yang sudah dihitung -->
                                                <input type="number" value="{{ Rupiah($subTotal) }}"
                                                    name="sub_total_rincian"
                                                    id="sub_total_rincian-{{ $antrianKasir->id }}"
                                                    class="form-control" style="text-align: end" readonly>
                                            </div>
                                        </div>

                                        <div class="info-item mb-2" data-pasien-id="{{ $antrianKasir->id }}">
                                            <label style="min-width: 110px;">Administrasi</label>
                                            <span>:</span>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"
                                                        style="background: rgb(228, 228, 228)">
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
                                                    <span class="input-group-text"
                                                        style="background: rgb(228, 228, 228)">
                                                        <b>Rp.</b>
                                                    </span>
                                                </div>
                                                @if ($datadokter->isNotEmpty())
                                                    <input type="number" name="konsul_dokter"
                                                        id="konsul_dokter-{{ $antrianKasir->id }}"
                                                        class="form-control" style="text-align: end"
                                                        value="{{ Rupiah($datadokter->first()->tarif) }}" readonly>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="info-item mb-2" data-pasien-id="{{ $antrianKasir->id }}">
                                            <label style="min-width: 110px;">Embalase</label>
                                            <span>:</span>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"
                                                        style="background: rgb(228, 228, 228)">
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
                                            if ($obatPasien) {
                                                // Decode jumlah obat dari soap_p_jumlah
                                                $jumlahObat = json_decode($obatPasien->obat_Ro_jumlah, true) ?? [];
                                            
                                                // Jika ada jumlah obat, tambahkan ke total
                                                if (!empty($jumlahObat)) {
                                                    foreach ($jumlahObat as $jumlah) {
                                                        $totalObat += $jumlah; // Akumulasi jumlah obat
                                                    }
                                                }
                                            }
                                            ?>

                                            <div class="input-group">
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
                                                        id="ppn-{{ $antrianKasir->id }}"
                                                        value="{{ $item->tarifPpn }}" class="form-control"
                                                        style="text-align: center; margin-left: 5px" readonly>
                                                @endforeach
                                                {{-- {{ dd($pajak) }} --}}
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"
                                                        style="background: rgb(228, 228, 228)">
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
                                    <div class="table col-md-12" data-pasien-id="{{ $antrianKasir->id }}">
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
                                                @php $no = 1; @endphp

                                                @if ($obatPasien)
                                                    <tr data-pasien-id="{{ $obatPasien->id }}">
                                                        <td>{{ $no++ }}</td>
                                                        <!-- Tidak perlu nomor iterasi karena hanya satu entri -->
                                                        {{-- KETERANGAN --}}
                                                        <td class="text-start"
                                                            data-pasien-id="{{ $obatPasien->id }}">
                                                            @php
                                                                $namaObat =
                                                                    json_decode(
                                                                        $obatPasien->obat_Ro_namaObatUpdate,
                                                                        true,
                                                                    ) ?? [];
                                                                if (!empty($namaObat)) {
                                                                    foreach ($namaObat as $index => $obat) {
                                                                        echo $index + 1 . '. ' . $obat . '<br><hr>';
                                                                    }
                                                                } else {
                                                                    echo 'Tidak ada data obat<br><hr>';
                                                                }
                                                            @endphp
                                                        </td>
                                                        {{-- SATUAN --}}
                                                        <td data-pasien-id="{{ $obatPasien->id }}">
                                                            @php
                                                                $jenisObat =
                                                                    json_decode($obatPasien->obat_Ro_jenisObat, true) ??
                                                                    [];
                                                                if (!empty($jenisObat)) {
                                                                    foreach ($jenisObat as $JnsObt) {
                                                                        echo $JnsObt . '<hr>';
                                                                    }
                                                                } else {
                                                                    echo 'Tidak ada data jenis obat<hr>';
                                                                }
                                                            @endphp
                                                        </td>
                                                        {{-- QTY --}}
                                                        <td data-pasien-id="{{ $obatPasien->id }}">
                                                            @php
                                                                $jumlahObat =
                                                                    json_decode($obatPasien->obat_Ro_jumlah, true) ??
                                                                    [];
                                                                if (!empty($jumlahObat)) {
                                                                    foreach ($jumlahObat as $jumlah) {
                                                                        echo $jumlah . '<hr>';
                                                                    }
                                                                } else {
                                                                    echo 'Tidak ada data jumlah<hr>';
                                                                }
                                                            @endphp
                                                        </td>
                                                        {{-- HARGA JUAL --}}
                                                        <td data-pasien-id="{{ $obatPasien->id }}">
                                                            @php
                                                                $namaObat =
                                                                    json_decode(
                                                                        $obatPasien->obat_Ro_namaObatUpdate,
                                                                        true,
                                                                    ) ?? [];
                                                                $hargaJualData = $reseps->keyBy('nama_obat');
                                                                if (!empty($namaObat)) {
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
                                                                } else {
                                                                    echo '0<hr>';
                                                                }
                                                            @endphp
                                                        </td>
                                                        {{-- TOTAL --}}
                                                        <td data-pasien-id="{{ $obatPasien->id }}">
                                                            @php
                                                                $namaObat =
                                                                    json_decode(
                                                                        $obatPasien->obat_Ro_namaObatUpdate,
                                                                        true,
                                                                    ) ?? [];
                                                                $jumlahObat =
                                                                    json_decode($obatPasien->obat_Ro_jumlah, true) ??
                                                                    [];
                                                                if (!empty($namaObat) && !empty($jumlahObat)) {
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
                                                                } else {
                                                                    echo '0<hr>';
                                                                }
                                                            @endphp
                                                        </td>
                                                        {{-- TARIF --}}
                                                        <td data-pasien-id="{{ $obatPasien->id }}">
                                                            {{ $obatPasien->booking->pasien->jenis_pasien }}
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td colspan="7" class="text-center">Tidak ada data obat
                                                            untuk
                                                            pasien ini.</td>
                                                    </tr>
                                                @endif
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
                                                <button type="button" class="btn btn-outline-success"
                                                    id="btn-bpjs-{{ $antrianKasir->id }}"
                                                    onclick="handlePaymentType('bpjs', {{ $antrianKasir->id }})">BPJS</button>
                                                <button type="button" class="btn btn-outline-primary"
                                                    id="btn-non-kapitasi-{{ $antrianKasir->id }}"
                                                    onclick="handlePaymentType('non-kapitasi', {{ $antrianKasir->id }})"
                                                    style="white-space: nowrap; width: 100%;">Non Kapitasi</button>
                                                <button type="button" class="btn btn-outline-info"
                                                    id="btn-umum-{{ $antrianKasir->id }}"
                                                    onclick="handlePaymentType('umum', {{ $antrianKasir->id }})">UMUM</button>
                                            </div>
                                            <div class="info-item text-nowrap"
                                                data-pasien-id="{{ $antrianKasir->id }}">
                                                <label for="" style="padding-left: 15px;">TOTAL</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"
                                                            style="background: rgb(228, 228, 228)">
                                                            <b>Rp.</b>
                                                        </span>
                                                    </div>
                                                    <input type="text" id="totalbayar-{{ $antrianKasir->id }}"
                                                        class="form-control" style="text-align: end;" readonly>
                                                    <!-- Hidden input untuk total bayar -->
                                                    <input type="hidden" name="totalbayar_hidden"
                                                        id="totalbayar_hidden-{{ $antrianKasir->id }}">
                                                </div>
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
                                                        class="form-control" required
                                                        oninput="hitungKembalian({{ $antrianKasir->id }})">
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
                                                        id="kembalian-{{ $antrianKasir->id }}"
                                                        style="text-align: end" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="info-item" style="justify-content: flex-end">
                                    <button type="button" class="btn btn-primary" id="saveButton"
                                        onclick="simpanDanCetak({{ $antrianKasir->id }})">
                                        <i class="fas fa-file"></i> SIMPAN TRANSAKSI
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
            function formatRupiah(angka) {
                return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            function initializeButtons(id) {
                const jenisPasien = document.getElementById('jenis_pasien').value.toLowerCase();
                const btnBpjs = document.getElementById('btn-bpjs-' + id);
                const btnNonKapitasi = document.getElementById('btn-non-kapitasi-' + id);
                const btnUmum = document.getElementById('btn-umum-' + id);

                if (jenisPasien === 'umum') {
                    btnBpjs.disabled = true;
                    btnNonKapitasi.disabled = false;
                    btnUmum.disabled = false;
                    handlePaymentType('umum', id);
                } else if (jenisPasien === 'bpjs') {
                    btnBpjs.disabled = false;
                    btnNonKapitasi.disabled = true;
                    btnUmum.disabled = true;
                    handlePaymentType('bpjs', id);
                } else {
                    btnBpjs.disabled = false;
                    btnNonKapitasi.disabled = false;
                    btnUmum.disabled = false;
                    handlePaymentType('umum', id);
                }

                hitungTotal(id);
            }

            function hitungTotal(id) {
                let subTotal = parseFloat(document.getElementById('sub_total_rincian-' + id).value.replace(/\./g, '')) || 0;
                let administrasi = parseFloat(document.getElementById('administrasi-' + id).value.replace(/\./g, '')) || 0;
                let konsulDokter = parseFloat(document.getElementById('konsul_dokter-' + id).value.replace(/\./g, '')) || 0;
                let embalase = parseFloat(document.getElementById('embalase-' + id).value.replace(/\./g, '')) || 0;
                let ppnPersen = parseFloat(document.getElementById('ppn-' + id).value) || 0;

                let totalSebelumPPN = subTotal + administrasi + konsulDokter + embalase;
                let ppn = Math.floor(totalSebelumPPN * (ppnPersen / 100));
                let total = totalSebelumPPN + ppn;

                document.getElementById('total-' + id).value = formatRupiah(total);
                document.getElementById('total_hidden-' + id).value = total;
            }

            function handlePaymentType(type, id) {
                hitungTotal(id);
                let totalAsli = parseFloat(document.getElementById('total_hidden-' + id).value) || 0;
                const jenisPasien = document.getElementById('jenis_pasien').value.toLowerCase();
                let totalBayar = 0;

                if (type === 'bpjs' && jenisPasien === 'bpjs') {
                    totalBayar = 0;
                    document.getElementById('bayar-' + id).value = 0;
                    document.getElementById('bayar-' + id).readOnly = true;
                    document.getElementById('kembalian-' + id).value = 0;
                } else {
                    totalBayar = totalAsli;
                    document.getElementById('bayar-' + id).readOnly = false;
                }

                document.getElementById('totalbayar-' + id).value = formatRupiah(totalBayar);
                document.getElementById('totalbayar_hidden-' + id).value = totalBayar;

                hitungKembalian(id);
            }

            function hitungKembalian(id) {
                let totalBayar = parseFloat(document.getElementById('totalbayar_hidden-' + id).value) || 0;
                let bayar = parseFloat(document.getElementById('bayar-' + id).value.replace(/\./g, '')) || 0;

                let kembalian = bayar - totalBayar;
                if (kembalian < 0) kembalian = 0;

                document.getElementById('kembalian-' + id).value = formatRupiah(kembalian);
            }

            // PERBAIKAN UTAMA: simpanDanCetak(id) + sanitasi field + error handling
            function simpanDanCetak(id) {
                const form = document.getElementById('transaksiForm');
                if (!form) {
                    alert('Form tidak ditemukan!');
                    return;
                }

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                if (!csrfToken) {
                    alert('CSRF token tidak ditemukan. Refresh halaman.');
                    return;
                }

                const formData = new FormData(form);

                // Daftar field numerik dengan suffix -id
                const numericFields = [
                    'total_hidden',
                    'totalbayar_hidden',
                    'bayar',
                    'kembalian',
                    'sub_total_rincian',
                    'administrasi',
                    'konsul_dokter',
                    'embalase',
                    'ppn'
                ];

                // Sanitasi: hapus titik, pastikan angka
                numericFields.forEach(field => {
                    const fieldName = `${field}-${id}`;
                    const value = formData.get(fieldName);
                    if (value !== null) {
                        const cleanValue = value.toString().replace(/[^0-9]/g, '');
                        formData.set(fieldName, cleanValue || '0');
                    }
                });

                console.log('Mengirim data:', Object.fromEntries(formData));

                fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        // Tangani semua status error
                        if (!response.ok) {
                            return response.text().then(text => {
                                throw new Error(`Server Error ${response.status}: ${text.substring(0, 200)}...`);
                            });
                        }
                        // Coba parse JSON
                        const contentType = response.headers.get('content-type');
                        if (contentType && contentType.includes('application/json')) {
                            return response.json();
                        } else {
                            return response.text().then(text => {
                                throw new Error('Respons bukan JSON: ' + text.substring(0, 200));
                            });
                        }
                    })
                    .then(data => {
                        console.log('Sukses:', data);
                        if (data.success && data.transaksi_id) {
                            const printUrl = '/kasir/cetakTransaksi/' + data.transaksi_id;
                            const printWindow = window.open(printUrl, '_blank');
                            if (printWindow) {
                                setTimeout(() => printWindow.print(), 500);
                            }
                            alert('Transaksi berhasil disimpan!');
                            window.location.href = '/kasir/index';
                        } else {
                            alert('Gagal: ' + (data.message || 'Respons tidak valid'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Tampilkan error tanpa crash
                        alert('Terjadi kesalahan: ' + error.message);
                    });
            }

            // Inisialisasi saat halaman loaded
            document.addEventListener('DOMContentLoaded', function() {
                const id = {{ $antrianKasir->id }};
                initializeButtons(id);

                // Event listener untuk perubahan input
                ['sub_total_rincian', 'administrasi', 'konsul_dokter', 'embalase', 'ppn'].forEach(field => {
                    const input = document.getElementById(field + '-' + id);
                    if (input) {
                        input.addEventListener('input', () => hitungTotal(id));
                    }
                });

                const bayarInput = document.getElementById('bayar-' + id);
                if (bayarInput) {
                    bayarInput.addEventListener('input', () => hitungKembalian(id));
                }
            });
        </script>
    @endpush

</x-admin.layout.terminal>
