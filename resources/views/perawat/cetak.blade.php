<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Antrian</title>
</head>
<style>
    .container .top .image {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 30px;
    }
    .container .top .image img {
        width: 150px;
    }
    .container .top .clinic h1{
        text-align: center;
        font-size: 30px;
    }
    .container .top .addres h2 {
        text-align: center;
        font-size: 24px;
    }
    .container .top .telp h2 {
        text-align: center;
        font-size: 24px;
        margin-top: -10px;
    }
    .container .middle .antrian h1 {
        text-align: center;
        font-size: 130px;
        margin-top: -20px;
        margin-bottom: 10px;
    }
    .container .middle .poli h3 {
        text-align: center;
        font-size: 24px;
        margin-top: -5px;
    }
    .container .bottom .kunjungan h5 {
        text-align: center;
        font-size: 24px;
        margin-top: -10px;
    }
    .container .bottom .people p {
        text-align: center;
        font-size: 24px;
        margin-top: -20px;
    }
    .container .bottom h4 {
        text-align: center;
        font-size: 30px;
        margin-top: -10px;
    }

</style>
<body>
    <section class="antrian">
        <div class="container">
            <div class="top">
                <div class="image">
                    <img src="{{ asset('assets/images/logo_multisari.png') }}" alt="">
                </div>
                <div class="clinic">
                    <h1>
                        Klinik Pratama Multisari II <br>
                        Kabupaten Jepara
                    </h1>
                </div>
                <div class="addres">
                    <h2>
                        Jl. Jepara-Kudus, Ruko Safira Regency
                        Desa Sengonbugel RT. 03 RW. 01,
                        Kec. Mayong, Kab. Jepara
                    </h2>
                </div>
                <div class="telp">
                    <h2>(0291) 7520234</h2>
                </div>
            </div>
            <div class="middle">
                <div class="antrian">
                    <h1>{{ $pasien->kode_antrian }}</h1>
                </div>
                <div class="poli">
                    <h3>Poli {{ $pasien->poli->namapoli }}</h3>
                </div>
            </div>
            <div class="bottom">
                <div class="kunjungan">
                    <div class="date">
                        <h5>{{ $date }} | {{ $time }}</h5>
                    </div>
                </div>
                <div class="people">
                    <div class="dilayani">
                        <p>Sedang Dilayani : {{ $layani }}, Sisa : {{ $sisa_urutan }}</p>
                    </div>
                </div>
                <h4>Terimakasih Kunjungannya <br>
                Semoga Sehat Selalu</h4>
            </div>
        </div>
    </section>

<script>
    window.print();
</script>
</body>
</html>
