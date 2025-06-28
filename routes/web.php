<?php

use App\Http\Controllers\Admin\Akun\InfoController;
use App\Http\Controllers\Admin\Akun\ProfileController;
use App\Http\Controllers\Admin\Kunjungan\BookingController;
use App\Http\Controllers\Admin\Kunjungan\SehatController;
use App\Http\Controllers\Admin\Master\AksesController;
use App\Http\Controllers\Admin\Master\DataDiagnosaController;
use App\Http\Controllers\Admin\Master\DataDokterController;
use App\Http\Controllers\Admin\Master\DataMarginController;
use App\Http\Controllers\Admin\Master\DataObatController;
use App\Http\Controllers\Admin\Master\DataPasienController;
use App\Http\Controllers\Admin\Master\DataPoliController;
use App\Http\Controllers\Admin\Master\DataSemuaPasienController;
use App\Http\Controllers\Admin\Master\DataUserController;
use App\Http\Controllers\Admin\Master\PidioController;
use App\Http\Controllers\Admin\Master\PotoController;
use App\Http\Controllers\Admin\Master\PpnController;
use App\Http\Controllers\Admin\Master\ShiftController;
use App\Http\Controllers\Admin\Master\TindakanController;
use App\Http\Controllers\Admin\Master\TtdController;
use App\Http\Controllers\Admin\Obat\MasukObatController;
use App\Http\Controllers\Admin\Pesan\ChatController;
use App\Http\Controllers\Admin\Rekapan\AncController;
use App\Http\Controllers\Admin\Rekapan\DiagnosaController;
use App\Http\Controllers\Admin\Rekapan\HarianController;
use App\Http\Controllers\Admin\Rekapan\KBController;
use App\Http\Controllers\Admin\Rekapan\KejadianController;
use App\Http\Controllers\Admin\Rekapan\LuarBiasaController;
use App\Http\Controllers\Admin\Rekapan\PemeriksaanController;
use App\Http\Controllers\Admin\Rekapan\RekapPasienController;
use App\Http\Controllers\Admin\Rekapan\RujukanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AntrianController;
use App\Http\Controllers\ApotekerObatController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DataVideController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\LaporanPerawatController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\Perawat\DiagnosaTerbanyakController;
use App\Http\Controllers\Perawat\Laporan\PoliGigi\GigiBpjsController;
use App\Http\Controllers\Perawat\Laporan\PoliGigi\GigiUmumController;
use App\Http\Controllers\Perawat\Laporan\PoliUmum\UmumBpjsController;
use App\Http\Controllers\Perawat\Laporan\PoliUmum\UmumUmumController;
use App\Http\Controllers\PerawatController;
use App\Http\Controllers\PetunjukController;
use App\Http\Controllers\StokObatApotekerController;
use App\Http\Controllers\User\Dashboard\BerandaApotekerController;
use App\Http\Controllers\User\Dashboard\BerandaDokterController;
use App\Http\Controllers\User\Dashboard\BerandaKasirController;
use App\Http\Controllers\User\Dashboard\BerandaPerawatController;
use App\Models\Kasir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('');
// });

// Route::get('/home', [HomeController::class, 'index']);
Route::get('/', [HomeController::class, 'depan'])->name('/');
Route::get('/antrian', [HomeController::class, 'dashboard']);

// PETUNJUK
Route::get('petunjuk/index', [PetunjukController::class, 'index'])->name('petunjuk.index');

// pasien umum
Route::get('get-dokter-by-poli/{id}', [PasienController::class, 'getDokter'])->name('get-dokter-by-poli');
Route::get('search_nama_pasien', [PasienController::class, 'searchPasien'])->name('search_nama_pasien');
Route::get('/search_pasien_bpjs', [PasienController::class, 'searchPasienBpjs'])->name('search_pasien_bpjs');
Route::post('/update_pasien', [PasienController::class, 'updatePasien'])->name('update_pasien');
Route::get('get_pasien_details', [PasienController::class, 'getPasienDetail'])->name('get_pasien_details');
Route::get('/get_pasien_bpjs', [PasienController::class, 'getPasienDetailBpjs'])->name('get_pasien_bpjs');
// Route::post('/get-patient-data', [PasienController::class, 'getPatientData'])->name('get-patient-data');
Route::get('pasien/index', [PasienController::class, 'index'])->name('pasien.index');

