<x-admin.layout.terminal title="Admin | Display Video">

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="title">
                        <h5><strong>Display Video Antrian</strong></h5>
                        <button type="button" style="margin-bottom: 20px" class="btn btn-primary rounded-pill"
                            data-bs-toggle="modal" data-bs-target="#tambahpoli"><i class="bi bi-plus-lg"></i>Tambah
                            Video</button>
                        <a href="{{ url('/daftar') }}" class="btn btn-primary rounded-pill"
                            style="margin-bottom: 20px; margin-left: 5px;" target="_blank">
                            <i class="antrian"></i> Daftar Antrian
                        </a>
                    </div>
                    <div class="tb-video">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Video</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($video as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>
                                            @if (pathinfo($item->video_path, PATHINFO_EXTENSION) == 'mp4')
                                                <video width="320" height="240" controls>
                                                    <source src="{{ asset('storage/' . $item->video_path) }}"
                                                        type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            @else
                                                <img src="{{ asset('storage/' . $item->video_path) }}"
                                                    alt="Uploaded Image" width="320" height="240">
                                            @endif
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ url('updateStatus') }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <div class="piket">
                                                    <input type="checkbox" name="status"
                                                        id="status_{{ $item->id }}" onchange="this.form.submit()"
                                                        {{ $item->status == 'Aktif' ? 'checked' : '' }}>

                                                    <label for="status_{{ $item->id }}" class="button"></label>

                                                    <div class="status-text">
                                                        <span id="statusText">
                                                            {{ $item->status == 'Aktif' ? 'Aktif' : 'Nonaktif' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="aksi d-flex">
                                                <button class="btn btn-primary"
                                                    data-bs-target="#editpoli{{ $item->id }}"
                                                    data-bs-toggle="modal"><i class="fas fa-info"></i> Edit</button>
                                                <button type="button" class="btn btn-danger mx-2"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#hapusvideo{{ $item->id }}">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
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

    @push('style')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap4.css">
        <style>
            /* Menyusun elemen dengan flexbox secara vertikal */
            .piket {
                display: flex;
                flex-direction: column;
                /* Menyusun elemen secara vertikal */
                align-items: center;
                /* Menyusun elemen di tengah secara horizontal */
            }

            /* Tampilan tombol */
            .button {
                width: 55px;
                height: 25px;
                background-color: #d2d2d2;
                border-radius: 200px;
                cursor: pointer;
                position: relative;
            }

            .button::before {
                position: absolute;
                content: "";
                width: 15px;
                height: 15px;
                background-color: #fff;
                border-radius: 200px;
                margin: 5px;
                transition: 0.2s;
            }

            input:checked+.button {
                background-color: rgb(0, 227, 30);
            }

            input:checked+.button::before {
                transform: translateX(30px);
            }

            /* Menyembunyikan input checkbox */
            input {
                display: none;
            }

            /* Status text berada di bawah tombol */
            .status-text {
                margin-top: 10px;
                /* Memberikan jarak antara tombol dan status text */
                font-weight: bold;
                color: #333;
            }

            .swal2-container {
                z-index: 9999 !important;
            }
        </style>
    @endpush

    @push('script')
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap4.js"></script>
    @endpush

</x-admin.layout.terminal>
