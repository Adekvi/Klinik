@extends('admin.layout.dasbrod')
@section('title', 'Admin | Display Video')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y mt-4">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="pasien-bpjs">
                    <div class="title">
                        <h5><strong>Display Video Antrian</strong></h5>
                        <button type="button" style="margin-bottom: 20px" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#tambahpoli"><i class="bi bi-plus-lg"></i>Tambah Video</button>
                        <a href="{{ url('/daftar') }}" class="btn btn-primary rounded-pill" style="margin-bottom: 20px; margin-left: 5px;" target="_blank">
                            <i class="antrian"></i> Daftar Antrian
                        </a>
                    </div>
                    <div class="tb-video">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead class="table-primary">
                                <tr>
                                    {{-- <th>Pilih Video</th> --}}
                                    <th>Judul</th>
                                    <th>Video</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($video as $item)
                                    <tr>
                                        <td>{{ $item->title }}</td>
                                        <td>
                                            @if (pathinfo($item->video_path, PATHINFO_EXTENSION) == 'mp4')
                                                <video width="320" height="240" controls>
                                                    <source src="{{ asset('storage/'. $item->video_path ) }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            @else
                                                <img src="{{ asset('storage/'. $item->video_path ) }}" alt="Uploaded Image" width="320" height="240">
                                            @endif
                                        </td>
                                        <td>
                                            <div class="aksi d-flex">
                                                <button class="btn btn-primary" data-bs-target="#editpoli{{ $item->id }}" data-bs-toggle="modal"><i class="fas fa-info"></i>Edit</button>
                                                <button type="button" class="btn btn-danger mx-2" data-bs-toggle="modal" data-bs-target="#hapusvideo{{ $item->id }}">Hapus</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Div untuk menampilkan video yang dipilih -->
                        <div id="videoContainer"></div>
                    </div>
            </div>
        </div>
    </div>
</div>

@include('admin.master.datavideo.modaltambah')
@include('admin.master.datavideo.modaledit')
@include('admin.master.datavideo.modalhapus')
@endsection
@push('style')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap4.css">
@endpush
@push('script')
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap4.js"></script>
{{-- <script>
    new DataTable('#example');
       $(document).ready(function() {
            // Tangani peristiwa klik pada checkbox
            $('.pilihVideo').change(function() {
                // Buat array untuk menyimpan URL video yang dipilih
                var selectedVideos = [];
                
                // Loop melalui setiap checkbox
                $('.pilihVideo').each(function() {
                    // Jika checkbox tersebut dicentang, tambahkan URL video ke dalam array selectedVideos
                    if ($(this).is(':checked')) {
                        selectedVideos.push($(this).attr('data-src')); // Menggunakan attr('data-src') untuk mendapatkan nilai atribut data-src
                    }
                });

                // Simpan selectedVideos dalam session Laravel
                $.ajax({
                    method: 'POST',
                    url: '/simpan-video',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: { selectedVideos: selectedVideos },
                    success: function(response) {
                        console.log('Data disimpan dalam session.');
                    },
                    error: function(xhr, status, error) {
                        console.error('Terjadi kesalahan saat menyimpan data dalam session.');
                    }
                });
            });
        });

</script> --}}
@endpush
