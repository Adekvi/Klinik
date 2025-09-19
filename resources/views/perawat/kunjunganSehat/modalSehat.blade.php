<div class="modal fade" id="Sehat" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="pasienbaru" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: rgb(0, 0, 0)">Kunjungan Sehat</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('admin/pasien-sehat/tambah') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="tgl_kunjungan">Tanggal Kunjungan</label>
                                <input type="date" class="form-control mt-2 mb-2" name="tgl_kunjungan"
                                    id="tgl_kunjungan" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="tgl">Tanggal Entri</label>
                                <input type="date" class="form-control mt-2 mb-2" name="tgl" id="tgl"
                                    required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">No. BPJS</label>
                                <input type="text" class="form-control mt-2 mb-2" name="noKartu" id="noKartu"
                                    placeholder="No. BPJS">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="norm">No. RM</label>
                                <input type="text" class="form-control mt-2 mb-2" name="norm" id="norm"
                                    placeholder="No. RM">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nama_pasien">Nama Pasien</label>
                                <input type="text" class="form-control mt-2 mb-2" name="nama_pasien" id="nama_pasien"
                                    placeholder="Nama Pasien">
                            </div>
                        </div>
                        {{-- <div class="col-lg-6">
                            <div class="form-group">
                                <label for="jenis_pasien">Jenis Pasien</label>
                                <select class="form-control mt-2 mb-2" name="jenis_pasien" id="jenis_pasien">
                                    <option value="">-- Pilih Jenis Pasien --</option>
                                    <option value="Umum">Umum</option>
                                    <option value="Bpjs">Bpjs</option>
                                </select>
                            </div>
                        </div> --}}
                    </div>
                    <div class="form-group">
                        <label for="kegiatan">Kegiatan</label>
                        <textarea name="kegiatan" id="kegiatan" class="form-control mt-2 mb-2" cols="30" rows="4"></textarea>
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
