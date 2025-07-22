@component('mail::message')
    # Halo {{ $user->name }}

    Selangkah lagi untuk mulai menikmati berbagai keuntungan dari ZaitunMart.

    Klik tombol di bawah ini untuk memverifikasi alamat email kamu:

    @component('mail::button', ['url' => url('activate/' . base64_encode($user->id))])
        Verifikasi Email
    @endcomponent

    Dengan memverifikasi alamat email, kamu akan resmi menjadi bagian dari keluarga ZaitunMart.

    Terima kasih,
    Tim ZaitunMart
@endcomponent
