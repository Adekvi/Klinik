<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Tiket Obat</title>

    <style>
        body {
            margin-top: 10px;
            padding: 0;
        }
        .paper {
            width: 100mm;
            height: 60mm;
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

        .container .top .image img {
            width: 50px;
            margin-left: 10px;
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
            border-top: 2px solid #000;
            margin-top: -8px;
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
            <div class="container" style="margin-left: -5px">
                <div class="top" style="margin-top: -5px; margin-left: -10px">
                    <div class="left">
                        <div class="image">
                            <img src="{{ asset('assets/images/logo_multisari.png') }}" alt="">
                        </div>
                    </div>
                    <div class="right">
                        <div class="clinic">
                            <h4>
                                KLINIK PRATAMA MULTISARI II <br>
                            </h4>
                        </div>
                        <div class="addres" style="margin-top: -8px">
                            <h5 style="font-size: 6px; white-space: nowrap; width: auto">
                                Jl. Jepara-Kudus, Ruko Safira Regency
                                Desa Sengonbugel RT. 03 RW. 01,
                                Kec. Mayong, Kab. Jepara
                            </h5>
                        </div>
                        <div class="telp" style="margin-top: -8px">
                            <h5 style="font-size: 6px;">(0291) 7520234, e-mail : klinikmultisari@gmail.com</h5>
                        </div>
                    </div>
                </div>
                <hr class="divider">
                <hr class="divider">
                
                <div class="judul" style="margin-top: -5px;">
                    <p style="text-align: center">{{ $item->booking->pasien->nama_pasien }}</p>
                    <div class="kalimat row" style="margin-top: -8px; display: flex; justify-content: space-between;">
                        <div class="col-lg-6">
                            <div class="tanggal mb-2" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <label for="" style="display:inline-block; min-width: 50px; font-weight: bold">Tanggal</label>
                                <span>:</span>
                                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                            </div>
                
                            <div class="no-rm mb-2" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <label for="" style="display:inline-block; min-width: 50px;">No. RM</label>
                                <span>:</span>
                                {{ $item->booking->pasien->no_rm }}
                            </div>
                            
                            <div class="alamat mb-2" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <label for="" style="display:inline-block; min-width: 50px;">Alamat</label>
                                <span>:</span>
                                {{ $item->booking->pasien->domisili }}
                            </div>
                        </div>
                
                        <div class="col-lg-6" style="margin-left: 50px">
                            <div class="umur-poli" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <label style="display:inline-block; min-width: 50px;">Umur</label>
                                <span>:</span>
                                {{ \Carbon\Carbon::parse($item->booking->pasien->tgllahir)->age }} Tahun
                            </div>
                            <div class="poli" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <label style="display:inline-block; min-width: 50px;">Poli</label>
                                <span>:</span>
                                {{ $item->poli->namapoli }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="nama-obat">
                    {{-- <h6 style="font-size: 10px; margin-top: -2px; margin-left: 10px">Informasi Obat</h6> --}}
                    {{-- <div class="pil" style="font-size: 10px; margin-top: 5px; margin-bottom: 5px">
                        <span style="display:inline-block; width: 70px;">Informasi Obat </span> :
                        @foreach($resep as $nama_obat => $aturan_minum) 
                        {{ $nama_obat }},
                        @endforeach
                    </div> --}}
                    {{-- <h6 style="font-size: 10px; margin-top: 2px; margin-left: 10px">Aturan Minum</h6> --}}
                    <div class="row">
                        <div class="col-6">
                            <div class="minum">
                                <label for="" style="min-width: 100px;">Aturan Minum</label>
                                <span>:</span>
                            </div>
                            {{-- <div class="pil" style="font-size: 10px; margin-top: 5px; margin-bottom: 10px">
                                <span style="display:inline-block; min-width: 100px;">Aturan Minum </span> :
                                @foreach($resep as $nama_obat => $aturan_minum) 
                                {{ $aturan_minum }},
                                @endforeach
                            </div> --}}
                            <div class="jumlah" style="margin-top: 8px">
                                <label for="" style="min-width: 100px;">Jumlah</label>
                                <span>:</span>
                            </div>
                        </div>
                        <div class="col-6" style="margin-top: 8px">
                            <label for="" style="min-width: 100px;">Aturan Tambahan</label>
                            <span>:</span>
                        </div>
                    </div>
                    {{-- {{ $item->jumlah }}/{{ $item->satuan }}<br> --}}
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

</body>
</html>