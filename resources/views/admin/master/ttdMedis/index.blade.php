@extends('admin.layout.dasbrod')
@section('title', 'Admin | Tanda Tangan Medis')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5 style="margin-bottom: 20px"><strong>TTD Tenaga Medis</strong></h5>
                        <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal"
                            data-bs-target="#poto"><i class="bi bi-plus-lg"></i>Tambah TTD</button>
                    </div>
                    <div class="tb-umum">
                        <table id="example" class="table table-striped table-bordered"
                            style="width:100%; text-align: center">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ttd as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            @if (!$item->foto)
                                                -
                                            @else
                                            @endif
                                        </td>
                                        <td>{{ $item->nama }}</td>
                                        <td>
                                            <form method="POST" action="{{ url('status-ttd') }}" style="display: inline;">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <div class="piket">
                                                    <label class="switch">
                                                        <input type="checkbox" name="status"
                                                            id="status_{{ $item->id }}" onchange="this.form.submit()"
                                                            @if ($item->status) checked @endif>
                                                        <span class="slider"></span>
                                                    </label>
                                                    <div class="status-text">
                                                        <span
                                                            id="statusText">{{ $item->status ? 'Aktif' : 'Non-Aktif' }}</span>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="aksi d-flex justify-content-center">
                                                <button class="btn btn-primary"
                                                    data-bs-target="#editpoli{{ $item->id }}" data-bs-toggle="modal"><i
                                                        class="fas fa-info"></i> Edit</button>
                                                <button type="button" class="btn btn-danger mx-2" data-bs-toggle="modal"
                                                    data-bs-target="#hapuspoli{{ $item->id }}"><i
                                                        class="fa fa-trash"></i> Hapus</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.master.ttdMedis.modaltambah')
    @include('admin.master.ttdMedis.modaledit')
    @include('admin.master.ttdMedis.modalhapus')
@endsection

<!-- Modal -->
<div id="imageModal"
    style="display: none; position: fixed; z-index: 1; left: 0; top: 15%; width: 100%; height: auto%; overflow: auto;">
    <span onclick="closeModal()"
        style="position: absolute; top: 10px; right: 25px; color: #fff; font-size: 35px; font-weight: bold; cursor: pointer;">&times;</span>
    <img id="modalImage" style="margin: auto; display: block; width: 80%; max-width: 700px;">
</div>

@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap4.css">
    <style>
        /* Flexbox untuk vertical center */
        .piket {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Switch wrapper */
        .switch {
            position: relative;
            display: inline-block;
            width: 55px;
            height: 28px;
        }

        /* Hide checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* Slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #d2d2d2;
            transition: 0.4s;
            border-radius: 34px;
        }

        /* Slider circle */
        .slider::before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        /* When checked */
        .switch input:checked+.slider {
            background-color: #007bff;
            /* Biru lebih enak */
        }

        /* Geser bulatan */
        .switch input:checked+.slider::before {
            transform: translateX(26px);
        }

        /* Status text */
        .status-text {
            margin-top: 8px;
            font-weight: 600;
            color: #555;
            font-size: 14px;
        }

        .swal2-container {
            z-index: 9999 !important;
        }
    </style>
@endpush
@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap4.js"></script>

    <script>
        new DataTable('#example');

        // Ambil elemen input file
        var inputFoto = document.getElementById('exampleInputFoto');

        // Tambahkan event listener untuk 'change' event
        inputFoto.addEventListener('change', function(event) {
            // Ambil nama file yang dipilih
            var namaFile = event.target.files[0].name;

            // Tampilkan nama file di dalam elemen dengan id 'namaFoto'
            document.getElementById('foto').textContent = namaFile;
        });

        // foto
        function openModal(imageSrc) {
            var modal = document.getElementById('imageModal');
            var modalImg = document.getElementById('modalImage');
            modal.style.display = 'block';
            modalImg.src = imageSrc;
        }

        function closeModal() {
            var modal = document.getElementById('imageModal');
            modal.style.display = 'none';
        }

        // Close the modal when clicking outside of the image
        window.onclick = function(event) {
            var modal = document.getElementById('imageModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
@endpush
