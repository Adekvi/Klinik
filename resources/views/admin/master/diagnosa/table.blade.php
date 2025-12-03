@foreach ($diagnosa as $item)
    <tr>
        <td>{{ ($diagnosa->currentPage() - 1) * $diagnosa->perPage() + $loop->iteration }}</td>
        <td>{{ $item->kd_diagno }}</td>
        <td>{{ $item->nm_diagno }}</td>
        <td>
            <div class="aksi d-flex justify-content-center">
                <button data-bs-target="#editdiagnosa{{ $item->id }}" data-bs-toggle="modal" class="btn btn-primary"><i
                        class="fas fa-info"></i> Edit</button>
                <button type="button" data-bs-target="#hapusdiagnosa{{ $item->id }}" data-bs-toggle="modal"
                    class="btn btn-danger mx-2"><i class="fas fa-trash"></i> Hapus</button>
            </div>
        </td>
    </tr>
@endforeach