// Pasien Baru
Route::post('/pasien/store-umum', [PasienController::class, 'storeUmum'])->name('pasien.store-umum');

// TOKEN
Route::get('/refresh-csrf', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

// Pasien Lama
Route::post('/pasien/store-bpjs', [PasienController::class, 'storeBpjs']);
Route::get('/pasien/show/{id_antrian}', [PasienController::class, 'show'])->name('pasien.show');
Route::post('/poli/store/{idBooking}', [PasienController::class, 'poliStore']);
Route::get('/pasien/latest-no-rm', [PasienController::class, 'getLatestNoRm']);

// pasien lama
Route::post('/pasien-lama/store', [PasienController::class, 'storeOld']);
Route::post('/get-patient-data', [PasienController::class, 'getPatientData']);

Route::group(['middleware' => ['auth', 'perawat']], function () {

    Route::get('perawat/dashboard', [BerandaPerawatController::class, 'index']);
    // perawat
    Route::get('perawat/index', [PerawatController::class, 'index'])->name('perawat.index');
    Route::get('perawat/daftar', [PerawatController::class, 'daftar'])->name('perawat.daftar');
    Route::post('perawat/store/{id}', [PerawatController::class, 'store']);

    // KAJIAN AWAL
    Route::post('perawat/kajian/{id}', [PerawatController::class, 'kajian']);

    // daftar pasien di perawat
    Route::post('/perawat/store-umum', [PerawatController::class, 'storeUmum']);
    Route::post('/perawat/store-bpjs', [PerawatController::class, 'storeBpjs']);

    // Rekap harian
    Route::get('rekap-harian', [LaporanPerawatController::class, 'rekap'])->name('rekap-harian.index');

    // Laporan Perawat untuk Kunjungan Pasien

    // Poli Umum - Pasien BPJS
    Route::get('laporan-perawat-pasienBpjs', [UmumBpjsController::class, 'poliUmumPasienBpjs'])->name('perawat.laporan.poliUmum.bpjs');

    // Cetak Pasien BPJS
    // Route::post('/perawat/bpjs/cetak', [UmumBpjsController::class, 'cetakUmumBpjs'])->name('cetakUmumBpjs');

    // export PasienBpjs -> Excel
    Route::get('export-UmumPasienBpjs', [UmumBpjsController::class, 'exportExcelUmumBpjs'])->name('export-pasienBpjs-Umum');

    // Poli Umum - Pasien UMUM
    Route::get('laporan-perawat-pasienUmum', [UmumUmumController::class, 'poliUmumPasienUmum'])->name('perawat.laporan.poliUmum.umum');

    // cari pasienUmum
    // Route::post('/perawat/umum/cetak', [UmumUmumController::class, 'cetakUmumUmum'])->name('cetak-Pasien-Umum');

    // export PasienUmum -> Excel
    Route::get('export/pasienUmum-Umum', [UmumUmumController::class, 'exportExcelUmumUmum'])->name('export-pasienUmum-Umum');

    // Poli Gigi - Pasien Bpjs
    Route::get('laporan/poliGigi/pasienBpjs', [GigiBpjsController::class, 'poliGigiPasienBpjs']);

    // Pasien BPJS
    // Route::post('/perawat/gigiBpjs/cetak', [LaporanPerawatController::class, 'printGigiBpjs'])->name('cetakGigi-PasienBpjs');

    // export Pasien Bpjs -> Excel
    Route::get('export/pasienBpjs-Gigi', [GigiBpjsController::class, 'exportExcelPoliGigiBpjs'])->name('exportGigi-pasienBpjs');

    // Poli Gigi - Pasien Umum
    Route::get('laporan/poliGigi/pasienUmum', [GigiUmumController::class, 'poliGigiPasienUmum']);

    // Cetak Pasien Umum
    // Route::post('/perawat/gigiUmum/cetak', [LaporanPerawatController::class, 'printGigiUmum'])->name('ceta-PasienUmum-Gigi');

    // export Pasien Umum -> Excel
    Route::get('export/pasienUmum-Gigi', [GigiUmumController::class, 'exportExcelPoliGigiUmum'])->name('export-Gigi-Umum');

    // pasien sehat
    Route::post('admin/pasien-sehat/tambah', [SehatController::class, 'store'])->name('pasien-sehat.tambah');

    // Route cetak
    Route::get('cetak-antrianPerawat/{id}', [PerawatController::class, 'cetakAntrianPerawat']);

    // Route untuk mendapatkan lewati
    Route::post('perawat/lewati/{id}', [PerawatController::class, 'lewatiAntrian'])->name('perawat.lewati');

    // Rekap Kunjungan
    Route::get('perawat/rekap/kunjungan', [PerawatController::class, 'rekapHarian'])->name('perawat.rekap.kunjungan');

    // Rekap Harian
    Route::get('perawat/rekap/harian', [BerandaPerawatController::class, 'pemeriksaan'])->name('perawat.rekap.harian');

    // EXPORT DATA
    Route::get('/perawat/laporan/export/excel', [BerandaPerawatController::class, 'exportExcel'])->name('perawat.laporan.export.excel');

    // REKAP DIAGNOSA
    Route::get('perawat/diagnosa-terbanyak', [DiagnosaTerbanyakController::class, 'indexdiagnosa'])->name('perawat.diagnosa');
    Route::get('perawat/diagnosa-terbanyak/export', [DiagnosaTerbanyakController::class, 'exportExcel'])->name('perawat.diagnosa.export');
});

Route::group(['middleware' => ['auth', 'dokter']], function () {
    Route::get('dokter/dashboard', [BerandaDokterController::class, 'index']);

    Route::post('dokter/lewati/{id}', [DokterController::class, 'lewatiAntrianDokter'])->name('dokter.lewati');
    // dokter
    Route::get('dokter/index', [DokterController::class, 'index'])->name('dokter.index');
    Route::get('dokter/soap/{id}', [DokterController::class, 'soap'])->name('dokter.soap');
    Route::post('dokter/store/{id}', [DokterController::class, 'store'])->name('dokter.store');
    Route::put('soap/update/{id}', [DokterController::class, 'updateSoap'])->name('soap.update');

    // datapasien telah diperiksa
    Route::get('dokter/periksa', [BerandaDokterController::class, 'periksa'])->name('dokter.periksa');

    // Dokter Umum
    Route::get('dokter/tubuh/{id}', [DokterController::class, 'dokterUmum'])->name('dokter.tubuh');

    // Dokter Gigi
    Route::get('dokter/odontogram/{id}', [DokterController::class, 'dokterGigi'])->name('dokter.odontogram');

    // tambah gambar dokter
    Route::post('dokter/tambah/{id}', [DokterController::class, 'tambah'])->name('dokter.tambah');

    Route::put('dokter/edit-fisik/{id}', [DokterController::class, 'editUmumGigi'])->name('dokter.editUmumGigi');

    Route::get('/search-diagnosa', [DokterController::class, 'searchDiagnosa']);
    Route::get('/resep-autocomplete', [DokterController::class, 'autocomplete']);
});

Route::group(['middleware' => ['auth', 'apoteker']], function () {
    Route::get('apotek/dashboard', [BerandaApotekerController::class, 'index']);
    // apotek
    Route::get('apotek/index', [ObatController::class, 'index'])->name('apotek.index');
    Route::post('obat/store/{id}', [ObatController::class, 'store'])->name('apotek.store');

    Route::post('obat/lewati/{id}', [ObatController::class, 'lewatiAntrianObat'])->name('obat.lewati');

    Route::get('cetak.kartu/{id}', [ObatController::class, 'cetakKartu'])->name('cetak.kartu');

    Route::get('/getHargaObat/{nama_obat}', [ObatController::class, 'getHargaObat']);

    // CARI OBAT
    Route::get('/cariObat-ganti', [ObatController::class, 'cariObat']);
    Route::get('/gantiObat-RegoGanti', [ObatController::class, 'gantiHargaObat']);

    // Master Apoteker
    Route::get('apoteker/masterObat', [ApotekerObatController::class, 'masterObat'])->name('apoteker.master.obat');
    Route::post('apoteker/dataobat-tambah', [ApotekerObatController::class, 'tambah'])->name('apoteker.tambah');
    Route::put('apoteker/dataobat-edit/{id}', [ApotekerObatController::class, 'edit'])->name('apoteker.edit');
    Route::delete('apoteker/dataobat-hapus/{id}', [ApotekerObatController::class, 'hapus'])->name('apoteker.hapus');
    Route::get('apoteker/master/obat/cari', [ApotekerObatController::class, 'search'])->name('apoteker.obat.cari');

    // UPLOUD OBAT
    Route::post('/apoteker/import', [ApotekerObatController::class, 'uploudObat'])->name('resep.import');
    Route::get('/master/obat/download-template', [ApotekerObatController::class, 'downloadTemplate'])->name('resep.downloadTemplate');

    // Stok Obat
    Route::get('apoteker/stok-Obat', [StokObatApotekerController::class, 'stokObat'])->name('apoteker.stok.obat');

    // Rekap Obat
    // Obat Masuk
    Route::get('apoteker/obatMasuk', [StokObatApotekerController::class, 'obatMasuk'])->name('apoteker.obat.masuk');
    Route::post('cari-ObatMasuk', [StokObatApotekerController::class, 'searchObatMasuk'])->name('seacrh-apoteker.ObatMasuk');

    // Obat Keluar
    Route::get('apoteker/obatKeluar', [StokObatApotekerController::class, 'obatKeluar'])->name('apoteker.obatKeluar');
    Route::get('apoteker-cari-obatKeluar', [StokObatApotekerController::class, 'searchObatKeluar'])->name('cari-ObatKeluar.apoteker');
});

Route::group(['middleware' => ['auth', 'kasir']], function () {
    Route::get('kasir/dashboard', [BerandaKasirController::class, 'index']);

    Route::get('kasir/index', [KasirController::class, 'index'])->name('kasir.index');

    Route::post('kasir/lewati/{id}', [KasirController::class, 'lewatiAntrianKasir'])->name('kasir.lewati');

    Route::get('kasir/rekap', [BerandaKasirController::class, 'check'])->name('kasir.check');
    Route::get('kasir/report', [BerandaKasirController::class, 'report'])->name('kasir.report');

    Route::get('kasir/totalan/{id}', [KasirController::class, 'totalan'])->name('kasir.total');

    Route::post('kasir/tambah/{id}', [KasirController::class, 'simpanTransaksi'])->name('kasir.tambah');

    Route::get('kasir/cetakTransaksi/{id}', [KasirController::class, 'cetakTransaksi'])->name('kasir.cetakTransaksi');

    Route::get('/kasir/laporan/export/excel', [BerandaKasirController::class, 'exportExcel'])->name('kasir.laporan.export.excel');
});

// antrian
Route::get('/antrian', [AntrianController::class, 'antrianView'])->name('antrian.view');

Route::get('/daftar', [DokterController::class, 'daftarAntrian'])->name('daftarAntrian.view');

Route::post('/panggil-antrian', [DokterController::class, 'panggilAntrian'])->name('antrian.panggil');
Route::post('/panggil-antrian-perawat', [PerawatController::class, 'panggilAntrianPerawat'])->name('antrian.panggil-perawat');
Route::post('/panggil-antrian-obat', [ObatController::class, 'panggilAntrianObat'])->name('antrian.panggil-obat');
Route::post('/simpan-video', [DataVideController::class, 'saveVideo'])->name('simpan-video');

// Customer service - Chat
// web.php
Route::get('/chat/fetchMessages/{userId}', [ChatController::class, 'fetchMessages']);
Route::post('/chat/sendMessage', [ChatController::class, 'sendMessage']);

// ROUTE ADMIN
Route::group(['middleware' => ['auth', 'admin']], function () {
    // dashboard
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Profile
    Route::get('admin/my-profile', [ProfileController::class, 'index'])->name('admin.profile');

    // Informasi
    Route::get('admin/info', [InfoController::class, 'index'])->name('admin.info');

    // Aktifitas User
    Route::get('admin/aktifitas-user/status-user', [InfoController::class, 'controlUser']);

    // Kelola Pesan
    Route::get('admin/aktiitas-user/kelola-pesan', [ChatController::class, 'index'])->name('admin.kelola.pesan');

    // master poli
    Route::get('admin/master/datapoli', [DataPoliController::class, 'index'])->name('master.datapoli');
    Route::put('admin/edit/datapoli/{id}', [DataPoliController::class, 'edit'])->name('edit.datapoli');
    Route::post('admin/tambah/datapoli', [DataPoliController::class, 'store'])->name('store.datapoli');
    Route::delete('admin/hapus/datapoli/{KdPoli}', [DataPoliController::class, 'delete'])->name('delete.datapoli');

    // master dokter
    Route::get('admin/master/datadokter', [DataDokterController::class, 'index'])->name('master.datadokter');
    Route::post('admin/tambah/datadokter', [DataDokterController::class, 'store'])->name('store.datadokter');
    Route::put('admin/edit/datadokter/{id}', [DataDokterController::class, 'edit'])->name('edit.datadokter');
    Route::delete('admin/hapus/datadokter/{id}', [DataDokterController::class, 'destroy'])->name('delete.datadokter');
    Route::post('updateStatus-dokter', [DataDokterController::class, 'updateStatus'])->name('updateStatus');

    // master semua pasien
    Route::get('admin/master/semuapasien', [DataSemuaPasienController::class, 'index'])->name('master.semuadata');
    Route::post('/pasien/import', [DataSemuaPasienController::class, 'import'])->name('pasien.import');
    Route::delete('admin/hapus/semuapasien/{id}', [DataSemuaPasienController::class, 'hapus'])->name('admin.hapus.semuapasien');
    Route::get('/admin/semuapasien/download-template', [DataSemuaPasienController::class, 'downloadTemplate'])->name('pasien.downloadTemplate');

    // master pasien umum
    Route::get('admin/master/pasienumum', [DataPasienController::class, 'umum'])->name('master.pasienumum');
    Route::post('admin/tambah/pasienumum', [DataPasienController::class, 'store'])->name('store.pasienumum');
    Route::delete('admin/hapus/pasienumum/{id}', [DataPasienController::class, 'delete'])->name('delete.pasienumum');

    // master pasien bpjs
    Route::get('admin/master/pasienbpjs', [DataPasienController::class, 'bpjs'])->name('master.pasienbpjs');
    Route::post('admin/tambah/pasienbpjs', [DataPasienController::class, 'tambah'])->name('tambah.pasienbpjs');
    Route::delete('admin/tambah/pasienbpjs/{id}', [DataPasienController::class, 'hapus'])->name('delete.pasienbpjs');

    // master diagnosa
    Route::get('admin/master/diagnosa', [DataDiagnosaController::class, 'index'])->name('master.diagnosa');
    Route::get('admin/master/diagnosa/search', [DataDiagnosaController::class, 'search'])->name('diagnosa.search');
    Route::put('admin/edit/diagnosa/{id}', [DataDiagnosaController::class, 'edit'])->name('edit.diagnosa');
    Route::post('admin/tambah/diagnosa', [DataDiagnosaController::class, 'store'])->name('store.diagnosa');
    Route::delete('admin/hapus/diagnosa/{id}', [DataDiagnosaController::class, 'delete'])->name('delete.diagnosa');

    // master obat
    Route::get('admin/master/obat', [DataObatController::class, 'index'])->name('master.obat');
    Route::get('admin/master/obat/search', [DataObatController::class, 'search'])->name('obat.search');
    Route::put('admin/edit/obat/{id}', [DataObatController::class, 'edit'])->name('edit.obat');
    Route::post('admin/tambah/obat', [DataObatController::class, 'store'])->name('store.obat');
    Route::delete('admin/hapus/obat/{id}', [DataObatController::class, 'delete'])->name('delete.obat');

    // master margin
    Route::get('admin/master/master-margin', [DataMarginController::class, 'index'])->name('master-margin');
    Route::post('admin/master/margin-tambah', [DataMarginController::class, 'tambah'])->name('master.margin-store');
    Route::put('admin/master/margin-edit/{id}', [DataMarginController::class, 'edit'])->name('edit.margin');
    Route::delete('admin/master/margin-hapus/{id}', [DataMarginController::class, 'hapus'])->name('hapus.margin');

    // master shift
    Route::get('admin/master/master-shift', [ShiftController::class, 'index'])->name('master-shift');
    Route::post('admin/master/shift-tambah', [ShiftController::class, 'tambah'])->name('master.shift-store');
    Route::put('admin/master/shift-edit/{id}', [ShiftController::class, 'edit'])->name('edit.shift');
    Route::delete('admin/master/shift-hapus/{id}', [ShiftController::class, 'hapus'])->name('hapus.shift');
    Route::post('updateStatus-shift', [ShiftController::class, 'updateStatus'])->name('updateStatus');

    // master user
    Route::get('admin/master/user', [DataUserController::class, 'index'])->name('master.user');
    Route::post('admin/tambah/user', [DataUserController::class, 'store'])->name('tambah.user');
    Route::put('admin/edit/user/{id}', [DataUserController::class, 'edit'])->name('edit.user');
    Route::delete('admin/hapus/user/{id}', [DataUserController::class, 'destroy'])->name('delete.user');

    // master antrian
    Route::get('admin/master/video', [DataVideController::class, 'index'])->name('master.video');
    Route::post('admin/tambah/video', [DataVideController::class, 'store'])->name('master.store');
    Route::put('admin/edit/video/{id}', [DataVideController::class, 'edit'])->name('master.edit');
    Route::delete('admin/hapus/video/{id}', [DataVideController::class, 'delete'])->name('master.hapus');

    // master ttd medis
    Route::get('admin/master/master-ttd', [TtdController::class, 'index'])->name('master.ttd');
    Route::post('admin/tambah/master-ttd', [TtdController::class, 'store'])->name('master.ttd-tambah');
    Route::put('admin/edit/master-ttd/{id}', [TtdController::class, 'edit'])->name('master.ttd-edit');
    Route::delete('admin/hapus/master-ttd/{id}', [TtdController::class, 'destroy'])->name('master.ttd-hapus');
    Route::post('status-ttd', [TtdController::class, 'updateStatus'])->name('updateStatus');

    // Tindakan Dokter
    Route::get('admin/master/tindakan', [TindakanController::class, 'index'])->name('tindakan.index');
    Route::post('admin/master/tindakan/tambah', [TindakanController::class, 'store'])->name('tindakan.store');
    Route::put('admin/master/tindakan/edit/{id}', [TindakanController::class, 'edit'])->name('tindakan.edit');
    Route::delete('admin/master/tindakan/hapus/{id}', [TindakanController::class, 'hapus'])->name('tindakan.hapus');

    // Kelola Akses
    Route::get('kelola/akses', [AksesController::class, 'index'])->name('akses.index');

    // PPN Pajak
    Route::get('admin/master/ppn', [PpnController::class, 'index'])->name('admin.master.ppn.index');
    Route::post('admin/master/ppn-tambah', [PpnController::class, 'tambah'])->name('admin.master.ppn.tambah');
    Route::put('admin/master/ppn-edit/{id}', [PpnController::class, 'edit'])->name('admin.master.ppn.edit');
    Route::delete('admin/master/ppn-hapus/{id}', [PpnController::class, 'hapus'])->name('admin.master.ppn.hapus');
    Route::post('updateStatus-pajak', [PpnController::class, 'updateStatus'])->name('updateStatus');

    // REKAPAN

    // rekapan poli umum pasien bpjs
    Route::get('admin/rekapan/umum-bpjs/index', [RekapPasienController::class, 'indexBpjs'])->name('pasien-bpjs.index');
    Route::post('/rekapan/bpjs/search', [RekapPasienController::class, 'searchBpjs'])->name('pasien-bpjs.search');
    Route::post('/rekapan/bpjs/cetak', [RekapPasienController::class, 'cetakBpjs'])->name('cetakBpjs');
    Route::get('/pasien-bpjs/export-excel', [RekapPasienController::class, 'exportExcelBpjs']);

    // rekapan poli umum pasien umum
    Route::get('admin/rekapan/umum-umum/index', [RekapPasienController::class, 'indexUmum'])->name('pasien-umum.index');
    Route::post('/rekapan/umum/search', [RekapPasienController::class, 'searchUmum'])->name('pasien-umum.search');
    Route::post('/rekapan/umum/cetak', [RekapPasienController::class, 'cetakUmum'])->name('cetakUmum');
    Route::get('/pasien-umum/export-excel', [RekapPasienController::class, 'exportExcelUmum']);

    // rekapan poli gigi pasien bpjs
    Route::get('admin/rekapan/gigi-bpjs/index', [RekapPasienController::class, 'indexGigiBpjs'])->name('gigi-bpjs.index');
    Route::post('/rekapan/gigi-bpjs/search', [RekapPasienController::class, 'searchGigiBpjs'])->name('gigi-bpjs.search');
    Route::post('/rekapan/gigi-bpjs/cetak', [RekapPasienController::class, 'cetakGigiBpjs'])->name('cetakGigiBpjs');
    Route::get('/gigi-bpjs/export-excel', [RekapPasienController::class, 'exportExcelGigiBpjs']);

    // rekapan poli gigi pasien umum
    Route::get('admin/rekapan/gigi-umum/index', [RekapPasienController::class, 'indexGigiUmum'])->name('gigi-umum.index');
    Route::post('/rekapan/gigi-umum/search', [RekapPasienController::class, 'searchGigiUmum'])->name('gigi-umum.search');
    Route::post('/rekapan/gigi-umum/cetak', [RekapPasienController::class, 'cetakGigiUmum'])->name('cetakGigiUmum');
    Route::get('/gigi-umum/export-excel', [RekapPasienController::class, 'exportExcelGigiUmum']);

    // rekapan pemeriksaan lab
    Route::get('admin/rekapan/pemeriksaan-lab/index', [PemeriksaanController::class, 'indexLab'])->name('pemeriksaan-lab.index');
    Route::post('/rekapan/pemeriksaan-lab/search', [PemeriksaanController::class, 'searchLab'])->name('pemeriksaan-lab.search');
    Route::post('/rekapan/pemeriksaan-lab/cetak', [PemeriksaanController::class, 'cetakLab'])->name('cetakLab');

    // rekapan kejadian-ptm
    Route::get('admin/rekapan/kejadian-ptm/index', [KejadianController::class, 'indexPtm'])->name('kejadian-ptm.index');
    Route::post('/rekapan/kejadian-ptm/search', [KejadianController::class, 'searchPtm'])->name('kejadian-ptm.search');
    Route::post('/rekapan/kejadian-ptm/cetak', [KejadianController::class, 'cetakPtm'])->name('cetakPtm');

    // diagnosa terbanyak
    Route::get('admin/rekapan/diagnosa/index', [DiagnosaController::class, 'indexdiagnosa'])->name('diagnosa-30.index');
    Route::post('/rekapan/diagnosa/search', [DiagnosaController::class, 'searchDiag'])->name('searchDiag.search');
    Route::post('/rekapan/diagnosa/cetak', [DiagnosaController::class, 'cetakdiag'])->name('cetakDiag');
    Route::get('/export-diagnosa-excel', [DiagnosaController::class, 'exportDiagnosa']);
    Route::get('/export-diagnoses-pdf', [DiagnosaController::class, 'exportToPDF']);

    // kejadian luar biasa
    Route::get('admin/rekapan/kejadian/luarbiasa/index', [LuarBiasaController::class, 'indexlb'])->name('luarbiasa.index');
    Route::post('/rekapan/kejadian/luarbiasa/search', [LuarBiasaController::class, 'searchlb'])->name('searchlb.search');
    Route::post('/rekapan/kejadian/luarbiasa/cetak', [LuarBiasaController::class, 'cetaklb'])->name('cetaklb.search');

    // kunjungan KB
    Route::get('admin/rekapan/kb/index', [KBController::class, 'indexKB'])->name('kbngarep.index');
    Route::post('/rekapan/kb/search', [KBController::class, 'searchKB'])->name('kbgolek.search');
    Route::post('/rekapan/kb/cetak', [KBController::class, 'cetakKB'])->name('cetakKB');

    // Rekapan Anc
    Route::get('admin/rekapan/anc', [AncController::class, 'index'])->name('anc.index');
    Route::post('/rekapan/anc/search', [AncController::class, 'searchanc'])->name('searchanc.search');
    Route::post('/rekapan/anc/cetak', [AncController::class, 'cetakanc'])->name('cetakanc.search');

    // Rekapan Harian
    Route::get('admin/rekapan-harian', [HarianController::class, 'index'])->name('rekap.harian');

    // Rujukan RS
    Route::get('admin/rekapan/rujukan/index', [RujukanController::class, 'indexRujukan'])->name('rujukanngarep.index');
    Route::post('/rekapan/rujukan/search', [RujukanController::class, 'searchRujukan'])->name('rujukangolek.search');
    Route::post('/rekapan/rujukan/cetak', [RujukanController::class, 'cetakRujukan'])->name('cetakrujukan');

    // END REKAPAN

    // poli umum
    Route::get('admin/pasien-umum', [BookingController::class, 'pasienUmum'])->name('admin.pasien-umum');
    Route::get('admin/pasien-bpjs', [BookingController::class, 'pasienBpjs'])->name('admin.pasien-bpjs');

    // poli gigi
    Route::get('admin/gigi-umum', [BookingController::class, 'gigiUmum'])->name('admin.gigi-umum');
    Route::get('admin/gigi-bpjs', [BookingController::class, 'gigiBpjs'])->name('admin.gigi-bpjs');
    Route::delete('admin/hapus/gigi-bpjs/{id}', [BookingController::class, 'delete'])->name('admin.gigi-bpjs');

    // Obat Masuk
    Route::get('admin/obat-Masuk', [MasukObatController::class, 'obatMasuk'])->name('admin.obatMasuk');
    Route::post('/search-obat', [MasukObatController::class, 'searchObatMasuk'])->name('serach-obatMasuk');

    // Obat keluar
    Route::get('admin/obat-keluar', [App\Http\Controllers\Admin\Obat\ObatController::class, 'obatKeluar'])->name('admin.obatKeluar');
    Route::get('admin/stok-obat', [App\Http\Controllers\Admin\Obat\ObatController::class, 'stokObat'])->name('admin.stokObat');
    Route::post('/search-obat', [App\Http\Controllers\Admin\Obat\ObatController::class, 'search'])->name('search-obat');
    Route::post('/cetak', [App\Http\Controllers\Admin\Obat\ObatController::class, 'cetak'])->name('cetak');

    // pasien-sehat
    Route::get('admin/pasien-sehat', [SehatController::class, 'index'])->name('admin.pasien-sehat');
    Route::post('admin/pasien-sehat/eksporToPcare', [SehatController::class, 'eksporToPcare'])->name('admin.pasien-sehat.pcare');

    // poto
    Route::get('admin/master/poto', [PotoController::class, 'index'])->name('admin.poto');
    Route::post('admin/tambah/poto', [PotoController::class, 'store'])->name('admin.tambah-poto');
    Route::put('admin/edit/poto/{id}', [PotoController::class, 'edit'])->name('admin.edit-poto');
    Route::delete('admin/hapus/poto/{id}', [PotoController::class, 'destroy'])->name('admin.hapus-poto');

    // pidio
    Route::get('admin/master/pidio', [PidioController::class, 'index'])->name('admin.pidio');
    Route::post('admin/tambah/pidio', [PidioController::class, 'store'])->name('admin.tambah-pidio');
    Route::put('admin/edit/pidio/{id}', [PidioController::class, 'edit'])->name('admin.edit-pidio');
    Route::delete('admin/hapus/pidio/{id}', [PidioController::class, 'destroy'])->name('admin.hapus-pidio');
});

Route::get('login/index', [LoginController::class, 'index'])->name('login.index');
Route::post('login/store', [LoginController::class, 'store'])->name('login.store');
Auth::routes();
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
