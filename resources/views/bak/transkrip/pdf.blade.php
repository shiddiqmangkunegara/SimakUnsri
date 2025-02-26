@extends('layouts.doc-nologo')
@section('content')
<div class="container-fluid">
    <center>
        <h2>TRANSKRIP MAHASISWA</h2>
    </center>
</div>
<div class="container-fluid table-responsive ml-3 text-pdf">
    <div class="row mt-3" style="align-content: center">
        <table class="table" style="width:100%" class="mb-3">
            <tr>
                <td class="text-start align-middle" style="width: 12%">NIM</td>
                <td>:</td>
                <td class="text-start" id="nimKrs" style="width: 45%; padding-left: 10px">{{$riwayat->nim}}</td>
                <td class="text-start align-middle" style="width: 18%">FAKULTAS</td>
                <td>:</td>
                <td class="text-start align-middle" id="fakultasKrs"
                    style="width: 30%; padding-left: 10px">{{$riwayat->prodi->fakultas->nama_fakultas}}</td>
            </tr>
            <tr>
                <td class="text-start align-middle" style="width: 12%">NAMA</td>
                <td>:</td>
                <td class="text-start" id="namaKrs" style="width: 45%; padding-left: 10px">{{$riwayat->nama_mahasiswa}}</td>
                <td class="text-start align-middle" style="width: 18%">JURUSAN</td>
                <td>:</td>
                <td class="text-start align-middle" id="jurusanKrs"
                    style="width: 30%; padding-left: 10px">{{$riwayat->prodi->jurusan->nama_jurusan_id}}</td>
            </tr>
            <tr>
                <td class="text-start align-middle" style="width: 12%">NIP PA</td>
                <td>:</td>
                <td class="text-start" id="nippaKrs" style="width: 45%; padding-left: 10px">{{$riwayat->pembimbing_akademik ? $riwayat->pembimbing_akademik->nip : '-'}}</td>
                <td class="text-start align-middle" style="width: 18%">PROGRAM STUDI</td>
                <td>:</td>
                <td class="text-start align-middle" id="prodiKrs"
                    style="width: 30%; padding-left: 10px">{{$riwayat->prodi->nama_program_studi}}</td>
            </tr>
            <tr>
                <td class="text-start align-middle" style="width: 12%">DOSEN PA</td>
                <td>:</td>
                <td class="text-start" id="dosenpaKrs" style="width: 45%; padding-left: 10px">{{$riwayat->pembimbing_akademik ? $riwayat->pembimbing_akademik->nama_dosen : '-'}}</td>
            </tr>
        </table>
    </div>
    <div class="row" style="margin-top: 15px">
        <table class="table-pdf text-pdf" id="krs-regular">
            <thead>
                <tr>
                    <th class="text-center align-middle table-pdf text-pdf">No</th>
                    <th class="text-center align-middle table-pdf text-pdf">Kode Mata Kuliah</th>
                    <th class="text-center align-middle table-pdf text-pdf">Nama Mata Kuliah</th>
                    <th class="text-center align-middle table-pdf text-pdf">SKS</th>
                    <th class="text-center align-middle table-pdf text-pdf">Nilai Index</th>
                    <th class="text-center align-middle table-pdf text-pdf">Nilai Huruf</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transkrip as $d)
                <tr>
                    <td class="text-center align-middle table-pdf text-pdf">{{$loop->iteration}}</td>
                    <td class="text-center align-middle table-pdf text-pdf">{{$d->kode_mata_kuliah}}</td>
                    <td class="text-start align-middle table-pdf text-pdf">{{$d->nama_mata_kuliah}}</td>
                    <td class="text-center align-middle table-pdf text-pdf">{{$d->sks_mata_kuliah}}</td>
                    <td class="text-center align-middle table-pdf text-pdf">{{$d->nilai_indeks}}</td>
                    <td class="text-center align-middle table-pdf text-pdf">{{$d->nilai_huruf}}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-center align-middle table-pdf text-pdf">Total SKS</th>
                    <th class="text-center align-middle table-pdf text-pdf" id="totalSks">{{$total_sks}}</th>
                    <th class="text-center align-middle table-pdf text-pdf"></th>
                    <th class="text-center align-middle table-pdf text-pdf"></th>
                </tr>
                <tr>
                    <th colspan="3" class="text-center align-middle table-pdf text-pdf">IPK</th>
                    <th class="text-center align-middle table-pdf text-pdf" id="totalSks">{{$ipk}}</th>
                    <th class="text-center align-middle table-pdf text-pdf"></th>
                    <th class="text-center align-middle table-pdf text-pdf"></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
