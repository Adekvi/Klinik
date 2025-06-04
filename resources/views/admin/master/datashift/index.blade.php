@extends('admin.layout.dasbrod')
@section('title', 'Admin | Data Master Shift')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5 style="margin-bottom: 20px"><strong>Master Shift</strong></h5>
                        {{-- <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal"
                            data-bs-target="#poto"><i class="bi bi-plus-lg"></i>Tambah Margin</button> --}}
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Shift</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($shift as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $item->nama_shift }}
                                        </td>
                                        <td>{{ $item->jam_mulai ?? '-' }}</td>
                                        <td>{{ $item->jam_selesai ?? '-' }}</td>
                                        <td>
                                            <form method="POST" action="{{ url('updateStatus-shift') }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">

                                                <div class="piket">
                                                    <!-- Checkbox toggle -->
                                                    <input type="checkbox" name="status" id="status_{{ $item->id }}"
                                                        onchange="this.form.submit()"
                                                        {{ $item->status === 'Aktif' ? 'checked' : '' }}>
                                                    <label for="status_{{ $item->id }}" class="button"></label>

                                                    <!-- Label status -->
                                                    <div class="status-text">
                                                        <span>{{ $item->status === 'Aktif' ? 'Aktif' : 'Nonaktif' }}</span>
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
    @include('admin.master.datashift.tambah')
    @include('admin.master.datashift.edit')
    @include('admin.master.datashift.hapus')
@endsection

@push('style')
    <style>
        .piket {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .button {
            width: 55px;
            height: 25px;
            background-color: #d2d2d2;
            border-radius: 200px;
            cursor: pointer;
            position: relative;
            transition: background-color 0.2s;
        }

        .button::before {
            position: absolute;
            content: "";
            width: 15px;
            height: 15px;
            background-color: #fff;
            border-radius: 50%;
            margin: 5px;
            transition: transform 0.2s;
        }

        input[type="checkbox"] {
            display: none;
        }

        input[type="checkbox"]:checked+.button {
            background-color: blue;
        }

        input[type="checkbox"]:checked+.button::before {
            transform: translateX(30px);
        }

        .status-text {
            margin-top: 8px;
            font-weight: bold;
            color: #333;
            font-size: 14px;
        }
    </style>
@endpush
@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endpush
