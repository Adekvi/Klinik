<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cetak Antrian</title>
    <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@500&family=Playfair+Display&display=swap"
        rel="stylesheet">
    <style>
        /* Aturan untuk cetak */
        @media print {
            @page {
                size: 58mm auto;
                margin: 3mm;
                margin-top: 0;
                margin-bottom: 0;
            }

            html,
            body {
                width: 58mm;
                margin: 0 !important;
                padding: 0 !important;
                box-sizing: border-box;
                height: auto !important;
                min-height: 0 !important;
            }
        }

        /* Aturan umum */
        body {
            width: 58mm;
            margin: 0;
            padding: 3mm;
            font-family: 'Assistant', Arial, sans-serif;
            font-size: 12px;
            /* Perbaikan dari HX12px */
            line-height: 1.2;
            box-sizing: border-box;
            overflow: hidden;
        }

        .container {
            width: 100%;
            text-align: center;
        }

        .image img {
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

        h2 {
            font-size: 12px;
        }

        h3 {
            font-size: 11px;
        }

        h4 {
            font-size: 10px;
        }

        h5 {
            font-size: 10px;
        }

        .antrian-number {
            font-size: 32px;
            /* Dikurangi untuk efisiensi */
            font-weight: bold;
            margin: 8px 0;
        }

        .note {
            margin-top: 8px;
            font-size: 10px;
        }

        * {
            box-sizing: border-box;
        }
    </style>
</head>

<body onload="window.print(); setTimeout(() => { window.close(); }, 1000);">
    <section class="antrian">
        <div class="container">
            <div class="top">
                <div class="image">
                    <img src="{{ asset('assets/images/logo_multisari.png') }}" alt="Logo">
                </div>
                <div class="clinic">
                    <h1>Klinik Pratama Multisari II</h1>
                </div>
                <div class="addres">
                    <h3>Jl. Jepara-Kudus, Ruko Safira Regency,</h3>
                    <h3>Ds. Sengonbugel RT. 03 RW. 01, Kec. Mayong,</h3>
                    <h3>Kab. Jepara</h3>
                </div>
                <div class="telp">
                    <h3>(0291) 7520234</h3>
                </div>
            </div>
            <div class="middle">
                <h3>No. RM: {{ $antrian->booking->no_rm }}</h3>
                <div class="antrian-number">{{ $antrian->kode_antrian }}</div>
                <h3>Poli {{ $antrian->poli->namapoli }}</h3>
            </div>
            <div class="bottom">
                <h5>{{ $date }} | {{ $time }}</h5>
                <div class="note">
                    <h4>Screenshot bukti pendaftaran <br>untuk diberikan ke perawat.</h4>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
