@extends('app')
@section('title', '- Verification')
@section('content')

<link rel="stylesheet" href="{{asset('css/email_verification.css')}}">

<body class="email_verification">

    <div class="email-verification-wrapper">
        <form  method="POST" action="/user/verify_email">
            @csrf
            <h4 ><i class="fas fa-user-check"></i> Verify your email</h4><br>
            <div class="form-floating">
                <input  type="email " class="form-control" value="{{ $email }}" disabled>
                <label >Email Address</label>
            </div>
            
            <input id="email" name="email" type="email" value="{{ $email }}" style="display:none">
            <div class="form-floating mb-3">
                <input name="verification_code" type="password" class="form-control @error('verification_code') is-invalid @enderror" placeholder="input verification code here" maxlength="6" >
                <label >Verification Code</label>
                @error('verification_code')
                    <div class="alert-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <h6 class="pota text-primary" >Resend code?</h6>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fas fa-check" ></i>Verify</button>

        </form>

        @error('verification_failed')
            <div class="alert-danger error-verify rounded">
                <i class="fas fa-exclamation-circle"></i> {{ $message }}
            </div>
        @enderror

        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex align-items-center">
                        <strong>Verifying email...</strong>
                        <div class="spinner-border ms-auto text-primary" role="status" aria-hidden="true"></div>
                    </div>
                </div>
              </div>
            </div>
        </div>

        <div class="modal fade" id="resend_code_modal" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="d-flex align-items-center">
                            <strong>Resending Verification code...</strong>
                            <div class="spinner-border ms-auto text-primary" role="status" aria-hidden="true"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="toast position-absolute bottom-0 start-50 translate-middle-x mb-3 " id="resend_success_toast">
            <div class="toast-body alert-success rounded-3">
                <i class="fas fa-check-circle text-success"></i>
                &nbsp; Verification code was sent successfully.
            </div>
        </div>
        <div class="toast position-absolute bottom-0 start-50 translate-middle-x mb-3 " id="resend_error_toast">
            <div class="toast-body alert-danger rounded-3">
                <i class="fas fa-exclamation-circle text-success"></i>
                &nbsp; Verification code was sent successfully.
            </div>
        </div>
    </div>
    
</body>
<script src="{{asset('js/pages/email_verification.js')}}"></script>



{{-- <script src="{{asset('js/pages/signup.js')}}"></script>   --}}

@endsection