@extends('layouts.bak')
@section('title')
Daftar Peserta Wisuda
@endsection
@section('content')
<section class="content">
    <div class="row align-items-end">
        <div class="col-xl-12 col-12">
            <div class="box bg-primary-light pull-up">
                <div class="box-body p-xl-0">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-3"><img
                                src="{{asset('images/images/svg-icon/color-svg/custom-14.svg')}}" alt="">
                        </div>
                        <div class="col-12 col-lg-9">
                            <h2>Daftar Peserta Wisuda</h2>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="box box-outline-success bs-3 border-success">
                <div class="box-header with-border">
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Fakultas</label>
                        <div class="col-md-8">
                            <select name="fakultas" id="fakultas" required class="form-select" onchange="filterProdi()">
                                <option value="*">-- Semua Fakultas --</option>
                                @foreach ($fakultas as $f)
                                <option value="{{$f->id}}">{{$f->nama_fakultas}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Prodi</label>
                        <div class="col-md-8">
                            <select name="prodi" id="prodi" required class="form-select">
                                <option value="*">-- Semua Prodi --</option>
                                @foreach ($prodi as $p)
                                <option value="{{$p->id_prodi}}">({{$p->kode_program_studi}}) - {{$p->nama_jenjang_pendidikan}} {{$p->nama_program_studi}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Periode</label>
                        <div class="col-md-3">
                            <select name="periode" id="periode" required class="form-select">
                                @foreach ($periode as $per)
                                <option value="{{$per->periode}}">{{$per->periode}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">&nbsp;</label>
                        <div class="col-md-8">
                           <div class="row mx-2">
                            <button class="btn btn-sm btn-primary" onclick="getData()">Tampilkan <i class="fa fa-magnifying-glass ms-2"></i></button>
                           </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="data" class="table table-bordered table-hover margin-top-10 w-p100">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle">NO</th>
                                    <th class="text-center align-middle">PERIODE</th>
                                    <th class="text-center align-middle">STATUS</th>
                                    <th class="text-center align-middle">IJAZAH TERAKHIR</th>
                                    <th class="text-center align-middle">BERKAS REGISTRASI WISUDA</th>
                                    <th class="text-center align-middle">NOMOR REGISTRASI</th>
                                    <th class="text-center align-middle">FOTO</th>
                                    <th class="text-center align-middle">FAKULTAS</th>
                                    <th class="text-center align-middle">PROGRAM STUDI</th>
                                    <th class="text-center align-middle">JENJANG</th>
                                    <th class="text-center align-middle">NIM</th>
                                    <th class="text-center align-middle">NAMA</th>
                                    <th class="text-center align-middle">NIK</th>
                                    <th class="text-center align-middle">TEMPAT KULIAH</th>
                                    <th class="text-center align-middle">JALUR MASUK</th>
                                    <th class="text-center align-middle">TEMPAT LAHIR</th>
                                    <th class="text-center align-middle">TANGGAL LAHIR</th>
                                    <th class="text-center align-middle">IPK</th>
                                    <th class="text-center align-middle">ALAMAT</th>
                                    <th class="text-center align-middle">TELP</th>
                                    <th class="text-center align-middle">EMAIL</th>
                                    <th class="text-center align-middle">NAMA ORANG TUA</th>
                                    <th class="text-center align-middle">ALAMAT ORANG TUA</th>
                                    <th class="text-center align-middle">TANGGAL MASUK</th>
                                    <th class="text-center align-middle">TANGGAL YUDISIUM</th>
                                    <th class="text-center align-middle">MASA STUDI</th>
                                    <th class="text-center align-middle">JUDUL TUGAS AKHIR / THESIS / DISERTASI</th>
                                    <th class="text-center align-middle">SCOR USEPT</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
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
<script src="{{asset('assets/vendor_components/select2/dist/js/select2.min.js')}}"></script>
<script>
function getData()
{
    var fakultas = $('#fakultas').val();
    var prodi = $('#prodi').val();
    var periode = $('#periode').val();

    // console.log(fakultas, prodi, periode);

    if (fakultas == '' || prodi == '' || periode == '') {
        swal('Peringatan', 'Silahkan pilih fakultas, prodi, dan periode wisuda terlebih dahulu', 'warning');
        return;

    }

    $.ajax({
        url: `{{route('bak.wisuda.peserta.data')}}`,
        type: 'GET',
        data: {
            fakultas: fakultas,
            prodi: prodi,
            periode: periode
        },
        success: function (response) {

            if (response.status === 'success') {
                console.log(response.data);
                var table = $('#data').DataTable();
                table.clear().draw();
                $.each(response.data, function (index, item) {
                    var url_berkas = '{{route('bak.wisuda.peserta.formulir', ['id' => 'ID'])}}';
                    url_berkas = url_berkas.replace('ID', item.id);
                    var berkasButton = '<a class="btn btn-sm btn-primary" href="' + url_berkas + '" target="_blank"><i class="fa fa-file me-2"></i>Unduh Berkas Registrasi</a>';
                    var spanStatus = item.approved > 5 ? '<span class="badge badge-danger">' + item.approved_text +'</span>' : '<span class="badge badge-success">' + item.approved_text +'</span>';
                    var namaOrtu = item.nama_ayah ? item.nama_ayah : '' + (item.nama_ibu_kandung ? ' & ' + item.nama_ibu_kandung : '');
                    var alamat = 'RT ' + item.rt + ' RW ' + item.rw + ', ' + item.dusun + ', ' + item.kelurahan + ', ' + item.jalan + ', ' + item.nama_wilayah;
                    var foto = item.pas_foto ? '<img src="{{ asset('' ) }}' + item.pas_foto + '" class="img-fluid" style="max-width: 300px; max-height: 500px;">' : '';
                    table.row.add([
                        index + 1,
                        item.wisuda_ke,
                        spanStatus,
                        item.ijazah_terakhir ?? '-',
                        berkasButton,
                        item.nomor_registrasi ?? '-',
                        foto,
                        item.nama_fakultas,
                        item.nama_prodi,
                        item.jenjang,
                        item.nim,
                        item.nama_mahasiswa,
                        item.nik,
                        item.lokasi_kuliah,
                        item.jalur_masuk,
                        item.tempat_lahir,
                        item.tanggal_lahir,
                        item.ipk ?? '-',
                        alamat,
                        item.handphone,
                        item.email,
                        namaOrtu,
                        item.alamat_orang_tua ?? '-',
                        item.tanggal_daftar,
                        item.tanggal_sk_yudisium ?? spanStatus,
                        item.masa_studi ?? spanStatus,
                        item.judul,
                        item.scor_usept ?? '-'
                    ]).draw(false);
                });

            } else if(response.status === 'error') {
                swal('Error', response.message, 'error');
            } else {
                swal('Error', 'Gagal mengambil data peserta wisuda', 'error');
            }

        }
    });
}

function filterProdi()
{
    var prodi = @json($prodi);
    var fakultas = $('#fakultas').val();

    if (fakultas == '*') {
        $('#prodi').empty();
        $('#prodi').append('<option value="*">-- Semua Prodi --</option>');
        $.each(prodi, function (i, p) {
            $('#prodi').append('<option value="'+p.id_prodi+'">('+p.kode_program_studi+') - '+p.nama_jenjang_pendidikan+' '+p.nama_program_studi+'</option>');
        });
        return;

    }

    var filteredProdi = prodi.filter(function (p) {
        return p.fakultas_id == fakultas;
    });

    $('#prodi').empty();

    $('#prodi').append('<option value="*">-- Semua Prodi --</option>');
    $.each(filteredProdi, function (i, p) {
        $('#prodi').append('<option value="'+p.id_prodi+'">('+p.kode_program_studi+') - '+p.nama_jenjang_pendidikan+' '+p.nama_program_studi+'</option>');
    });

}

$(function () {
    // "use strict";
    $('#data').DataTable();

    $('#fakultas').select2();
    $('#prodi').select2();
    $('#periode').select2();
});
</script>
@endpush
