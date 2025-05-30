<div class="modal fade" id="filter-button" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    role="dialog" aria-labelledby="filterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterTitle">
                    {{-- filter icon fa --}}
                    <i class="fa fa-filter"></i> Filter
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('fakultas.data-akademik.kelas-penjadwalan')}}" method="get">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="prodi" class="form-label">Prodi</label>
                            <select multiple class="form-select" name="prodi[]" id="prodi">
                                @foreach ($prodi as $p)
                                <option value="{{$p->id_prodi}}" {{ in_array($p->id_prodi, old('prodi',
                                    request()->get('prodi', []))) ? 'selected' : '' }}>
                                    {{$p->nama_jenjang_pendidikan}} - {{$p->nama_program_studi}} ({{$p->kode_program_studi}})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="col-md-12 mb-3">
                            <label for="daftar_semester" class="form-label">Angkatan</label>
                            <select multiple class="form-select" name="daftar_semester[]" id="daftar_semester">
                                <option value="">
                                    -- Pilih Angkatan --
                                </option>
                                @foreach ($daftar_semester as $p)
                                    <option value="{{$p->id_semester}}" {{ in_array($p->id_semester, old('daftar_semester',
                                        request()->get('daftar_semester', []))) ? 'selected' : '' }}>
                                        {{$p->nama_semester}}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="submit" class="btn btn-primary" id="apply-filter">Apply</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('js')
<script>
    $(document).ready(function () {
        $('#prodi').select2({
            placeholder: '-- Pilih Prodi -- ',
            allowClear: true,
            width: '100%',
            dropdownParent: $('#filter-button')
        });

        $('#daftar_semester').select2({
            placeholder: '-- Pilih Angkatan -- ',
            allowClear: true,
            width: '100%',
            dropdownParent: $('#filter-button')
        });
    });
</script>
@endpush
