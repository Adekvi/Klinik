@extends('admin.layout.dasbrod')
@section('title', 'Admin | Informasi')
@section('content')

    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin/</span> Informasi</h4>

            <!-- Basic Layout -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Informasi Perangkat</h5>
                            <small class="text-muted float-end">Perangkat Keras</small>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">Device</label>
                                <input type="text" class="form-control" id="basic-default-fullname"
                                    value="{{ $deviceInfo['device'] }}" readonly />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-company">OS</label>
                                <input type="text" class="form-control" id="basic-default-company"
                                    value="{{ $deviceInfo['os'] }}" readonly />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-message">User Agent</label>
                                <input type="text" class="form-control" id="basic-default-company"
                                    value="{{ $deviceInfo['userAgent'] }}" readonly />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
