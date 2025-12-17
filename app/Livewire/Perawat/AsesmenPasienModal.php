<?php

namespace App\Livewire\Perawat;

use Livewire\Component;
use App\Models\AntrianPerawat;
use App\Models\TtdMedis;
use Carbon\Carbon;

class AsesmenPasienModal extends Component
{
    public $antrianId;
    public $antrian;
    public $booking;

    public $activeTab = 'asesmen';

    // ===== STATUS & WARNING =====
    public $createdAtRM;
    public $nextAsesmenDate;
    public $shouldShowAsesmenWarning = false;

    public $lastKajianDate;
    public $nextKajianDate;
    public $shouldShowKajianWarning = false;

    public $isAsesmenFilled = false;
    public $isKajianFilled  = false;

    // ===== DATA ASESMEN =====
    public $p_tensi;
    public $p_rr;
    public $p_nadi;
    public $p_suhu;

    // ===== GCS =====
    public $gcs_e;
    public $gcs_m;
    public $gcs_v;
    public $gcs_total;

    // ===== IMT ASESMEN =====
    public $p_tb;
    public $p_bb;
    public $p_imt;

    // ===== IMT KAJIAN =====
    public $nutrisi_tb;
    public $nutrisi_bb;
    public $nutrisi_imt;

    public $p_anak_riwayat_lahir_bb;
    public $p_anak_riwayat_lahir_pb;

    // HAMIL
    public $hpht;
    public $usia_kehamilan;

    public $ttd = [];

    public $showIdentitas = true;

    public $selectedTtdPerawat;
    public $selectedAnalisaMasalah;

    protected $listeners = [
        'openAsesmenModal' => 'openFor',
    ];

    public function mount($antrianId = null)
    {
        if ($antrianId) {
            $this->openFor($antrianId);
        }
    }

    public function openFor($antrianId)
    {
        $this->ttd = TtdMedis::where('status', true)->get();

        $this->antrianId = $antrianId;
        $this->loadAntrianData();
        $this->activeTab = 'asesmen';

        // Bootstrap modal
        $this->dispatchBrowserEvent('open-periksa-modal');
    }

    public function setTab($tab)
    {
        if (in_array($tab, ['asesmen', 'kajian', 'hamil'])) {
            $this->activeTab = $tab;
        }
    }

    public function updatedSelectedTtdPerawat($value)
    {
        $this->isAsesmenFilled = !empty($value);
    }

    public function updatedSelectedAnalisaMasalah($value)
    {
        $this->isKajianFilled = !empty($value);
    }

    public function toggleIdentitas()
    {
        $this->showIdentitas = !$this->showIdentitas;
    }

    private function loadAntrianData()
    {
        $this->antrian = AntrianPerawat::with([
            'booking.pasien',
            'poli',
            'rm',
            'isian',
        ])->find($this->antrianId);

        if (!$this->antrian) {
            return;
        }

        $this->booking = $this->antrian->booking;
        $now = Carbon::now();

        /**
         * ======================
         * ASESMEN (RM)
         * ======================
         */
        $this->createdAtRM = optional($this->antrian->rm)->created_at;

        $this->nextAsesmenDate = $this->createdAtRM
            ? Carbon::parse($this->createdAtRM)->addMonths(3)
            : null;

        $this->shouldShowAsesmenWarning =
            !$this->createdAtRM ||
            ($this->nextAsesmenDate && $now->gte($this->nextAsesmenDate));

        /**
         * ======================
         * KAJIAN
         * ======================
         */
        $this->lastKajianDate = optional($this->antrian->kajian)->created_at;

        $this->nextKajianDate = $this->lastKajianDate
            ? Carbon::parse($this->lastKajianDate)->addMonths(3)
            : null;

        $this->shouldShowKajianWarning =
            !$this->lastKajianDate ||
            ($this->nextKajianDate && $now->gte($this->nextKajianDate));

        /**
         * ======================
         * PREFILL / RESET
         * ======================
         */
        if (!$this->shouldShowAsesmenWarning) {
            $this->prefillAsesmen();
        } else {
            $this->resetAsesmen();
        }

        $this->isAsesmenFilled = !empty($this->antrian->isian);
        $this->isKajianFilled  = !empty($this->antrian->kajian?->nama_perawat);
    }

