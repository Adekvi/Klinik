@extends('admin.layout.dasbrod')
@section('title', 'Admin | Data Pasien Sehat')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5 style="margin-bottom: 20px"><strong>Pasien Sehat</strong></h5>
                        {{-- <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#tambahpasien"><i class="bi bi-plus-lg"></i> Tambah Pasien</button> --}}
                        <button type="button" class="btn btn-danger rounded-pill" id="exportToPcare"><i
                                class="bi bi-share-lg"></i> Export to PCare</button>
                    </div>
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered"
                            style="width:100%; margin-top: 10px;">
                            <thead class="table-primary" style="text-align: center; white-space: nowrap">
                                <tr>
                                    <th>No</th>
                                    <th>Pilih</th>
                                    <th>Tanggal Kunjungan</th>
                                    <th>Tanggal Entri</th>
                                    <th>No. Kartu</th>
                                    <th>Nama Pasien</th>
                                    <th>Kegiatan</th>
                                    {{-- <th>Status</th> --}}
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sehat as $index => $item)
                                    <tr>
                                        <td>{{ $sehat->firstItem() + $index }}</td>
                                        <td style="text-align: center">
                                            <input type="checkbox" class="pilih" data-id="{{ $item->id }}">
                                        </td>
                                        <td>{{ $item->tgl_kunjungan }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        @if (!empty($item->pasien->bpjs))
                                            <td>{{ $item->pasien->bpjs }}</td>
                                            <td>{{ $item->pasien->nama_pasien }}</td>
                                        @else
                                            <td>{{ $item->noKartu }}</td>
                                            <td>{{ $item->nama_pasien }}</td>
                                        @endif
                                        <td>{{ $item->kegiatan }}</td>
                                        <td>
                                            <div class="aksi d-flex">
                                                <button type="button" class="btn btn-danger mx-2" data-bs-toggle="modal"
                                                    data-bs-target="#hapusumum"><i class="fas fa-trash"></i> Hapus</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $sehat->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap4.css">
@endpush

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap4.js"></script>
    <script>
        new DataTable('#example');

        $(document).ready(function() {
            $('#exportToPcare').click(function() {
                var selectedIds = [];
                $('.pilih:checked').each(function() {
                    selectedIds.push($(this).data('id'));
                });

                // Kirim data yang dipilih ke PCare
                // Misalnya, dengan menggunakan Ajax
                $.ajax({
                    url: '{{ url('/admin/pasien-sehat/eksporToPcare') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        ids: selectedIds
                    },
                    success: function(response) {
                        // Tampilkan pesan sukses atau lakukan tindakan lain jika diperlukan
                        alert('Data berhasil diekspor ke PCare');
                    },
                    error: function(xhr, status, error) {
                        // Tangani kesalahan jika terjadi
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endpush
