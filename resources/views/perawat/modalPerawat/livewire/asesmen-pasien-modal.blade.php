<div>
    <div wire:ignore.self class="modal fade" id="periksaModal" tabindex="-1" data-bs-backdrop="static">

        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">

                {{-- HEADER --}}
                <div class="modal-header text-dark">
                    <h5 class="modal-title text-capitalize">
                        Asesmen Keperawatan -
                        {{ strtolower($booking?->pasien?->nama_pasien ?? 'Memuat...') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="card">
                    <div class="card-body">
                        @if ($antrian && $booking)

                            <div class="sticky-top bg-white border-bottom pb-3" style="top:0; z-index:10;">
                                @include('perawat.modalPerawat.partials.header-pasien')

                                <div class="tombol">
                                    {{-- TAB --}}
                                    <ul class="nav nav-tabs nav-fill">
                                        <li class="nav-item">
                                            <button type="button" wire:click="setTab('asesmen')"
                                                class="nav-link {{ $activeTab === 'asesmen' ? 'active bg-primary text-white' : '' }}">
                                                Asesmen Awal
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button type="button" wire:click="setTab('kajian')"
                                                class="nav-link {{ $activeTab === 'kajian' ? 'active bg-info text-white' : '' }}">
                                                Kajian Awal
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button type="button" wire:click="setTab('hamil')"
                                                class="nav-link {{ $activeTab === 'hamil' ? 'active bg-secondary text-white' : '' }}">
                                                Hamil
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            {{-- FORM --}}
                            <form action="{{ url('perawat/store/' . $antrianId) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="modal-body" style="max-height:70vh;overflow-y:auto">

                                    @if ($activeTab === 'asesmen')
                                        @include('perawat.modalPerawat.tabs.tab-asesmen-awal', [
                                            'antrian' => $antrian,
                                            'booking' => $booking,
                                        ])
                                    @elseif ($activeTab === 'kajian')
                                        @include('perawat.modalPerawat.tabs.tab-kajian-awal', [
                                            'antrian' => $antrian,
                                        ])
                                    @elseif ($activeTab === 'hamil')
                                        @include('perawat.modalPerawat.tabs.tab-hamil', [
                                            'antrian' => $antrian,
                                        ])
                                    @endif
                                </div>

                                @include('perawat.modalPerawat.partials.footer-pasien')
                            </form>
                        @else
                            <div class="modal-body text-center py-5">
                                <div class="spinner-border text-primary"></div>
                                <p class="mt-3">Memuat data pasien...</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
