@extends('layouts.fakultas')
@section('title')
KHS Mahasiswa
@endsection
@section('content')
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h3 class="page-title">Kartu Hasil Studi</h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('prodi')}}"><i
                                    class="mdi mdi-home-outline"></i></a></li>
                        <li class="breadcrumb-item" aria-current="page">Data Akademik</li>
                        <li class="breadcrumb-item active" aria-current="page">Kartu Hasil Studi</li>
                    </ol>
                </nav>
            </div>
        </div>

    </div>
</div>

<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="box box-outline-success bs-3 border-success">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="semester" class="form-label">Tahun Akademik</label>
                                <select class="form-select" name="semester" id="semester">
                                    <option value="" disabled selected>-- Pilih Tahun Akademik --</option>
                                    @foreach ($semesters as $semester)
                                    <option value="{{$semester->id_semester}}" {{request()->semester == '' &&
                                        $semester->id_semester ==
                                        $semesterAktif->id_semester ? 'selected' : ''}}>{{$semester->nama_semester}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="nim" class="form-label">Nomor Induk Mahasiswa</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="nim" id="nim" required />
                                <button class="input-group-button btn btn-primary btn-sm" id="basic-addon1"
                                    onclick="getKrs()"><i class="fa fa-search"></i> Proses</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body text-center">
                    <div class="table-responsive">
                        <div id="khsDiv" hidden>
                            <div class="row mb-20">
                                <form action="{{route('fakultas.data-akademik.khs.download')}}" method="get" id="cetakForm" target="_blank">
                                    <input type="hidden" name="nim" id="nimCetak">
                                    <input type="hidden" name="id_semester" id="idSemesterCetak">
                                    <button class="btn btn-success" type="submit"><i class="fa fa-print"></i> Cetak KHS</button>
                                </form>
                            </div>
                            <h3 class="text-center">Kartu Hasil Studi (KHS)</h3>
                            <table style="width:100%" class="mb-3">
                                <tr>
                                    <td class="text-start align-middle" style="width: 12%">NIM</td>
                                    <td>:</td>
                                    <td class="text-start" id="nimKrs" style="width: 45%; padding-left: 10px"></td>
                                    <td class="text-start align-middle" style="width: 18%">FAKULTAS</td>
                                    <td>:</td>
                                    <td class="text-start align-middle" id="fakultasKrs"
                                        style="width: 30%; padding-left: 10px"></td>
                                </tr>
                                <tr>
                                    <td class="text-start align-middle" style="width: 12%">NAMA</td>
                                    <td>:</td>
                                    <td class="text-start" id="namaKrs" style="width: 45%; padding-left: 10px"></td>
                                    <td class="text-start align-middle" style="width: 18%">JURUSAN</td>
                                    <td>:</td>
                                    <td class="text-start align-middle" id="jurusanKrs"
                                        style="width: 30%; padding-left: 10px"></td>
                                </tr>
                                <tr>
                                    <td class="text-start align-middle" style="width: 12%">NIP PA</td>
                                    <td>:</td>
                                    <td class="text-start" id="nippaKrs" style="width: 45%; padding-left: 10px"></td>
                                    <td class="text-start align-middle" style="width: 18%">PROGRAM STUDI</td>
                                    <td>:</td>
                                    <td class="text-start align-middle" id="prodiKrs"
                                        style="width: 30%; padding-left: 10px"></td>
                                </tr>
                                <tr>
                                    <td class="text-start align-middle" style="width: 12%">DOSEN PA</td>
                                    <td>:</td>
                                    <td class="text-start" id="dosenpaKrs" style="width: 45%; padding-left: 10px"></td>
                                    <td class="text-start align-middle" style="width: 18%">SEMESTER</td>
                                    <td>:</td>
                                    <td class="text-start align-middle" id="semesterKrs"
                                        style="width: 30%; padding-left: 10px"></td>
                                </tr>
                            </table>
                            <div class="d-flex justify-content-end align-middle">

                            </div>
                            <table class="table table-bordered mt-4" id="khs-regular">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle">No</th>
                                        <th class="text-center align-middle">Kode Mata Kuliah</th>
                                        <th class="text-center align-middle">Nama Mata Kuliah</th>
                                        <th class="text-center align-middle">Nama Kelas</th>
                                        <th class="text-center align-middle">Semester</th>
                                        <th class="text-center align-middle">SKS</th>
                                        <th class="text-center align-middle">Nilai Angka</th>
                                        <th class="text-center align-middle">Nilai Index</th>
                                        <th class="text-center align-middle">Nilai Huruf</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <hr>
                            <div class="row mt-5" id="transferDiv" hidden>
                                <h3>Nilai Transfer</h3>
                                <table class="table table-bordered table-hover mt-2" id="transferTable">
                                    <thead>
                                        <tr>
                                            <th class="text-center align-middle">No</th>
                                            <th class="text-center align-middle">Kode Mata Kuliah</th>
                                            <th class="text-center align-middle">Nama Mata Kuliah</th>
                                            <th class="text-center align-middle">Semester</th>
                                            <th class="text-center align-middle">SKS Diakui</th>
                                            <th class="text-center align-middle">Nilai Index Diakui</th>
                                            <th class="text-center align-middle">Nilai Huruf Diakui</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                            <div class="row mt-5" id="akmDiv">

                            </div>

                            <div class="row mt-5" id="totalDiv">

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
@push('js')
<script src="{{asset('assets/vendor_components/datatable/datatables.min.js')}}"></script>
<script src="{{asset('assets/vendor_components/sweetalert/sweetalert.min.js')}}"></script>
<script>
 function getKrs()
    {
        var nim = $('#nim').val();
        var semester = $('#semester').val();
        if(nim == '' || semester == ''){
            swal({
                title: "Peringatan!",
                text: "Nomor Induk Mahasiswa dan Tahun Akademik harus diisi!",
                type: "warning",
                buttons: {
                    confirm: {
                        className : 'btn btn-warning'
                    }
                }
            });
        }else{
            $.ajax({
                url: '{{route('fakultas.data-akademik.khs.data')}}',
                type: 'GET',
                data: {
                    nim: nim,
                    semester: semester
                },
                success: function(response){
                    if (response.status == 'error') {
                        swal({
                            title: "Peringatan!",
                            text: response.message,
                            type: "warning",
                            buttons: {
                                confirm: {
                                    className : 'btn btn-warning'
                                }
                            }
                        });
                        return false;
                    }
                    // console.log(response);

                    $('#nimCetak').val(response.riwayat.nim);
                    $('#idSemesterCetak').val(semester);
                    $('#khsDiv').removeAttr('hidden');
                    // append response.krs to table of khs-regular
                    $('#nimKrs').text(response.riwayat.nim);
                    // remove "Fakultas " from nama_fakultas
                    var fakultas = response.riwayat.prodi.fakultas.nama_fakultas.replace('Fakultas ', '');
                    $('#fakultasKrs').text(fakultas.toUpperCase());
                    $('#namaKrs').text(response.riwayat.nama_mahasiswa);
                    var jurusan = response.riwayat.prodi.jurusan.nama_jurusan_id ?? '-';
                    $('#jurusanKrs').text(jurusan);
                    var nip_pa = response.riwayat.dosen_pa ? response.riwayat.dosen_pa.nip : '-';
                    $('#nippaKrs').text(nip_pa);
                    var dosen_pa = response.riwayat.dosen_pa ? response.riwayat.dosen_pa.nama_dosen : '-';
                    $('#dosenpaKrs').text(dosen_pa);
                    $('#prodiKrs').text(response.riwayat.prodi.nama_program_studi.toUpperCase());
                    var semesterText =  $('#semester option:selected').text();
                    $('#semesterKrs').text(semesterText.toUpperCase());
                    $('#khs-regular tbody').empty();

                    // count response.krs.approved
                    var approved = 0;
                    var no = 1;
                    // var totalSks = 0;

             
                    // console.log(response.nilai);
                    response.nilai.forEach(function(khs_reg, index){
                        var trClass = '';
                        if(khs_reg.nilai_huruf == 'F' || khs_reg.nilai_huruf == null)
                        {
                            trClass = 'bg-danger';
                        }
                        $('#khs-regular tbody').append(`
                            <tr class="${trClass}">
                                <td class="text-center align-middle">${no}</td>
                                <td class="text-center align-middle">${khs_reg.kode_mata_kuliah}</td>
                                <td class="text-start align-middle">${khs_reg.nama_mata_kuliah}</td>
                                <td class="text-center align-middle">${khs_reg.nama_kelas_kuliah}</td>
                                <td class="text-center align-middle">${khs_reg.semester.nama_semester}</td>
                                <td class="text-center align-middle">${khs_reg.sks_mata_kuliah}</td>
                                <td class="text-center align-middle">${khs_reg.nilai_angka ?? '-'}</td>
                                <td class="text-center align-middle">${khs_reg.nilai_indeks ?? '-'}</td>
                                <td class="text-center align-middle">${khs_reg.nilai_huruf ?? '-'}</td>
                            </tr>
                        `);
                        no++;
                    });
                    // console.log(response.konversi);
                    if (response.konversi.length > 0) {
                        $('#khs-regular tbody').append(`
                            <tr>
                                <th class="text-center align-middle" colspan="8">Konversi Aktivitas</th>
                            </tr>
                        `);

                        response.konversi.forEach(function(konversi, index){
                            var trClass = '';
                            if(konversi.nilai_huruf == 'F' || konversi.nilai_huruf == null)
                            {
                                trClass = 'bg-danger';
                            }
                            $('#khs-regular tbody').append(`
                                <tr class="${trClass}">
                                    <td class="text-center align-middle">${no}</td>
                                    <td class="text-center align-middle">${konversi.matkul.kode_mata_kuliah}</td>
                                    <td class="text-start align-middle">${konversi.nama_mata_kuliah}</td>
                                    <td class="text-center align-middle"> - </td>
                                    <td class="text-center align-middle">${konversi.semester.nama_semester}</td>
                                    <td class="text-center align-middle">${konversi.sks_mata_kuliah}</td>
                                    <td class="text-center align-middle">${konversi.nilai_angka ?? '-'}</td>
                                    <td class="text-center align-middle">${konversi.nilai_indeks}</td>
                                    <td class="text-center align-middle">${konversi.nilai_huruf}</td>
                                </tr>
                            `);
                            no++;
                        });
                    }

                    if(response.akm.length > 0)
                    {
                        $('#akmDiv').empty();
                        $('#akmDiv').append(`
                            <hr>
                            <h2>Aktivitas Kuliah Mahasiswa (AKM)</h2>
                        `);
                        response.akm.forEach(function(akm, index){
                            $('#akmDiv').append(`
                                <div class="col-md-4">
                                    <table style="width:100%" class="table table-bordered">
                                        <tr>
                                            <td class="text-start align-middle" style="width: 50%">Semester</td>
                                            <td>:</td>
                                            <td class="text-start
                                                align-middle">${akm.nama_semester}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-start align-middle" style="width: 50%">IPK</td>
                                            <td>:</td>
                                            <td class="text-start align-middle">${akm.ipk}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-start align-middle" style="width: 50%">IPS</td>
                                            <td>:</td>
                                            <td class="text-start align-middle">${akm.ips}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-start align-middle" style="width: 50%">Status Mahasiswa</td>
                                            <td>:</td>
                                            <td class="text-start align-middle">${akm.nama_status_mahasiswa}</td>
                                        </tr>
                                    </table>
                                </div>
                            `);
                        });
                    }
                    // console.log(response.transfer);
                    if (response.transfer.length > 0) {
                        $('#transferDiv').removeAttr('hidden');

                        response.transfer.forEach(function(transfer, index){
                            $('#transferTable tbody').append(`
                                <tr>
                                    <td class="text-center align-middle">${index + 1}</td>
                                    <td class="text-center align-middle">${transfer.kode_matkul_diakui}</td>
                                    <td class="text-start align-middle">${transfer.nama_mata_kuliah_diakui}</td>
                                    <td class="text-center align-middle">${transfer.semester.nama_semester}</td>
                                    <td class="text-center align-middle">${transfer.sks_mata_kuliah_diakui}</td>
                                    <td class="text-center align-middle">${transfer.nilai_angka_diakui}</td>
                                    <td class="text-center align-middle">${transfer.nilai_huruf_diakui}</td>
                                </tr>
                            `);
                        });

                    }
                }
            });
        }
    }
</script>
@endpush
