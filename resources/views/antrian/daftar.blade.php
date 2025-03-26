<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Antrian</title>
    
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
    .container .bawah h4 {
        text-align: center;
        font-size: 30px;
        margin-top: 20px;
    }
    .patients-container {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    .patient-card {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 10px;
        margin: 10px;
        width: 18%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .patient-card .middle, .patient-card .bottom {
        text-align: center;
        margin-bottom: 10px;
    }

    .patient-card .middle .antrian h1 {
        font-size: 2em;
        margin: 0;
    }

    .patient-card .middle .poli h3 {
        font-size: 1.2em;
        margin: 0;
    }

    .patient-card .bottom .kunjungan .date h5 {
        font-size: 1em;
        margin: 0;
    }

    .patient-card .bottom h4 {
        font-size: 1em;
        margin: 0;
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
            <div class="atas">
                <h1 style="text-align: center">Daftar Antrian Pasien</h1>
            </div>
            <div class="patients-container">
                @foreach ($pasien as $key => $item)
                    @if ($key < 6)
                        <div class="patient-card">
                            <div class="middle">
                                <div class="antrian">
                                    <h1>{{ $item->kode_antrian }}</h1>
                                </div>
                                <div class="poli">
                                    <h3>Poli {{ $item->poli->namapoli }}</h3>
                                </div>
                            </div>
                            <div class="bottom">
                                <div class="kunjungan">
                                    <div class="date">
                                        <h5>{{ $date[$key] }} | {{ $time[$key] }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>  
            <div class="bawah">
                <h4>Terimakasih Kunjungannya <br>
                    Semoga Sehat Selalu</h4>
            </div>          
        </div>
    </section>

    {{-- Export foto ke jpg/png --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script> --}}
    <script>
        // // Fungsi untuk melakukan render dan penyimpanan gambar
        // function exportToImage() {
        //     // Menggunakan html2canvas untuk merender konten halaman
        //     html2canvas(document.querySelector('.container')).then(canvas => {
        //         // Mengonversi canvas menjadi data URL gambar (png)
        //         const dataURL = canvas.toDataURL('image/png');
    
        //         // Mengirim data URL gambar ke server untuk disimpan
        //         const xhr = new XMLHttpRequest();
        //         xhr.open('POST', '/simpan-daftar-antrian', true); // Sesuaikan endpoint dengan yang Anda gunakan di server
        //         xhr.setRequestHeader('Content-Type', 'application/json');
        //         xhr.onreadystatechange = function() {
        //             if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        //                 console.log('Gambar berhasil disimpan:', JSON.parse(xhr.responseText).url);
        //             }
        //         };
        //         xhr.send(JSON.stringify({ image: dataURL }));
        //     });
        // }
    
        // // Panggil fungsi exportToImage saat halaman dimuat
        // window.onload = function() {
        //     exportToImage();
        // };
    </script>   

</body>
</html>
