<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Obat</title>
    <style>
        /* Style CSS dapat ditambahkan di sini */
    </style>
</head>
<body>
    <h1>Data Obat</h1>
    <p>Filter: {{ $filterInfo }}</p>
    <table border="1">
        <thead>
            <tr>
                <th>Tanggal Ambil Obat</th>
                <th>No. RM</th>
                <th>Nama Pasien</th>
                <th>Jenis Pasien</th>
                <th>Poli</th>
            </tr>
        </thead>
        <tbody>
            @if (count($data) === 0)
                <tr>
                    <td colspan="5" style="text-align: center"></td>
                </tr>
            @else
                @foreach ($data as $item)
                    <tr>
                        <td>{{ date_format(date_create($item->created_at), 'H:i:s / d-m-Y') }}</td>
                        <td>{{ $item->booking->pasien->no_rm }}</td>
                        <td>{{ $item->booking->pasien->nama_pasien }}</td>
                        <td>{{ $item->booking->pasien->jenis_pasien }}</td>
                        <td>{{ $item->soap->poli->namapoli }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</body>
</html>
