@extends('layouts.mahasiswa')
@section('title')
Jadwal dan Presensi
@endsection
@section('content')
<section class="content">
    <div class="row align-items-end">
        <div class="col-xl-12 col-12">
            <div class="box bg-primary-light pull-up">
                <div class="box-body p-xl-0">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-3"><img src="{{asset('images/images/svg-icon/color-svg/custom-14.svg')}}" alt="">
                        </div>
                        <div class="col-12 col-lg-9">
                            <!-- <h2>Halaman KRS {{auth()->user()->name}}</h2> -->
                            <h2>Pembimbing Akademik Online</h2>
                            <p class="text-dark mb-0 fs-16">
                                Universitas Sriwijaya
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-20">
        <div class="col-lg-12 col-xl-12 mt-5">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <h3 class="fw-500 text-dark mt-0">Pembimbing Akademik Online</h3>
                        </div>                             
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <!-- <div class="box no-shadow"> -->
                                <div class="box-header no-border p-0 mb-20">
                                    <!-- <div class="box-controls pull-left d-md-flex d-none"> -->
                                        <div class="form-group m-10">
                                            <label class="form-label">Pilih Periode</label>
                                            <select class="form-select">
                                                <option>2023/2024 Genap</option>
                                                <option>2023/2024 Ganjil</option>
                                                <option>2022/2023 Genap</option>
                                                <option>2022/2023 Ganjil</option>
                                                <option>2021/2022 Genap</option>
                                                <option>2021/2022 Ganjil</option>
                                            </select>
                                        </div>
                                    <!-- </div> -->
                                </div>
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="box-body">
                    <div class="row mt-20">
                        <div class="col-xxl-12">
                            <div class="box box-body mb-0 bordered">
                                <!-- <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <h3 class="fw-500 text-dark mt-0">Daftar Tagihan Uang Kuliah Tunggal</h3>
                                    </div>                             
                                </div> -->
                                <div class="row">
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-bordered table-striped text-left">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Pertemua</th>
                                                    <th>Waktu Mulai</th>
                                                    <th>Waktu Selesai</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1 </td>
                                                    <td>Pertemuan 1 </td>
                                                    <td>Rabu, 10 Januari 2024 08:00</td>
                                                    <td>Rabu, 17 Januari 2024 23:59</td>
                                                    <td>
                                                        <button type="button" class="waves-effect waves-light btn btn-danger-light mb-5">Belum isi</button>
                                                        <button type="button" class="waves-effect waves-light btn btn-danger-light mb-5">Di luar jadwal</button>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>2</td>
                                                    <td>Pertemuan 2</td>
                                                    <td>Selasa, 1 Agustus 2023 08:00</td>
                                                    <td>Selasa, 8 Agustus 2023 23:59</td>
                                                    <td>
                                                        <button type="button" class="waves-effect waves-light btn btn-success-light mb-5">Sudah isi</button>
                                                        <button type="button" class="waves-effect waves-light btn btn-outline btn-primary mb-5" data-bs-toggle="modal" data-bs-target="#editModal">Lihat Pertanyaan</button>
                                                        @include('mahasiswa.pa-online.include.edit')
                                                        <button type="button" class="waves-effect waves-light btn btn-danger-light mb-5">Di luar jadwal</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Pertemuan 3</td>
                                                    <td>Kamis, 5 Januari 2023 08:00</td>
                                                    <td>Kamis, 12 Januari 2023 23:59</td>
                                                    <td>
                                                        <button type="button" class="waves-effect waves-light btn btn-success-light mb-5">Sudah isi</button>
                                                        <button type="button" class="waves-effect waves-light btn btn-outline btn-primary mb-5" data-bs-toggle="modal" data-bs-target="#editModal">Lihat Pertanyaan</button>
                                                        @include('mahasiswa.pa-online.include.edit')
                                                        <button type="button" class="waves-effect waves-light btn btn-danger-light mb-5">Di luar jadwal</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Pertemuan 4</td>
                                                    <td>Rabu, 3 Agustus 2022 08:00</td>
                                                    <td>Rabu, 10 Agustus 2022 23:59</td>
                                                    <td>
                                                        <button type="button" class="waves-effect waves-light btn btn-success-light mb-5">Sudah isi</button>
                                                        <button type="button" class="waves-effect waves-light btn btn-outline btn-primary mb-5" data-bs-toggle="modal" data-bs-target="#editModal">Lihat Pertanyaan</button>
                                                        @include('mahasiswa.pa-online.include.edit')
                                                        <button type="button" class="waves-effect waves-light btn btn-danger-light mb-5">Di luar jadwal</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>Pertemuan 5</td>
                                                    <td>Sabtu, 2 Januari 2022 08:00</td>
                                                    <td>Sabtu, 9 Januari 2022 23:59</td>
                                                    <td>
                                                        <button type="button" class="waves-effect waves-light btn btn-success-light mb-5">Sudah isi</button>
                                                        <button type="button" class="waves-effect waves-light btn btn-outline btn-primary mb-5" data-bs-toggle="modal" data-bs-target="#editModal">Lihat Pertanyaan</button>
                                                        @include('mahasiswa.pa-online.include.edit')
                                                        <button type="button" class="waves-effect waves-light btn btn-danger-light mb-5">Di luar jadwal</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>Pertemuan 6</td>
                                                    <td>Sabtu, 1 Agustus 2021 08:00</td>
                                                    <td>Sabtu, 8 Agustus 2021 23:59</td>
                                                    <td>
                                                        <button type="button" class="waves-effect waves-light btn btn-danger-light mb-5">Belum isi</button>
                                                        <button type="button" class="waves-effect waves-light btn btn-danger-light mb-5">Di luar jadwal</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>	
</section>
@endsection