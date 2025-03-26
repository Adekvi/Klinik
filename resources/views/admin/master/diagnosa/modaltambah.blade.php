{{-- @foreach ($diagnosa as $item)
    
@endforeach --}}
<div class="modal fade" id="tambahdiagnosa" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="pasienbaru" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
            <div class="modal-header bg-primary">
                <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: white">Tambah Diagnosa</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('admin/tambah/diagnosa') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kd_diagno">Kode Diagnosa</label>
                        <input type="text" class="form-control mt-2 mb-2" name="kd_diagno" id="kd_diagno" placeholder="Masukkan Kode Diagnosa" required>
                    </div>
                    <div class="form-group">
                        <label for="nm_diagno">Nama Diagnosa</label>
                        <input type="text" class="form-control mt-2 mb-2" name="nm_diagno" id="nm_diagno" placeholder="Masukkan Nama Diagnosa" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>