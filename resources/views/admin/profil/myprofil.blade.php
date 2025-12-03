<x-admin.layout.terminal title="My Profile">

    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4>

            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-pills flex-column flex-md-row mb-3">
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i>
                                Account</a>
                        </li>
                        {{-- <li class="nav-item">
                                <a class="nav-link" href="#"><i class="bx bx-bell me-1"></i> Notifications</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="bx bx-link-alt me-1"></i> Connections</a>
                            </li> --}}
                    </ul>
                    <div class="card mb-4">
                        <h5 class="card-header">Profile Details</h5>

                        <form id="formAccountSettings" method="POST"
                            action="{{ route('profile.update', $profil->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="d-flex align-items-start align-items-sm-center gap-4">

                                    <!-- Kondisi foto -->
                                    <img src="{{ $profil->foto ? asset('storage/' . $profil->foto) : asset('aset/img/user.webp') }}"
                                        alt="user-avatar" class="d-block rounded" height="100" width="100"
                                        id="uploadedAvatar" />

                                    <div class="button-wrapper">
                                        <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                            <span class="d-none d-sm-block">Upload new photo</span>
                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                            <input type="file" id="upload" name="foto"
                                                class="account-file-input" hidden accept="image/png, image/jpeg" />
                                        </label>

                                        <button type="button"
                                            class="btn btn-outline-secondary account-image-reset mb-4" id="resetImage">
                                            <i class="bx bx-reset d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Reset</span>
                                        </button>

                                        <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-0" />

                            <div class="card-body">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Nama</label>
                                        <input class="form-control" type="text" name="name"
                                            value="{{ $profil->name }}" />
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Username</label>
                                        <input class="form-control" type="text" name="username"
                                            value="{{ $profil->username }}" />
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">E-mail</label>
                                        <input class="form-control" type="text" name="email"
                                            value="{{ $profil->email ?? '-' }}" />
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Password</label>

                                        <div class="position-relative">
                                            <input type="password" id="password" name="password" class="form-control"
                                                placeholder="Kosongkan jika tidak mengubah"
                                                value="{{ $profil->password }}" />

                                            <!-- Eye icon -->
                                            <i class="fa-solid fa-eye-slash" id="togglePassword"
                                                style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #6c757d;">
                                            </i>
                                        </div>
                                    </div>

                                </div>

                                <div class="mt-2">
                                    <button type="submit" class="btn btn-info me-2">
                                        <i class="fas fa-save"></i> Save changes</button>
                                    {{-- <button type="reset" class="btn btn-outline-secondary">Cancel</button> --}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- <div class="card">
                        <h5 class="card-header">Delete Account</h5>
                        <div class="card-body">
                            <div class="mb-3 col-12 mb-0">
                                <div class="alert alert-warning">
                                    <h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete your account?
                                    </h6>
                                    <p class="mb-0">Once you delete your account, there is no going back. Please be
                                        certain.</p>
                                </div>
                            </div>
                            <form id="formAccountDeactivation" onsubmit="return false">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="accountActivation"
                                        id="accountActivation" />
                                    <label class="form-check-label" for="accountActivation">I confirm my account
                                        deactivation</label>
                                </div>
                                <button type="submit" class="btn btn-danger deactivate-account">Deactivate
                                    Account</button>
                            </form>
                        </div>
                    </div> --}}
            </div>
        </div>
    </div>
    <!-- / Content -->

    @push('style')
        <style>
            .swal2-container {
                z-index: 9999 !important;
            }
        </style>
    @endpush

    @push('script')
        <script>
            document.getElementById('upload').addEventListener('change', function(e) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('uploadedAvatar').src = e.target.result;
                }
                reader.readAsDataURL(this.files[0]);
            });

            document.getElementById('resetImage').addEventListener('click', function() {
                document.getElementById('uploadedAvatar').src =
                    "{{ asset('storage/' . ($profil->foto ?? 'aset/img/user.webp')) }}";
                document.getElementById('upload').value = "";
            });

            // password
            document.getElementById('togglePassword').addEventListener('click', function() {
                const input = document.getElementById('password');
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);

                // Toggle icon
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        </script>
    @endpush

</x-admin.layout.terminal>
