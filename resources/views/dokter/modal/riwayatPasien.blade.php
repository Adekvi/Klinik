<!-- Modal Utama: Riwayat Pasien -->
<div class="modal fade" id="riwayat{{ $antrianDokter->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="modalScrollableTitle" style="color: rgb(0, 0, 0)">Riwayat Periksa Pasien
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead class="table-primary" style="text-align: center;">
                            <tr>
                                <th>TGL DAN JAM</th>
                                <th>PROFESI</th>
                                <th>ASESMEN</th>
                                <th>EDUKASI</th>
                            </tr>
                        </thead>
                        @php
                            $allSoapPatients = [];
                        @endphp
                        @foreach ($soap as $item)
                            @php
                                $soapData = json_decode($item['soap_p'], true);
                                $allSoapPatients = array_merge($allSoapPatients, array_keys($soapData));
                            @endphp
                        @endforeach
                        @php
                            $allSoapPatients = array_unique($allSoapPatients);
                        @endphp
                        <tbody style="text-align: center; white-space: nowrap">
                            @if ($soapRiwayat->isEmpty())
                                <tr>
                                    <td colspan="6" style="text-align: center">Belum ada Asesmen</td>
                                </tr>
                            @else
                                @foreach ($soapRiwayat as $item)
                                    <tr>
                                        <td>{{ date_format(date_create($item['created_at']), 'Y-m-d/H:i:s') }}</td>
                                        <td>{{ $item['nama_dokter'] }}</td>
                                        <td style="text-align: left">
                                            <table class="table">
                                                <thead>
                                                    <tr style="text-align: center; font-weight: bold">
                                                        <td>S</td>
                                                        <td>O</td>
                                                        <td>A</td>
                                                        <td>P</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $item['keluhan_utama'] ?? '-' }}</td>
                                                        <td>
                                                            <ul>
                                                                <li>Tensi : {{ $item['p_tensi'] ?? '-' }} / mmHg</li>
                                                                <li>RR : {{ $item['p_rr'] ?? '-' }} / minute</li>
                                                                <li>Nadi : {{ $item['p_nadi'] ?? '-' }} / minute</li>
                                                                <li>Suhu : {{ $item['p_suhu'] ?? '-' }} °c</li>
                                                                <li>TB : {{ $item['p_tb'] ?? '-' }} / cm</li>
                                                                <li>BB : {{ $item['p_bb'] ?? '-' }} / kg</li>
                                                            </ul>
                                                        </td>
                                                        <td>
                                                            @php
                                                                $diagnosaPrimer = json_decode(
                                                                    $item['soap_a_primer'] ?? '[]',
                                                                    true,
                                                                );
                                                                $diagnosaPrimer = array_values($diagnosaPrimer);
                                                                $diagnosaSekunder = json_decode(
                                                                    $item['soap_a_sekunder'] ?? '[]',
                                                                    true,
                                                                );
                                                                $diagnosaSekunder = array_values($diagnosaSekunder);
                                                            @endphp
                                                            @if (!empty($diagnosaPrimer) || !empty($diagnosaSekunder))
                                                                @foreach ($diagnosaPrimer as $diag)
                                                                    <ul>
                                                                        <li>{{ $diag ?? '-' }}</li>
                                                                    </ul>
                                                                @endforeach
                                                                @foreach ($diagnosaSekunder as $diagn)
                                                                    <ul>
                                                                        <li>{{ $diagn ?? '-' }}</li>
                                                                    </ul>
                                                                @endforeach
                                                            @else
                                                                <ul>
                                                                    <li>Tidak Ada Diagnosa</li>
                                                                </ul>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <p style="font-weight: bold; margin-bottom: -0px">Resep :
                                                            </p>
                                                            <p style="font-weight: bold; margin-bottom: -0px"> - Non
                                                                Racikan</p>
                                                            @php
                                                                $resep = json_decode($item['soap_p'] ?? '[]', true);
                                                                $aturan = json_decode(
                                                                    $item['soap_p_aturan'] ?? '[]',
                                                                    true,
                                                                );
                                                            @endphp
                                                            @if (is_array($resep) && is_array($aturan) && count($resep) == count($aturan))
                                                                @foreach ($resep as $obat => $namaObat)
                                                                    @php
                                                                        $aturanMinum = $aturan[$obat] ?? '-';
                                                                    @endphp
                                                                    <ul>
                                                                        <li>{{ $namaObat ?? '-' }} |
                                                                            {{ $aturanMinum }}</li>
                                                                    </ul>
                                                                @endforeach
                                                            @else
                                                                <p>-</p>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>{{ $item['edukasi'] ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
