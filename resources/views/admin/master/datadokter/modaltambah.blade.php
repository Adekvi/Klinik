{{-- @foreach ($poli as $item) --}}
    <div class="modal fade" id="tambahdokter" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="pasienbaru" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: white">Tambah Tenaga Medis</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('admin/tambah/datadokter') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="poli">Poli</label>
                            <select name="poli" id="poli" class="form-control mt-2 mb-2" required>
                                <option value="#" disabled selected>Pilih Poli</option>
                                @foreach ($poli as $item)
                                    <option value="{{ $item->KdPoli }}">{{ $item->namapoli }}</option>
                                @endforeach
                            </select>
                            <p style="font-size: 14px"><span style="color: green; font-weight: bold">Info.</span> Selain dokter silahkan lewati untuk bagian pilih poli</p>
                        </div>
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <input type="text" class="form-control mb-2 mt-2 @error('nik') is-invalid @enderror" name="nik" id="nik" placeholder="Masukkan NIK">
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback" id="nik-error" style="display: none;">NIK harus berisi 16 karakter angka.</div>
                            <p style="font-size: 14px"><span style="color: green; font-weight: bold">Info.</span> Selain Dokter NIK tidak wajib diisi!</p>
                        </div>
                        <div class="form-group">
                            <label for="dokter">Nama Tenaga Medis</label>
                            <input type="text" class="form-control mb-2 mt-2" name="dokter" id="dokter" placeholder="Masukkan Nama Tenaga Medis">
                        </div>
                        <div class="form-group">
                            <label for="profesi">Profesi</label>
                            <input type="text" class="form-control mt-2 mb-2" name="profesi" id="profesi" placeholder="Masukkan Profesi">
                        </div>
                        <div class="form-group">
                            <label for="tarif">Tarif Jasa</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text mt-2" style="background: rgb(228, 228, 228)">
                                        <b>Rp.</b>
                                    </span>
                                </div>
                                <input type="number" name="tarif" id="tarif" class="form-control mb-2 mt-2" placeholder="Masukkan Tarif Jasa">
                            </div>
                        </div>
                        <p style="font-size: 14px"><span style="color: green; font-weight: bold">Info.</span> Selain Dokter Tarif tidak wajib diisi!</p>
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
{{-- @endforeach --}}
