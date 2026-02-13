    <?php
    if (!function_exists('Rupiah')) {
        function Rupiah($angka)
        {
            return 'Rp ' . number_format($angka, 0, ',', '.');
        }
    }
    ?>

@foreach ($obat as $item)
@php
    $stokTerakhir = $item->stok;
@endphp
<tr class="text-center align-middle" style="white-space: nowrap;">
    <td>{{ ($obat->currentPage() - 1) * $obat->perPage() + $loop->iteration }}</td>
    <td>{{ $item->golongan ?? '-' }}</td>
    <td>{{ $item->jenis_sediaan }}</td>
    <td>{{ $item->nama_obat }}</td>
    <td>{{ $item->harga_pokok ? Rupiah($item->harga_pokok) : '0' }}</td>
    <td>{{ Rupiah($item->harga_jual) }}</td>
    <td>{{ $item->keluar ?? '0' }}</td>
    <td>{{ $item->retur ?? '0' }}</td>
    <td>{{ $stokTerakhir }}</td>
    <td>
        <div class="d-flex flex-wrap gap-2 justify-content-center">
            <!-- Detail Obat -->
            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailObat{{ $item->id }}">
                <i class="fa-solid fa-info-circle"></i> Detail
            </button>

            <!-- Edit & Hapus -->
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editobat{{ $item->id }}">
                <i class="fa-solid fa-cart-shopping"></i> Stok
            </button>
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusobat{{ $item->id }}">
                <i class="fa-solid fa-trash"></i> Hapus
            </button>
        </div>

        <!-- Modal Detail Obat -->
      <!-- Modal Detail Obat -->
<div class="modal fade" id="detailObat{{ $item->id }}" tabindex="-1"
    aria-labelledby="detailObatLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailObatLabel{{ $item->id }}">
                    Detail Obat: {{ $item->nama_obat }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row gy-3">
                    <!-- Kiri: Info Obat & Distributor -->
                    <div class="col-md-8">
                        <dl class="row mb-0">
                            <dt class="col-sm-4 text-muted">No. Faktur</dt>
                            <dd class="col-sm-8">{{ $item->no_faktur ?? '-' }}</dd>

                            <dt class="col-sm-4 text-muted">Distributor</dt>
                            <dd class="col-sm-8">{{ $item->nama_distributor ?? '-' }}</dd>

                            <dt class="col-sm-4 text-muted">Telepon</dt>
                            <dd class="col-sm-8">{{ $item->hp_distributor ?? '-' }}</dd>
{{--
                            <dt class="col-sm-4 text-muted">Alamat</dt>
                            <dd class="col-sm-8">{{ $item->alamat_distributor ?? '-' }}</dd> --}}

                            <dt class="col-sm-4 text-muted">Nama Obat</dt>
                            <dd class="col-sm-8 fw-semibold">{{ $item->nama_obat }}</dd>

                            <dt class="col-sm-4 text-muted">Golongan / Sediaan</dt>
                            <dd class="col-sm-8">{{ $item->golongan ?? '-' }} / {{ $item->jenis_sediaan ?? '-' }}</dd>

                            <dt class="col-sm-4 text-muted">Harga Beli</dt>
                            <dd class="col-sm-8">{{ Rupiah($item->harga_pokok ?? 0) }}</dd>

                            <dt class="col-sm-4 text-muted">Harga Jual</dt>
                            <dd class="col-sm-8">{{ Rupiah($item->harga_jual ?? 0) }}</dd>
                        </dl>
                    </div>

                    <!-- Kanan: Stok Total -->
                    <div class="col-md-4 d-flex flex-column justify-content-center align-items-center border rounded p-3 bg-light">
                        <h6 class="text-secondary mb-2">Stok Total</h6>
                        <span class="display-4 fw-bold text-primary">{{ $item->stok ?? 0 }}</span>
                    </div>
                </div>

                <!-- Batch Detail -->
                <h6 class="border-bottom pb-2 mt-4 mb-3 text-secondary fw-semibold">Batch Detail</h6>
                @if($item->details->count())
                    <div class="table-responsive rounded-3" style="max-height: 320px; overflow-y: auto;">
                        <table class="table table-sm table-bordered align-middle text-center mb-0">
                            <thead class="table-light text-uppercase small">
                                <tr>
                                    <th>Tanggal Terima</th>
                                    <th>Expired Date</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($item->details as $detail)
                                <tr class="align-middle">
                                    <td>{{ \Carbon\Carbon::parse($detail->etd)->format('d M Y') ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($detail->expired_date)->format('d M Y') ?? '-' }}</td>
                                    <td>{{ $detail->jumlah_expired ?? 0 }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted fst-italic mt-3">Belum ada batch untuk obat ini.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

    </td>
</tr>
@endforeach
