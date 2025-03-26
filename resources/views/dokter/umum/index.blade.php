@extends('admin.layout.dasbrod')
@section('title', 'Dokter | Periksa Tubuh')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card-title">
                    <div class="judul mt-3">
                        <h4><strong>@yield('title')</strong></h4>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="kembali mb-2" style="display: flex; justify-content: space-between">
                            <a href="{{ url('dokter/soap/' . $antrianDokter->id) }}" class="btn btn-primary"
                                data-toggle="tooltip" data-bs-placement="top" title="Kembali" style>
                                <i class="fa-solid fa-backward"></i> Kembali
                            </a>
                            <div class="date-time d-flex align-items-center gap-2 text-center">
                                <div class="tanggal text-muted" id="tanggal"></div>
                                <div class="jam text-muted" id="jam"></div>
                            </div>
                        </div>
                        <form action="{{ url('dokter/tambah/' . $antrianDokter->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="dokter_id" value="{{ $antrianDokter->dokter_id }}">
                            <input type="hidden" name="pasien_id" value="{{ $antrianDokter->booking->pasien_id }}">
                            <div class="row">
                                <div class="card-body">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th scope="row" style="padding: 4px; text-align: left">
                                                    Tanggal Periksa
                                                </th>
                                                <td style="padding: 4px; width: 20px;">:</td>
                                                <td style="font-weight: bold; padding: 4px;">
                                                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row" style="padding: 4px; text-align: left;">No RM</th>
                                                <td style="padding: 4px; width: 20px;">:</td>
                                                <td style="padding: 4px;">{{ $antrianDokter->booking->pasien->no_rm }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" style="padding: 4px; text-align: left;">Nama Pasien
                                                </th>
                                                <td style="padding: 4px; width: 20px;">:</td>
                                                <td style="padding: 4px;">{{ $antrianDokter->booking->pasien->nama_pasien }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row" style="padding: 4px; text-align: left;">Jenis Pasien
                                                </th>
                                                <td style="padding: 4px; width: 20px;">:</td>
                                                <td style="padding: 4px;">
                                                    {{ $antrianDokter->booking->pasien->jenis_pasien }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row" style="padding: 4px; text-align: left;">Umur</th>
                                                <td style="padding: 4px; width: 20px;">:</td>
                                                <td style="padding: 4px;">
                                                    <?php
                                                    $tgllahir = \Carbon\Carbon::parse($antrianDokter->booking->pasien->tgllahir);
                                                    $umur = $tgllahir->diffInMonths(\Carbon\Carbon::now());
                                                    
                                                    if ($umur < 12) {
                                                        echo $tgllahir->diff(\Carbon\Carbon::now())->format('%m&nbsp;bulan&nbsp;%d&nbsp;hari');
                                                    } else {
                                                        echo $tgllahir->age . '&nbsp;Tahun';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row" style="padding: 4px; text-align: left;">Jenis Kelamin
                                                </th>
                                                <td style="padding: 4px; width: 20px;">:</td>
                                                <td style="padding: 4px;">
                                                    {{ $antrianDokter->booking->pasien->jekel == 'L' ? 'Laki-laki' : ($antrianDokter->booking->pasien->jekel == 'P' ? 'Perempuan' : '') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row" style="padding: 4px; text-align: left;">Alamat
                                                    Domisili</th>
                                                <td style="padding: 4px; width: 20px;">:</td>
                                                <td style="padding: 4px;">{{ $antrianDokter->booking->pasien->domisili }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Kolom Kiri: Gambar -->
                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary"
                                            onclick="showImage('depan')">Depan</button>
                                        <input name="depan" class="form-control mt-2 mb-2" id="depan" rows="2"
                                            placeholder="Belum Ada Catatan">
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary"
                                            onclick="showImage('samping')">Samping</button>
                                        <input name="samping" class="form-control mt-2 mb-2" id="samping" rows="2"
                                            placeholder="Belum Ada Catatan">
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary"
                                            onclick="showImage('belakang')">Belakang</button>
                                        <input name="belakang" class="form-control mt-2 mb-2" id="belakang" rows="2"
                                            placeholder="Belum Ada Catatan">
                                    </div>
                                    <div class="tutup" style="margin-top: 20px; margin-bottom: 30px;">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary ml-1">Simpan</button>
                                    </div>
                                </div>

                                <div class="col-md-6 text-center">
                                    <p style="font-size: 20px; font-weight: bold; margin-top: 10px; margin-bottom: 10px;">
                                        Anatomi
                                        Tubuh Manusia</p>

                                    <img id="displayedImage" src="{{ asset('assets/images/depan.png') }}"
                                        style="max-width: 70%; height: auto; border-radius: 10px;" alt="Kerangka">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        // jam dan tanggal
        function updateClock() {
            var now = new Date();
            var tanggalElement =
                document.getElementById('tanggal');
            var options = {
                weekday: 'short',
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            };
            tanggalElement.innerHTML = '<h6>' + now.toLocaleDateString('id-ID', options) + '</h6>';

            var jamElement = document.getElementById('jam');
            var jamString = now.getHours().toString().padStart(2, '0') + ':' +
                now.getMinutes().toString().padStart(2, '0') + ':' +
                now.getSeconds().toString().padStart(2, '0');
            jamElement.innerHTML = '<h6>' + jamString + '</h6>';
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Function to show image outside modal
        function showImage() {
            var imageUrl = "{{ asset('assets/images/kerangka.png') }}"; // URL of the image
            var imageContainer = document.getElementById("imageContainer"); // Container element to display image
            imageContainer.innerHTML = `<img src="${imageUrl}" alt="Kerangka Image">`; // Insert image into container
        }

        // Add event listener to the button for showing image
        document.getElementById("lihatGambarButton").addEventListener("click", function() {
            showImage();
        });

        function showImage(position) {
            var imageElement = document.getElementById('displayedImage');

            if (position === 'depan') {
                imageElement.src = '{{ asset('assets/images/depan.png') }}';
                imageElement.alt = 'Depan';
            } else if (position === 'samping') {
                imageElement.src = '{{ asset('assets/images/samping.png') }}';
                imageElement.alt = 'Samping';
            } else if (position === 'belakang') {
                imageElement.src = '{{ asset('assets/images/belakang.png') }}';
                imageElement.alt = 'Belakang';
            }
            // Gigi
            else if (position === 'gigi') {
                imageElement.src = '{{ asset('assets/images/atas.png') }}';
                imageElement.alt = 'Gigi';
            } else if (position === 'gigidepan') {
                imageElement.src = '{{ asset('assets/images/gigi_depan.png') }}';
                imageElement.alt = 'Gigidepan';
            } else if (position === 'gigibelakang') {
                imageElement.src = '{{ asset('assets/images/gigi_belakang.png') }}';
                imageElement.alt = 'Gigibelakang';
            }
        }
    </script>
@endpush
