@extends('layouts.dosen')
@section('title')
Detail Penilaian Perkuliahan Mahasiswa
@endsection
@section('content')
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
                                <h2 class="mb-10">{{$data->kode_mata_kuliah}} - {{$data->nama_mata_kuliah}}</h2>
                                <p class="mb-0 text-fade fs-18">{{$data->nama_program_studi}}</p>
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
                                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('dosen.penilaian.penilaian-perkuliahan')}}">Penilaian Perkuliahan</a></li>
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
                        <div class="row">
                            <div class="table-responsive">
                                <table id="data" class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">No</th>
                                            <th rowspan="2">NIM</th>
                                            <th rowspan="2">Nama Mahasiswa</th>
                                            <th rowspan="2">Angkatan</th>
                                            <th colspan="2">Nilai</th>
                                        </tr>
                                        <tr>
                                            <th>Angka</th>
                                            <th>Huruf</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data->nilai_perkuliahan as $d)
                                            <tr>
                                                <td class="text-center align-middle">{{$loop->iteration}}</td>
                                                <td class="text-center align-middle">{{$d->nim}}</td>
                                                <td class="text-start align-middle">{{$d->nama_mahasiswa}}</td>
                                                <td class="text-center align-middle">{{$d->angkatan}}</td>
                                                <td class="text-center align-middle">{{$d->nilai_angka}}</td>
                                                <td class="text-center align-middle">{{$d->nilai_huruf}}</td>
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

<script>
      $(document).ready(function() {
        $('#data').DataTable({
            "paging": false,
            "ordering": true,
            "searching": true,
            "scrollCollapse": true,
            "scrollY": "550px",
            "fixedColumns": {
                "rightColumns": 6
            },
            columnDefs:[]
        });

    });
</script>

@endpush