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
        // Ambil stok terakhir dari database
        $stokTerakhir = $item->stok;

        // Hitung stok akhir berdasarkan nilai database
        $stokAkhirBaru = $stokTerakhir;
    @endphp
    <tr class="text-center" style="white-space: nowrap">
        <td>{{ ($obat->currentPage() - 1) * $obat->perPage() + $loop->iteration }}</td>
        <td>{{ $item->golongan ?? '-' }}</td>
        <td>{{ $item->jenis_sediaan }}</td>
        <td>{{ $item->nama_obat }}</td>
        <td>{{ $item->harga_pokok ? Rupiah($item->harga_pokok) : '0' }}</td>
        <td>{{ Rupiah($item->harga_jual) }}</td>
        {{-- <td>{{ $item->stok_awal ?? '0' }}</td> --}}
        <td>{{ $item->masuk ?? '0' }}</td>
        <td>{{ $item->keluar ?? '0' }}</td>
        <td>{{ $item->retur ?? '0' }}</td>
        <td>
            {{ $stokAkhirBaru }}
            @if ($stokAkhirBaru < 50)
                <span class="tooltip-icon" style="color: red; margin-left: 5px;">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </span>
            @endif
        </td>
        <td>
            <div class="aksi d-flex" style="white-space: nowrap">
                <button type="button" data-bs-target="#editobat{{ $item->id }}" data-bs-toggle="modal"
                    class="btn btn-outline-info mx-2">
                    <i class="fa-solid fa-cart-plus"></i> Stok
                </button>
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                    data-bs-target="#hapusobat{{ $item->id }}">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div>
        </td>
    </tr>
@endforeach
