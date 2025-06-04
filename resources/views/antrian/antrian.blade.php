<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('assets/images/logo_multisari.png') }}" rel="icon">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <title>Antrian</title>

    <style>
        body {
            height: 100%;
            margin: 0;
            font-family: 'Open Sans', sans-serif;
            display: flex;
            flex-direction: column;
            background-color: rgba(31, 125, 108, 0.95);
        }

        .container-fluid {
            width: 100%;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .container-fluid {
                width: 80%;
            }
        }

        .header {
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(to right top, #008B8B, rgba(98, 231, 207, 1));
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 999;
        }

        .header img {
            width: 100px;
            margin-right: 10px;
        }

        .header h4 {
            margin: 0;
            font-weight: bold;
            font-family: 'Open Sans', sans-serif;
            color: white;
        }

        @media screen and (min-width: 1024px) {
            body {
                zoom: 75%;
            }
        }

        .header .date-time {
            text-align: right;
            color: white;
        }

        .header .date-time .tanggal,
        .header .date-time .jam {
            margin: 0;
            padding: 0;
            color: white;
        }

        .header .date-time .jam h1 {
            font-weight: bold;
            font-size: 20px;
        }

        .main-container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            margin-top: 110px;
            gap: 20px;
            padding: 10px;
            box-sizing: border-box;
        }

        .video-container {
            width: 100%;
            max-width: 670px;
            background: #FFF;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
        }

        .info-container {
            width: 100%;
            max-width: 600px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .info-box {
            width: 100%;
            background: #008B8B;
            min-height: 110px;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
        }

        .inpo-boxs {
            width: 100%;
            background: #fff;
            border-radius: 8px;
            padding: 10px;
            min-height: 200px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
        }

        .table-responsive {
            width: 100%;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .info-table thead {
            background-color: #008B8B;
            color: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .info-table th,
        .info-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .info-table tr:nth-child(even) {
            background-color: #f2f2f2;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .video-container video,
        .video-container img {
            width: 100%;
            height: auto;
        }

        #stats-container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 20px;
            padding: 10px;
            box-sizing: border-box;
            margin-bottom: 80px;
        }

        #stats-container>div {
            flex: 1 1 200px;
            max-width: 280px;
            text-align: center;
            max-height: 150px;
            background: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.3s ease;
            box-sizing: border-box;
        }

        #stats-container>div:hover {
            transform: translateY(-10px);
        }

        #stats-container>div p {
            margin: auto;
            font-size: 20px;
            font-weight: bold;
            margin-top: -20px;
        }

        #stats-container>div p:first-child {
            font-weight: bold;
            color: #008B8B;
            font-size: 80px;
            margin-bottom: 0px;
            margin-top: -30px;
        }

        .footer {
            width: 100%;
            position: fixed;
            bottom: 0;
            left: 0;
            background-color: #008B8B;
            color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 10px 0;
        }

        .marquee {
            display: block;
            white-space: nowrap;
            overflow: hidden;
            box-sizing: border-box;
        }

        .marquee span {
            display: inline-block;
            padding-left: 100%;
            animation: marquee 25s linear infinite;
        }

        @keyframes marquee {
            from {
                transform: translate(0, 0);
            }

            to {
                transform: translate(-100%, 0);
            }
        }

        .table-responsive {
            height: 200px;
            /* Sesuaikan tinggi container */
            overflow: hidden;
            position: relative;
        }

        @keyframes scroll-up {
            0% {
                transform: translateY(100%);
            }

            100% {
                transform: translateY(-100%);
            }
        }

        .info-table tbody {
            display: block;
            animation: scroll-up 10s linear infinite;
            position: relative;
            top: 0;
        }

        .info-table thead,
        .info-table tbody tr {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .info-table thead {
            position: sticky;
            top: 0;
            z-index: 1;
        }
    </style>

</head>

<body>
    <div class="container-fluid">
        <header class="header">
            <div class="welcome">
                <div class="icon">
                    <img src="{{ asset('assets/images/logo_multisari.png') }}" alt="Logo" style="width: 50px">
                </div>
            </div>
            <h4 style="color: white">KLINIK PRATAMA<span style="color: #FFE033"> MULTISARI II</span></h4>
            <div class="date-time">
                <div class="tanggal" id="tanggal"></div>
                <div class="jam" id="jam"></div>
            </div>
        </header>
        <div class="main-container row">
            <div class="video-container col-lg-6 col-md-12">
                <div id="videoContainer">
                    @foreach ($video as $item)
                        @if (pathinfo($item->video_path, PATHINFO_EXTENSION) == 'mp4')
                            <video id="video{{ $loop->index }}" class="mediaItem videoPlayer" controls>
                                <source src="{{ asset('storage/' . $item->video_path) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @else
                            <img src="{{ asset('storage/' . $item->video_path) }}" class="mediaItem"
                                alt="Uploaded Image">
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="info-container col-lg-6 col-md-12">
                <div class="info-box">
                    <strong>
                        <h4 style="color: white">Informasi<span style="color: #FFE033"> Terkini?
                    </strong></span></h4>
                    <div id="infoContent">
                        <!-- Konten tambahan bisa Anda tambahkan di sini -->
                    </div>
                </div>
                <div class="inpo-boxs">
                    <strong>
                        <h4 style="color: #008B8B">Daftar<span style="color: #FFE033"> Antrian Pasien
                    </strong></span></h4>
                    <div id="inpoContent2">
                        <div class="table-responsive">
                            <table class="info-table table table-striped">
                                <thead>
                                    <tr>
                                        {{-- <th>No. Antrian</th> --}}
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data->isEmpty())
                                        <tr>
                                            {{-- <td>-</td> --}}
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                        </tr>
                                    @else
                                        @foreach ($data as $item)
                                            <tr class="text-center">
                                                {{-- <td>{{ $item->antrianDokter }}</td> --}}
                                                <td>{{ $item->booking->pasien->nama_pasien }}</td>
                                                @if ($item->booking->pasien->jekel)
                                                    <td>{{ $item->booking->pasien->jekel ?? 'Perempuan' }}</td>
                                                @else
                                                    <td>{{ $item->booking->pasien->jekel ?? 'Laki-laki' }}</td>
                                                @endif
                                                </td>
                                                {{-- <td>{{ \Carbon\Carbon::parse($item->booking->pasien->tgllahir)->age }}
                                                    Tahun</td> --}}
                                                <td>{{ $item->booking->pasien->alamat_asal }}</td>
                                                <td>
                                                    @switch($item->status)
                                                        @case('D')
                                                            Datang
                                                        @break

                                                        @case('B')
                                                            Periksa
                                                        @break

                                                        @case('P')
                                                            Obat
                                                        @break

                                                        @default
                                                            Pendaftaran
                                                    @endswitch
                                                </td>

                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="stats-container">
            <div id="total">
                <p class="totalPasien">{{ $totalHariIni }}</p>
                <p id="pasientotal">Total Pasien</p>
            </div>
            {{-- <div id="perawat">
                <p id="nomorAntrianPerawat">{{ $nomorAntrianPerawat }}</p>
                <p class="namePerawat">Perawat</p>
            </div> --}}
            <div id="umum">
                <p id="nomorAntrianUmum">
                    {{ $nomorAntrianUmum }}
                </p>
                <p class="namePoli">Poli Umum</p>
            </div>
            <div id="gigi">
                <p id="nomorAntrianGigi">
                    {{ $nomorAntrianGigi }}
                </p>
                <p class="namePoli">Poli Gigi</p>
            </div>
            <div id="obat">
                <p id="nomorAntrianObat">{{ $nomorAntrianObat }}</p>
                <p class="nameObat">Ruang Farmasi</p>
            </div>
        </div>
        <footer class="footer">
            <div class="marquee">
                <span>Selamat datang di klinik multisari II | Jl. Raya Jepara Kudus</span>
            </div>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/antrian.script.js') }}"></script>
    <script>
        $(document).ready(function() {
            function reloadContent() {
                $.ajax({
                    url: window.location.href,
                    type: 'GET',
                    success: function(response) {
                        $('#capek').html($(response).find('#capek').html());
                    },
                    complete: function() {
                        setTimeout(reloadContent, 1000);
                    }
                });
            }
            setTimeout(reloadContent, 1000);

            function updateClock() {
                var now = new Date();
                var tanggalElement = document.getElementById('tanggal');
                var options = {
                    weekday: 'short',
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                };
                tanggalElement.innerHTML = '<h6>' + now.toLocaleDateString('id-ID', options) + '</h6>';

                var jamElement = document.getElementById('jam');
                var jamString = now.getHours().toString().padStart(2, '0') + ':' +
                    now.getMinutes().toString().padStart(2, '0');
                jamElement.innerHTML = '<h1>' + jamString + '</h1>';
            }
            setInterval(updateClock, 1000);
            updateClock();

            var currentIndex = 0;
            var mediaItems = document.querySelectorAll("#videoContainer .mediaItem");

            function showMediaItem(index) {
                mediaItems.forEach(function(item, i) {
                    item.classList.remove('active');
                    item.style.display = 'none';
                });
                mediaItems[index].style.display = 'block';
                setTimeout(function() {
                    mediaItems[index].classList.add('active');
                }, 50);
            }

            function playNextMediaItem() {
                var currentMediaItem = mediaItems[currentIndex];
                if (currentMediaItem.tagName === 'VIDEO') {
                    currentMediaItem.pause();
                }
                currentIndex = (currentIndex + 1) % mediaItems.length;
                var nextMediaItem = mediaItems[currentIndex];
                showMediaItem(currentIndex);

                if (nextMediaItem.tagName === 'VIDEO') {
                    nextMediaItem.play().catch(function(error) {
                        console.log("Autoplay error:", error);
                    });
                    nextMediaItem.addEventListener('ended', playNextMediaItem, {
                        once: true
                    });
                } else {
                    setTimeout(playNextMediaItem, 5000);
                }
            }

            showMediaItem(currentIndex);

            var currentMediaItem = mediaItems[currentIndex];
            if (currentMediaItem.tagName === 'VIDEO') {
                currentMediaItem.play().catch(function(error) {
                    console.log("Autoplay error:", error);
                });
                currentMediaItem.addEventListener('ended', playNextMediaItem, {
                    once: true
                });
            } else {
                setTimeout(playNextMediaItem, 5000);
            }
        });

        function handleClick(type) {
            console.log("Clicked on", type);
            // You can add more functionality here based on which element is clicked
        }

        // JavaScript
        // const statCards = document.querySelectorAll('#stats-container > div');

        // statCards.forEach(card => {
        //     card.addEventListener('click', () => {
        //         alert(`You clicked on ${card.querySelector('p:first-child').textContent}`);
        //     });
        // });
    </script>

</body>

</html>
