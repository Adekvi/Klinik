<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Struk Pembayaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Courier+Prime&display=swap");

        body {
            font-family: Arial, sans-serif;
        }

        .courier-prime {
            font-family: "Courier Prime", monospace;
        }

        table {
            border-collapse: collapse;
        }
    </style>
</head>

<body class="bg-white p-4 sm:p-6">
    <div class="max-w-4xl mx-auto border border-black p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 mb-1">
            <img src="{{ asset('assets/images/logo_multisari.png') }}"
                alt="Blue circular logo with white letter R and text Klinik Multisari II"
                class="w-16 h-16 sm:w-20 sm:h-20 object-contain flex-shrink-0" width="80" height="80" />
            <div class="flex-1 text-[10px] sm:text-[11px] font-bold leading-tight">
                <p class="mb-[2px]" style="font-size: 15px">Klinik Multisari II</p>
                {{-- <p class="mb-[2px]">
                    No. Surat Izin Apotek :
                    <span class="font-normal">503/00686/DPM-PTSP/kes/XII/2018</span>
                </p> --}}
                <p class="mb-[2px]">Jl. Jepara-Kudus, Ruko Safira Regency
                    Desa Sengonbugel RT. 03 RW. 01,
                    Kec. Mayong, Kab. Jepara</p>
                <p>
                    Telp. (0291) 7520234, Email :
                    <span class="font-normal break-words">klinikmultisari@gmail.com</span>, Website :
                    <span class="font-normal break-words">https://klinikmultisari2.com</span>
                </p>
            </div>
            <div class="courier-prime text-3xl sm:text-4xl font-extrabold tracking-widest select-none whitespace-nowrap"
                style="line-height: 1">
                F A K T U R
            </div>
        </div>
        <hr class="border-black border-t-[1.5px] mb-2" />
        <div class="flex flex-col sm:flex-row justify-between text-[10px] sm:text-[11px] mb-2 gap-2 sm:gap-0"
            style="text-transform: uppercase">
            <div class="flex flex-col gap-[2px] w-full sm:w-1/2">
                <div class="flex gap-1 flex-wrap">
                    <span class="font-bold w-28 min-w-[110px]">Nama Pasien</span>:
                    <span class="font-normal">{{ $transaksi->booking->pasien->nama_pasien }}</span>
                </div>
                <div class="flex gap-1 flex-wrap">
                    <span class="font-bold w-28 min-w-[110px]">Jenis Pasien</span>:
                    <span class="font-normal">{{ $transaksi->booking->pasien->jenis_pasien }}</span>
                </div>
                <div class="flex gap-1 flex-wrap">
                    <span class="font-bold w-28 min-w-[110px]">No. Telp</span>:
                    <span class="font-normal">{{ $transaksi->booking->pasien->noHP ?? '' }}</span>
                </div>
                <div class="flex gap-1 flex-wrap">
                    <span class="font-bold w-28 min-w-[110px]">Alamat</span>:
                    <span class="font-normal">{{ $transaksi->booking->pasien->alamat_asal }}</span>
                </div>
            </div>
            <div class="flex flex-col gap-[2px] w-full sm:w-1/2">
                <div class="flex gap-1 flex-wrap">
                    <span class="font-bold w-28 min-w-[110px]">Kasir</span>:
                    <span class="font-normal">{{ Auth::user()->name ?? '' }}</span>
                </div>
                <div class="flex gap-1 flex-wrap">
                    <span class="font-bold w-28 min-w-[110px]">Tanggal</span>:
                    <span class="font-normal">{{ Carbon\Carbon::now()->format('Y-m-d / H:i') }}</span>
                </div>
                <div class="flex gap-1 flex-wrap">
                    <span class="font-bold w-28 min-w-[110px]">No. Transaksi</span>:
                    <span class="font-normal">{{ $transaksi->no_transaksi ?? '-' }}</span>
                </div>
                <div class="flex gap-1 flex-wrap">
                    <span class="font-bold w-28 min-w-[110px]">Pembayaran</span>:
                    <span class="font-normal">TUNAI</span>
                </div>
            </div>

        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-[9px] sm:text-[10px] border border-black min-w-[200px]">
                <thead>
                    <tr>
                        {{-- <th class="border border-black px-1 py-0.5 text-center w-6">No</th> --}}
                        <th class="border border-black px-1 py-0.5 text-center w-[120px]">
                            Nama Obat
                        </th>
                        <th class="border border-black px-1 py-0.5 text-center w-10">Qty</th>
                        <th class="border border-black px-1 py-0.5 text-center w-14">
                            Satuan
                        </th>
                        <th class="border border-black px-1 py-0.5 text-center w-14">
                            Harga
                        </th>
                        <th class="border border-black px-1 py-0.5 text-center w-16">
                            Subtotal
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    // Fungsi untuk memformat harga ke dalam format Rupiah
                    if (!function_exists('Rupiah')) {
                        function Rupiah($angka)
                        {
                            return '' . number_format($angka, 0, ',', '.');
                        }
                    }
                    ?>

                    @php
                        $namaObat = json_decode($cetak->obat_Ro_namaObatUpdate, true) ?? [];
                        $jumlahObat = json_decode($cetak->obat_Ro_jumlah, true) ?? [];
                        $jenisObat = json_decode($cetak->obat_Ro_jenisObat, true) ?? [];
                        $hargaJualData = $reseps->keyBy('nama_obat');

                        $grandTotal = 0;
                        $totalQty = 0;
                    @endphp

                    <tr>
                        {{-- NAMA OBAT --}}
                        <td class="border border-black px-1 py-0.5 align-top leading-tight">
                            @foreach ($namaObat as $index => $obat)
                                {{ $index + 1 }}. {{ $obat }}<br>
                                <hr>
                            @endforeach
                        </td>

                        {{-- SATUAN --}}
                        <td class="border border-black px-1 py-0.5 align-top leading-tight text-center">
                            @foreach ($jenisObat as $jenis)
                                {{ $jenis }}<br>
                                <hr>
                            @endforeach
                        </td>

                        {{-- QTY --}}
                        <td class="border border-black px-1 py-0.5 align-top leading-tight text-center">
                            @foreach ($jumlahObat as $jumlah)
                                {{ $jumlah }}<br>
                                <hr>
                                @php $totalQty += $jumlah; @endphp
                            @endforeach
                        </td>

                        {{-- HARGA --}}
                        <td class="border border-black px-1 py-0.5 align-top leading-tight text-center">
                            @foreach ($namaObat as $obat)
                                Rp {{ number_format($hargaJualData[$obat]['harga_jual'] ?? 0, 0, ',', '.') }}<br>
                                <hr>
                            @endforeach
                        </td>

                        {{-- SUBTOTAL --}}
                        <td class="border border-black px-1 py-0.5 align-top leading-tight text-center">
                            @foreach ($namaObat as $index => $obat)
                                @php
                                    $harga = $hargaJualData[$obat]['harga_jual'] ?? 0;
                                    $jumlah = $jumlahObat[$index] ?? 1;
                                    $sub = $harga * $jumlah;
                                    $grandTotal += $sub;
                                @endphp
                                Rp {{ number_format($sub, 0, ',', '.') }}<br>
                                <hr>
                            @endforeach
                        </td>
                    </tr>

                    {{-- BARIS TOTAL QTY & SUBTOTAL --}}
                    <tr>
                        <td class="px-1 py-0.5 text-center font-semibold">Keterangan</td>
                        <td class="px-1 py-0.5"></td> {{-- kolom kosong untuk satuan --}}
                        <td class="border border-black px-1 py-0.5 font-semibold  text-center">{{ $totalQty }}</td>
                        <td class="px-1 py-0.5"></td> {{-- kolom kosong untuk harga --}}
                        <td class="border border-black px-1 py-0.5 font-semibold text-center">
                            Rp {{ number_format($grandTotal, 0, ',', '.') }}
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <div class="mt-2 border-t border-grey"></div>
        <div class="flex justify-content-start mt-3 w-full max-w-[300px]">
            <table class="w-full text-[11px]">
                <tbody>
                    <tr>
                        <td class="font-semibold">
                            Pajak (%)
                        </td>
                        <td>:</td>
                        <td class="font-semibold">
                            {{ $transaksi->ppn ? number_format($transaksi->ppn, 0, ',', '') : '-' }} %
                        </td>
                    </tr>
                    <tr>
                        <td class="font-semibold">
                            Konsultasi Dokter
                        </td>
                        <td>:</td>
                        <td class="font-semibold">
                            Rp. {{ Rupiah($transaksi->konsul_dokter) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="font-semibold">
                            Sub Total
                        </td>
                        <td>:</td>
                        <td class="font-semibold">
                            Rp. {{ Rupiah($grandTotal) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="font-semibold">
                            Total
                        </td>
                        <td>:</td>
                        <td class="font-semibold">
                            Rp. {{ Rupiah($grandTotal + $transaksi->konsul_dokter) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="font-extrabold">
                            Bayar
                        </td>
                        <td>:</td>
                        <td class="font-extrabold">
                            Rp. {{ Rupiah($transaksi->bayar ?? '-') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="font-extrabold">
                            Kembalian
                        </td>
                        <td>:</td>
                        <td class="font-extrabold">
                            Rp. {{ Rupiah($transaksi->kembalian ?? '-') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr>
        <div class="flex flex-col sm:flex-row gap-2 text-[10px] mt-3">
            <div class="w-16 font-bold flex-shrink-0">Catatan</div>
            <div class="flex-1 leading-tight">
                <p>: Terimakasih Telah berkunjung. semoga sehat selalu</p>
                <p><span class="font-semibold">Maaf,</span> barang yang sudah dibeli</p>
                <p>tidak dapat ditukar atau dikembalikan</p>
            </div>
        </div>
        <div class="flex flex-col sm:flex-row justify-between text-[10px] mt-6 px-1 gap-2 sm:gap-0">
            <div>Penerima / Pembeli</div>
            <div>Klinik Multisari II</div>
        </div>
    </div>

    <script>
        window.print();
    </script>

</body>

</html>
