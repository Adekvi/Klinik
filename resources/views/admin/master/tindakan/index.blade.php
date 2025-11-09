<x-admin.layout.terminal title="Admin | Data Tindakan Dokter">

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="tindakan">
                    <div class="card-title">
                        <h5 style="margin-bottom: 20px"><strong>Master Tindakan Dokter</strong></h5>
                        <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal"
                            data-bs-target="#tindakan"><i class="fa-solid fa-square-plus"></i> Tambah</button>
                    </div>
                    <div class="tb-umum">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Tindakan</th>
                                    <th>Tarif</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php
                                if (!function_exists('Rupiah')) {
                                    function Rupiah($angka)
                                    {
                                        return 'Rp ' . number_format($angka, 2, ',', '.');
                                    }
                                }
                                ?>
                                @foreach ($tindakan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->tindakan }}</td>
                                        <td>{{ Rupiah($item->tarif) }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td>
                                            <div class="aksi d-flex">
                                                <button class="btn btn-primary"
                                                    data-bs-target="#editpoli{{ $item->id }}"
                                                    data-bs-toggle="modal"><i class="fas fa-info"></i>Edit</button>
                                                <button type="button" class="btn btn-danger mx-2"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#hapuspoli{{ $item->id }}">Hapus</button>
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

    @include('admin.master.tindakan.tambah')
    @include('admin.master.tindakan.edit')
    @include('admin.master.tindakan.hapus')

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
        </script>
    @endpush

</x-admin.layout.terminal>
