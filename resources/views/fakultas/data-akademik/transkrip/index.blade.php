@extends('layouts.fakultas')
@section('title')
Transkrip Nilai
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
                            <h2>Transkrip Nilai Mahasiswa</h2>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-body py-10">
                    <div class="col-md-6 mt-5">
                        <div class="form-group row">
                            <label class="col-form-label col-md-2">NIM</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="nim" placeholder="Masukan NIM mahasiswa">
                                    <button class="btn btn-primary" id="btnCari"><i class="fa fa-search"></i> Cari</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mt-5">
                        <div class="box-body text-center">
                            <div class="table-responsive">
                                <div id="krsDiv" hidden>
                                    <div class="row mb-2">
                                        <form action="{{route('fakultas.transkrip-nilai.download')}}" method="get" id="cetakForm" target="_blank">
                                            <input type="hidden" name="nim" id="nimCetak">
                                            <button class="btn btn-success" type="submit"><i class="fa fa-print"></i> Cetak</button>
                                        </form>
                                    </div>
                                    <h3 class="text-center">Transkrip Mahasiswa</h3>
                                    <div class="row">
                                        <div class="col-md-2" id="foto">

                                        </div>
                                        <div class="col-md-10">
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
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end align-middle">

                                    </div>
                                    <table class="table table-bordered mt-4" id="krs-regular">
                                        <thead>
                                            <tr>
                                                <th class="text-center align-middle">No</th>
                                                <th class="text-center align-middle">Kode Mata Kuliah</th>
                                                <th class="text-center align-middle">Nama Mata Kuliah</th>

                                                <th class="text-center align-middle">SKS</th>
                                                <th class="text-center align-middle">Nilai Angka</th>
                                                <th class="text-center align-middle">Nilai Index</th>
                                                <th class="text-center align-middle">Nilai Huruf</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3" class="text-center align-middle">Total SKS</th>
                                                <th class="text-center align-middle" id="totalSks"></th>
                                                <th ></th>
                                                <th ></th>
                                                <th ></th>
                                            </tr>
                                        </tfoot>
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
        </div>
    </div>
</section>
@endsection
@push('js')
<script src="{{asset('assets/vendor_components/datatable/datatables.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#btnCari').click(function () {
                var nim = $('#nim').val();
                if (nim == '') {
                    swal('Peringatan', 'NIM tidak boleh kosong', 'warning');
                } else {
                    $.ajax({
                        url: '{{route('fakultas.transkrip-nilai.get')}}',
                        type: 'GET',
                        data: {
                            nim: nim
                        },
                        success: function (response) {

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
                            $('#nimCetak').val(nim);
                            $('#krsDiv').removeAttr('hidden');
                            // append response.krs to table of krs-regular
                            $('#nimKrs').text(response.riwayat.nim);
                            // remove "Fakultas " from nama_fakultas
                            var fakultas = response.riwayat.prodi.fakultas.nama_fakultas.replace('Fakultas ', '');
                            $('#fakultasKrs').text(fakultas);
                            $('#namaKrs').text(response.riwayat.nama_mahasiswa);
                            var jurusan = response.riwayat.prodi.jurusan.nama_jurusan_id ?? '-';
                            $('#jurusanKrs').text(jurusan);
                            var nip_pa = response.riwayat.pembimbing_akademik ? response.riwayat.pembimbing_akademik.nip : '-';
                            $('#nippaKrs').text(nip_pa);
                            var dosen_pa = response.riwayat.pembimbing_akademik ? response.riwayat.pembimbing_akademik.nama_dosen : '-';
                            $('#dosenpaKrs').text(dosen_pa);
                            $('#prodiKrs').text(response.riwayat.prodi.nama_program_studi);
                            var semesterText =  $('#semester option:selected').text();
                            $('#semesterKrs').text(semesterText);
                            $('#krs-regular tbody').empty();

                            // append foto
                            var imagePath = '{{ asset('storage') }}' + '/' + response.riwayat.angkatan + '/' + response.riwayat.nim + '.jpg';
                            $('#foto').html(`
                                <img class="rounded20 bg-light img-fluid w-80" src="` + imagePath + `" alt="" onerror="this.onerror=null;this.src='{{ asset('images/images/avatar/avatar-15.png') }}';">
                            `);

                              // Initialize DataTable
                             // Initialize DataTable with no pagination and custom draw callback
                             var table = $('#krs-regular').DataTable({
                                paging: false,
                                info: false,
                                columnDefs: [
                                    { orderable: false, targets: 0 } // Make the first column non-sortable
                                ],
                                order: [], // Disable initial sorting
                                drawCallback: function(settings) {
                                    var api = this.api();
                                    api.rows({ page: 'current' }).every(function (rowIdx, tableLoop, rowLoop) {
                                        var data = this.data();
                                        data[0] = rowIdx + 1; // Update the first column with the row number
                                        this.invalidate();
                                    });
                                }
                            });
                            table.clear().draw(); // Clear existing data
                            // count response.krs.approved
                            var approved = 0;
                            var no = 1;
                            var totalSks = 0;

                            response.data.forEach(function (krs, index) {
                                var trClass = '';
                                if (krs.nilai_huruf == 'F' || krs.nilai_huruf == null) {
                                    trClass = 'bg-danger';
                                }
                                table.row.add([
                                    `<td class="text-center align-middle"></td>`,
                                    `<td class="text-center align-middle">${krs.kode_mata_kuliah}</td>`,
                                    `<td class="text-start align-middle">${krs.nama_mata_kuliah}</td>`,
                                    `<td class="text-center align-middle">${krs.sks_mata_kuliah}</td>`,
                                    `<td class="text-center align-middle">${krs.nilai_angka ?? '-'}</td>`,
                                    `<td class="text-center align-middle">${krs.nilai_indeks ?? '-'}</td>`,
                                    `<td class="text-center align-middle">${krs.nilai_huruf ?? '-'}</td>`
                                ]).node().className = trClass;

                                totalSks += parseInt(krs.sks_mata_kuliah);
                            });

                            table.draw(); // Redraw the DataTable with new data
                            $('#totalSks').text(totalSks);

                        }
                    });

                }
            });
        });
    </script>
@endpush