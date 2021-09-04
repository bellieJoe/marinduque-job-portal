@extends('app')
@section('title', '- Employer Sign up')
@section('content')
<body class="mplyr_sup">

    <link rel="stylesheet" href="{{asset('css/employer_signup.css')}}">

    <div class="wrapper">

        <form class="form_container shadow-lg mt-5 mb-5 " method='POST' action='/emp_sup/register'>
            @csrf

            {{-- header --}}
            <h1 class="fw-bold mt-3 mb-3 text-indigo-500"><i class="fas fa-user-plus"></i> &nbsp; Employer Sign Up</h1>
            <hr class='mb-3'>

            {{-- form controls --}}
            <div class=" mb-3">
                <label class="fw-bold">Contact Person Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('contact_person_name') is-invalid @enderror" name='contact_person_name'  value='{{ old('contact_person_name') }}'>
                
                @error('contact_person_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class=" mb-3">
                <label class="fw-bold">Company Name</label>
                <input class="form-control @error('company_name') is-invalid @enderror" type='text' name='company_name'  value='{{ old('company_name') }}'>

                @error('company_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class=" mb-3">
                <label class="fw-bold">Contact Number</label>
                <input type="tel" class="form-control @error('contact_number') is-invalid @enderror" name='contact_number'  value='{{ old('contact_number') }}'>
                
                @error('contact_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class=" mb-3">
                <label class="fw-bold">Company Email Address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name='email'  value='{{ old('email') }}'>
                
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class=" mb-3">
                <label class="fw-bold">Password <label class="text-secondary"> (8 characters minimum)</label></label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name='password'  id='password'>
                
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="">
                <label class="fw-bold">Confirm Password</label>
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name='password_confirmation'  id='password_confirmation'>
                
            </div>

            <div class="password-toggle text-secondary mb-3 mt-1" id='password_toggle'>
                <i class="fas fa-eye-slash" id='hide'></i>
                <i class="fas fa-eye" id='show'></i>
                <label for="" id='lblPasswordToggle'>See password</label>
            </div>

            <div>
                <label for=""><span class='text-secondary'><i class="fas fa-question-circle"></i> Already have a company account?</span>  <a href="/signin" class='text-decoration-none'>Sign In</a></label>
            </div>

            <div class="">
                <input class="btn btn-primary btn-lg ms-auto me-0 d-block mb-3" type="submit" value="Register" id="emp_sup">
            </div>

        </form>

        {{-- loading screen --}}
        <div class="modal fade" id="mdlLoading" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="d-flex align-items-center">
                            <strong>Registering employer, please wait...</strong>
                            <div class="spinner-border ms-auto text-primary" role="status" aria-hidden="true"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>

<script src="{{ asset('js/pages/employer_signup.js') }}"></script>
    
@endsection