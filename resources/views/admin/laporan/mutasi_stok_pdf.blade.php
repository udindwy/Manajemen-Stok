<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Mutasi Stok</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;gg
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #ddd;
        }
    </style>
</head>

<body>
    <h3 align="center">Laporan Mutasi Stok</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Tanggal</th>
                <th>Jenis Mutasi</th>
                <th>Jumlah</th>
                <th>Stok Tersisa</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mutasi as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item['nama_produk'] }}</td>
                    <td>{{ $item['tanggal'] }}</td>
                    <td>{{ $item['jenis'] }}</td>
                    <td>{{ $item['jumlah'] }}</td>
                    <td>{{ $item['sisa_stok'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
