<!-- modal pemeriksaan -->
@foreach ($fisik as $row)
<div class="modal fade" id="gambarModal{{ $row['id'] }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalFisik" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: white">Update Rekam Medis Tubuh/Gigi</h1>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <form action="{{ url('dokter/edit/'. $row['id']) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="dokter_id" value="{{ $antrianDokter->dokter_id }}">
                <input type="hidden" name="pasien_id" value="{{ $antrianDokter->booking->pasien_id }}">
                <div class="modal-body" style="max-height: 700px; overflow-y: auto;">
                    <div class="row" style="width: 100%">
                        <div class="card-body">
                            <table class="table" style="border-bottom: 1px solid white; width: 100%; margin-top: -40px; margin-bottom: -50px">
                                <tbody>
                                    <tr>
                                        <td style="font-weight: bold">
                                            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }} |
                                            {{ $antrianDokter->booking->pasien->nama_pasien }}
                                            {{ $antrianDokter->booking->pasien->no_rm }}
                                            {{ $antrianDokter->booking->pasien->jekel }}
                                            {{ $antrianDokter->booking->pasien->domisili }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Kolom Kiri: Gambar -->
                        @if($antrianDokter->poli->namapoli === 'Umum')
                            <div class="col-md-6 text-center" style="padding: 20px; margin-top: -40px">
                                <img id="displayedImage" src="{{ asset('assets/images/depan.png') }}" style="max-width: 80%; height: auto; border-radius: 10px;" alt="Kerangka">
                            </div>
                            <div class="col-md-6" style="margin-top: -20px; justify-content: center">
                                @if($fisik->isNotEmpty())
                                    @php $fisikData = $fisik->first(); @endphp
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary" onclick="showImage('depan')">Depan</button>
                                        <input name="depan" class="form-control mt-2 mb-2" id="depan" rows="2" placeholder="Belum Ada Catatan" value="{{ $row['depan'] }}">
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary" onclick="showImage('samping')">Samping</button>
                                        <input name="samping" class="form-control mt-2 mb-2" id="samping" rows="2" placeholder="Belum Ada Catatan" value="{{ $row['samping'] }}">
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary" onclick="showImage('belakang')">Belakang</button>
                                        <input name="belakang" class="form-control mt-2 mb-2" id="belakang" rows="2" placeholder="Belum Ada Catatan" value="{{ $row['belakang'] }}">                                        
                                    </div>
                                @else
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary" onclick="showImage('depan')">Depan</button>
                                        <input name="depan" class="form-control mt-2 mb-2" id="depan" rows="2" placeholder="Belum Ada Catatan">
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary" onclick="showImage('samping')">Samping</button>
                                        <input name="samping" class="form-control mt-2 mb-2" id="samping" rows="2" placeholder="Belum Ada Catatan">
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary" onclick="showImage('belakang')">Belakang</button>
                                        <input name="belakang" class="form-control mt-2 mb-2" id="belakang" rows="2" placeholder="Belum Ada Catatan">
                                    </div>
                                @endif
                                <div class="tutup" style="margin-top: 20px; margin-left: 150px">
                                    <button type="submit" class="btn btn-primary ml-1">Simpan</button>
                                </div>
                            </div>
                        @elseif($antrianDokter->poli->namapoli === 'Gigi')
                            <div style="max-height: 400px; overflow-y: auto;">
                                <div class="d-flex justify-content-center mb-4">
                                    <img id="displayedImage" src="{{ asset('assets/images/gigi.jpeg') }}" style="max-width: 100%; height: auto; border-radius: 10px" alt="Kerangka">
                                </div>
                                <hr>
                                <div class="row justify-content-center">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="tanggal">Tanggal</label>
                                            <input type="date" class="form-control mt-2 mb-2" name="tanggal" id="tanggal" value="{{ $row['tanggal'] }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="dokter">Dokter/Tenaga Medis</label>
                                            <input type="text" class="form-control mt-2 mb-2" name="dokter" id="dokter" placeholder="Masukkan Nama Dokter/Tenaga Medis" value="{{ $antrianDokter->dokter->nama_dokter }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="no_gigi">Nomor Gigi</label>
                                            <input type="number" class="form-control mt-2 mb-2" name="no_gigi" id="no_gigi" placeholder="Masukkan Nama Nomor Gigi" value="{{ $row['no_gigi'] }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="keterangan">Keterangan</label>
                                            <input type="text" class="form-control mt-2 mb-2" name="keterangan" id="keterangan" placeholder="Keterangan" value="{{ $row['keterangan'] }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="tutup" style="margin-top: 20px; margin-left: 150px">
                                    <button type="submit" class="btn btn-primary ml-1">Simpan</button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@push('script')
<script>
    $(document).ready(function() {
        // Mengatur tanggal input dengan tanggal hari ini
        var today = new Date().toISOString().split('T')[0];
        $('#tanggal').val(today);
        
        $('.tambah-keterangan').click(function() {
            var keteranganElement = `
                <div class="form-group keterangan-item">
                    <label for="no_gigi">Nomor Gigi</label>
                    <input type="number" class="form-control mt-2 mb-2" name="no_gigi[]" placeholder="Masukkan Nomor Gigi">
                    <label for="keterangan">Keterangan</label>
                    <input type="text" class="form-control mt-2 mb-2" name="keterangan[]" placeholder="Keterangan">
                </div>
            `;
            $('#keterangan-container').append(keteranganElement);
        });

        // Hapus keterangan
        $(document).on('click', '.hapus-keterangan', function () {
            $('#keterangan-container .keterangan-item:last').remove();
        });
    });
</script>
@endpush