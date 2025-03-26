@foreach ($pajak as $item)
    <div class="modal fade" id="editpoli{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="pasienbaru" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: white">Edit Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('admin/master/ppn-edit/'. $item->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama Pajak</label>
                            {{-- <select name="nama" id="nama" class="form-control mt-2 mb-2">
                                <option value="">Pilih Nama</option>
                                @foreach ($dokter as $item)
                                    <option value="{{ $item->nama_dokter }}">{{ $item->nama_dokter }}</option>
                                @endforeach
                            </select> --}}
                            <input type="text" class="form-control mt-2 mb-2" value="{{ $item->namaPajak }}" name="namaPajak" id="namaPajak" placeholder="Masukkan Nama Pajak" required>
                        </div>
                        <div class="form-group">
                            <label for="">Tarif Pajak</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text mt-2" style="background: rgb(228, 228, 228)">
                                        <b>%</b>
                                    </span>
                                </div>
                                <input type="text" class="form-control mt-2 mb-2" value="{{ $item->tarifPpn }}" name="tarifPpn" id="tarifPpn">
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
