@foreach ($pasien as $item)
    <div class="modal fade" id="editbpjs{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="pasienbaru" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color:rgb(0, 0, 0)e;">Edit Data
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('admin/edit/pasienbpjs/' . $item->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_rm">No. RM</label>
                                    <input type="text" class="form-control mt-2 mb-2" name="no_rm" id="no_rm"
                                        value="{{ $item->no_rm }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_pasien">Nama Pasien</label>
                                    <input type="text" class="form-control mt-2 mb-2" name="nama_pasien"
                                        id="nama_pasien" value="{{ $item->nama_pasien }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nik">NIK</label>
                                    <input type="text" class="form-control mt-2 mb-2" name="nik" id="nik"
                                        value="{{ $item->nik }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_kk">Nama Kepala Keluarga</label>
                                    <input type="text" class="form-control mt-2 mb-2" name="nama_kk" id="nama_kk"
                                        value="{{ $item->nama_kk }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tgllahir">Tanggal Lahir</label>
                                    <input type="date" class="form-control mt-2 mb-2" name="tgllahir" id="tgllahir"
                                        value="{{ $item->tgllahir }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jekel">Jenis Kelamin</label>
                                    <select name="jekel" id="jekel" class="form-control mt-2 mb-2">
                                        <option value="L" {{ $item->jekel == 'L' ? 'selected' : '' }}>Laki-Laki
                                        </option>
                                        <option value="P" {{ $item->jekel == 'P' ? 'selected' : '' }}>Perempuan
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alamat_asal">Alamat Asal</label>
                                    <input type="text" class="form-control mt-2 mb-2" name="alamat_asal"
                                        id="alamat_asal" value="{{ $item->alamat_asal }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="noHP">No. HP</label>
                                    <input type="text" class="form-control mt-2 mb-2" name="noHP" id="noHP"
                                        value="{{ $item->noHP }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="domisili">Domisili</label>
                                    <input type="text" class="form-control mt-2 mb-2" name="domisili" id="domisili"
                                        value="{{ $item->domisili }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_pasien">Jenis Pasien</label>
                                    <input type="text" class="form-control mt-2 mb-2" name="jenis_pasien"
                                        id="jenis_pasien" value="{{ $item->jenis_pasien }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bpjs">No. BPJS</label>
                                    <input type="text" class="form-control mt-2 mb-2" name="bpjs"
                                        id="bpjs" value="{{ $item->bpjs }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pekerjaan">Pekerjaan</label>
                                    <input type="text" class="form-control mt-2 mb-2" name="pekerjaan"
                                        id="pekerjaan" value="{{ $item->pekerjaan }}">
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
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
