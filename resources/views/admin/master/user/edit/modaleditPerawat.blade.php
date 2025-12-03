@foreach ($user as $item)
    <div class="modal fade" id="editperawat{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="pasienbaru" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Akses User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('admin/edit/user/' . $item->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama Tenaga Medis</label>
                            <select name="name" id="name" class="form-control mt-2 mb-2">
                                <option value="{{ $item->name }}" selected>{{ $item->name }}</option>
                                @foreach ($dokter as $dok)
                                    <option value="{{ $dok->id }}">{{ $dok->nama_dokter }} -
                                        {{ $dok->profesi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control mt-2 mb-2" name="username" id="username"
                                value="{{ $item->username }}">
                        </div>
                        <div class="form-group">
                            <label for="password">Email</label>
                            <input type="text" class="form-control mt-2 mb-2" name="email" id="email"
                                value="{{ $item->email ?? '-' }}">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control mt-2 mb-2" name="password" id="password"
                                value="{{ $item->password }}">
                        </div>
                        <div class="form-group">
                            <label for="role">Role Akses</label>
                            <input type="text" class="form-control mt-2 mb-2" name="role" id="role"
                                value="{{ $item->role }}" readonly>
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
@endforeach
