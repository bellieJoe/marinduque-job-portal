@extends('app')
@section('title', '- Sign Up')
@section('content')


<link rel="stylesheet" href="{{asset('css/signup.css')}}">

<body class="signup">
    <div class="wrapper">
        <div class="form_container  ">
            {{-- <div class="title">
                
            </div> --}}

            <form action="seeker/register" class="signup_form shadow-sm" method="POST" >
                @csrf
                <h1 class="text-indigo-500 fs-5 fw-bold mb-3 mt-3"><i class="fas fa-sign-in-alt me-2"></i>Sign Up</h1>
                <div class=" mb-3 mt-3">
                    <label class="fw-bold">Firstname <span class="text-danger">*</span></label>
                    <input type="text" placeholder="eg Juan" name="firstname" value="{{ old('firstname') }}" class="form-control @error('firstname') is-invalid @enderror">
                </div>
                

                <div class="mb-3">
                    <label class="fw-bold">Middlename <span class="text-danger">*</span></label>
                    <input type="text" placeholder="eg Hernandez" name="middlename" value="{{ old('middlename') }}" class="form-control @error('middlename') is-invalid @enderror">
                    @error('middlename')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
            
                <div class=" mb-3" >
                    <label class="fw-bold">Lastname <span class="text-danger">*</span></label>
                    <input class="form-control @error('lastname') is-invalid @enderror" type="text" placeholder="eg Dela Cruz" name="lastname" value="{{ old('lastname') }}">
                    @error('lastname')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                
                <div class=" mb-3">
                    <label class="fw-bold">Email Address <span class="text-danger">*</span></label>
                    <input class="form-control @error('email') is-invalid @enderror" type="text" placeholder="eg delacruzjuan@gmail.com" name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class=" mb-3">
                    <label class="fw-bold">Gender <span class="text-danger">*</span></label>
                    <select name="gender" class="form-select">
                        <option value="male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="female"  {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                

                <div class=" mb-3">
                    <label class="fw-bold">Password <span class="text-danger">*</span></label>
                    <input class="form-control  @error('password') is-invalid @enderror" type="password" placeholder="write password here" id="password" name="password" value={{ old('password') }}>
                    @error('password')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label ><i class="fas fa-info-circle"></i> Already have an account?<a href="/signin"> Sign in</a></label>
                    <input class="btn btn-primary btn-lg d-block ms-auto me-0" type="submit" value="Register" id='btnSignup'>
                </div>

            </form>

            {{-- loading screen --}}
            <div class="modal fade" id="mdlLoading" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="d-flex align-items-center">
                                <strong>Signing Up, Please wait</strong>
                                <div class="spinner-border ms-auto text-primary" role="status" aria-hidden="true"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</body>
<script src="{{asset('js/pages/signup.js')}}"></script>  


@endsection

