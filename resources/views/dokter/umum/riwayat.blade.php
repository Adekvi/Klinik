<!-- Modal Riwayat Odontogram -->
@if ($fisik && $fisik->id)
    <div class="modal fade" id="riwayatTubuh{{ $fisik->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="pasienbaru" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color:rgb(0, 0, 0)e;">Riwayat
                        Anatomi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table"
                                        style="text-align: center; overflow-y: auto; white-space: nowrap">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>AKSI</th>
                                                <th>NO</th>
                                                <th>TANGGAL DAN WAKTU PERIKSA</th>
                                                <th>NO. RM</th>
                                                <th>NAMA PASIEN</th>
                                                <th>UMUR</th>
                                                <th>ALAMAT</th>
                                            </tr>
                                        </thead>
                                        <tbody style="text-align: center;">
                                            <?php $no = 1; ?>
                                            @if (!$fisik)
                                                <tr>
                                                    <td colspan="7" class="text-center">Belum ada riwayat anatomi
                                                        pasien.
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-info toggle-detail"
                                                            data-target="#rincian-detail" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" data-bs-offset="0,4"
                                                            data-bs-html="true"
                                                            data-bs-original-title="<i class='bx bx-bell bx-xs'></i> <span>Lihat</span>">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </td>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($fisik->created_at)->translatedFormat('l, d-m-Y / H:i') }}
                                                    </td>
                                                    <td>{{ $antrianDokter->booking->pasien->no_rm }}</td>
                                                    <td>{{ $antrianDokter->booking->pasien->nama_pasien }}</td>
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($antrianDokter->booking->pasien->tgllahir)->age }}
                                                        Tahun
                                                    </td>
                                                    <td>{{ $antrianDokter->booking->pasien->alamat_asal }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rincian-detail" id="rincian-detail">
                        <div class="row">
                            <div class="card-body">
                                <div class="card-title">
                                    <h5 class="text-muted">
                                        <strong>
                                            <li>Pengkajian Awal Pasien Gigi</li>
                                        </strong>
                                    </h5>
                                </div>
                                <hr>
                                <div class="row display-flex justify-content-between">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Keterangan Anatomi Depan</label>
                                            <textarea name="depan" class="form-control mt-2 mb-2" id="depan" cols="5" rows="5">{{ $fisik->depan ?? '-' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Keterangan Anatomi Samping</label>
                                            <textarea name="samping" class="form-control mt-2 mb-2" id="samping" cols="5" rows="5">{{ $fisik->samping ?? '-' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Keterangan Anatomi Belakang</label>
                                            <textarea name="belakang" class="form-control mt-2 mb-2" id="belakang" cols="5" rows="5">{{ $fisik->belakang ?? '-' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endif

@push('style')
    <style>
        /* Styling rincian */
        .card-body {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
        }

        /* Kontrol visibilitas dan animasi */
        .rincian-detail {
            margin-top: 1rem;
            overflow: hidden;
            height: 0;
            opacity: 0;
            transition: height 0.3s ease, opacity 0.3s ease;
            display: block;
            /* Pastikan elemen tetap ada di DOM */
        }

        .rincian-detail.active {
            height: auto;
            /* Biarkan konten menentukan tinggi */
            opacity: 1;
            padding: 1rem;
            /* Tambahkan padding untuk konten */
        }

        /* Ikon eye pada tombol */
        .btn-info .fas.fa-eye {
            color: #fff;
        }
    </style>
@endpush

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Event click pada tombol toggle
            $('.toggle-detail').on('click', function() {
                var targetId = $(this).data('target'); // Ambil ID target dari data-target
                var $target = $(targetId); // Elemen target

                // Toggle kelas active
                $target.toggleClass('active');

                // Perbarui aria-expanded untuk aksesibilitas
                var isExpanded = $target.hasClass('active');
                $(this).attr('aria-expanded', isExpanded);

                // Atur tinggi secara dinamis untuk animasi
                if (isExpanded) {
                    var height = $target.find('.card-body').outerHeight();
                    $target.css('height', height + 'px');
                } else {
                    $target.css('height', '0');
                }
            });
        });
    </script>
@endpush
