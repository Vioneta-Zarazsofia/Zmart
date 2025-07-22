@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

            {{-- Header --}}
            <div class="card-header bg-white py-4 px-4 text-center">
                <h3 class="mb-0 text-dark fw-bold">Konfirmasi Pembayaran</h3>
            </div>

            <div class="card-body bg-light px-4 py-4">

                {{-- Info Transfer --}}
                <div class="bg-white border rounded-3 p-4 mb-4 shadow-sm">
                    <h5 class="fw-semibold mb-3">Silakan transfer ke rekening berikut:</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><strong>🏦 Bank:</strong> <span class="text-dark">BRI</span></li>
                        <li class="mb-2 d-flex flex-wrap align-items-center">
                            <strong>🔢 No. Rekening:</strong>
                            <span id="rekening-number" class="text-primary fw-bold ms-2 fs-5">6441 0101 7045 534</span>
                            <button type="button"
                                class="btn btn-outline-primary btn-sm ms-3 px-2 py-1 d-flex align-items-center gap-1"
                                style="font-size: 0.85rem; min-width: 60px;" aria-label="Salin nomor rekening"
                                onclick="copyRekening()">
                                <i class="fas fa-copy"></i>
                                <span>Salin</span>
                            </button>
                        </li>

                        <li class="mb-2"><strong>👤 Atas Nama:</strong> VIONETA ZARAZSOFIA P</li>
                        <li class="mt-3"><strong>💰 Total:</strong>
                            <span class="badge bg-success text-white fs-6 px-3 py-2">
                                Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                            </span>
                        </li>
                    </ul>
                </div>

                {{-- Countdown Timer --}}
                @if ($order->payment_deadline)
                    <div class="alert alert-warning d-flex justify-content-between align-items-center shadow-sm mb-4">
                        <div>
                            <i class="fas fa-hourglass-start me-2"></i>
                            <strong>Sisa waktu pembayaran:</strong>
                        </div>
                        <div id="countdown" class="fw-bold fs-5 text-black"></div>
                    </div>
                @endif

                {{-- Success Notification --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Upload Form --}}
                <form action="{{ route('payment.confirm.submit', $order->id) }}" method="POST"
                    enctype="multipart/form-data" class="bg-white border rounded-3 p-4 shadow-sm mb-4">
                    @csrf
                    <div class="mb-3">
                        <label for="payment_proof" class="form-label fw-semibold">Upload Bukti Transfer</label>
                        <input type="file" name="payment_proof" id="payment_proof"
                            class="form-control @error('payment_proof') is-invalid @enderror" accept="image/*" required>
                        <div class="form-text">Format JPG, JPEG, PNG. Maksimal 2MB.</div>
                        @error('payment_proof')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit"
                        class="btn btn-success w-100 py-3 fw-semibold d-flex justify-content-center gap-2 shadow-sm">
                        <i class="fas fa-upload"></i>
                        <span>Kirim Bukti Pembayaran</span>
                    </button>
                </form>

                {{-- Bukti Transfer --}}
                @if ($order->payment_proof)
                    <div class="bg-white p-3 border rounded shadow-sm text-center">
                        <h6 class="fw-semibold mb-3">🖼️ Bukti Transfer:</h6>
                        <a href="{{ asset($order->payment_proof) }}" target="_blank">
                            <img src="{{ asset($order->payment_proof) }}" class="img-fluid rounded shadow-sm"
                                style="max-height: 250px;">
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Countdown Timer Script --}}
    @if ($order->payment_deadline)
        <script>
            const deadline = new Date("{{ $order->payment_deadline }}").getTime();
            const countdownEl = document.getElementById("countdown");

            const interval = setInterval(() => {
                const now = new Date().getTime();
                const diff = deadline - now;

                if (diff < 0) {
                    clearInterval(interval);
                    countdownEl.innerHTML = "WAKTU HABIS";
                    countdownEl.classList.add("text-muted");
                    return;
                }

                const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const s = Math.floor((diff % (1000 * 60)) / 1000);

                countdownEl.innerHTML = `${h}j ${m}m ${s}d`;
            }, 1000);
        </script>
    @endif

    {{-- Copy Rekening Script --}}
    <script>
        function copyRekening() {
            const rekening = document.getElementById('rekening-number').innerText;
            navigator.clipboard.writeText(rekening).then(() => {
                const btn = event.target.closest('button');
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check-circle text-success me-1"></i> Disalin!';
                btn.classList.remove("btn-outline-primary");
                btn.classList.add("btn-success");
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.classList.remove("btn-success");
                    btn.classList.add("btn-outline-primary");
                }, 2000);
            });
        }
    </script>
@endsection
