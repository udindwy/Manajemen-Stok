<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Stok Masuk</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
        }

        th {
            background-color: #ddd;
            text-align: center;
        }

        td.text-center {
            text-align: center;
        }

        td.text-left {
            text-align: left;
        }

        h3 {
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <h3>Laporan Stok Masuk</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Tanggal</th>
                <th>Nama Pengguna</th>
                <th>Jumlah</th>
                <th>Stok Tersisa</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($mutasi as $item)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td class="text-center">{{ $item['kode_produk'] }}</td>
                    <td class="text-left">{{ $item['nama_produk'] }}</td>
                    <td class="text-left">{{ $item['kategori'] }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item['tanggal'])->format('d/m/Y H:i') }}</td>
                    <td class="text-left">{{ $item['nama_pengguna'] }}</td>
                    <td class="text-center">{{ $item['jumlah'] }}</td>
                    <td class="text-center">{{ $item['sisa_stok'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>