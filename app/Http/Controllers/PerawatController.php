<?php

namespace App\Http\Controllers;

use App\Models\IsianPerawat;
use App\Models\Pasien;
use App\Models\Poli;
use App\Models\RmDa1;
use Illuminate\Http\Request;

class PerawatController extends Controller
{
    public function index ()
    {
        $perawat = IsianPerawat::with('pasien');
        $pasien = Pasien::all();
        $poli = Poli::all();
        
        return view('perawat.index', compact('pasien','perawat', 'poli'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'poli' => 'required',
        ]);
        $data = $request->all();
        // $poli = $data['poli'];
        // dd($data);
        $anamnesis = new RmDa1();
        // $anamnesis->id = $data['id'];
        $anamnesis->pasien = $data['pasien'];
        $anamnesis->poli = $data['poli'];
        $anamnesis->a_keluhan_utama = $data['a_keluhan_utama'];
        $anamnesis->a_riwayat_penyakit_skrg = $data['a_riwayat_penyakit_skrg'];
        $anamnesis->a_riwayat_penyakit_terdahulu = $data['a_riwayat_penyakit_terdahulu'];
        $anamnesis->a_riwayat_penyakit_keluarga = $data['a_riwayat_penyakit_keluarga'];
        $anamnesis->a_riwayat_alergi = $data['a_riwayat_alergi'];
        $anamnesis->o_keadaan_umum = $data['keadaan_umum'];
        $anamnesis->o_kesadaran = $data['kesadaran'];
        $anamnesis->o_kepala = $data['kepala'];
        $anamnesis->o_kepala_uraian = $data['alasan-kepala'];
        $anamnesis->o_mata = $data['mata'];
        $anamnesis->o_mata_uraian = $data['alasan-mata'];
        $anamnesis->o_tht = $data['tht'];
        $anamnesis->o_tht_uraian = $data['alasan-tht'];
        $anamnesis->o_paru = $data['paru'];
        $anamnesis->o_paru_uraian = $data['alasan-paru'];
        $anamnesis->o_jantung = $data['jantung'];
        $anamnesis->o_jantung_uraian = $data['alasan-jantung'];
        $anamnesis->o_abdomen = $data['abdomen'];
        $anamnesis->o_abdomen_uraian = $data['alasan-abdomen'];
        $anamnesis->o_leher = $data['leher'];
        $anamnesis->o_leher_uraian = $data['alasan-leher'];
        $anamnesis->o_ekstremitas = $data['ekstremitas'];
        $anamnesis->o_ekstremitas_uraian = $data['alasan-ekstremitas'];
        $anamnesis->o_kulit = $data['kulit'];
        $anamnesis->o_kulit_uraian = $data['alasan-kulit'];
        // dd($data);
        // Simpan data ke dalam database
        $data2 = [
            'pasien' => $request->pasien,
            'poli' => $request->poli,
            'p_form_isian_pilihan' => $request->isian,
            'p_form_isian_pilihan_uraian' => $request->isian_alasan,
            'p_dws_rokok' => $request->rokok,
            'p_dws_alkohol' => $request->alkohol,
            'p_obat_tidur' => $request->obat_tidur,
            'p_dws_olahraga' => $request->olahraga,
            'p_anak_riwayat_lahir' => $request->p_anak_riwayat_lahir,
            'p_anak_riwayat_lahir_bulan' => $request->p_anak_riwayat_lahir_bulan,
            'p_anak_riwayat_lahir_bb' => $request->p_anak_riwayat_lahir_bb,
            'p_anak_riwayat_lahir_pb' => $request->p_anak_riwayat_lahir_pb,
            'p_anak_riwayat_lahir_vaksin' => $request->p_anak_riwayat_lahir_vaksin,
            'p_tensi' => $request->tensi,
            'p_rr' => $request->rr,
            'p_suhu' => $request->suhu,
            'p_nadi' => $request->nadi,
            'p_tb' => $request->tb,
            'p_bb' => $request->bb,
            'ak_nutrisi_bb' => $request->nutrisi_bb,
            'ak_nutrisi_tb' => $request->nutrisi_tb,
            'ak_nutrisi_imt' => $request->imt,
            'ak_jenisaktifitas_mobilisasi' => $request->ak_jenisaktivitas_mobilisasi,
            'ak_jenisaktifitas_toileting' => $request->ak_jenisaktivitas_toileting,
            'ak_jenisaktifitas_makan_minum' => $request->ak_jenisaktivitas_makan_minum,
            'ak_jenisaktifitas_mandi' => $request->ak_jenisaktivitas_mandi,
            'ak_jenisaktifitas_berpakaian' => $request->ak_jenisaktivitas_berpakaian,
            'ak_resiko_jatuh' => $request->ak_resiko_jatuh,
            'ak_psikologis' => $request->ak_psikologis,
            'ak_psikologis_lain' => $request->alasan_ak_psikologis_lain,
            'ak_masalah' => $request->ak_masalah,
            'ak_rencana_tindakan' => $request->ak_rencana_tindakan,
            'psico_pengetahuan_ttg_penyakit_ini' => $request->psico_pengetahuan_ttg_penyakit_ini,
            'psico_perawatan_tindakan_yg_dilakukan' => $request->psico_perawatan_tindakan_yg_dlakukan,
            'psico_adakah_keyakinan_pantangan' => $request->psico_adakah_keyakinan_pantangan,
            'psico_kendala_komunikasi' => $request->psico_kendala_kominukasi,
            'psico_yg_merawat_dirumah' => $request->psico_yang_merawat_dirumah,
            'nyeri_apakah_pasien_merasakan_nyeri' => $request->nyeri_apakah_pasien_merasakan_nyeri,
            'nyeri_pencetus' => $request->nyeri_pencetus,
            'nyeri_kualitas' => $request->nyeri_kualitas,
            'nyeri_lokasi' => $request->nyeri_lokasi,
            'nyeri_skala' => $request->nyeri_skala,
            'nyeri_waktu' => $request->nyeri_waktu,
            'jatuh_sempoyong' => $request->jatuh_sempoyong,
            'jatuh_pegangan' => $request->jatuh_pegangan,
            'jatuh_hasil_kajian' => $request->jatuh_hasil_kajian,
            'ak_nama_perawat_bidan' => $request->ak_nama_perawat_bidan,
            'ak_ttdperawat_bidan' => $request->ak_ttdperawat_bidan
        ];
        $anamnesis->save();
        IsianPerawat::create($data2);
        return redirect()->route('dokter.index')->with('success', 'Data Telah Tersimpan');
        // dd($data);
    }

