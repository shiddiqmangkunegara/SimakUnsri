@extends('layouts.universitas')
@section('title')
Periode Perkuliahan
@endsection
@section('content')
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h3 class="page-title">Periode Perkuliahan</h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('univ')}}"><i class="mdi mdi-home-outline"></i></a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Pengaturan</li>
                        <li class="breadcrumb-item active" aria-current="page">Periode Perkuliahan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
@include('swal')
<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="box box-outline-success bs-3 border-success">
                <div class="box-header d-flex justify-content-between with-border">
                    <div class="d-flex justify-content-start gap-3">
                        <!-- Modal trigger button -->
                        <button type="button" class="btn btn-secondary waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#filter-button">
                            <i class="fa fa-filter"></i> Filter
                        </button>
                        <!-- Modal trigger button -->
                        <button
                            type="button"
                            class="btn btn-success waves-effect waves-light"
                            data-bs-toggle="modal"
                            data-bs-target="#uploadModal"
                        >
                            <i class="fa fa-upload"></i> Upload Periode
                        </button>

                        <!-- Modal Body -->
                        <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->

                        @include('universitas.pengaturan.periode-perkuliahan.filter')
                        @include('universitas.pengaturan.periode-perkuliahan.upload')
                    </div>
                    <div class="d-flex justify-content-end">
                        <form action="{{route('univ.pengaturan.periode-perkuliahan.sync')}}" method="get"
                            id="sync-form">
                            <button class="btn btn-primary waves-effect waves-light" type="submit"><i
                                    class="fa fa-refresh"></i> Sinkronisasi</button>
                        </form>
                        <span class="divider-line mx-1"></span>
                        {{-- <form action="{{route('univ.mata-kuliah.sync-rencana')}}" method="get" id="sync-rencana">
                            <button class="btn btn-success waves-effect waves-light" type="submit"><i
                                    class="fa fa-refresh"></i> Sinkronisasi RPS & Evaluasi</button>
                        </form> --}}
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="data" class="table  table-hover margin-top-10 w-p100">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle">Status</th>
                                    <th class="text-center align-middle">No</th>
                                    <th class="text-center align-middle">Semester</th>
                                    <th class="text-center align-middle">Program Studi</th>
                                    <th class="text-center align-middle">Status Prodi</th>
                                    <th class="text-center align-middle">Target MHS Baru</th>
                                    <th class="text-center align-middle">Tanggal Awal Perkuliahan</th>
                                    <th class="text-center align-middle">Tanggal Akhir Perkuliahan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $d)
                                <tr>
                                    <td class="text-center align-middle">
                                        @if ($d->status_sync == 'sudah sync')
                                        <span class="badge bg-success">{{$d->status_sync}}</span>
                                        @else
                                        <span class="badge bg-danger">{{$d->status_sync}}</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">{{$loop->iteration}}</td>
                                    <td class="text-center align-middle">{{$d->semester->nama_semester}}</td>
                                    <td class="text-start align-middle">{{$d->nama_program_studi}}</td>
                                    <td class="text-center align-middle">{{$d->prodi->status}}</td>
                                    <td class="text-center align-middle">{{$d->jumlah_target_mahasiswa_baru}}</td>
                                    <td class="text-center align-middle">{{$d->tanggal_awal_perkuliahan}}</td>
                                    <td class="text-center align-middle">{{$d->tanggal_akhir_perkuliahan}}</td>
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
<script src="{{asset('assets/vendor_components/datatable/datatables.min.js')}}"></script>
<script src="{{asset('assets/vendor_components/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/vendor_components/select2/dist/js/select2.min.js')}}"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.21/sorting/date-eu.js"></script>
<script>
    $(function () {
        "use strict";

        $('#id_prodi').select2({
            placeholder: 'Pilih Program Studi',
            allowClear: true,
            width: '100%',
            dropdownParent: $('#filter-button')
        });

        $('#id_semester').select2({
            placeholder: 'Pilih Semester',
            allowClear: true,
            width: '100%',
            dropdownParent: $('#filter-button')
        });

        // $.fn.dataTable.moment('dd-mm-yyyy');

        $('#data').DataTable({
            columnDefs: [
                {
                    type: 'date-eu', targets: [6, 7]
                },
                {
                    targets: [0,1], // specify the columns (0-indexed) that you want to sort as date
                    sortable: false
                } // specify the columns (0-indexed) that you want to sort as date
            ]
        });

        // sweet alert sync-form
        $('#sync-form').submit(function(e){
            e.preventDefault();
            swal({
                title: 'Sinkronisasi Data',
                text: "Apakah anda yakin ingin melakukan sinkronisasi?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Sinkronkan!',
                cancelButtonText: 'Batal'
            }, function(isConfirm){
                if (isConfirm) {
                    $('#spinner').show();
                    $('#sync-form').unbind('submit').submit();
                }
            });
        });

    });
</script>
@endpush
