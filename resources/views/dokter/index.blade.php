@extends('layout.home')
@section('title', 'Dokter')
@section('content')

<div class="tb-dokter" style="margin-top: 50px">
    <table id="example" class="table table-striped table-bordered" style="width:100%;">
        <thead>
            <tr>
                <th>No</th>
                <th>No. RM</th>
                <th>Poli</th>
                <th>Nama Pasien</th>
                <th>Keluhan</th>
                <th>Riwayat Penyakit Sekarang</th>
                <th>Riwayat Penyakit Terdahulu</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($anamnesis as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item['pasien']['no_rm'] }}</td>
                <td>{{ $item['poli']['namapoli'] }}</td>
                <td>{{ $item['pasien']['nama_pasien'] }}</td>
                <td>{{ $item['a_keluhan_utama'] }}</td>
                <td>{{ $item['a_riwayat_penyakit_skrg'] }}</td>
                <td>{{ $item['a_riwayat_penyakit_terdahulu'] }}</td>
                <td>
                    <a href="{{ url('dokter/soap/' . $item['id'] ) }}"
                        class="btn btn-primary rounded-pill" >Soap</a>
                    <button type="button" class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#hapuspasien">
                        Hapus
                    </button>
                </td>
            </tr>
            @endforeach

    </table>
</div>

@endsection
@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
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
</script>
@endpush