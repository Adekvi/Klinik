@extends('layout.home')
@section('title', 'Pasien')
@section('content')

<section>
  <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
    <div class="pendaftaran">
      <div class="container">
        <div class="judul">
          <h2>Pendaftaran</h2>
        </div>
        <div class="isian">
          <div class="pasien">
            <div class="pasien-baru" style="text-align: center;">
              <div style="margin-top: 50px; color: rgb(0, 0, 0);">
                  <i class="fas fa-user-plus" style="font-size: 80px;"></i>
                  <br>
                  <button class="btn" style="font-size: 20px;" data-bs-toggle="modal" data-bs-target="#pasienbaru">Pasien Baru</button>
              </div>            
            </div>
            <div class="pasien-lama" style="text-align: center;">
              <div style="margin-top: 50px; color: rgb(0, 0, 0);">
                <i class="fas fa-user-check" style="font-size: 80px;"></i>
                <br>
                <button class="btn" style="font-size: 20px;" data-bs-toggle="modal" data-bs-target="#pasienlama">Pasien Lama</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

  <!-- Modal PASIEN BARU -->
  <div class="modal fade" id="pasienbaru" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="pasienbaru" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Pendaftaran Pasien</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ url('pasien/store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label for="no_rm">No. RM</label>
              <input type="text" class="form-control mt-2 mb-2" name="no_rm" id="no_rm" placeholder="Masukkan No.RM">
            </div>
            <div class="form-group">
              <label for="nama_pasien">Nama Pasien</label>
              <input type="text" class="form-control mt-2 mb-2" name="nama_pasien" id="nama_pasien" placeholder="Masukkan Nama Pasien">
            </div>
            <div class="form-group">
              <label for="nik">NIK</label>
              <input type="text" class="form-control mt-2 mb-2" name="nik" id="nik" placeholder="Masukkan NIK">
            </div>
            <div class="form-group">
              <label for="nama_kk">Nama Kepala Keluarga</label>
              <input type="text" class="form-control mt-2 mb-2" name="nama_kk" id="nama_kk" placeholder="Masukkan Nama Kepala Keluarga">
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
              <label for="noHP">No. HP</label>
              <input type="text" class="form-control mt-2 mb-2" name="noHP" id="noHP" placeholder="Masukkan No. HP">
            </div>
            <div class="form-group">
              <label for="jenis_bayar">Jenis Pembayaran</label>
              <select name="jenis_bayar" id="jenis_bayar" class="form-control mt-2 mb-2">
                <option value="" disabled selected>Pilih Pembayaran</option>
                <option value="umum">Umum</option>
                <option value="bpjs">BPJS</option>
              </select>
            </div>
            <div class="form-group">
              <label for="bpjs">No. BPJS</label>
              <input type="text" class="form-control mt-2 mb-2" name="bpjs" id="bpjs" placeholder="Masukkan No. BPJS">
            </div>
            <div class="form-group">
              <label for="status">Status</label>
              <select name="status" id="status" class="form-control mt-2 mb-2">
                <option value="" disabled selected>Pilih Status</option>
                <option value="pasien">Pasien</option>
                <option value="suami">Suami</option>
                <option value="anak">Anak</option>
                <option value="ibu_kandung">Ibu Kandung</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Daftar</button>
          </div>
        </form>
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
