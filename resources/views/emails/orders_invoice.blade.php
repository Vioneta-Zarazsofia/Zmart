@component('mail::message')
    <div style="font-family: 'Segoe UI', Arial, sans-serif; color:#2d3748;">
        <h2 style="margin-bottom: 0;">Halo, <span style="color:#3182ce;">{{ $orders->name }}</span></h2>
        <p style="margin-top: 5px;">Terima kasih telah melakukan pemesanan di <strong>{{ config('app.name') }}</strong>.<br>
            Berikut adalah rincian pesanan Anda:</p>

        <div style="margin-bottom: 16px;">
            <strong>Nomor Pesanan:</strong> {{ $orders->order_number }}<br>
            <strong>Tanggal Pesanan:</strong> {{ $orders->created_at->format('d M Y') }}
        </div>

        @php
            $total = 0;
            $totalShipping = 0;
        @endphp

        @foreach ($orders->items as $item)
            @php
                $subtotal = $item->price * $item->quantity;
                $total += $subtotal;
                $totalShipping += $item->shipping_amount;
            @endphp
            <div style="margin-bottom: 12px; padding: 10px; background: #f7fafc; border-radius: 6px;">
                <strong>Produk:</strong> {{ $item->product->title }}<br>
                <strong>Jumlah:</strong> {{ $item->quantity }}<br>
                <strong>Harga Satuan:</strong> Rp{{ number_format($item->price, 0, ',', '.') }}<br>
                <strong>Ongkir:</strong> Rp{{ number_format($item->shipping_amount, 0, ',', '.') }}<br>
                <strong>Subtotal:</strong> Rp{{ number_format($subtotal, 0, ',', '.') }}
            </div>
        @endforeach

        <div style="margin-top: 20px; margin-bottom: 8px;">
            <strong>Total Ongkir:</strong> Rp{{ number_format($totalShipping, 0, ',', '.') }}<br>
            <strong>Total:</strong> Rp{{ number_format($total + $totalShipping, 0, ',', '.') }}
        </div>
        <p style="margin-top: 20px;">Kami akan segera memproses pesanan Anda dan mengirimkan informasi lebih lanjut mengenai
            pengiriman.</p>
        <p>Terima kasih,<br>
            <strong>{{ config('app.name') }}</strong>
        </p>
    </div>
@endcomponent
