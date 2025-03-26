<!-- Modal Kajian Awal -->
<div class="modal fade" id="modalKajian{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="periksa" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <form id="myForm1" action="{{ url('perawat/store/' . $item->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalScrollableTitle" style="color: rgb(0, 0, 0);">Asesmen
                        Keperawatan -
                        Kajian Awal</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- <button type="button" class="btn btn-primary" id="btnKajian{{ $item->id }}" style="margin-bottom: 20px">Kajian Awal</button>               --}}
                    @php
                        use Carbon\Carbon;

                        // Ambil waktu pembuatan data
                        $createdAt = optional($item->rm)->created_at;
                        $thirtyMinutesLater = $createdAt ? Carbon::parse($createdAt)->addMinutes(3) : null;
                        $now = Carbon::now();
                    @endphp

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
