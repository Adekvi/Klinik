<div class="modal fade" id="tambahuser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="pasienbaru" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Akses User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('admin/tambah/user') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="id_dokter">Nama Tenaga Medis</label>
                        <select name="id_dokter" id="id_dokter" class="form-control mt-2 mb-2">
                            <option value="#" disabled selected>Pilih Tenaga Medis</option>
                            @foreach ($dokter as $dok)
                                <option value="{{ $dok->id }}">{{ $dok->nama_dokter }} -
                                    {{ $dok->profesi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control mt-2 mb-2" name="username" id="username"
                            placeholder="Masukkan Username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control mt- mb-2" name="password" id="password" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role Akses</label>
                        <select name="role" id="role" class="form-control mt-2 mb-2">
                            <option value="#">Pilih Akses Sebagai</option>
                            <option value="perawat">Perawat</option>
                            <option value="dokter">Dokter</option>
                            <option value="apoteker">Apoteker</option>
                            <option value="kasir">Kasir</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
