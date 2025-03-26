<div class="modal fade" id="tindakan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="pasienbaru" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
            <div class="modal-header bg-primary">
                <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: white">Tindakan Dokter</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tindakan">Tindakan Dokter</label>
                        <select name="tindakan" id="tindakan" class="form-control mt-2 mb-2">
                            <option value="">Pilih Tindakan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tindakan">Tarif</label>
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text mt-2" style="background: rgb(228, 228, 228)">
                                    <b>Rp.</b>
                                </span>
                            </div>
                            <input type="number" class="form-control mt-2 mb-2" name="tarif" id="tarif" placeholder="Masukkan Tarif" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" cols="30" rows="3" class="form-control mt-2 mb-2"></textarea>
                        {{-- <input type="text" class="form-control mt-2 mb-2" name="keterangan" id="keterangan" placeholder="Masukkan Nama Poli" required> --}}
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