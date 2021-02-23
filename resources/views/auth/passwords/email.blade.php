@extends('layouts.app')

@push('styles')

<link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'>
<link href='https://use.fontawesome.com/releases/v5.8.1/css/all.css'>
<style>
    body {
    margin: 0;
    padding: 0;
    font-family: sans-serif;
    background: #2A3F54;
}

.box {
    width: 500px;
    padding: 40px;
    position: absolute;
    top: 50%;
    left: 50%;
    background: #191919;
    ;
    text-align: center;
    transition: 0.25s;
    margin-top: 100px
}

.box input[type="text"],
.box input[type="password"] {
    border: 0;
    background: none;
    display: block;
    margin: 20px auto;
    text-align: center;
    border: 2px solid #3498db;
    padding: 10px 10px;
    width: 250px;
    outline: none;
    color: white;
    border-radius: 24px;
    transition: 0.25s
}

.box h1 {
    color: white;
    text-transform: uppercase;
    font-weight: 500
}

.box input[type="text"]:focus,
.box input[type="password"]:focus {
    width: 300px;
    border-color: #2ecc71
}

.box input[type="submit"] {
    border: 0;
    background: none;
    display: block;
    margin: 20px auto;
    text-align: center;
    border: 2px solid #2ecc71;
    padding: 14px 40px;
    outline: none;
    color: white;
    border-radius: 24px;
    transition: 0.25s;
    cursor: pointer
}

.box input[type="submit"]:hover {
    background: #2ecc71
}

.forgot {
    text-decoration: underline
}
</style>
@endpush

@section('content')
<div class="container">
    <div class="row">
        {{-- <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </div> --}}

        <div class="col-md-6">

            <form class="box" method="POST" action="{{ route('password.email') }}">
                @csrf
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <h1>Forgot Password</h1>
                <p class="text-muted"> Please enter your email address</p>

                <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                {{-- <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required autocomplete="current-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror --}}

                {{-- @if (Route::has('password.request'))
                    <a class="btn btn-link forgot text-muted" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif --}}

                <input type="submit" name="" value="Send Password Reset link" href="#">

                {{-- @if (Route::has('register'))
                    <a class="btn btn-link forgot text-muted" href="{{ route('register') }}">{{ __('Register') }}</a>
                @endif --}}
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js'>
</script><script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
@endpush
