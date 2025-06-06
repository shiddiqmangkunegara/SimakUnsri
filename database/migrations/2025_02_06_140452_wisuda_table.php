<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_wisuda', function (Blueprint $table) {
            $table->id();
            $table->string('id_perguruan_tinggi')->nullable();
            $table->foreign('id_perguruan_tinggi')->references('id_perguruan_tinggi')->on('all_pts')->onDelete('set null');
            $table->string('id_registrasi_mahasiswa')->nullable();
            $table->foreign('id_registrasi_mahasiswa')->references('id_registrasi_mahasiswa')->on('riwayat_pendidikans')->onDelete('set null');
            $table->string('id_prodi')->nullable();
            $table->foreign('id_prodi')->references('id_prodi')->on('program_studis')->onDelete('set null');
            $table->date('tgl_masuk')->nullable();
            $table->date('tgl_keluar')->nullable();
            $table->string('no_peserta_ujian')->nullable();
            $table->string('sks_diakui')->nullable();
            $table->string('no_ijazah')->nullable();
            $table->string('id_aktivitas')->nullable();
            $table->foreign('id_aktivitas')->references('id_aktivitas')->on('aktivitas_mahasiswas')->onDelete('set null');
            $table->text('judul')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('angkatan')->nullable();
            $table->string('nim')->nullable();
            $table->string('nama_mahasiswa')->nullable();
            $table->string('kosentrasi')->nullable();
            $table->string('pas_foto')->nullable(); // Path ke file pas foto
            $table->string('lokasi_kuliah')->nullable();
            $table->integer('lama_studi')->nullable(); // Lama studi dalam bulan atau tahun
            $table->text('abstrak_ta')->nullable();
            $table->string('abstrak_file')->nullable(); // Path ke file abstrak
            $table->timestamps(); // Menambahkan kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_wisuda');
    }
};