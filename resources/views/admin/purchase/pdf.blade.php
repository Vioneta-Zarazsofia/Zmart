<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Purchase Order - {{ $purchase->purchase_number ?? 'PO-' . $purchase->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #000;
        }

        h2,
        h4 {
            text-align: center;
            margin: 0;
        }

        .header {
            margin-bottom: 20px;
            text-align: center;
        }

        .header div {
            margin: 2px 0;
        }

        .info {
            margin: 20px 0;
        }

        .info table {
            width: 100%;
            border: none;
        }

        .info td {
            padding: 4px 0;
            vertical-align: top;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            padding: 8px 10px;
            border: 1px solid #000;
            text-align: left;
        }

        th {
            background: #f0f0f0;
        }

        tfoot td {
            font-weight: bold;
        }

        .right {
            text-align: right;
        }

        .signature {
            margin-top: 50px;
            width: 100%;
        }

        .signature td {
            text-align: center;
            padding-top: 60px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>CV. BUKIT ZAITUN</h2>
        <h4>Purchase Order (PO)</h4>
        <div>No: {{ $purchase->purchase_number ?? 'PO-' . $purchase->id }}</div>
        <div>Tanggal: {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d/m/Y') }}</div>
    </div>

    <div class="info">
        <table>
            <tr>
                <td><strong>Supplier:</strong> {{ $purchase->supplier->name ?? '-' }}</td>
                <td><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td><strong>No. Telepon:</strong> {{ $purchase->supplier->phone ?? '-' }}</td>
                <td></td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 50px;">No</th>
                <th>Nama Produk</th>
                <th style="width: 100px; text-align: center;">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchase->items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->product->title ?? '-' }}</td>
                    <td class="right">{{ $item->qty }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
