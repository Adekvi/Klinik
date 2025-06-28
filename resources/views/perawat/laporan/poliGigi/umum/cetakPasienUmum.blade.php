<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Kunjungan Pasien BPJS</title>
    
    <style>
        .container .top {
            display: flex;
            align-items: center;
        }

        .container .top .left {
            flex: 0 0 auto;
            margin-right: 10px; /* Atur jarak antara logo dan teks */
        }

        .container .top .right {
            flex: 1;
        }

        .container .top .image img {
            width: 100px;
            margin-left : 20px;
        }

        .container .top .clinic p,
        .container .top .clinic p {
            margin: 0; /* Hapus margin default */
            font-size: 25px;
            font-weight: bold;
        }

        .container .top .address p,
        .container .top .tel p {
            margin: 0; /* Hapus margin default */
            font-size: 12px;
        }

        .divider {
            border-top: 5px solid #000; /* Warna garis dan ketebalan dapat disesuaikan */
            margin-top: -5px; /* Atur jarak antara garis dan teks */
        }
        .divider-2 {
            border-top: 1px solid #000; /* Warna garis dan ketebalan dapat disesuaikan */
            margin-top: -5px;
        }

        .container .judul p {
            font-weight: bold;
            text-align: center;
            font-size: 20px;
        }

        .container .judul .kalimat p {
            text-align: start;
            margin-top: -10px;
            font-size: 15px;
        }
    </style>
</head>
<body>
    <div class="conatiner">
        <div class="top">
            <div class="left">
                <div class="image">
                    <img src="{{ asset('assets/images/logo_multisari.png') }}" alt="">
                </div>
            </div>
            <div class="right">
                <div class="clinic">
                    <p>
                        KLINIK PRATAMA MULTISARI II <br>
                    </p>
                </div>
                <div class="addres" style="margin-top: -10px">
                    <p>
                        Jl. Jepara-Kudus, Ruko Safira Regency
                        Desa Sengonbugel RT. 03 RW. 01,
                        Kec. Mayong, Kab. Jepara
                    </p>
                </div>
                <div class="telp" style="margin-top: -10px">
                    <p>(0291) 7520234, e-mail : klinikmultisari@gmail.com</p>
                </div>
            </div>
        </div>
        <hr class="divider">
        <hr class="divider-2">
        
        <div class="judul">
            <p>Poli Gigi/Laporan Data Kunjungan Pasien Umum</p>
            <div class="kalimat">
                <p>FASKES : KLINIK PRATAMA MULTISARI II</p>
                <p style="margin-top: -10px">{{ $filterInfo }}</p>
            </div>
        </div>
    
        <table border="1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>No. RM</th>
                    <th>Nama Pasien</th>
                    <th>Jenis Pasien</th>
                    <th>Tanggal Lahir</th>
                    <th>Pasien Umum</th>
                    <th>Harga</th>
                    <th>Nomor NIK</th>
                    <th>Nomor HP</th>
                    <th>Pekerjaan</th>
                    <th>Nama KK</th>
                    <th>Alamat</th>
                    <th>Keluhan (S)</th>
                    <th>Pemeriksaan (O)</th>
                    <th>Diagnosa (A)</th>
                    <th>Tindakan (P)</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @if (count($data) === 0)
                    <tr>
                        <td colspan="5" style="text-align: center"></td>
                    </tr>
                @else
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ date_format(date_create($item->created_at), 'd-m-Y') }}</td>
                            <td>{{ date_format(date_create($item->created_at), 'H:i:s') }}</td>
                            <td>{{ $item->pasien->no_rm }}</td>
                            <td>{{ $item->pasien->nama_pasien }}</td>
                            <td>{{ $item->pasien->jenis_pasien }}</td>
                            <td>{{ $item->pasien->tgllahir }}</td>
                            <td>{{ $item->poli->namapoli }}</td>
                            <td>{{ $item->harga_keseluruhan }}</td>
                            <td>{{ $item->pasien->nik }}</td>
                            <td>{{ $item->pasien->noHP }}</td>
                            <td>{{ $item->pasien->pekerjaan }}</td>
                            <td>{{ $item->pasien->nama_kk }}</td>
                            <td>{{ $item->pasien->alamat_asal }}</td>
                            <td>{{ $item->keluhan_utama }}</td>
                            <td>
                                Tensi: {{ $item->p_tensi }},
                                RR: {{ $item->p_rr }},
                                Nadi: {{ $item->p_nadi }},
                                SpO2: {{ $item->spo2 }},
                                Suhu: {{ $item->p_suhu }},
                                TB: {{ $item->p_tb }},
                                BB: {{ $item->p_bb }}
                            </td>
                            <td>
                                Diagnosa Primer : {{ $item->soap_a_primer }}
                                Diagnosa Sekunder : {{ $item->soap_a_sekunder }}
                            </td>
                            <td>{{ $item->edukasi }}</td>
                            <td>{{ $item->rujuk }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</body>
</html>
