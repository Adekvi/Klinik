<?php

namespace App\Http\Controllers\Dokter\Gambar;

use App\Http\Controllers\Controller;
use App\Models\AntrianPerawat;
use App\Models\Fisik;
use App\Models\RmDa1;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GambarDokterController extends Controller
{
    public function tambah(Request $request, $id)
    {
        // dd($request->all());
        // Ambil data dokter dan pasien dari $id
        $antrianDokter = AntrianPerawat::with(['booking.pasien', 'rm', 'isian', 'poli'])->find($id);

        // Periksa apakah $antrianDokter ditemukan
        if (!$antrianDokter) {
            return redirect()->back()->withErrors(['error' => 'Antrian Dokter tidak ditemukan.']);
        }

        // Ambil id_dokter dan id_pasien dengan relasi yang sesuai
        $dokter_id = $antrianDokter->id_dokter;
        $booking = $antrianDokter->booking;

        // Periksa apakah relasi booking ditemukan
        if (!$booking) {
            return redirect()->back()->withErrors(['error' => 'Booking tidak ditemukan untuk Antrian Dokter ini.']);
        }

        $pasien_id = $booking->id_pasien;

        // Tangani field yang mungkin array
        $samping = $request->input('samping');
        $depan = $request->input('depan');
        $belakang = $request->input('belakang');

        $tgl_kunjungan = Carbon::now();
        $alergi_gigi = $request->input('alergi_gigi');
        $skala_nyeriGigi = $request->input('skala_nyeriGigi');
        $metode = $request->input('metode');
        $wongbaker = $request->input('wongbaker');
        $a_riwayat_penggunaan_obat = $request->input('a_riwayat_penggunaan_obat');
        $periksa_fisik = $request->input('periksa_fisik');

        // Tangani no_gigi dan keadaan_gigi yang mungkin array
        $no_gigi = is_array($request->input('no_gigi')) ? implode(',', $request->input('no_gigi')) : $request->input('no_gigi');
        $keadaan_gigi = is_array($request->input('keadaan_gigi')) ? implode(',', $request->input('keadaan_gigi')) : $request->input('keadaan_gigi');

        $keterangan_gigi = $request->input('keterangan_gigi');
        $occlusi_gigi = $request->input('occlusi_gigi');
        $torus_palatines = $request->input('torus_palatines');
        $torus_mandibularis = $request->input('torus_mandibularis');
        $palatum = $request->input('palatum');
        $diastema = $request->input('diastema');
        $diastema_alasan = $request->input('diastema_alasan');
        $gigi_anomali = $request->input('gigi_anomali');
        $gigi_anomali_alasan = $request->input('gigi_anomali_alasan');
        $gigi_lain_lain = $request->input('gigi_lain_lain');
        $foto_yg_diambil_digital = $request->input('foto_yg_diambil_digital');
        $foto_yg_diambil_intraoral = $request->input('foto_yg_diambil_intraoral');
        $foto_jumlah = $request->input('foto_jumlah');
        $foto_rontgen_ambil_dental = $request->input('foto_rontgen_ambil_dental');
        $foto_rontgen_ambil_pa = $request->input('foto_rontgen_ambil_pa');
        $foto_rontgen_ambil_opg = $request->input('foto_rontgen_ambil_opg');
        $foto_rontgen_ambil_ceph = $request->input('foto_rontgen_ambil_ceph');
        $foto_rontgen_jumlah = $request->input('foto_rontgen_jumlah');
        $keterangan = $request->input('keterangan');
        $tindakan_gigi = $request->input('tindakan_gigi');
        $prosedur_tindakan = $request->input('prosedur_tindakan');
        $tgl_rencana = $request->input('tgl_rencana');
        $lama_tindakan = $request->input('lama_tindakan');
        $hasil_tindakan = $request->input('hasil_tindakan');
        $indikasi_tindakan = $request->input('indikasi_tindakan');
        $tujuan_tindakan = $request->input('tujuan_tindakan');
        $resiko_tindakan = $request->input('resiko_tindakan');
        $komplikasi_tindakan = $request->input('komplikasi_tindakan');
        $prognosa_tindakan = $request->input('prognosa_tindakan');
        $alternatif_resiko = $request->input('alternatif_resiko');
        $keterangan_tindakan = $request->input('keterangan_tindakan');

        // Tangani checkbox (jika tidak dicentang, set null)
        $jenis_pelayanan_preventif = $request->input('jenis_pelayanan_preventif', null);
        $jenis_pelayanan_preventif_alasan = $request->input('jenis_pelayanan_preventif_alasan', null);
        $jenis_pelayanan_paliatif = $request->input('jenis_pelayanan_paliatif', null);
        $jenis_pelayanan_paliatif_alasan = $request->input('jenis_pelayanan_paliatif_alasan', null);
        $jenis_pelayanan_kuratif = $request->input('jenis_pelayanan_kuratif', null);
        $jenis_pelayanan_kuratif_alasan = $request->input('jenis_pelayanan_kuratif_alasan', null);
        $jenis_pelayanan_rehabilitatif = $request->input('jenis_pelayanan_rehabilitatif', null);
        $jenis_pelayanan_rehabilitatif_alasan = $request->input('jenis_pelayanan_rehabilitatif_alasan', null);

        $data = [
            'id_dokter' => $dokter_id,
            'id_pasien' => $pasien_id,
            'id_booking' => $antrianDokter->id_booking,
            'id_rm' => $antrianDokter->id_rm,
            'id_isian' => $antrianDokter->id_isian,
            // TUBUH
            'samping' => $samping,
            'depan' => $depan,
            'belakang' => $belakang,
            // GIGI
            'tgl_kunjungan' => $tgl_kunjungan,
            'alergi_gigi' => $alergi_gigi,
            'skala_nyeriGigi' => $skala_nyeriGigi,
            'metode' => $metode,
            'wongbaker' => $wongbaker,
            'a_riwayat_penggunaan_obat' => $a_riwayat_penggunaan_obat,
            'periksa_fisik' => $periksa_fisik,
            'no_gigi' => $no_gigi,
            'keadaan_gigi' => $keadaan_gigi,
            'keterangan_gigi' => $keterangan_gigi,
            'occlusi_gigi' => $occlusi_gigi,
            'torus_palatines' => $torus_palatines,
            'torus_mandibularis' => $torus_mandibularis,
            'palatum' => $palatum,
            'diastema' => $diastema,
            'diastema_alasan' => $diastema_alasan,
            'gigi_anomali' => $gigi_anomali,
            'gigi_anomali_alasan' => $gigi_anomali_alasan,
            'gigi_lain_lain' => $gigi_lain_lain,
            'foto_yg_diambil_digital' => $foto_yg_diambil_digital,
            'foto_yg_diambil_intraoral' => $foto_yg_diambil_intraoral,
            'foto_jumlah' => $foto_jumlah,
            'foto_rontgen_ambil_dental' => $foto_rontgen_ambil_dental,
            'foto_rontgen_ambil_pa' => $foto_rontgen_ambil_pa,
            'foto_rontgen_ambil_opg' => $foto_rontgen_ambil_opg,
            'foto_rontgen_ambil_ceph' => $foto_rontgen_ambil_ceph,
            'foto_rontgen_jumlah' => $foto_rontgen_jumlah,
            'keterangan' => $keterangan,
            'tindakan_gigi' => $tindakan_gigi,
            'prosedur_tindakan' => $prosedur_tindakan,
            'tgl_rencana' => $tgl_rencana,
            'lama_tindakan' => $lama_tindakan,
            'hasil_tindakan' => $hasil_tindakan,
            'indikasi_tindakan' => $indikasi_tindakan,
            'tujuan_tindakan' => $tujuan_tindakan,
            'resiko_tindakan' => $resiko_tindakan,
            'komplikasi_tindakan' => $komplikasi_tindakan,
            'prognosa_tindakan' => $prognosa_tindakan,
            'alternatif_resiko' => $alternatif_resiko,
            'keterangan_tindakan' => $keterangan_tindakan,
            'jenis_pelayanan_preventif' => $jenis_pelayanan_preventif,
            'jenis_pelayanan_preventif_alasan' => $jenis_pelayanan_preventif_alasan,
            'jenis_pelayanan_paliatif' => $jenis_pelayanan_paliatif,
            'jenis_pelayanan_paliatif_alasan' => $jenis_pelayanan_paliatif_alasan,
            'jenis_pelayanan_kuratif' => $jenis_pelayanan_kuratif,
            'jenis_pelayanan_kuratif_alasan' => $jenis_pelayanan_kuratif_alasan,
            'jenis_pelayanan_rehabilitatif' => $jenis_pelayanan_rehabilitatif,
            'jenis_pelayanan_rehabilitatif_alasan' => $jenis_pelayanan_rehabilitatif_alasan,
        ];

        // Simpan data fisik ke dalam database
        Fisik::create($data);

        // Tangani data anamnesis yang mungkin array
        $dataAnamnesis = [
            'id_pasien' => $pasien_id,
            'id_poli' => $antrianDokter->id_poli,
            'id_dokter' => $antrianDokter->id_dokter,
            'a_keluhan_utama' => is_array($request->input('a_keluhan_utama')) ? implode(',', $request->input('a_keluhan_utama')) : $request->input('a_keluhan_utama'),
            'a_riwayat_penyakit_skrg' => is_array($request->input('a_riwayat_penyakit_skrg')) ? implode(',', $request->input('a_riwayat_penyakit_skrg')) : $request->input('a_riwayat_penyakit_skrg'),
            'a_riwayat_penyakit_terdahulu' => is_array($request->input('a_riwayat_penyakit_terdahulu')) ? implode(',', $request->input('a_riwayat_penyakit_terdahulu')) : $request->input('a_riwayat_penyakit_terdahulu'),
            'a_riwayat_penyakit_keluarga' => is_array($request->input('a_riwayat_penyakit_keluarga')) ? implode(',', $request->input('a_riwayat_penyakit_keluarga')) : $request->input('a_riwayat_penyakit_keluarga'),
        ];

        // Update data anamnesis
        RmDa1::where('id', $antrianDokter->id_rm)->update($dataAnamnesis);

        // Redirect dengan pesan sukses
        return redirect()->route('dokter.soap', ['id' => $id])
            ->with('toast_success', 'Data Odontogram Berhasil Disimpan');
    }

    public function editUmumGigi(Request $request, $id)
    {
        // Ambil data dokter dan pasien dari $id
        $antrianDokter = AntrianPerawat::with(['booking.pasien', 'rm', 'isian', 'poli'])->find($id);

        if (!$antrianDokter) {
            return redirect()->back()->withErrors(['error' => 'Antrian Dokter tidak ditemukan.']);
        }

        $dokter_id = $antrianDokter->id_dokter;
        $booking = $antrianDokter->booking;

        if (!$booking) {
            return redirect()->back()->withErrors(['error' => 'Booking tidak ditemukan untuk Antrian Dokter ini.']);
        }

        $pasien_id = $booking->id_pasien;

        // Cari record Fisik berdasarkan id_pasien atau relasi lainnya
        $fisik = Fisik::where('id_pasien', $pasien_id)
            ->where('id_booking', $antrianDokter->id_booking)
            ->first();

        if (!$fisik) {
            return redirect()->back()->withErrors(['error' => 'Data Fisik tidak ditemukan untuk pasien ini.']);
        }

        // Tangani field yang mungkin array
        $samping = $request->input('samping');
        $depan = $request->input('depan');
        $belakang = $request->input('belakang');

        $tgl_kunjungan = Carbon::now();
        $alergi_gigi = $request->input('alergi_gigi');
        $skala_nyeriGigi = $request->input('skala_nyeriGigi');
        $metode = $request->input('metode');
        $wongbaker = $request->input('wongbaker');
        $a_riwayat_penggunaan_obat = $request->input('a_riwayat_penggunaan_obat');
        $periksa_fisik = $request->input('periksa_fisik');

        // Tangani no_gigi dan keadaan_gigi yang mungkin array
        $no_gigi = is_array($request->input('no_gigi')) ? implode(',', $request->input('no_gigi')) : $request->input('no_gigi');
        $keadaan_gigi = is_array($request->input('keadaan_gigi')) ? implode(',', $request->input('keadaan_gigi')) : $request->input('keadaan_gigi');

        $keterangan_gigi = $request->input('keterangan_gigi');
        $occlusi_gigi = $request->input('occlusi_gigi');
        $torus_palatines = $request->input('torus_palatines');
        $torus_mandibularis = $request->input('torus_mandibularis');
        $palatum = $request->input('palatum');
        $diastema = $request->input('diastema');
        $diastema_alasan = $request->input('diastema_alasan');
        $gigi_anomali = $request->input('gigi_anomali');
        $gigi_anomali_alasan = $request->input('gigi_anomali_alasan');
        $gigi_lain_lain = $request->input('gigi_lain_lain');
        $foto_yg_diambil_digital = $request->input('foto_yg_diambil_digital');
        $foto_yg_diambil_intraoral = $request->input('foto_yg_diambil_intraoral');
        $foto_jumlah = $request->input('foto_jumlah');
        $foto_rontgen_ambil_dental = $request->input('foto_rontgen_ambil_dental');
        $foto_rontgen_ambil_pa = $request->input('foto_rontgen_ambil_pa');
        $foto_rontgen_ambil_opg = $request->input('foto_rontgen_ambil_opg');
        $foto_rontgen_ambil_ceph = $request->input('foto_rontgen_ambil_ceph');
        $foto_rontgen_jumlah = $request->input('foto_rontgen_jumlah');
        $keterangan = $request->input('keterangan');
        $tindakan_gigi = $request->input('tindakan_gigi');
        $prosedur_tindakan = $request->input('prosedur_tindakan');
        $tgl_rencana = $request->input('tgl_rencana');
        $lama_tindakan = $request->input('lama_tindakan');
        $hasil_tindakan = $request->input('hasil_tindakan');
        $indikasi_tindakan = $request->input('indikasi_tindakan');
        $tujuan_tindakan = $request->input('tujuan_tindakan');
        $resiko_tindakan = $request->input('resiko_tindakan');
        $komplikasi_tindakan = $request->input('komplikasi_tindakan');
        $prognosa_tindakan = $request->input('prognosa_tindakan');
        $alternatif_resiko = $request->input('alternatif_resiko');
        $keterangan_tindakan = $request->input('keterangan_tindakan');

        $jenis_pelayanan_preventif = $request->input('jenis_pelayanan_preventif', null);
        $jenis_pelayanan_paliatif = $request->input('jenis_pelayanan_paliatif', null);
        $jenis_pelayanan_kuratif = $request->input('jenis_pelayanan_kuratif', null);
        $jenis_pelayanan_rehabilitatif = $request->input('jenis_pelayanan_rehabilitatif', null);

        $data = [
            'id_dokter' => $dokter_id,
            'id_pasien' => $pasien_id,
            'id_booking' => $antrianDokter->id_booking,
            'id_rm' => $antrianDokter->id_rm,
            'id_isian' => $antrianDokter->id_isian,
            'samping' => $samping,
            'depan' => $depan,
            'belakang' => $belakang,
            'tgl_kunjungan' => $tgl_kunjungan,
            'alergi_gigi' => $alergi_gigi,
            'skala_nyeriGigi' => $skala_nyeriGigi,
            'metode' => $metode,
            'wongbaker' => $wongbaker,
            'a_riwayat_penggunaan_obat' => $a_riwayat_penggunaan_obat,
            'periksa_fisik' => $periksa_fisik,
            'no_gigi' => $no_gigi,
            'keadaan_gigi' => $keadaan_gigi,
            'keterangan_gigi' => $keterangan_gigi,
            'occlusi_gigi' => $occlusi_gigi,
            'torus_palatines' => $torus_palatines,
            'torus_mandibularis' => $torus_mandibularis,
            'palatum' => $palatum,
            'diastema' => $diastema,
            'diastema_alasan' => $diastema_alasan,
            'gigi_anomali' => $gigi_anomali,
            'gigi_anomali_alasan' => $gigi_anomali_alasan,
            'gigi_lain_lain' => $gigi_lain_lain,
            'foto_yg_diambil_digital' => $foto_yg_diambil_digital,
            'foto_yg_diambil_intraoral' => $foto_yg_diambil_intraoral,
            'foto_jumlah' => $foto_jumlah,
            'foto_rontgen_ambil_dental' => $foto_rontgen_ambil_dental,
            'foto_rontgen_ambil_pa' => $foto_rontgen_ambil_pa,
            'foto_rontgen_ambil_opg' => $foto_rontgen_ambil_opg,
            'foto_rontgen_ambil_ceph' => $foto_rontgen_ambil_ceph,
            'foto_rontgen_jumlah' => $foto_rontgen_jumlah,
            'keterangan' => $keterangan,
            'tindakan_gigi' => $tindakan_gigi,
            'prosedur_tindakan' => $prosedur_tindakan,
            'tgl_rencana' => $tgl_rencana,
            'lama_tindakan' => $lama_tindakan,
            'hasil_tindakan' => $hasil_tindakan,
            'indikasi_tindakan' => $indikasi_tindakan,
            'tujuan_tindakan' => $tujuan_tindakan,
            'resiko_tindakan' => $resiko_tindakan,
            'komplikasi_tindakan' => $komplikasi_tindakan,
            'prognosa_tindakan' => $prognosa_tindakan,
            'alternatif_resiko' => $alternatif_resiko,
            'keterangan_tindakan' => $keterangan_tindakan,
            'jenis_pelayanan_preventif' => $jenis_pelayanan_preventif,
            'jenis_pelayanan_paliatif' => $jenis_pelayanan_paliatif,
            'jenis_pelayanan_kuratif' => $jenis_pelayanan_kuratif,
            'jenis_pelayanan_rehabilitatif' => $jenis_pelayanan_rehabilitatif,
        ];

        // Update data menggunakan ID dari Fisik
        $fisik->update($data);

        // Tangani data anamnesis yang mungkin array
        $dataAnamnesis = [
            'id_pasien' => $pasien_id,
            'id_poli' => $antrianDokter->id_poli,
            'id_dokter' => $antrianDokter->id_dokter,
            'a_keluhan_utama' => is_array($request->input('a_keluhan_utama')) ? implode(',', $request->input('a_keluhan_utama')) : $request->input('a_keluhan_utama'),
            'a_riwayat_penyakit_skrg' => is_array($request->input('a_riwayat_penyakit_skrg')) ? implode(',', $request->input('a_riwayat_penyakit_skrg')) : $request->input('a_riwayat_penyakit_skrg'),
            'a_riwayat_penyakit_terdahulu' => is_array($request->input('a_riwayat_penyakit_terdahulu')) ? implode(',', $request->input('a_riwayat_penyakit_terdahulu')) : $request->input('a_riwayat_penyakit_terdahulu'),
            'a_riwayat_penyakit_keluarga' => is_array($request->input('a_riwayat_penyakit_keluarga')) ? implode(',', $request->input('a_riwayat_penyakit_keluarga')) : $request->input('a_riwayat_penyakit_keluarga'),
        ];

        // Update data anamnesis
        RmDa1::where('id', $antrianDokter->id_rm)->update($dataAnamnesis);

        return redirect()->route('dokter.soap', ['id' => $id])
            ->with('toast_success', 'Data Odontogram Berhasil Diubah');
    }
}
