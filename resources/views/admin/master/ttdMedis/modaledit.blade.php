@foreach ($ttd as $item)
    <div class="modal fade" id="editpoli{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="pasienbaru" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: white">Ganti TTD</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('admin/edit/master-ttd/' . $item->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama Tenaga Medis</label>
                            <input type="text" class="form-control mt-2 mb-2" name="id_medis" id="id_medis"
                                placeholder="Masukkan Nama Tenaga Medis" value="{{ $item->nama }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFoto">Foto</label>
                            <input type="file" class="form-control mb-2 mt-2" name="foto" id="exampleInputFoto">
                            <small class="form-text text-muted" id="foto"></small>
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Status</label>
                            <select name="status" id="status" class="form-control mb-2 mt-2">
                                <option value="Aktif" selected>Aktif</option>
                                <option value="Non-Aktif">Non-Aktif</option>
                            </select>
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
@endforeach
