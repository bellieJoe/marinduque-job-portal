@extends('app')
@section('title', '- Password Reset')
@section('content')

<link rel="stylesheet" href="{{asset('css/forgot-password.css')}}">

<body class="password-reset">
    
    <div class="wrapper">
        <br>
        <form action="/update-password" class="pr-form" method="POST">
            @csrf

            <div >
                <h4 class="text-dark"><i class="fas fa-key"></i> Password Reset</h4>
                <hr>
            </div>
            
            {{-- unseen inputs --}}
            <input type="text" class="d-none" value="{{ $token }}" name="token">
            <input type="text" class="d-none" value="{{ $email }}" name="email">

            <div class=" mb-3">
                <label>New Password</label>
                <input type="password" name="password" class="form-control  @error('password') is-invalid @enderror"  placeholder="write your new password here" id="password">
                @error('password')
                    <div class="alert-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class=" mb-3">
                <label>Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-control  @error('password') is-invalid @enderror"  placeholder="write your new password here" id="password_confirmation">
                @error('password_confirmation')
                    <div class="alert-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="password_input password_toggle">
                <span>
                    <i class="far fa-eye-slash " id="hide"></i>
                    <i class="far fa-eye " id="show"></i>
                    &nbsp;See password
                </span> 
            </div>

            {{-- other errors --}}
            @error('email')
                <div class="alert-danger">
                    {{ $message }}
                </div><br>
            @enderror 
            @error('token')
                <div class="alert-danger">
                    {{ $message }}
                </div><br>
            @enderror  

            <button type="submit" class="btn btn-primary ms-auto me-0 d-block" id="btnUpdatePassword"><i class="fas fa-check"></i>&nbsp;Change Password</button>
            
        </form>

        {{-- success message --}}
        @if (session('status'))
        <div class="modal fade" tabindex="-1" aria-hidden="true" id="mdlResetSuccess">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-0 alert-success">
                        <label class="h4 text-success"><i class="fas fa-check-circle"> </i> Success</label>   
                    </div>
                    <div class="modal-body border-0 ">
                        <p class="fs-5 text-secondary">{{ session('status') }}</p>
                        <p class="fs-5 text-secondary">Would you like to signin now?</p>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLose</button>
                        <button type="button" id="btnGoSignin" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i>&nbsp;Sign In</button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- loading screen --}}
        <div class="modal fade" id="mdlLoading" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="d-flex align-items-center">
                            <strong>Reseting password...</strong>
                            <div class="spinner-border ms-auto text-primary" role="status" aria-hidden="true"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

    </div>

</body>

<script src="{{asset('js/auth/password-reset.js')}}"></script>
<script src="{{asset('js/pages/signin.js')}}"></script>


@endsection