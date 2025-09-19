<div class="modal fade" id="KunjunganOnline" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="pasienbaru" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: rgb(0, 0, 0)">Kunjungan Online</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_rm">No. RM</label>
                                <input type="text" class="form-control mt-2 mb-2" name="no_rm" id="no_rm"
                                    placeholder="No. RM" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_pasien">Nama Pasien</label>
                                <input type="text" class="form-control mt-2 mb-2" name="nama_pasien" id="nama_pasien"
                                    placeholder="Nama Pasien">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jenis_pasien">Jenis Pasien</label>
                                <select class="form-control mt-2 mb-2" name="jenis_pasien" id="jenis_pasien">
                                    <option value="">-- Pilih Jenis Pasien --</option>
                                    <option value="Umum">Umum</option>
                                    <option value="Bpjs">Bpjs</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="nobpjs" style="display: none;">
                                <label for="norm">No. BPJS</label>
                                <div class="cari" style="display: flex; align-items: center">
                                    <input type="text" class="form-control mt-2 mb-2" name="norm" id="norm"
                                        placeholder="Masukkan No. BPJS">
                                    <div id="autocompletebpjs-results"></div>
                                </div>
                                <div class="invalid-feedback" id="nobpjsError" style="display: none;">No. BPJS harus
                                    berisi 13
                                    digit</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tgl">Tanggal</label>
                                <input type="date" class="form-control mt-2 mb-2" name="tgl" id="tgl"
                                    required>
                            </div>
                        </div>
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

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Jenis pasien Bpjs
            const jenisPasienSelect = document.getElementById('jenis_pasien');
            const nobpjs = document.getElementById('nobpjs');
            const normInput = document.getElementById('norm');
            const nobpjsError = document.getElementById('nobpjsError');
            if (jenisPasienSelect && nobpjs && normInput && nobpjsError) {
                console.log('Elemen jenis_pasien ditemukan, menambahkan event listener');
                jenisPasienSelect.addEventListener('change', function() {
                    console.log('Jenis pasien dipilih:', this.value);
                    if (this.value === 'Bpjs') {
                        console.log('Menampilkan field No. BPJS');
                        nobpjs.style.display = 'block';
                    } else {
                        console.log('Menyembunyikan field No. BPJS');
                        nobpjs.style.display = 'none';
                        nobpjsError.style.display = 'none';
                        normInput.classList.remove('is-invalid');
                    }
                });

                nobpjs.style.display = 'none';

                normInput.addEventListener('input', function() {
                    const bpjs = normInput.value;
                    if (bpjs.length === 13 && /^\d+$/.test(bpjs)) {
                        nobpjsError.style.display = 'none';
                        normInput.classList.remove('is-invalid');
                    } else {
                        nobpjsError.style.display = 'block';
                        normInput.classList.add('is-invalid');
                    }
                });
            } else {
                console.error('Elemen jenis_pasien, nobpjs, norm, atau nobpjsError tidak ditemukan');
            }
        });
    </script>
@endpush
