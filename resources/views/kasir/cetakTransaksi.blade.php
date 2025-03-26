<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Transaksi</title>

    <style>
        body {
            margin-top: 10px;
            padding: 0;
        }
        .paper {
            width: 80mm;
            height: 120mm;
            padding: 5mm;
            border: 1px solid #000;
            border-radius: 3px;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            /* background-color: rgb(211, 255, 255); */
        }
        .container .top {
            display: flex;
            align-items: center;
        }

        .container .top .left {
            flex: 0 0 auto;
            margin-right: 5px;
        }

        .container .top .right {
            flex: 1;
        }

        .container .center .image img {
            width: 50px;
            margin-bottom: -18px;
            /* margin-left: 10px; */
        }

        .container .top .clinic h4,
        .container .top .clinic h4 {
            margin: 0;
            font-size: 10px;
            font-weight: bold;
        }

        .container .top .address h5,
        .container .top .tel h5 {
            margin: 0;
            /* font-size: 3px; */
        }

        .divider {
            border-top: 1px solid #000;
            margin-top: -8px;
            margin-bottom: 5px;
        }

        .container .judul p {
            font-weight: bold;
            text-align: center;
            font-size: 11px;
        }

        .container .judul .kalimat p {
            text-align: start;
            margin-top: -5px;
            font-size: 10px;
        }

        .container .judul .kalimat .col-lg-6 #Tanggal {
            font-weight: bold;
        }

        .kalimat {
            display: flex;
            justify-content: space-between;
            font-size: 10px;
        }
        .kalimat div {
            flex: 1;
        }
        .nama-obat {
            text-align: start;
            margin-top: 15px;
            font-size: 10px;
        }
        .aturan {
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            margin-top: -20px;
        }
    </style>
</head>
<body>

    <section class="laporan">
        <div class="paper">
            <div class="container">
                <div class="center" style="display: flex; justify-content: center; align-items: center">
                    <div class="image">
                        <img src="{{ asset('assets/images/logo_multisari.png') }}" alt="">
                    </div>
                </div>
                <div class="top" style="text-align: center">
                    <div class="right">
                        <div class="clinic">
                            <p style="font-size: 15px; font-weight: bold">
                                KLINIK PRATAMA MULTISARI II <br>
                            </p>
                        </div>
                        <div class="addres" style="margin-top: -14px">
                            <h5 style="font-size: 10px; width: auto">
                                Jl. Jepara-Kudus, Ruko Safira Regency
                                Desa Sengonbugel RT. 03 RW. 01,
                                Kec. Mayong, Kab. Jepara
                            </h5>
                        </div>
                        <div class="telp" style="margin-top: -14px">
                            <h5 style="font-size: 10px; width: auto">(0291) 7520234, e-mail: klinikmultisari@gmail.com</h5>
                        </div>
                    </div>
                </div>

                {{-- <hr class="divider">
                <hr class="divider"> --}}
                
                <div class="judul">
                    {{-- <p style="">{{ $transaksi->booking->pasien->nama_pasien }}</p> --}}
                    <div class="kalimat row" style="margin-top: -8px; display: flex; justify-content: space-between;">
                        <div class="col-lg-6">                
                            <div class="no-rm mb-2" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <label for="" style="display:inline-block; min-width: 65px;">No. Transaksi</label>
                                <span>:</span>
                                @if ($strukPembayaran->isNotEmpty())
                                    {{ $strukPembayaran->first()->no_transaksi }}
                                @else
                                    <p>-</p>
                                @endif
                            </div>
                            
                            <div class="alamat mb-2" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <label for="" style="display:inline-block; min-width: 65px;">Kasir</label>
                                <span>:</span>
                                @if ($strukPembayaran->isNotEmpty())
                                    {{ $strukPembayaran->first()->nama_kasir }}
                                @else
                                    <p>-</p>
                                @endif
                            </div>

                            <div class="alamat mb-2" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <label for="" style="display:inline-block; min-width: 65px;">Nama Pasien</label>
                                <span>:</span>
                                {{ $transaksi->booking->pasien->nama_pasien }}
                            </div>

                            <div class="alamat mb-2" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <label for="" style="display:inline-block; min-width: 65px;">No. Hp</label>
                                <span>:</span>
                                {{ $transaksi->booking->pasien->noHP }}
                            </div>

                            <div class="alamat mb-2" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <label for="" style="display:inline-block; min-width: 65px;">No. Antrian</label>
                                <span>:</span>
                                {{ $transaksi->kode_antrian }}
                            </div>
                        </div>
                        <div class="col-lg-6" style="margin-top: 60px; margin-left: -50px">
                            <div class="umur-poli">
                                {{ $date }}
                            </div>
                            <div class="poli">
                                {{ $time }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="nama-obat">
                    <h3>Transaksi</h3>
                    <div class="row">
                        <div class="tabel col-lg-12">
                            <table class="table table-responsive table-bordered" style="overflow-x: auto; margin-top: -10px">
                                <thead class="text-center" style="white-space: nowrap">
                                    <th>Keterangan</th>
                                    <th>Satuan</th>
                                    <th>Qty</th>
                                    <th>Harga Jual</th>
                                    <th>Total</th>
                                </thead>
                                <tbody class="text-center">
                                    <?php 
                                        // Fungsi untuk memformat harga ke dalam format Rupiah
                                        if (!function_exists('Rupiah')) {
                                            function Rupiah($angka)
                                            {
                                                return "" . number_format($angka, 0, ',', '.');
                                            }
                                        }
                                    ?>
                                    @foreach ($transaksi as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            {{-- <td>{{ $item }}</td>
                                            <td>{{ $item }}</td>
                                            <td>{{ Rupiah($item) }}</td>
                                            <td>{{ $item }}</td>
                                            <td>{{ $item }}</td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> 

                <h6 style="text-align: center; font-size: 10px; margin-top: 5px; margin-left: -30px">DIHABISKAN</h6>

                <div class="aturan" style="margin-bottom: 5px;">
                    <div class="pagi">
                        <span style="display: inline-block; width: 40px;">Pagi</span> :
                    </div>
                    <div class="col-lg-6">
                        <div class="siang" style="margin-left: -87px;">
                            <span style="display: inline-block; width: 40px;">Siang</span> :
                        </div>
                    </div>
                    <div class="malam">
                        <span style="display: inline-block; width: 40px; margin-left: -115px;">Malam</span> :
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        window.print();
    </script>

</body>
</html>
