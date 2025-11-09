<x-admin.layout.terminal title="Apoteker | Stok Obat">

    <div class="breadcrumbs d-flex align-items-center"
        style="background-image: url('{{ asset('assetss/img/profil.jpg') }}');">
    </div>

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h3><strong>Stok Obat</strong></h3>
                        <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal"
                            data-bs-target="#"><i class="bi bi-plus-lg"></i> Tambah Obat</button>
                    </div>
                    <div class="tb-umum">
                        <table id="example" class="table table-striped table-bordered" style="width:100%;">
                            <thead>
                                @php
                                    $allSoapPatients = [];
                                @endphp

                                @foreach ($obat as $item)
                                    @php
                                        $soapData = json_decode($item['resep'], true);
                                        $allSoapPatients = array_merge($allSoapPatients, array_keys($soapData));
                                    @endphp
                                @endforeach

                                @php
                                    $allSoapPatients = array_unique($allSoapPatients);
                                    // dd($allSoapPatients);
                                @endphp
                                <tr class="table-primary text-center"
                                    style=" white-space: nowrap; justify-content: center">
                                    <th>No</th>
                                    <th>Tanggal Ambil Obat</th>
                                    <th>No. RM</th>
                                    <th>Nama Pasien</th>
                                    <th>Jenis Pasien</th>
                                    <th>Poli</th>
                                    <th>Keterangan Obat</th>
                                    {{-- <th>Harga</th>
                                    <th>Total</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                if (!function_exists('Rupiah')) {
                                    function Rupiah($angka)
                                    {
                                        return 'Rp ' . number_format($angka, 2, ',', '.');
                                    }
                                }
                                ?>
                                @foreach ($obat as $item)
                                    {{-- {{ dd($item['soap']) }} --}}
                                    @if ($item->status == 'B')
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ date_format(date_create($item->created_at), 'H:i:s/Y-m-d') }}</td>
                                            <td>{{ $item->booking->pasien->no_rm }}</td>
                                            <td>{{ $item->booking->pasien->nama_pasien }}</td>
                                            <td>{{ $item->booking->pasien->jenis_pasien }}</td>
                                            <td>{{ $item->soap->poli->namapoli }}</td>
                                            <td>
                                                @foreach ($allSoapPatients as $patientName)
                                                    @if (isset(json_decode($item['resep'], true)[$patientName]))
                                                        {{ $patientName }} :
                                                        {{ json_decode($item['resep'], true)[$patientName] }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            {{-- <td>{{ Rupiah($item->harga) }}</td>
                                            <td>{{ Rupiah(($item->harga) * ($item->jumlah)) }}</td> --}}
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
