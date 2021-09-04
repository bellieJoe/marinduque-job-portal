@extends('app')
@section('title' , '- Sign In')
@section('content')
<body class="signin">
    <link rel="stylesheet" href="{{asset('css/signin.css')}}">
    <br>
    <div class="wrapper">

        <div class="form_container shadow">

            {{-- form title --}}
            <h1 class="fw-bold">Sign In</h1>
            <hr>

            {{-- main form --}}
            <form action="/signin/try" method="POST">
                @csrf

                <div class=" mb-3">
                    <label class="fw-bold">Email Address</label>
                    <input type="text" name="email" placeholder="eg juandelacuz@gmail.com" value="{{ old('email') }}" class="form-control  @error('email') is-invalid @enderror">
                    @error('email')
                        <div class="alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class=" mb-3">
                    <label class="fw-bold">Password</label>
                    <div class="input-group ">
                        <input type="password" name="password" class="form-control  @error('password') is-invalid @enderror"  placeholder="write your password here" id="password">
                        <div class="input-group-text password_input password_toggle">
                            <i class="far fa-eye-slash " id="hide"></i>
                            <i class="far fa-eye " id="show"></i>
                        </div>
                    </div>
                    @error('password')
                        <div class="alert-danger">
                            {{ $message }}
                        </div>
                    @enderror

                </div>
                
                <div class="item_last">
                    <label ><i class="fas fa-info-circle"></i> Not yet a member? <a href="/signup">Sign up</a></label><br>
                    <label ><i class="fas fa-info-circle"></i> Forgot password? <a href="/forgot-password">Recover</a></label>
                </div>

                <input type="submit" value="SIGN IN" id='btnSignin' class="login">

            </form>

             {{-- loading screen --}}
            <div class="modal fade" id="mdlLoading" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="d-flex align-items-center">
                                <strong>Signing In, please wait...</strong>
                                <div class="spinner-border ms-auto text-primary" role="status" aria-hidden="true"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- signin failed --}}
            @error('signin_failed')
            <div class="modal fade" id="mdlSigninFailed" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header border-0 alert-danger">
                            <label class="h4 text-danger"><i class="fas fa-times-circle me-3"></i> Signin Failed</label>   
                        </div>
                        <div class="modal-body border-0 ">
                            <p class="fs-5 text-secondary">{{ $message }}</p>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div> 
            @enderror

        </div>
        
    </div>
</body>
<script src="{{asset('js/pages/signin.js')}}"></script>
@endsection