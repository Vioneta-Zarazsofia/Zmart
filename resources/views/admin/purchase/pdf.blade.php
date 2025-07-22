<!DOCTYPE html>
<html>

<head>
    <title>Daftar Pembelian - {{ $supplier->name }}</title>
    <style>
        body {
            font-family: sans-serif;
        }

        h2 {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 8px 12px;
            border: 1px solid #000;
            text-align: left;
        }
    </style>
</head>

<body>
    <h2>Daftar Pembelian ke {{ $supplier->name }}</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Jumlah Pembelian</th>
                <th>Harga Beli</th>
                <th>Stok Saat Ini</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->title }}</td>
                    <td>{{ $product->purchase_quantity }}</td>
                    <td>Rp{{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                    <td>{{ $product->stock }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
