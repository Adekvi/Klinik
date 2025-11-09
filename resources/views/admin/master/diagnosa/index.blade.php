<x-admin.layout.terminal title="Admin | Data Diagnosa">

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5 style="margin-bottom: 20px"><strong>Data Diagnosa</strong></h5>
                        <div class="mb-1" style="display: flex; justify-content: space-between">
                            <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal"
                                data-bs-target="#tambahdiagnosa"><i class="bi bi-plus-lg"></i>Tambah Data
                                Diagnosa</button>
                        </div>
                    </div>

                    <div class="page d-flex" style="justify-content: space-between">
                        <form method="GET" action="{{ route('master.diagnosa') }}"
                            class="d-flex justify-content-between align-items-center mb-3">
                            <input type="hidden" name="page" value="1"> {{-- Reset ke halaman 1 saat pencarian --}}
                            <div class="d-flex align-items-center">
                                <label for="entries" class="me-2">Tampilkan:</label>
                                <select name="entries" id="entries" class="form-select form-select-sm me-3"
                                    style="width: 80px;" onchange="this.form.submit()">
                                    <option value="10" {{ request('entries', 10) == 10 ? 'selected' : '' }}>10
                                    </option>
                                    <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25
                                    </option>
                                    <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50
                                    </option>
                                    <option value="100" {{ request('entries') == 100 ? 'selected' : '' }}>100
                                    </option>
                                </select>
                            </div>
                        </form>

                        <div class="cari mb-2">
                            <input type="text" name="search" id="search" class="form-control"
                                placeholder="Cari..." style="width: 100%">
                        </div>
                    </div>

                    <div class="tb-umum">
                        <table id="example" class="table table-striped table-bordered text-center" style="width:100%">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Diagnosa</th>
                                    <th>Nama Diagnosa</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="diagnosa-table">
                                @include('admin.master.diagnosa.table', ['diagnosa' => $diagnosa])
                            </tbody>
                        </table>

                        <div class="halaman d-flex justify-content-end">
                            {{ $diagnosa->appends(['entries' => $entries])->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.master.diagnosa.modaltambah')
    @include('admin.master.diagnosa.modaledit')
    @include('admin.master.diagnosa.modalhapus')

    @push('style')
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> --}}
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap4.css">
    @endpush

    @push('script')
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap4.js"></script>
        {{-- <script>
    new DataTable('#example');
</script> --}}
        <script>
            $(document).ready(function() {
                $('#search').on('input', function() {
                    var query = $(this).val();
                    $.ajax({
                        url: "{{ route('diagnosa.search') }}",
                        method: "GET",
                        data: {
                            query: query
                        },
                        success: function(data) {
                            $('#diagnosa-table').html(data);
                        }
                    });
                });
            });
        </script>
    @endpush

</x-admin.layout.terminal>
