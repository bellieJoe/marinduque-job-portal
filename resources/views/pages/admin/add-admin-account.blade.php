@extends('app')
@section('title', '- Add account')
@section('content')
    
    <body class=bg-gray-100>
        <div id="addAdminAccount">

            <div v-if="loading">
                @component('components.loading')
                @endcomponent
            </div>
            

            <form action="/admin/add-account" method="POST" class="p-4 col-md-4 mx-auto shadow-sm rounded-2 my-16 bg-white">
                @csrf
                <h4 class="font-bold fs-4 text-blue-500 mb-3 text-center"><i class="fa fa-user-shield me-2 text-gray-500"></i>Add Admin</h4>
                <div class="mb-3">
                    <label class="mb-1 font-bold">Fullname</label>
                    <input type="text" class="form-control @error('fullname') is-invalid @enderror" name="fullname" value="{{ old('fullname') }}">
                    @error('fullname')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="mb-1 font-bold">Contact Number</label>
                    <input type="tel" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number') }}">
                    @error('contact_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="mb-1 font-bold">Address</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}">
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="mb-1 font-bold">Email Address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="mb-1 font-bold">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="mb-1 font-bold">Re-Enter Password</label>
                    <input type="password" class="form-control" name="password_confirmation">
                </div>
                <div class="w-max mb-3 ms-auto me-0">
                    <button class="btn btn-primary" @click="toggleLoading">
                        <i class="fa fa-user-plus me-2"></i>
                        Register
                    </button>
                </div>

                @if(session('message'))
                <div class="alert alert-success" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close float-right" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

            </form>

        
            
            

        </div>
    </body>
    <script src="{{ asset('js/pages/admin/add-admin-account.js') }}"></script>

@endsection