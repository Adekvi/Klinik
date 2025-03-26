<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Kunjungan Pasien Umum</title>
    
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
    <div class="container">
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
            <p>Poli Umum/Laporan Data Kunjungan Pasien Umum</p>
            <div class="kalimat">
                <p>FASKES : KLINIK PRATAMA MULTISARI II</p>
                <p style="margin-top: -10px">{{ $filterInfo }}</p>
            </div>
        </div>
        <table border="1">
            <thead>
                <tr>
                    <th>Tanggal Ambil Obat</th>
                    <th>No. RM</th>
                    <th>Nama Pasien</th>
                    <th>Jenis Pasien</th>
                    <th>Poli</th>
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
                            <td>{{ date_format(date_create($item->created_at), 'H:i:s / d-m-Y') }}</td>
                            <td>{{ $item->booking->pasien->no_rm }}</td>
                            <td>{{ $item->booking->pasien->nama_pasien }}</td>
                            <td>{{ $item->booking->pasien->jenis_pasien }}</td>
                            <td>{{ $item->soap->poli->namapoli }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</body>
</html>
