<?php

namespace App\Http\Controllers\Mahasiswa\Akademik;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use App\Models\Semester;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\SemesterAktif;
use App\Models\Dosen\BiodataDosen;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\AsistensiAkhir;
use App\Models\Dosen\PenugasanDosen;
use App\Models\Perkuliahan\Konversi;
use App\Models\Perkuliahan\MataKuliah;
use App\Models\Mahasiswa\RiwayatPendidikan;
use App\Models\Perkuliahan\BimbingMahasiswa;
use App\Models\Perkuliahan\AktivitasMahasiswa;
use App\Models\Perkuliahan\PesertaKelasKuliah;
use App\Models\Perkuliahan\TranskripMahasiswa;
use App\Models\Perkuliahan\AktivitasKuliahMahasiswa;
use App\Models\Perkuliahan\AnggotaAktivitasMahasiswa;


class AktivitasMahasiswaController extends Controller
{
    public function getAktivitas(Request $request)
    {
        $id_reg = auth()->user()->fk_id;

        $riwayat_pendidikan = RiwayatPendidikan::select('riwayat_pendidikans.*', 'biodata_dosens.id_dosen', 'biodata_dosens.nama_dosen')
        ->where('id_registrasi_mahasiswa', $id_reg)
        ->leftJoin('biodata_dosens', 'biodata_dosens.id_dosen', '=', 'riwayat_pendidikans.dosen_pa')
        ->first();

        $prodi_id = $riwayat_pendidikan->id_prodi;

        $akm = AktivitasKuliahMahasiswa::where('id_registrasi_mahasiswa', $id_reg)
                    ->whereNotIn('id_status_mahasiswa', ['N'])
                    ->orderBy('id_semester', 'DESC')
                    ->first();

        $semester_aktif = SemesterAktif::leftJoin('semesters','semesters.id_semester','semester_aktifs.id_semester')
                    ->first();

        $krs_akt = AnggotaAktivitasMahasiswa::select(
            'anggota_aktivitas_mahasiswas.*', 'aktivitas_mahasiswas.*', 'bimbing_mahasiswas.*'
        )
            ->leftJoin('aktivitas_mahasiswas', 'aktivitas_mahasiswas.id_aktivitas', '=', 'anggota_aktivitas_mahasiswas.id_aktivitas')
            ->leftJoin('bimbing_mahasiswas', 'bimbing_mahasiswas.id_aktivitas', '=', 'anggota_aktivitas_mahasiswas.id_aktivitas')
            ->where('anggota_aktivitas_mahasiswas.id_registrasi_mahasiswa', $id_reg)
            ->where('aktivitas_mahasiswas.id_semester', $semester_aktif->id_semester)
            ->where('aktivitas_mahasiswas.id_prodi', $prodi_id)
            ->whereIn('aktivitas_mahasiswas.id_jenis_aktivitas', ['2', '3', '4', '22'])
            ->whereNotNull('bimbing_mahasiswas.id_bimbing_mahasiswa')
            ->get();

        // dd($krs_akt);

        return response()->json($krs_akt);
    }

