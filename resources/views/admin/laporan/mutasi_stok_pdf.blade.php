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
            /* Header rata tengah */
        }

        td.text-center {
            text-align: center;
            /* Untuk angka atau data pendek */
        }

        td.text-left {
            text-align: left;
            /* Untuk teks seperti nama produk, nama pengguna */
        }

        h3 {
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <h3>Laporan Mutasi Stok</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Tanggal</th>
                @if (Auth::check() && Auth::user()->peran == 'admin')
                    <th>Jenis Mutasi</th>
                    <th>Nama Pengguna</th>
                @endif
                <th>Jumlah</th>
                @if (Auth::check() && Auth::user()->peran == 'admin')
                    <th>Stok Tersisa</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($mutasi as $item)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td class="text-left">{{ $item['nama_produk'] }}</td>
                    <td class="text-center">{{ $item['tanggal'] }}</td>
                    @if (Auth::check() && Auth::user()->peran == 'admin')
                        <td class="text-center">{{ $item['jenis'] }}</td>
                        <td class="text-left">{{ $item['nama_pengguna'] }}</td>
                    @endif
                    <td class="text-center">{{ $item['jumlah'] }}</td>
                    @if (Auth::check() && Auth::user()->peran == 'admin')
                        <td class="text-center">{{ $item['sisa_stok'] }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
