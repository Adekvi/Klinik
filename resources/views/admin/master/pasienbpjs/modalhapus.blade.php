@foreach ($pasien as $item)
    <div class="modal fade" id="hapusbpjs{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="pasienbaru" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: white">Hapus Poli</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('admin/tambah/pasienbpjs/'. $item->id ) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <h5 class="mt-2 mb-3">Apakah Anda ingin menghapus data ini?</h5>
                            <button type="submit" class="btn btn-danger ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Hapus</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach