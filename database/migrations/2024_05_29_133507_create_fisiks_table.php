<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFisiksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fisiks', function (Blueprint $table) {
            $table->id();
            // pasien id
            $table->foreignId('id_dokter')->constrained('data_dokters')->onDelete('cascade');
            $table->foreignId('id_pasien')->constrained('pasiens')->onDelete('cascade');
            $table->foreignId('id_booking')->constrained('bookings')->onDelete('cascade');
            $table->foreignId('id_rm')->nullable()->constrained('rm_da1s')->onDelete('cascade');
            $table->foreignId('id_isian')->nullable()->constrained('isian_perawats')->onDelete('cascade');

            // UMUM
            $table->text('samping')->nullable();
            $table->text('belakang')->nullable();
            $table->text('depan')->nullable();

            // ASESMEN GIGI
            $table->date('tgl_kunjungan')->nullable();
            $table->string('alergi_gigi')->nullable();
            $table->string('skala_nyeriGigi')->nullable();
            $table->string('metode')->nullable();
            $table->string('wongbaker')->nullable();
            $table->string('a_riwayat_penggunaan_obat')->nullable();
            $table->string('periksa_fisik')->nullable();

            // GIGI
            $table->string('no_gigi')->nullable();
            $table->string('keadaan_gigi')->nullable();
            $table->text('keterangan_gigi')->nullable();
            $table->string('occlusi_gigi')->nullable();
            $table->string('torus_palatines')->nullable();
            $table->string('torus_mandibularis')->nullable();
            $table->string('palatum')->nullable();
            $table->string('diastema')->nullable();
            $table->string('diastema_alasan')->nullable();
            $table->string('gigi_anomali')->nullable();
            $table->string('gigi_anomali_alasan')->nullable();
            $table->string('gigi_lain_lain')->nullable();
            $table->string('foto_yg_diambil_digital')->nullable();
            $table->string('foto_yg_diambil_intraoral')->nullable();
            $table->string('foto_jumlah')->nullable();
            $table->string('foto_rontgen_ambil_dental')->nullable();
            $table->string('foto_rontgen_ambil_pa')->nullable();
            $table->string('foto_rontgen_ambil_opg')->nullable();
            $table->string('foto_rontgen_ambil_ceph')->nullable();
            $table->string('foto_rontgen_jumlah')->nullable();
            $table->text('keterangan')->nullable();
            $table->date('tindakan_gigi')->nullable();
            $table->string('prosedur_tindakan')->nullable();
            $table->date('tgl_rencana')->nullable();
            $table->string('lama_tindakan')->nullable();
            $table->string('hasil_tindakan')->nullable();
            $table->string('indikasi_tindakan')->nullable();
            $table->string('tujuan_tindakan')->nullable();
            $table->string('resiko_tindakan')->nullable();
            $table->string('komplikasi_tindakan')->nullable();
            $table->string('prognosa_tindakan')->nullable();
            $table->string('alternatif_resiko')->nullable();
            $table->string('keterangan_tindakan')->nullable();
            $table->string('jenis_pelayanan_preventif')->nullable();
            $table->string('jenis_pelayanan_preventif_alasan')->nullable();
            $table->string('jenis_pelayanan_paliatif')->nullable();
            $table->string('jenis_pelayanan_paliatif_alasan')->nullable();
            $table->string('jenis_pelayanan_kuratif')->nullable();
            $table->string('jenis_pelayanan_kuratif_alasan')->nullable();
            $table->string('jenis_pelayanan_rehabilitatif')->nullable();
            $table->string('jenis_pelayanan_rehabilitatif_alasan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fisiks');
    }
}