    public function ambilAktivitas($id_matkul)
    {
        $id_reg = auth()->user()->fk_id;

        $riwayat_pendidikan = RiwayatPendidikan::select('riwayat_pendidikans.*', 'biodata_dosens.id_dosen', 'biodata_dosens.nama_dosen')
        ->where('id_registrasi_mahasiswa', $id_reg)
        ->leftJoin('biodata_dosens', 'biodata_dosens.id_dosen', '=', 'riwayat_pendidikans.dosen_pa')
        ->first();

        $mk_konversi=Konversi::where('id_matkul', $id_matkul)->first();
        // dd($aktivitas_mk);

        // $prodi_id = $riwayat_pendidikan->id_prodi;
        $transkrip = TranskripMahasiswa::select(
            DB::raw('SUM(CAST(sks_mata_kuliah AS UNSIGNED)) as total_sks'), // Mengambil total SKS tanpa nilai desimal
            // DB::raw('ROUND(SUM(nilai_indeks * sks_mata_kuliah) / SUM(sks_mata_kuliah), 2) as ips'),
            DB::raw('ROUND(SUM(nilai_indeks * sks_mata_kuliah) / SUM(sks_mata_kuliah), 2) as ipk') // Mengambil IPK dengan 2 angka di belakang koma
            )
            ->where('id_registrasi_mahasiswa', $id_reg)
            ->whereNotIn('nilai_huruf', ['F', ''])
            // ->groupBy('id_registrasi_mahasiswa')
            ->first();


        // $akm = AktivitasKuliahMahasiswa::where('id_registrasi_mahasiswa', $id_reg)
        //             ->whereNotIn('id_status_mahasiswa', ['N'])
        //             ->orderBy('id_semester', 'DESC')
        //             ->first();

        $semester_aktif = SemesterAktif::leftJoin('semesters','semesters.id_semester','semester_aktifs.id_semester')
                    ->first();

        $akm = Semester::orderBy('id_semester', 'ASC')
                    ->whereBetween('id_semester', [$riwayat_pendidikan->id_periode_masuk, $semester_aktif->id_semester])
                    ->whereRaw('RIGHT(id_semester, 1) != ?', [3])
                    ->pluck('id_semester');

        // Dapatkan indeks dari semester terakhir dalam koleksi
        $index_semester_terakhir = $akm->search($akm->last());

        // Pastikan bahwa indeks tidak berada di posisi pertama
        if ($index_semester_terakhir > 0) {
            // Mundur satu semester dari yang terakhir
            $akm_sebelum = $akm[$index_semester_terakhir - 1];
        } else {
            // Jika tidak ada semester sebelumnya (semester pertama), bisa didefinisikan logika lain
            $akm_sebelum = null;
        }

        // dd($akm_sebelum);

        $semester_ke = Semester::orderBy('id_semester', 'ASC')
                    ->whereBetween('id_semester', [$riwayat_pendidikan->id_periode_masuk, $semester_aktif->id_semester])
                    ->whereRaw('RIGHT(id_semester, 1) != ?', [3])
                    ->count();



        $ips = AktivitasKuliahMahasiswa::select('ips')
                ->where('id_registrasi_mahasiswa', $id_reg)
                ->where('id_semester', $akm_sebelum)
                // ->where('id_status_mahasiswa', ['O'])
                ->orderBy('id_semester', 'DESC')
                // ->pluck('ips')
                ->first();

        // dd($mk_konversi->id_matkul);

        $riwayat_aktivitas = AktivitasMahasiswa::with(['anggota_aktivitas', 'bimbing_mahasiswa', 'konversi'])
                    ->whereHas('bimbing_mahasiswa', function ($query) {
                        $query->whereNotNull('id_bimbing_mahasiswa');
                    })
                    ->whereHas('anggota_aktivitas', function ($query) use ($riwayat_pendidikan) {
                        $query->where('id_registrasi_mahasiswa', $riwayat_pendidikan->id_registrasi_mahasiswa)
                            ->where('nim', $riwayat_pendidikan->nim);
                    })
                    ->where('mk_konversi', $mk_konversi->id_matkul)
                    ->where('id_prodi', $riwayat_pendidikan->id_prodi)
                    ->whereIn('id_jenis_aktivitas', ['1', '2', '3', '4', '5', '6', '22'])
                    ->first();

        // Pastikan untuk mengambil nilai ips
        $ips = $ips ?  $ips->ips : null;

        // dd($riwayat_aktivitas);

        if ($semester_ke == 1 || $semester_ke == 2) {
            $sks_max = 20;
        } else {
            if ($ips !== null) {
                if ($ips >= 3.00) {
                    $sks_max = 24;
                } elseif ($ips >= 2.50 && $ips <= 2.99) {
                    $sks_max = 21;
                } elseif ($ips >= 2.00 && $ips <= 2.49) {
                    $sks_max = 18;
                } elseif ($ips >= 1.50 && $ips <= 1.99) {
                    $sks_max = 15;
                } elseif ($ips < 1.50) {
                    $sks_max = 12;
                } else {
                    $sks_max = 0;
                }
            } else {
                $sks_max = 0;
            }
        }

        // dd($ips, $semester_ke, $sks_max);

        $dosen_pembimbing = BiodataDosen::select('biodata_dosens.id_dosen', 'biodata_dosens.nama_dosen', 'biodata_dosens.nidn')
                // ->leftJoin()
                // ->where('id_prodi', $prodi_id)
                ->get();

        return view('mahasiswa.perkuliahan.krs.krs-regular.aktivitas-mahasiswa.ambil-aktivitas-mahasiswa',
        [
            'id_matkul' => $id_matkul,
            'transkrip' => $transkrip,
            'riwayat_pendidikan' => $riwayat_pendidikan,
            'akm'=>$akm_sebelum,
            'sks_max'=>$sks_max,
            'mk_konversi'=>$mk_konversi,
            'dosen_bimbing_aktivitas'=>$dosen_pembimbing,
            'riwayat_aktivitas' => $riwayat_aktivitas
        ]);
    }

