@extends('layouts.dosen')
@section('title')
Rencana Pembelajaran Semester
@endsection
@section('content')
@include('swal')
@php
$id_matkul = $matkul->id_matkul;
@endphp
<section class="content bg-white">
    <div class="row align-items-end">
        <div class="col-12">
            <div class="box pull-up">
                <div class="box-body bg-img bg-primary-light">
                    <div class="d-lg-flex align-items-center justify-content-between">
                        <div class="d-lg-flex align-items-center mb-30 mb-xl-0 w-p100">
                            <img src="{{asset('images/images/svg-icon/color-svg/custom-14.svg')}}"
                                class="img-fluid max-w-250" alt="" />
                            <div class="ms-30">
                                <h2 class="mb-10">{{$matkul->kode_mata_kuliah}} - {{$matkul->nama_mata_kuliah}}</h2>
                                <p class="mb-0 text-fade fs-18">{{$matkul->nama_program_studi}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-header mb-3">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('dosen')}}"><i class="mdi mdi-home-outline"></i></a></li>
                                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('dosen.perkuliahan.rencana-pembelajaran')}}">Rencana Pembelajaran</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-12">
                    <div class="box box-body mb-0 ">
                        <div class="row mb-5">
                            <div class="col-xl-6 col-lg-6">
                                <a class="btn btn-rounded bg-warning-light" href="{{route('dosen.perkuliahan.rencana-pembelajaran')}}"><i class="fa fa-chevron-left"><span class="path1"></span><span class="path2"></span></i> Kembali</a>
                            </div>  
                            <div class="col-xl-6 col-lg-6 text-end">
                                <div class="btn-group">
                                    <a class="btn btn-rounded bg-success-light " href="{{route('dosen.perkuliahan.rencana-pembelajaran.tambah', ['matkul' => $id_matkul])}}"><i class="fa fa-plus"><span class="path1"></span><span class="path2"></span></i> Tambah RPS</a>
                                    <a class="btn btn-rounded bg-warning-light " href="{{route('dosen.perkuliahan.rencana-pembelajaran.ubah-link', ['matkul' => $id_matkul])}}"><i class="fa fa-pencil-square-o"><span class="path1"></span><span class="path2"></span></i> Edit Link RPS</a>
                                </div>   
                            </div>                           
                        </div><br>
                        <div class="row">
                            <div class="table-responsive">
                                <table id="data" class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>Pertemuan</th>
                                            <th>Materi Indonesia</th>
                                            <th>Materi Inggris</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $d)
                                            <tr>
                                                <td class="text-center align-middle">{{$d->pertemuan}}</td>
                                                <td class="text-start align-middle">{{$d->materi_indonesia}}</td>
                                                <td class="text-start align-middle">{{$d->materi_inggris}}</td>
                                                <td class="text-center align-middle">@if($d->approved == 0)
                                                    <span class="badge badge-danger">Belum di Setujui<span>
                                                    @elseif($d->approved == 1)
                                                        <span class="badge badge-success">Sudah di Setujui<span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="btn btn-sm btn-rounded bg-warning" href="{{route('dosen.perkuliahan.rencana-pembelajaran.ubah', ['rencana_ajar' => $d->id_rencana_ajar])}}"><i class="fa fa-pencil-square-o"></i> Update RPS</a>
                                                    <a class="btn btn-sm btn-rounded bg-danger" href="{{route('dosen.perkuliahan.rencana-pembelajaran.delete', ['rencana_ajar' => $d->id_rencana_ajar])}}"><i class="fa fa-trash" id="delete-rps"></i> Delete RPS</a>
                                                </td>
                                            </tr>
                                        @endforeach
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
<script src="{{asset('assets/vendor_components/sweetalert/sweetalert.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#data').DataTable({
            "paging": true,
            "ordering": true,
            "searching": true,
            // "scrollCollapse": true,
            // "scrollY": "550px",
        });
    });

    $('#delete-rps').submit(function(e){
        e.preventDefault();
        swal({
            title: 'Perubahan Rencana Pembelajaran Semester',
            text: "Apakah anda yakin ingin?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Batal'
        }, function(isConfirm){
            if (isConfirm) {
                $('#delete-rps').unbind('submit').submit();
                $('#spinner').show();
            }
        });
    });
</script>

@endpush
