<?php

namespace App\Exports;

use App\Models\DiagnosaTerbanyak;
use Dompdf\Dompdf;
use Maatwebsite\Excel\Concerns\FromCollection;

class DiagnosaTerbanyakExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $allDiagnoses = DiagnosaTerbanyak::with('diagno')->get();

        $groupedDiagnoses = [];

        foreach ($allDiagnoses as $diagnosis) {
            $id = $diagnosis->id_diagnosa;
            $nm_diagno = $diagnosis->diagno->nm_diagno;
            $gender = $diagnosis->gender;

            if (!isset($groupedDiagnoses[$id])) {
                $groupedDiagnoses[$id] = [
                    'diagnosa' => $nm_diagno,
                    'laki_laki' => 0,
                    'perempuan' => 0,
                    'jumlah' => 0,
                ];
            }

            if ($gender == 'L') {
                $groupedDiagnoses[$id]['laki_laki'] += 1;
            } else {
                $groupedDiagnoses[$id]['perempuan'] += 1;
            }

            $groupedDiagnoses[$id]['jumlah'] += 1;
        }

        return collect($groupedDiagnoses);
    }

    public function exportToPDF()
    {
        $allDiagnoses = DiagnosaTerbanyak::with('diagno')->get();

        $groupedDiagnoses = [];

        foreach ($allDiagnoses as $diagnosis) {
            $id = $diagnosis->id_diagnosa;
            $nm_diagno = $diagnosis->diagno->nm_diagno;
            $gender = $diagnosis->gender;

            if (!isset($groupedDiagnoses[$id])) {
                $groupedDiagnoses[$id] = [
                    'diagnosa' => $nm_diagno,
                    'laki_laki' => 0,
                    'perempuan' => 0,
                    'jumlah' => 0,
                ];
            }

            if ($gender == 'L') {
                $groupedDiagnoses[$id]['laki_laki'] += 1;
            } else {
                $groupedDiagnoses[$id]['perempuan'] += 1;
            }

            $groupedDiagnoses[$id]['jumlah'] += 1;
        }

        // Generate HTML content for PDF
        $html = '<table>';
        foreach ($groupedDiagnoses as $diagnosis) {
            $html .= '<tr>';
            $html .= '<td>' . $diagnosis['diagnosa'] . '</td>';
            $html .= '<td>' . $diagnosis['laki_laki'] . '</td>';
            $html .= '<td>' . $diagnosis['perempuan'] . '</td>';
            $html .= '<td>' . $diagnosis['jumlah'] . '</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';

        // Create PDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        
        // Output PDF to browser
        $dompdf->stream('Diagnosa Terbanyak.pdf');
    }
}
