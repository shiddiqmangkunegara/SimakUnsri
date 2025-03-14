<div class="modal fade" id="createLain" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
    aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-l" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    Tambah Akun Dosen
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('univ.pengaturan.akun.create-lain')}}" method="post" id="dosen-refresh">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Role</label>
                            <select class="form-select" name="role" id="role" required>
                                <option value="" disabled selected>Select one</option>
                                <option value="perpus">Perpustakaan</option>
                                <option value="bak">Bak</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" id="username" required
                                value="{{old('username')}}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="name" id="name" required
                                value="{{old('name')}}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">E-Mail</label>
                            <input type="text" class="form-control" name="email" id="email" required
                                value="{{old('email')}}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" name="password_confirmation"
                                id="password_confirmation" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
