<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cetak Antrian</title>
    <style>
        /* Atur ukuran thermal (58mm) */
        @media print {
            @page {
                size: 58mm auto;
                margin: 5mm;
                margin-top: 0;
                margin-bottom: 0;
            }

            body {
                width: 58mm;
                margin: 0 !important;
                padding: 0 !important;
                box-sizing: border-box;
                height: auto !important;
                min-height: 0 !important;
            }

            /* Hilangkan header/footer browser */
            html,
            body {
                margin: 0 !important;
                padding: 0 !important;
            }
        }

        body {
            width: 58mm;
            margin: 0;
            padding: 5mm;
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.2;
            box-sizing: border-box;
            overflow: hidden;
        }

        .container {
            width: 100%;
            text-align: center;
        }

        img {
            max-width: 50px;
            /* Dikurangi untuk efisiensi */
            margin: 5px auto;
            display: block;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        p {
            margin: 3px 0;
            padding: 0;
            line-height: 1.2;
            word-break: break-word;
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        h1 {
            font-size: 14px;
            font-weight: bold;
        }

        h2,
        h3 {
            font-size: 13px;
        }

        h4 {
            font-size: 12px;
        }

        h5,
        p {
            font-size: 11px;
        }

        .antrian-number {
            font-size: 36px;
            font-weight: bold;
            margin: 8px 0;
        }

        .thankyou {
            margin-top: 8px;
            font-size: 11px;
        }

        * {
            box-sizing: border-box;
        }
    </style>
</head>

<body onload="window.print(); setTimeout(() => { window.close(); }, 1000);">
    <div class="container">
        <img src="{{ asset('assets/images/logo_multisari.png') }}" alt="Logo">
        <h1>Klinik Pratama Multisari II</h1>
        <h5>Jl. Jepara-Kudus, Ruko Safira Regency,</h5>
        <h5>Desa Sengonbugel RT. 03 RW. 01,</h5>
        <h5>Kab. Jepara</h5>
        <h5>Telp: (0291) 7520234</h5>
        <div class="antrian-number">{{ $pasien->kode_antrian }}</div>
        <h3>Poli {{ $pasien->poli->namapoli }}</h3>
        <h5>{{ $date }} | {{ $time }}</h5>
        <p>Sedang Dilayani: {{ $layani }}, Sisa: {{ $sisa_urutan }}</p>
        <div class="thankyou">
            <h4>Terimakasih Kunjungannya</h4>
            <h4>Semoga Sehat Selalu</h4>
        </div>
    </div>
</body>

</html>
