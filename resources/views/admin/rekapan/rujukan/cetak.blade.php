<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rujukan ke Rumah sakit ( FKTRL)</title>
    
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
            <p>FORM PERLAPORAN RUJUKAN KE RUMAH SAKIT (FKTRL)</p>
            <div class="kalimat">
                <p>FASKES : KLINIK PRATAMA MULTISARI II</p>
                <p style="margin-top: -10px">{{ $filterInfo }}</p>
            </div>
        </div>

        <table border="1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Kunjungan</th>
                    <th>Tanggal Pelayanan</th>
                    <th>Tanggal Entri</th>
                    <th>No. Kartu</th>
                    <th>Nama Peserta</th>
                    <th>Jenis Kelamin</th>
                    <th>Diagnosa</th>
                    <th>Dirujuk</th>
                    {{-- <th>Poli</th> --}}
                </tr>
            </thead>
            <tbody>
                @if (count($data) === 0)
                    <tr>
                        <td colspan="9" style="text-align: center">Tidak Ada Data</td>
                    </tr>
                @else
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->pasien->no_rm }}</td>
                            <td>{{ date_format(date_create($item->created_at), 'd-m-Y') }}</td>
                            <td>{{ date_format(date_create($item->created_at), 'd-m-Y / H:i:s') }}</td>
                            <td>{{ $item->pasien->bpjs }}</td>
                            <td style="text-transform: uppercase">{{ $item->pasien->nama_pasien }}</td>
                            <td>{{ $item->pasien->jekel }}</td>
                            <td>{{ $item->soap_a_primer }}, {{ $item->soap_a_sekunder }}</td>
                            <td>{{ $item->rujuk }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</body>
</html>
