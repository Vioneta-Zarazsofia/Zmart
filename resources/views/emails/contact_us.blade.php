@component('mail::message')
 Halo Admin </b>,
<p>Anda menerima pesan baru dari halaman Kontak.</p>
<p>Berikut adalah detail pesan:</p>

<p><b>Name : </b>{{ $user->name }}</p>
<p><b>Email : </b>{{ $user->email }}</p>
<p><b>Phone : </b>{{ $user->phone }}</p>
<p><b>Subject : </b>{{ $user->subject }}</p>
<p><b>Message : </b>{{ $user->message }}</p>
@endcomponent
