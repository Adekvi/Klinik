<!-- Modal Resep BARU -->
<div class="modal fade" id="tambahpasien" data-bs-backdrop="static" dat    a-bs-keyboard="false" tabindex="-1" aria-labelledby="pasienbaru" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: white">Tambah Pasien Sehat</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ url('obat/store/'. $item->id ) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="nama_pasien">Nama Pasien</label>
                        <input type="text" class="form-control mt-2 mb-2" name="nama_pasien" id="nama_pasien" value="{{ $item->booking->pasien->nama_pasien }}" disabled>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Umur</label>
                        <div class="input-group">
                          <input type="text" class="form-control mt-2 mb-2" name="nama_pasien" id="nama_pasien" value="{{ \Carbon\Carbon::parse($item->booking->pasien->tgllahir)->age }}" disabled>
                            <span class="input-group-text mt-2 mb-2" id="basic-addon2" style="background: rgb(228, 228, 228)">
                              <b>Tahun</b>
                            </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="jekel">Jenis Kelamin</label>
                        <input type="text" class="form-control mt-2 mb-2" name="jekel" id="jekel" value="{{ $item->booking->pasien->jekel }}" disabled>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Berat Badan</label>
                        <div class="input-group">
                          <input type="text" class="form-control mt-2 mb-2" name="bb" id="bb" value="{{ $item->isian->p_bb }}" disabled>
                            <span class="input-group-text mt-2 mb-2" id="basic-addon2" style="background: rgb(228, 228, 228)">
                              <b>Kg</b>
                            </span>
                        </div>
                      </div>
                    </div>
                    @php
                        $resep = json_decode($item['obat']['resep'], true);
                        $aturan = json_decode($item['obat']['aturan_minum'], true);
                        $count = count($resep); // Mendapatkan panjang array untuk looping
                    @endphp

                    @for ($i = 0; $i < $count; $i++)
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nama_obat">Nama Obat</label>
                                <input type="text" name="resep[]" value="{{ $resep[$i] }}" class="form-control mt-2">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Aturan Minum</label>
                                <div class="input-group">
                                    <input type="text" name="aturan_minum[]" value="{{ $aturan[$i] }}" class="form-control mt-2">
                                    <span class="input-group-text mt-2" id="basic-addon2" style="background: rgb(228, 228, 228)">
                                        <b>Sehari</b>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="jumlah">Jumlah Obat</label>
                                <input type="number" name="jumlah[]" class="form-control mt-2">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="satuan">Satuan Penggunaan</label>
                                <select name="satuan[]" id="satuan" class="form-control mt-2">
                                    <option value="">--Pilih--</option>
                                    <option value="Tablet">Tablet</option>
                                    <option value="Kapsul">Kapsul</option>
                                    <option value="Bungkus">Bungkus</option>
                                    <option value="Salep">Salep</option>
                                    <option value="Krim">Krim</option>
                                    <option value="ml">ml</option>
                                    <option value="Sendok Sirup">Sendok Sirup</option>
                                    <option value="Sendok Makan">Sendok Makan</option>
                                    <option value="Tetes">Tetes</option>
                                </select>
                            </div>
                        </div>
                    @endfor

                    <div class="form-group">
                        <label for="tambahan">Aturan Tambahan</label>
                        <textarea name="aturan_tambahan" class="form-control mt-2" id="aturan_tambahan" cols="20" rows="10"></textarea>
                    </div>

                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
