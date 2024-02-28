@extends('layout.home')
@section('title', 'Perawat')
@section('content')

<div class="pendaftaran">
  <div class="container">
      <div class="card">
          <div class="card-body">
              <div class="judul">
                  <h2>Daftar Pasien</h2>
                  <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#pasienbaru"><i class="bi bi-plus-lg"></i>
                      Pasien Baru
                  </button>
              </div>
              <div class="isian">
                  <table class="table">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>No. RM</th>
                              <th>Nama Pasien</th>
                              <th>Alamat</th>
                              <th>Jenis Pembayaran</th>
                              <th>Status</th>
                              <th>Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                        @if (empty($pasien))
                            <tr>
                              <td colspan="6" style="text-align: center">Tidak Ada Data Pasien</td>
                            </tr>
                        @else
                          <?php $no = 1; ?>
                          @foreach ($pasien as $item)
                          <tr id="row_{{ $item->id }}">
                              <td>{{ $no++ }}</td>
                              <td>{{ $item->no_rm }}</td>
                              <td>{{ $item->nama_pasien }}</td>
                              <td>{{ $item->alamat }}</td>
                              <td>{{ $item->jenis_bayar }}</td>
                              <td>{{ $item->status }}</td>
                              <td>
                                  <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#periksa{{ $item->id }}">
                                      Periksa
                                  </button>
                                  <button type="button" class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#hapuspasien{{ $item->id }}">
                                      Hapus
                                  </button>
                              </td>
                          </tr>
                          @include('perawat.modalPerawat.ModalAnamnesis')
                          @endforeach
                        @endif
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>
</div>

  {{-- Pasien Baru --}}
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

  {{-- Delete Pasien --}}
  @foreach ($pasien as $item)
    <div class="modal fade text-left" id="hapuspasien{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
              <div class="modal-header bg-danger">
                  <h5 class="modal-title white" id="myModalLabel160">Hapus Data Pasien</h5>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                      <i data-feather="x"></i>
                  </button>
              </div>
              <form action="{{ url('pasien/hapus/'. $item->id ) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('DELETE')
                  <div class="modal-body">
                      <center>
                          <h5 class="mt-2 mb-3">Apakah anda ingin menghapus data pasien ini?</h5>
                          <button type="submit" class="btn btn-danger ml-1">
                              <i class="bx bx-check d-block d-sm-none"></i>
                              <span class="d-none d-sm-block">Hapus</span>
                          </button>
                      </center>
                  </div>
              </form>
          </div>
      </div>
    </div>
  @endforeach
     
@endsection

@push('script')
<script src="{{ asset('assets/js/script.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

<script>
  
// Pada modal pertama
function saveDataAndShowNextModal() {
    // Mendapatkan semua elemen <tr> yang memiliki atribut data-item-id
    var tableRows = document.querySelectorAll('[data-item-id]');

    // Loop melalui setiap elemen <tr> dan ambil nilai data-item-id
    tableRows.forEach(function (tableRow) {
        var id = tableRow.getAttribute("data-item-id");

        // Mengumpulkan data dari form modal pertama
        var formData = new FormData(document.getElementById("myForm1"));
        formData.append('pasien', id); // Sisipkan nilai id ke dalam formData

        // Mengirim data ke server untuk disimpan ke dalam session
        fetch('/modal1/store', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Menutup modal pertama
                $('#periksa' + id).modal('hide');

                // Menampilkan modal kedua
                $('#periksa2' + id).modal('show');
            } else {
                // Menampilkan pesan error jika ada
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
}

</script>

@endpush
