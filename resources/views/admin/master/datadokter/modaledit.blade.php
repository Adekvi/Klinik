@foreach ($dokter as $item)
    <div class="modal fade" id="editdokter{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="pasienbaru" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: white">Edit Tenaga Medis</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('admin/edit/datadokter/' . $item->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="poli">Poli</label>
                            <select name="poli" id="poli" class="form-control mt-2 mb-2">
                                <option value="0" {{ $item->id_poli == 0 ? 'selected' : '' }}>Tidak ada Poli
                                </option>
                                @foreach ($poli as $poliItem)
                                    <option value="{{ $poliItem->KdPoli }}"
                                        {{ $item->id_poli == $poliItem->KdPoli ? 'selected' : '' }}>
                                        {{ $poliItem->namapoli }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- <div class="form-group">
                        <label for="poli">Poli</label>
                        <select name="poli" id="poli" class="form-control mt-2 mb-2">
                            @foreach ($poli as $poliItem)
                                <option value="{{ $poliItem->KdPoli }}" {{ $item->id_poli == $poliItem->KdPoli ? 'selected' : '' }}>{{ $poliItem->namapoli }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <input type="text" class="form-control mt-2 mb-2 @error('nik') is-invalid @enderror"
                                name="nik" id="nik" value="{{ $item->nik }}" placeholder="Masukkan NIK">
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback" id="nik-error" style="display: none;">NIK harus berisi 16
                                karakter
                                angka.</div>
                        </div>
                        <div class="form-group">
                            <label for="dokter">Nama Tenaga Medis</label>
                            <input type="text" class="form-control mt-2 mb-2" name="dokter" id="dokter"
                                value="{{ $item->nama_dokter }}" placeholder="Masukkan nama dokter" required>
                        </div>
                        <div class="form-group">
                            <label for="profesi">Profesi</label>
                            <input type="text" class="form-control mt-2 mb-2" name="profesi" id="profesi"
                                value="{{ $item->profesi }}" placeholder="Masukkan profesi" required>
                        </div>
                        <div class="form-group">
                            <label for="tarif">Tarif Jasa</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text mt-2" style="background: rgb(228, 228, 228)">
                                        <b>Rp.</b>
                                    </span>
                                </div>
                                <input type="number" name="tarif" id="tarif" class="form-control mb-2 mt-2"
                                    placeholder="Masukkan Tarif Jasa" value="{{ $item->tarif }}">
                            </div>
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
