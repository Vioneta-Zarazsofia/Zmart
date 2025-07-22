@component('mail::message')
    # Halo, {{ $user->name }}

    Kami mengerti bahwa terkadang lupa kata sandi bisa terjadi pada siapa saja.

    Klik tombol di bawah ini untuk mengatur ulang kata sandi kamu:

    @component('mail::button', ['url' => url('reset/' . $user->remember_token)])
        Atur Ulang Kata Sandi
    @endcomponent

    Jika kamu tidak meminta pengaturan ulang kata sandi, abaikan email ini.

    Terima kasih,
    **{{ config('app.name') }}**
@endcomponent