    // Controller
    // public function savedata(Request $request)
    // {
    //     // Handle saving data logic here
    //     $data = $request->all();

    //     // Simpan data dalam sesi
    //     $request->session()->put('form_data', $data);

    //     // Determine whether to show the second modal based on your logic
    //     $showNextModal = true; // Ganti dengan logika Anda

    //     return response()->json(['success' => true, 'showNextModal' => $showNextModal]);
    // }

    // public function getNextModalContent(Request $request)
    // {
    //     // Dapatkan data dari sesi
    //     $formData = $request->session()->get('form_data', []);

    //     // Simpan data ke dalam database dan dapatkan tipe modal
    //     $modalType = $this->saveFormDataToDatabase($formData);

    //     // Tambahkan pesan log untuk memeriksa nilai $modalType
    //     error_log('getNextModalContent - modalType: ' . $modalType);

    //     if ($modalType === 'modal2') {
    //         // Jika tipe modal adalah modal kedua, kembalikan konten modal kedua sebagai respons AJAX
    //         $modal2Content = view('perawat.modalPerawat.ModalIsianPerawat')->render(); // Sesuaikan dengan nama view modal kedua Anda
    //         return response()->json($modal2Content);
    //     } else {
    //         // Jika tipe modal bukan modal kedua, kembalikan respons kosong
    //         return response()->json([]);
    //     }
    // }

    // private function saveFormDataToDatabase($formData)
    // {
    //     // Tambahkan pesan log untuk memeriksa aliran dan nilai $modalType
    //     error_log('formData: ' . print_r($formData, true));
    
    //     if (array_key_exists('modal_type', $formData)) {
    //         $modalType = $formData['modal_type'];
    //         // Tambahkan pesan log untuk memeriksa nilai $modalType
    //         error_log('modalType: ' . $modalType);
    
