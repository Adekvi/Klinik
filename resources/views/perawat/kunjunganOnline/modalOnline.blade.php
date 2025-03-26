<div class="modal fade" id="KunjunganOnline" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="pasienbaru" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: rgb(0, 0, 0)">Kunjungan Online</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama">Nama Tenaga Medis</label>
                        <input type="text" class="form-control mt-2 mb-2" name="nama" id="nama"
                            placeholder="Masukkan Nama Tenaga Medis" required>
                    </div>
                    {{-- <div class="form-group">
                        <label for="tgl">Tanggal</label>
                        <input type="date" class="form-control mt-2 mb-2" name="tgl" id="tgl" placeholder="Masukkan Tanggal" required>
                    </div> --}}
                    <div class="form-group">
                        <label for="">Foto</label>
                        <input type="file" class="form-control" name="foto" id="exampleInputFoto" required>
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
