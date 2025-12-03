<x-admin.layout.terminal title="Admin | PPN">

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <div class="judul d-flex justify-content-between align-items-center">
                            <h4><strong>PPN</strong></h4>
                            <div class="date-time d-flex align-items-center gap-2 text-center">
                                <div class="tanggal text-muted" id="tanggal"></div>
                                <div class="jam text-muted" id="jam"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="tb-umum">
                                <table id="example" class="table table-striped table-bordered"
                                    style="width:100%; text-align: center">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pajak</th>
                                            <th>Tarif Pajak</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pajak as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    {{ $item->namaPajak }}
                                                </td>
                                                <td>{{ $item->tarifPpn }}%</td>
                                                <td>
                                                    <form method="POST" action="{{ url('updateStatus-pajak') }}">
                                                        @csrf
                                                        <input type="hidden" name="id"
                                                            value="{{ $item->id }}">
                                                        <div class="piket">
                                                            <input type="checkbox" name="status"
                                                                id="status_{{ $item->id }}"
                                                                onchange="updateStatusText(this)"
                                                                @if ($item->status) checked @endif>
                                                            <label for="status_{{ $item->id }}"
                                                                class="button"></label>

                                                            <div class="status-text">
                                                                <span id="statusText_{{ $item->id }}">
                                                                    {{ $item->status ? 'Aktif' : 'Non-Aktif' }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </td>
                                                <td>
                                                    <div class="aksi d-flex justify-content-center">
                                                        <button class="btn btn-primary"
                                                            data-bs-target="#editpoli{{ $item->id }}"
                                                            data-bs-toggle="modal"><i class="fas fa-info"></i>
                                                            Edit</button>
                                                        {{-- <button type="button" class="btn btn-danger mx-2" data-bs-toggle="modal"
                                                    data-bs-target="#hapuspoli{{ $item->id }}"><i
                                                        class="fa fa-trash"></i> Hapus</button> --}}
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
        </div>
    </div>

    @include('admin.master.ppn.tambah')
    @include('admin.master.ppn.edit')
    @include('admin.master.ppn.hapus')

    <!-- Modal -->
    <div id="imageModal"
        style="display: none; position: fixed; z-index: 1; left: 0; top: 15%; width: 100%; height: auto%; overflow: auto;">
        <span onclick="closeModal()"
            style="position: absolute; top: 10px; right: 25px; color: #fff; font-size: 35px; font-weight: bold; cursor: pointer;">&times;</span>
        <img id="modalImage" style="margin: auto; display: block; width: 80%; max-width: 700px;">
    </div>

    @push('style')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap4.css">

        <style>
            .piket {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 8px;
            }

            .button {
                width: 50px;
                height: 25px;
                background-color: #ccc;
                border-radius: 50px;
                position: relative;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            .button::before {
                content: "";
                position: absolute;
                width: 18px;
                height: 18px;
                top: 3.5px;
                left: 4px;
                background-color: white;
                border-radius: 50%;
                transition: transform 0.3s;
            }

            input[type="checkbox"] {
                display: none;
            }

            input[type="checkbox"]:checked+.button {
                background-color: #3b82f6;
                /* Tailwind blue */
            }

            input[type="checkbox"]:checked+.button::before {
                transform: translateX(24px);
            }

            .status-text {
                font-weight: bold;
                color: #333;
            }
        </style>
    @endpush

    @push('script')
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap4.js"></script>
        <script>
            new DataTable('#example');

            // jam dan tgl
            function updateClock() {
                var now = new Date();
                var tanggalElement =
                    document.getElementById('tanggal');
                var options = {
                    weekday: 'short',
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                };
                tanggalElement.innerHTML = '<h6>' + now.toLocaleDateString('id-ID', options) + '</h6>';

                var jamElement = document.getElementById('jam');
                var jamString = now.getHours().toString().padStart(2, '0') + ':' +
                    now.getMinutes().toString().padStart(2, '0') + ':' +
                    now.getSeconds().toString().padStart(2, '0');
                jamElement.innerHTML = '<h6>' + jamString + '</h6>';
            }
            setInterval(updateClock, 1000);
            updateClock();
        </script>
    @endpush

</x-admin.layout.terminal>
