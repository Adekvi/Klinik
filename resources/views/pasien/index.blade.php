@extends('layout.home')

@section('content')
    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
      <div class="pendaftaran">
        <div class="container">
          <div class="judul">
            <h2>Pendaftaran</h2>
          </div>
          <div class="isian">
            <div class="pasien">
              <div class="pasien-baru">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pasienbaru">Pasien Baru</button>
              </div>
              <div class="pasien-lama">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#pasienlama">Pasien Lama</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  <!-- Modal PASIEN BARU -->
  <div class="modal fade" id="pasienbaru" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="pasienbaru" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Pendaftaran Pasien</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="#">
            <div class="form-group">
              <label for="norm">No. RM</label>
              <input type="text" class="form-control mt-2 mb-2" name="norm" id="norm" placeholder="Masukkan No.RM">
            </div>
            <div class="form-group">
              <label for="nama">Nama Pasien</label>
              <input type="text" class="form-control mt-2 mb-2" name="nama" id="nama" placeholder="Masukkan Nama Pasien">
            </div>
            <div class="form-group">
              <label for="tgllahir">Tanggal Lahir</label>
              <input type="date" class="form-control mt-2 mb-2" name="tgllahir" id="tgllahir">
            </div>
            <div class="form-group">
              <label for="alamat">Alamat</label>
              <input type="text" class="form-control mt-2 mb-2" name="alamat" id="alamat" placeholder="Masukkan Alamat">
            </div>
            <div class="form-group">
              <label for="nohp">No. HP</label>
              <input type="text" class="form-control mt-2 mb-2" name="nohp" id="nohp" placeholder="Masukkan No. HP">
            </div>
            <div class="form-group">
              <label for="pembayaran">Status Pembayaran</label>
              <select name="pembayaran" id="pembayaran" class="form-control mt-2 mb-2">
                <option value="">Pilih Pembayaran</option>
                <option value="">Umum</option>
                <option value="">BPJS</option>
              </select>
            </div>
            <div class="form-group">
              <label for="nobpjs">No. BPJS</label>
              <input type="text" class="form-control mt-2 mb-2" name="nobpjs" id="nobpjs" placeholder="Masukkan No. BPJS">
            </div>
            <div class="form-group">
              <label for="status">Status</label>
              <select name="status" id="status" class="form-control mt-2 mb-2">
                <option value="">Pilih Status</option>
                <option value="">Pasien</option>
                <option value="">Suami</option>
                <option value="">Anak</option>
                <option value="">Ibu Kandung</option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Daftar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal PASIEN LAMA -->
  <div class="modal fade" id="pasienlama" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="pasienlama" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Pendaftaran Pasien</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="norm">No. RM</label>
            <input type="text" class="form-control mt-2 mb-2" name="norm" id="norm" placeholder="Masukkan No.RM">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Daftar</button>
        </div>
      </div>
    </div>
  </div>
@endsection
