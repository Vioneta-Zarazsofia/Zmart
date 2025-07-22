<footer class="footer footer-dark">
    <div class="footer-middle">
        <div class="container">
            <div class="row">
                <!-- About Widget -->
                <div class="col-sm-6 col-lg-3">
                    <div class="widget widget-about">
                        <img src="{{ $getStemSettingApp->getLogo() }}" class="footer-logo" alt="Footer Logo" width="200"
                            height="50">
                        <p>
                            {{ $getStemSettingApp->footer_description }}
                        </p>
                    </div>
                </div>
                <!-- Useful Links Widget -->
                <div class="col-sm-6 col-lg-3">
                    <div class="widget">
                        <h4 class="widget-title">Useful Links</h4>
                        <ul class="widget-list">
                            <li><a href="{{ url('') }}">Home</a></li>
                            <li><a href="{{ url('contact') }}">Contact Us</a></li>
                            <li><a href="{{ url('faq') }}">FAQ</a></li>
                            <li><a href="https://wa.me/6285156477844" target="_blank">WhatsApp</a></li>
                            <li><a href="#signin-modal" data-toggle="modal">Login</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Customer Service Widget -->
                <div class="col-sm-6 col-lg-3">
                    <div class="widget">
                        <h4 class="widget-title">Customer Service</h4>
                        <ul class="widget-list">
                            <li><a href="{{ url('metode-pembayaran') }}">Metode Pembayaran</a></li>
                            <li><a href="{{ url('pengembalian') }}">Pengembalian</a></li>
                            <li><a href="{{ url('pengiriman') }}">Pengiriman</a></li>
                            <li><a href="{{ url('syarat-ketentuan') }}">Syarat dan Ketentuan</a></li>
                            <li><a href="{{ url('kebijakan-privasi') }}">Kebijakan Privasi</a></li>
                        </ul>
                    </div>
                </div>
                <!-- My Account Widget -->
                <div class="col-sm-6 col-lg-3">
                    <div class="widget">
                        <h4 class="widget-title">My Account</h4>
                        <ul class="widget-list">
                            <li><a href="{{ url('cart') }}">Lihat Keranjang</a></li>
                            <li><a href="{{ url('checkout') }}">Checkout</a></li>
                            <li><a href="#">Status Pemesanan</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
            <p class="footer-copyright mb-2 mb-md-0">
                &copy; {{ date('Y') }} {{ $getStemSettingApp->website_name }}
            </p>
            <figure class="footer-payment mb-0">
                <img src="{{ $getStemSettingApp->getFooterPayment() }}" alt="Payment Methods" width="50"
                    height="10">
            </figure>
        </div>
    </div>
</footer>
