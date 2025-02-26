@extends('layouts.fakultas')
@section('title')
Pengajuan Cuti Fakultas
@endsection
@section('content')
@include('swal')
<section class="content bg-white">
    <div class="row align-items-end">
        <div class="col-12">
			<div class="box pull-up">
				<div class="box-body bg-img bg-primary-light">
					<div class="d-lg-flex align-items-center justify-content-between">
						<div class="d-lg-flex align-items-center mb-30 mb-xl-0 w-p100">
			    			<img src="{{asset('images/images/svg-icon/color-svg/custom-14.svg')}}" class="img-fluid max-w-250" alt="" />
							<div class="ms-30">
								<h2 class="mb-10">Pengajuan Cuti Fakultas</h2>
								<p class="mb-0 text-fade fs-18">Universitas Sriwijaya</p>
							</div>
						</div>
					<div>
				</div>
			</div>							
		</div>
    </div>
    <div class="row">
        <div class="col-xxl-12">
            <div class="box box-body mb-0">
                <div class="row">
                    <div class="col-xl-6 col-lg-12">
                        <h3 class="fw-500 text-dark mt-0">Daftar Pengajuan Cuti Fakultas</h3>
                    </div>                             
                </div>
                {{-- <div class="row mb-5">
                    <div class="col-xl-12 col-lg-12 text-end">
                        <div class="btn-group">
                            <a class="btn btn-rounded bg-success-light " href="{{route('fakultas.pengajuan-cuti.tambah')}}"><i class="fa fa-plus"><span class="path1"></span><span class="path2"></span></i> Tambah Pengajuan Cuti</a>
                        </div>   
                    </div>                           
                </div><br> --}}
                <div class="row">
                    <div class="table-responsive">
                        <table id="data" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIM</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Program Studi</th>
                                    <th>Semester</th>
                                    <th>Alasan Pengajuan Cuti</th>
                                    <th>Status Pengajuan Cuti</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $d)
                                @include('fakultas.lain-lain.pengajuan-cuti.pembatalan-cuti')
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td class="text-start align-middle">{{$d->riwayat->nim}}</td>
                                        <td class="text-start align-middle">{{$d->nama_mahasiswa}}</td>
                                        <td class="text-start align-middle">{{$d->prodi->nama_jenjang_pendidikan}} - {{$d->prodi->nama_program_studi}}</td>
                                        <td class="text-start align-middle" style="white-space:nowrap;">{{$d->nama_semester}}</td>
                                        <td class="text-start align-middle">{{$d->alasan_cuti}}</td>
                                        <td class="text-center align-middle" style="width:10%">
                                            @if($d->approved == 0)
                                                <span class="badge badge-xl badge-danger-light mb-5">Belum Disetujui</span>
                                            @elseif($d->approved == 1)
                                                <span class="badge badge-xl badge-warning-light mb-5">Disetujui Fakultas</span>
                                            @elseif($d->approved == 2)
                                                <span class="badge badge-xl badge-success-light mb-5">Disetujui BAK</span>
                                            @elseif($d->approved == 3)
                                                <span class="badge badge-xl badge-danger-light mb-5">Ditolak Fakultas</span>
                                            @elseif($d->approved == 4)
                                                <span class="badge badge-xl badge-danger-light mb-5">Ditolak BAK</span>
                                            @endif
                                        </td>
                                        <td class="text-center align-middle text-nowrap">
                                            <div class="row">
                                                @if($d->approved == 0)
                                                <form action="{{route('fakultas.pengajuan-cuti.approve', $d)}}" method="post" id="approveForm{{$d->id_cuti}}" class="approve-class" data-id='{{$d->id_cuti}}'>
                                                    @csrf
                                                    <div class="row  mb-5">
                                                        <button 
                                                        type="submit" 
                                                        class="btn btn-sm btn-primary" title="Setujui Pengajuan Cuti"><i class="fa fa-thumbs-up"></i> Approve</button>
                                                    </div>
                                                </form>
                                                @endif
                                                @if($d->approved < 3)
                                                    <a href="#" class="btn btn-danger btn-sm my-2" title="Tolak Bimbingan" data-bs-toggle="modal" data-bs-target="#pembatalanModal{{$d->id}}"><i class="fa fa-ban"></i> Decline</a>
                                                @endif
                                                <a href="{{ asset('storage/' . $d->file_pendukung) }}" target="_blank" class="btn btn-primary">
                                                    <i class="fa fa-file-pdf-o"></i> File Pendukung
                                                </a>                                                                                            
                                            </div>
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

<script>
    $(function () {
        $('#data').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
        });
    });
</script>

@endpush

