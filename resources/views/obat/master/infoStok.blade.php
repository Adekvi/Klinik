@foreach ($obat as $item)
    <div class="modal fade" id="infoObat{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="pasienbaru" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: rgb(0, 0, 0)">Informasi Obat
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- @method('DELETE') --}}
                    <div class="modal-body">
                        <div class="judul">
                            <h3><strong>Catatan Stok Obat</strong></h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" style="width: 100%; overflow-y: auto">
                                <thead class="table-primary text-center" style="white-space: nowrap">
                                    <tr>
                                        <th>Hari, Tanggal dan Jam</th>
                                        <th>Nama Obat</th>
                                        <th>Harga Pokok</th>
                                        <th>Harga Jual</th>
                                        <th>Obat Masuk</th>
                                        <th>Obat Keluar</th>
                                        <th>Retur</th>
                                        <th>Stok</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center" style="white-space: nowrap">
                                    <?php
                                    if (!function_exists('Rupiah')) {
                                        function Rupiah($angka)
                                        {
                                            return 'Rp ' . number_format($angka, 2, ',', '.');
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y / H:i:s') }}</td>
                                        <td>{{ $item->nama_obat }}</td>
                                        <td>{{ $item->harga_pokok ? Rupiah($item->harga_pokok) : '0' }}</td>
                                        <td>{{ Rupiah($item->harga_jual) }}</td>
                                        <td>{{ isset($item->masuk) ? $item->masuk : '0' }}</td>
                                        <td>{{ isset($item->keluar) ? $item->keluar : '0' }}</td>
                                        <td>{{ isset($item->retur) ? $item->retur : '0' }}</td>
                                        <td>
                                            {{ $item->stok }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Tutup</span>
                        </button>
                        {{-- <button type="submit" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Simpan</span>
                        </button> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
