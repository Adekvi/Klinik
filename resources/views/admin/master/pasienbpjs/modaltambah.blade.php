@foreach ($pasien as $item)
<div class="modal fade" id="pasienbaru" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="pasienbaru" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: white">Tambah Data Pasien</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ url('admin/tambah/pasienbpjs') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label for="">Poli</label>
              <div class="col-sm-12">
                  <select name="poli" class="form-control">
                      <option value="">--Pilih Poli--</option>
                      @foreach ($poli as $item)
                          <option value="{{ $item->KdPoli }}">{{ $item->namapoli }}</option>
                      @endforeach
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label for="no_rm">No. RM</label>
              <input type="text" class="form-control mt-2 mb-2" name="no_rm" id="no_rm" placeholder="Masukkan No.RM" required>
            </div>
            <div class="form-group">
              <label for="nama_pasien">Nama Pasien</label>
              <input type="text" class="form-control mt-2 mb-2" name="nama_pasien" id="nama_pasien" placeholder="Masukkan Nama Pasien" required>
            </div>
            <div class="form-group">
              <label for="nik">NIK</label>
              <input type="text" class="form-control mt-2 mb-2" name="nik" id="nik" placeholder="Masukkan NIK" required>
            </div>
            <div class="form-group">
              <label for="nama_kk">Nama Kepala Keluarga</label>
              <input type="text" class="form-control mt-2 mb-2" name="nama_kk" id="nama_kk" placeholder="Masukkan Nama Kepala Keluarga" required>
            </div>
            <div class="form-group">
              <label for="pekerjaan">Pekerjaan</label>
              <input type="text" class="form-control mt-2 mb-2" name="pekerjaan" id="pekerjaan" placeholder="Masukkan Pekerjaan" required>
            </div>
            <div class="form-group">
              <label for="tgllahir">Tanggal Lahir</label>
              <input type="date" class="form-control mt-2 mb-2" name="tgllahir" id="tgllahir" required>
            </div>
            <div class="form-group">
              <label for="alamat">Alamat</label>
              <input type="text" class="form-control mt-2 mb-2" name="alamat" id="alamat" placeholder="Masukkan Alamat" required>
            </div>
            <div class="form-group">
              <label for="noHP">No. HP</label>
              <input type="text" class="form-control mt-2 mb-2" name="noHP" id="noHP" placeholder="Masukkan No. HP" required>
            </div>
            <div class="form-group">
              <label for="jenis_bayar">Jenis Pasien</label>
              <input type="text" class="form-control mt-2 mb-2" name="jenis_bayar" id="jenis_bayar" value="BPJS" readonly>
            </div>
            <div class="form-group">
              <label for="bpjs">No. BPJS</label>
              <input type="text" class="form-control mt-2 mb-2" name="bpjs" id="bpjs" placeholder="Masukkan No. BPJS">
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