    //         switch ($modalType) {
    //             case 'modal1':
    //                 $rmDa1 = new RmDa1();
    //                 $rmDa1->pasien = $formData['field1']; // Ganti dengan nama kolom yang sesuai dalam tabel RmDa1
    //                 $rmDa1->field2 = $formData['field2'];
    //                 $rmDa1->save();
    //                 break;
    //             case 'modal2':
    //                 // Lakukan penyimpanan data untuk modal 2
    //                 // ...
    //                 break;
    //             default:
    //                 // Tindakan default jika modal_type tidak dikenali
    //                 break;
    //         }
    //         return $modalType;
    //     } else {
    //         // Tindakan yang akan diambil jika kunci 'modal_type' tidak ada dalam array $formData
    //         // Misalnya, lempar exception, log pesan kesalahan, atau tindakan lain sesuai kebutuhan Anda.
    //         // Di sini saya hanya mencetak pesan kesalahan ke log
    //         error_log('Kunci modal_type tidak ditemukan dalam data formulir yang diterima.');
    //         return null;
    //     }
    // }
    
    // public function storeModal1(Request $request)
    // {
    //     $validatedData = $request->validate([
    //        'poli' => 'required',
    //     ]);
    //     $data = $request->all();
    //     // $poli = $data['poli'];
    //     // dd($data);
    //     $anamnesis = new RmDa1();
    //     $anamnesis->pasien = $data['pasien'];
    //     $anamnesis->poli = $data['poli'];
    //     $anamnesis->a_keluhan_utama = $data['a_keluhan_utama'];
    //     $anamnesis->a_riwayat_penyakit_skrg = $data['a_riwayat_penyakit_skrg'];
    //     $anamnesis->a_riwayat_penyakit_terdahulu = $data['a_riwayat_penyakit_terdahulu'];
    //     $anamnesis->a_riwayat_penyakit_keluarga = $data['a_riwayat_penyakit_keluarga'];
    //     $anamnesis->a_riwayat_alergi = $data['a_riwayat_alergi'];
    //     $anamnesis->o_keadaan_umum = $data['keadaan_umum'];
    //     $anamnesis->o_kesadaran = $data['kesadaran'];
    //     $anamnesis->o_kepala = $data['kepala'];
    //     $anamnesis->o_kepala_uraian = $data['alasan-kepala'];
    //     $anamnesis->o_mata = $data['mata'];
    //     $anamnesis->o_mata_uraian = $data['alasan-mata'];
    //     $anamnesis->o_tht = $data['tht'];
    //     $anamnesis->o_tht_uraian = $data['alasan-tht'];
    //     $anamnesis->o_paru = $data['paru'];
    //     $anamnesis->o_paru_uraian = $data['alasan-paru'];
    //     $anamnesis->o_jantung = $data['jantung'];
    //     $anamnesis->o_jantung_uraian = $data['alasan-jantung'];
    //     $anamnesis->o_abdomen = $data['abdomen'];
    //     $anamnesis->o_abdomen_uraian = $data['alasan-abdomen'];
    //     $anamnesis->o_leher = $data['leher'];
    //     $anamnesis->o_leher_uraian = $data['alasan-leher'];
    //     $anamnesis->o_ekstremitas = $data['ekstremitas'];
    //     $anamnesis->o_ekstremitas_uraian = $data['alasan-ekstremitas'];
    //     $anamnesis->o_kulit = $data['kulit'];
    //     $anamnesis->o_kulit_uraian = $data['alasan-kulit'];
    //     // dd($data);
    //     // Simpan data ke dalam database
    //     $anamnesis->save();

    //     return response()->json(['success' => true]);
    // }

    // public function storeModal2(Request $request)
    // {
    //     // Validasi data jika diperlukan
    //     $validatedData = $request->validate([
    //         // Atur aturan validasi sesuai kebutuhan Anda
    //     ]);

    //     // Simpan data ke dalam database
    //     IsianPerawat::create($validatedData);

    //     // Kirim respon JSON ke JavaScript
    //     return response()->json(['success' => true]);
    // }


    
}