    public function get_dosen(Request $request)
    {
        $search = $request->get('q');


        $tahun_ajaran = SemesterAktif::leftJoin('semesters','semesters.id_semester','semester_aktifs.id_semester')
                        ->first();

        $query = PenugasanDosen::where('id_tahun_ajaran', $tahun_ajaran->id_tahun_ajaran)
                                ->orderby('nama_dosen', 'asc');
        if ($search) {
            $query->where('nama_dosen', 'like', "%{$search}%")
                  ->orWhere('nama_program_studi', 'like', "%{$search}%")
                  ->where('id_tahun_ajaran', $tahun_ajaran->id_tahun_ajaran);
        }

        $data = $query->get();
        // dd($data);

        return response()->json($data);
    }


    public function simpanAktivitas(Request $request)
    {
        // Validasi data
        // if (!$request->id_aktivitas) {
        //     $validated = $request->validate([
        //         // 'id_aktivitas'=>'required',
        //         'judul' => 'required|string|max:255',
        //         'keterangan' => 'nullable|max:100', // tambahkan validasi untuk Keterangan
        //         'lokasi' => 'required|string|max:80',
        //         'dosen_bimbing_aktivitas.*' => 'required',
        //         'id_matkul_konversi' => 'required',
        //     ]);
        // } else {
        //     $validated = $request->validate([
        //         'id_aktivitas' => 'required',
        //     ]);
        // }

        $validate = $request->validate([
            'id_aktivitas' => 'nullable',
            'keterangan' => 'nullable|max:100',
            'judul' => 'required_without:id_aktivitas|string|max:255',
            'lokasi' => 'required_without:id_aktivitas|string|max:80',
            'dosen_bimbing_aktivitas.*' => 'required_without:id_aktivitas',
            'id_matkul_konversi' => 'required_without:id_aktivitas',
        ]);

        $id_reg = auth()->user()->fk_id;

        $riwayat_pendidikan = RiwayatPendidikan::with('prodi')
            ->where('id_registrasi_mahasiswa', $id_reg)
            ->first();

        $semester_aktif = SemesterAktif::with('semester')->first();

        $now = Carbon::now();

        $mk_konversi = Konversi::where('id_matkul', $request->id_matkul_konversi)->where('id_prodi', $riwayat_pendidikan->id_prodi)->first();
        // dd($mk_konversi);

        $krs_aktivitas_mbkm = AktivitasMahasiswa::with(['anggota_aktivitas'])
        ->whereHas('anggota_aktivitas', function ($query) use ($id_reg) {
            $query->where('id_registrasi_mahasiswa', $id_reg);
        })
            // ->where('approve_krs', 1)
            ->where('id_semester', $semester_aktif->id_semester)
            ->whereIn('id_jenis_aktivitas', ['13', '14', '15', '16', '17', '18', '19', '20', '21'])
            ->get();

        $db = new MataKuliah();
        $db_akt = new AktivitasMahasiswa();

        list($krs_akt, $data_akt_ids) = $db_akt->getKrsAkt($id_reg, $semester_aktif->id_semester);

        $sks_max = $db->getSksMax($id_reg, $semester_aktif->id_semester, $riwayat_pendidikan->id_periode_masuk);
        $krs_regular = $db->getKrsRegular($id_reg, $riwayat_pendidikan, $semester_aktif->id_semester, $data_akt_ids);
        $krs_merdeka = $db->getKrsMerdeka($id_reg, $semester_aktif->id_semester, $riwayat_pendidikan->id_prodi);

        $total_sks_akt = $krs_akt->sum('konversi.sks_mata_kuliah');
        $total_sks_merdeka = $krs_merdeka->sum('sks_mata_kuliah');
        $total_sks_regular = $krs_regular->sum('sks_mata_kuliah');
        $total_sks_mbkm = $krs_aktivitas_mbkm->sum('sks_aktivitas');

        $total_sks = $total_sks_regular + $total_sks_merdeka + $total_sks_akt + $total_sks_mbkm;

        // Pengecekan apakah KRS sudah diApprove
        $approved_krs = PesertaKelasKuliah::where('id_registrasi_mahasiswa', $id_reg)
        ->whereHas('kelas_kuliah', function ($query) use ($semester_aktif) {
            $query->where('id_semester', $semester_aktif->id_semester);
        })
            ->where('id_registrasi_mahasiswa', $id_reg)
            ->where('nama_kelas_kuliah', 'LIKE', '241%')
            ->where('approved', 1)
            ->count();
        // dd($approved);

        $approved_akt = AktivitasMahasiswa::with(['anggota_aktivitas'])
        ->whereHas('anggota_aktivitas', function ($query) use ($id_reg) {
            $query->where('id_registrasi_mahasiswa', $id_reg);
        })
            ->where('id_semester', $semester_aktif->id_semester)
            ->whereIn('id_jenis_aktivitas', ['1', '2', '3', '4', '5', '6', '22'])
            ->where('approve_krs', 1)
            ->count();
        // dd($approved);

        $approved_mbkm = $krs_aktivitas_mbkm->where('approve_krs', 1)
        ->count();

        // dd($approved_mbkm);
        if ($approved_krs > 0 || $approved_akt > 0 || $approved_mbkm > 0) {
            // return response()->json(['message' => 'Anda tidak bisa mengambil Mata Kuliah / Aktivitas, KRS anda telah disetujui Pembimbing Akademik.'], 400);
            return redirect()->back()->with('error', 'Anda tidak bisa mengambil Mata Kuliah / Aktivitas, KRS anda telah disetujui Pembimbing Akademik.');
        }

        // dd($total_sks);
        // Periksa jumlah dosen pembimbing yang dipilih
        if (count((array)$request->dosen_bimbing_aktivitas) == 0) {
            return redirect()->back()->with('error', 'Harap pilih minimal satu dosen pembimbing.');
        }

        // Pengecekan apakah SKS maksimum telah tercapai
        if ($sks_max == 0) {
            return redirect()->back()->with('error', 'Data AKM Anda Tidak Ditemukan, Silahkan Hubungi Admin Program Studi.');
            // return response()->json(['message' => 'Data AKM Anda Tidak Ditemukan, Silahkan Hubungi Admin Program Studi.', 'sks_max' => $sks_max], 400);
        }

        if (($total_sks + $mk_konversi->sks_mata_kuliah) > $sks_max) {
            return redirect()->back()->with('error', 'Total SKS tidak boleh melebihi SKS maksimum. Anda sudah mengambil ' . $total_sks . ' SKS.');
            // return response()->json(['message' => 'Total SKS tidak boleh melebihi SKS maksimum. Anda sudah Mengambil'.' '.$total_sks.' SKS', 'sks_max' => $sks_max], 400);
        }

        $id_aktivitas = Uuid::uuid4()->toString();

        // Periksa jumlah dosen pembimbing yang dipilih
        // if (count((array)$request->dosen_bimbing_aktivitas) == 0) {
        //     return redirect()->back()->with('error', 'Harap pilih minimal satu dosen pembimbing.');
        // }

        $riwayat_aktivitas = AktivitasMahasiswa::where('id_aktivitas', $request->id_aktivitas)->first();

        $judul = $riwayat_aktivitas ? $riwayat_aktivitas->judul : $request->judul;
        $keterangan = $riwayat_aktivitas ? $riwayat_aktivitas->keterangan : $request->keterangan;
        $lokasi = $riwayat_aktivitas ? $riwayat_aktivitas->lokasi : $request->lokasi;
        $tanggal_mulai = $riwayat_aktivitas ? $riwayat_aktivitas->tanggal_mulai : $now;

        // if ($riwayat_aktivitas) {
        //     $judul = $riwayat_aktivitas->judul;
        //     $keterangan = $riwayat_aktivitas->keterangan;
        //     $lokasi = $riwayat_aktivitas->lokasi;
        //     $tanggal_mulai = $riwayat_aktivitas->tanggal_mulai;
        // } else {
        //     $judul = $request->judul;
        //     $keterangan = $request->keterangan;
        //     $lokasi = $request->lokasi;
        //     $tanggal_mulai = $now;
        // }


        try {
            // Gunakan transaksi untuk memastikan semua operasi database berhasil
            DB::beginTransaction();

            // Simpan data ke tabel aktivitas_mahasiswas
            $aktivitas = AktivitasMahasiswa::create([
                'approve_krs' => 0,
                'approve_sidang' => 0,
                'feeder' => 0,
                'submitted' => 0,
                'id_aktivitas' => $id_aktivitas,
                'program_mbkm' => 0,
                'nama_program_mbkm' => 'Mandiri', //tanyakan dirapat
                'jenis_anggota' => 0,
                'nama_jenis_anggota' => 'Personal', //tanyakan dirapat
                'id_jenis_aktivitas' => $mk_konversi->id_jenis_aktivitas,
                'nama_jenis_aktivitas' => $mk_konversi->nama_jenis_aktivitas,
                'id_prodi' => $riwayat_pendidikan->id_prodi,
                'nama_prodi' => $riwayat_pendidikan->nama_program_studi,
                'id_semester' => $semester_aktif->id_semester,
                'nama_semester' => $semester_aktif->semester->nama_semester,
                'judul' => $judul,
                'keterangan' => $keterangan,
                'lokasi' => $lokasi,
                'sk_tugas' => Null,
                'sumber_data' => 1,
                'tanggal_sk_tugas' => Null,
                'tanggal_mulai' => $tanggal_mulai,
                //tambahkan kondisi jika aktivitas melanjutkan semester
                'tanggal_selesai' => Null,
                'untuk_kampus_merdeka' => 1,
                'asal_data' => 9,
                'nm_asaldata' => '',
                'status_sync' => 'belum sync',
                'mk_konversi' => $mk_konversi->id_matkul,
                // tambahkan field lain yang diperlukan
            ]);

            $id_anggota = Uuid::uuid4()->toString();

            // Simpan data ke tabel anggota_aktivitas_mahasiswas
            AnggotaAktivitasMahasiswa::create([
                'feeder' => 0,
                'id_anggota' => $id_anggota,
                'id_aktivitas' => $aktivitas->id_aktivitas,
                'judul' => $aktivitas->judul,
                'id_registrasi_mahasiswa' => $id_reg,
                'nim' => $riwayat_pendidikan->nim,
                'nama_mahasiswa' => $riwayat_pendidikan->nama_mahasiswa,
                'jenis_peran' => 2,
                'nama_jenis_peran' => 'Personal',
                'status_sync' => 'belum sync',
            ]);

            $jumlah_dosen = count($request->dosen_bimbing_aktivitas);

            $prodi = $riwayat_pendidikan->prodi;

            for ($i = 0; $i < $jumlah_dosen; $i++) {
                //Generate id aktivitas mengajar
                $id_bimbing_mahasiswa = Uuid::uuid4()->toString();

                //KONDISI JENIS AKTIVITAS KKN DAN KP
                if ($mk_konversi->id_jenis_aktivitas == 5 || $mk_konversi->id_jenis_aktivitas == 6) {
                    $id_kategori_kegiatan = 110300;
                    $nama_kategori_kegiatan = 'Membimbing Kuliah Kerja Nyata, Praktek Kerja Nyata, Praktek Kerja Lapangan, termasuk membimbing pelatihan militer mahasiswa, pertukaran mahasiswa,  Magang, kuliah berbasis penelitian, wirausaha, dan bentuk lain pengabdian kepada masyarakat, dan sejenisnya';
                } elseif (
                    $mk_konversi->id_jenis_aktivitas == 1 || $mk_konversi->id_jenis_aktivitas == 2 ||
                    $mk_konversi->id_jenis_aktivitas == 3 || $mk_konversi->id_jenis_aktivitas == 4 ||
                    $mk_konversi->id_jenis_aktivitas == 7
                    || $mk_konversi->id_jenis_aktivitas == 22
                ) {
                    //KONDISI JENJANG PENDIDIKAN KKN DAN KP
                    if ($prodi->nama_jenjang_pendidikan == 'S1') {
                        if ($i == 0) {
                            $id_kategori_kegiatan = 110403;
                            $nama_kategori_kegiatan = 'Skripsi (pembimbing utama)';
                        } else {
                            $id_kategori_kegiatan = 110407;
                            $nama_kategori_kegiatan = 'Skripsi (pembimbing pendamping)';
                        }
                    } elseif ($prodi->nama_jenjang_pendidikan == 'S2' || $prodi->nama_jenjang_pendidikan == 'Sp-1' || $prodi->nama_jenjang_pendidikan == 'Sp-2') {
                        if ($i == 0) {
                            $id_kategori_kegiatan = 110402;
                            $nama_kategori_kegiatan = 'Tesis (pembimbing utama)';
                        } else {
                            $id_kategori_kegiatan = 110406;
                            $nama_kategori_kegiatan = 'Tesis (pembimbing pendamping)';
                        }
                    } elseif ($prodi->nama_jenjang_pendidikan == 'S3') {
                        if ($i == 0) {
                            $id_kategori_kegiatan = 110401;
                            $nama_kategori_kegiatan = 'Disertasi (pembimbing utama)';
                        } else {
                            $id_kategori_kegiatan = 110405;
                            $nama_kategori_kegiatan = 'Disertasi (pembimbing pendamping)';
                        }
                    } elseif ($prodi->nama_jenjang_pendidikan == 'D3' || $prodi->nama_jenjang_pendidikan == 'Profesi') {
                        if ($i == 0) {
                            $id_kategori_kegiatan = 110404;
                            $nama_kategori_kegiatan = 'Laporan/tugas akhir studi (pembimbing utama)';
                        } else {
                            $id_kategori_kegiatan = 110408;
                            $nama_kategori_kegiatan = 'Laporan akhir studi (pembimbing pendamping)';
                        }
                    }
                }


                $dosen_pembimbing = BiodataDosen::where('id_dosen', $request->dosen_bimbing_aktivitas[$i])->first();
                // dd($dosen_pembimbing);

                //DOSEN PEMBIMBING AKTIVITAS LANJUT SKRIPSI
                $approved_dosen_aktivitas = BimbingMahasiswa::where('id_aktivitas', $request->id_aktivitas)->where('id_dosen', $dosen_pembimbing->id_dosen)->get();

                if ($approved_dosen_aktivitas->isEmpty()) {
                    $approved = 0;
                    $approved_dosen = 0;
                } else {
                    foreach ($approved_dosen_aktivitas as $app) {
                        $approved = $app->approved;
                        $approved_dosen = $app->approved_dosen;
                    }
                }

                $bimbing = BimbingMahasiswa::create([
                    'feeder' => 0,
                    'approved' => $approved,
                    'approved_dosen' => $approved_dosen,
                    'id_bimbing_mahasiswa' => $id_bimbing_mahasiswa,
                    'id_aktivitas' => $aktivitas->id_aktivitas,
                    'judul' => $aktivitas->judul,
                    'id_kategori_kegiatan' => $id_kategori_kegiatan,
                    'nama_kategori_kegiatan' => $nama_kategori_kegiatan,
                    'id_dosen' => $dosen_pembimbing->id_dosen,
                    'nidn' => $dosen_pembimbing->nidn,
                    'nama_dosen' => $dosen_pembimbing->nama_dosen,
                    'pembimbing_ke' => $i + 1,
                    'status_sync' => 'belum sync',
                ]);
                //QUERY AMBIL DATA LAMA
            }

            if ($request->id_aktivitas) {
                $riwayat_asistensi = AsistensiAkhir::where('id_aktivitas', $request->id_aktivitas)->orderBy('id', 'ASC')->get();
                // dd($riwayat_asistensi);
                foreach ($riwayat_asistensi as $asistensi) {
                    // Menambahkan data ke tabel asistensi_akhirs
                    AsistensiAkhir::create([
                        'id_aktivitas' => $id_aktivitas,
                        'id_dosen' => $asistensi->id_dosen,
                        'approved' => $asistensi->approved,
                        'tanggal' => $asistensi->tanggal,
                        'uraian' => $asistensi->uraian,
                        'created_at' => $asistensi->created_at,
                        'updated_at' => $asistensi->updated_at,
                        // Kolom lainnya sesuai dengan tabel `asistensi_akhirs`
                    ]);
                }
            };

            DB::commit();

            // Jika berhasil, kembalikan respons sukses
            return redirect()->route('mahasiswa.krs.index')->with('success', 'Data aktivitas mahasiswa berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            // Jika terjadi kesalahan, kembalikan respons dengan pesan kesalahan
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }


    public function hapusAktivitas($id)
    {
        $aktivitas=AktivitasMahasiswa::with(['bimbing_mahasiswa'])->where('id', $id)->first();
        $id_aktivitas=$aktivitas->where('id', $id)->pluck('id_aktivitas');

        // dd($aktivitas->bimbing_mahasiswa);

        DB::beginTransaction();

        try {

            if ($aktivitas->approve_krs ==1) {
                if ($aktivitas->bimbing_mahasiswa->first()->approved == 1) {
                    return redirect()->back()->with('error', 'Anda tidak dapat menghapus Aktivitas ini, Aktivitas telah disetujui oleh KoProdi');
                }
                return redirect()->back()->with('error', 'Anda tidak dapat menghapus Aktivitas ini, Aktivitas telah disetujui Dosen Pembimbing Akademik');
            }

            // Menghapus bimbingan mahasiswa
           $bimbing = BimbingMahasiswa::where('id_aktivitas', $id_aktivitas);
            if ($bimbing) {
                $bimbing->delete();
            }

            // Menghapus anggota aktivitas mahasiswa
            $anggota = AnggotaAktivitasMahasiswa::where('id_aktivitas', $id_aktivitas);
            if ($anggota) {
                $anggota->delete();
            }

            // Menghapus anggota aktivitas mahasiswa
            $asistensi = AsistensiAkhir::where('id_aktivitas', $id_aktivitas);
            if ($asistensi) {
                $asistensi->delete();
            }

            // Menghapus aktivitas mahasiswa
            $aktivitas = AktivitasMahasiswa::findOrFail($id);
            $aktivitas->delete();

            DB::commit();

            return redirect()->route('mahasiswa.krs.index')->with('success', 'Aktivitas berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('mahasiswa.krs.index')->with('error', 'Terjadi kesalahan saat menghapus aktivitas.');
        }
    }

}
