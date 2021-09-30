@extends('app')
@section('title', '- Password Reset')
@section('content')

<link rel="stylesheet" href="{{asset('css/forgot-password.css')}}">

<body class="password-reset">
    
    <div class="wrapper">
        <br>
        <form action="/forgot-password-send" method="POST" class=" pr-form mx-auto">
            @csrf

            <div class="font-bold mb-3">
                <h4 class="text-dark"><i class="fas fa-key"></i> Password Reset</h4>
            </div>
    
            <div class="form-floating mb-3">
                <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" placeholder="eg juandelacruz@gmail.com">
                <label >Email</label>
                @error('email')
                    <div class="alert-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <input type="submit" class="btn btn-primary ms-auto me-0 d-block" id="btnReset" value="Next">

        </form>

        {{-- loading screen --}}
        <div class="modal fade" id="mdlLoading" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="d-flex align-items-center">
                            <strong>Sending password reset link...</strong>
                            <div class="spinner-border ms-auto text-primary" role="status" aria-hidden="true"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- success message --}}
        @if (session('status'))
        <div class="modal fade" id="mdlEmailStatus" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-0 alert-success">
                        <label class="h4 text-success"><i class="fas fa-check-circle"> </i> Success</label>   
                    </div>
                    <div class="modal-body border-0 ">
                        <p class="fs-5 text-secondary">{{ session('status') }}</p>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>

</body>

<script src="{{ asset('js/auth/password-reset.js') }}"></script>

@endsection