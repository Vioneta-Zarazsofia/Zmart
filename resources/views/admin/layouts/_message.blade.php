@if (!empty(session('success')))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
    </div>
@endif
@if (!empty(session('error')))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
    </div>
@endif
@if (!empty(session('payment -error')))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('payment -error') }}
    </div>
@endif

@if (!empty(session('warning')))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ session('warning') }}
    </div>
@endif
@if (!empty(session('info')))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ session('info') }}
    </div>
@endif
@if (!@empty(session('secondary')))
    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
        {{ session('secondary') }}
    </div>
@endif
@if (!empty(session('light')))
    <div class="alert alert-light alert-dismissible fade show" role="alert">
        {{ session('light') }}
    </div>
@endif
@if (!empty(session('dark')))
    <div class="alert alert-dark alert-dismissible fade show" role="alert">
        {{ session('dark') }}
    </div>
@endif
@if (!empty(session('light')))
    <div class="alert alert-light alert-dismissible fade show" role="alert">
        {{ session('light') }}
    </div>
@endif
