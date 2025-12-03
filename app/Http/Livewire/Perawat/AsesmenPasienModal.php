<?php

namespace App\Http\Livewire\Perawat;

use Livewire\Component;

class AsesmenPasienModal extends Component
{
    public $bookingId;
    public $booking;
    public $activeTab = 'asesmen';

    public function mount($bookingId = null)
    {
        if ($bookingId) {
            $this->bookingId = $bookingId;
            $this->booking = \App\Models\Booking::with(['pasien', 'rm', 'kajian'])
                ->findOrFail($bookingId);
        }
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }
    public function render()
    {
        return view('perawat.modalPerawat.livewire.asesmen-perawat-modal');
    }
}