    protected function prefillAsesmen()
    {
        $isian = $this->antrian->isian?->first();

        if (!$isian) {
            $this->resetAsesmen();
            return;
        }

        $this->p_tensi = $isian->p_tensi;
        $this->p_rr    = $isian->p_rr;
        $this->p_nadi  = $isian->p_nadi;
        $this->p_suhu  = $isian->p_suhu;

        $this->p_tb = $isian->p_tb;
        $this->p_bb = $isian->p_bb;
        $this->hitungImt();

        $this->gcs_e = $isian->gcs_e ?? 0;
        $this->gcs_m = $isian->gcs_m ?? 0;
        $this->gcs_v = $isian->gcs_v ?? 0;
        $this->hitungGcs();

        $this->nutrisi_tb = $isian->nutrisi_tb;
        $this->nutrisi_bb = $isian->nutrisi_bb;
        $this->hitungImtKajian();

        $this->p_anak_riwayat_lahir_bb = $isian->p_anak_riwayat_lahir_bb;
        $this->p_anak_riwayat_lahir_pb = $isian->p_anak_riwayat_lahir_pb;
    }

    protected function resetAsesmen()
    {
        $this->reset([
            'p_tensi', 'p_rr', 'p_nadi', 'p_suhu',
            'p_tb', 'p_bb', 'p_imt',
            'gcs_e', 'gcs_m', 'gcs_v', 'gcs_total',
            'nutrisi_tb', 'nutrisi_bb', 'nutrisi_imt',
        ]);
    }

    // ====================
    // GCS - Diperbaiki
    // ====================
    public function updatedGcsE() { $this->hitungGcs(); }
    public function updatedGcsM() { $this->hitungGcs(); }
    public function updatedGcsV() { $this->hitungGcs(); }

    protected function hitungGcs()
    {
        $e = (int) $this->gcs_e;
        $m = (int) $this->gcs_m;
        $v = (int) $this->gcs_v;

        $total = $e + $m + $v;

        // Total maksimal 15, tidak boleh lebih
        $this->gcs_total = $total > 15 ? 15 : $total;

        // Nilai E, M, V TETAP asli (tidak diubah/dibulatkan)
        // Hanya total yang dibatasi 15
    }

    // ====================
    // IMT ASESMEN - Realtime
    // ====================
    public function updatedPTb() { $this->hitungImt(); }
    public function updatedPBb() { $this->hitungImt(); }

    protected function hitungImt()
    {
        if ($this->p_tb > 0 && $this->p_bb > 0) {
            $tinggiMeter = $this->p_tb / 100;
            $this->p_imt = round($this->p_bb / ($tinggiMeter * $tinggiMeter), 2);
        } else {
            $this->p_imt = null;
        }
    }

    // ====================
    // IMT KAJIAN - Realtime
    // ====================
    public function updatedNutrisiTb() { $this->hitungImtKajian(); }
    public function updatedNutrisiBb() { $this->hitungImtKajian(); }

    protected function hitungImtKajian()
    {
        if ($this->nutrisi_tb > 0 && $this->nutrisi_bb > 0) {
            $tinggiMeter = $this->nutrisi_tb / 100;
            $this->nutrisi_imt = round($this->nutrisi_bb / ($tinggiMeter * $tinggiMeter), 2);
        } else {
            $this->nutrisi_imt = null;
        }
    }

    // HAMIL
    public function updatedHpht($value)
    {
        if ($value) {
            $hphtDate = Carbon::parse($value);
            $today = Carbon::now();

            $diffWeeks = $hphtDate->diffInWeeks($today);
            $diffDays = $hphtDate->diffInDays($today) % 7;

            $this->usia_kehamilan = "{$diffWeeks} minggu {$diffDays} hari";
        } else {
            $this->usia_kehamilan = null;
        }
    }

    public function render()
    {
        return view('perawat.modalPerawat.livewire.asesmen-pasien-modal');
    }
}
