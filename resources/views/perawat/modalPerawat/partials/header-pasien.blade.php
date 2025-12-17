<div class="row bg-light">
    <div class="col-md-7">
        <div class="card mt-2">
            <div class="card-body py-2 px-3">
                <div class="d-flex justify-content-start align-items-center mt-2">
                    <h5 class="fw-semibold m-0">Identitas Pasien</h5>
                    <button wire:click="toggleIdentitas" class="btn btn-sm btn-outline-info" style="margin-left: 10px">
                        @if ($showIdentitas)
                            <i class="fa-solid fa-eye"></i>
                        @else
                            <i class="fa-solid fa-eye-slash"></i>
                        @endif
                    </button>
                </div>

                @if ($showIdentitas)
                    <div class="row mb-1 align-items-center">
                        <div class="col-6">Nama Pasien</div>
                        <div class="col-6 fw-semibold text-capitalize">
                            : {{ strtolower($booking->pasien->nama_pasien) }} ({{ $booking->pasien->jekel }})
                        </div>
                    </div>

                    <div class="row mb-1 align-items-center">
                        <div class="col-6">Umur</div>
                        <div class="col-6 fw-semibold">
                            : {{ \Carbon\Carbon::parse($booking->pasien->tgllahir)->age }} Tahun
                        </div>
                    </div>

                    <div class="row mb-1 align-items-center">
                        <div class="col-6">Jenis Pasien</div>
                        <div class="col-6 fw-semibold">
                            : {{ $booking->pasien->jenis_pasien }}
                        </div>
                    </div>

                    <div class="row align-items-center">
                        <div class="col-6">Nama Kepala Keluarga</div>
                        <div class="col-6 fw-semibold">
                            : {{ $booking->pasien->nama_kk }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-5 text-end">
        <!-- Asesmen -->
        <span
            class="badge position-relative px-3 py-2 mb-2
        {{ $isAsesmenFilled ? 'bg-success text-white' : 'bg-warning text-dark' }}">
            <i class="{{ $isAsesmenFilled ? 'fas fa-check-circle' : 'fas fa-exclamation-circle' }}"></i>
            Asesmen: {{ $isAsesmenFilled ? 'Asesmen Terisi' : 'Asesmen Belum Diisi' }}
        </span>
        <br>

        <!-- Kajian -->
        <span
            class="badge position-relative px-3 py-2
        {{ $isKajianFilled ? 'bg-success text-white' : 'bg-danger text-white' }}">
            <i class="{{ $isKajianFilled ? 'fas fa-check-circle' : 'fas fa-times-circle' }}"></i>
            Kajian: {{ $isKajianFilled ? 'Kajian Terisi' : 'Kajian Belum Diisi' }}
        </span>
    </div>

</div>
<hr>
