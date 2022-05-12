<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="_token" content="{!! csrf_token() !!}" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ url('image').'/website/favicon.png' }}" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    
    <script src="https://kit.fontawesome.com/2a90b2a25f.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <title>Job Hunter @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app_sample.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- <style>
        /* @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');  */
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100&family=Ubuntu&display=swap');
        * :not(i) {
            font-family: 'Ubuntu' !important; 
    
        },

    </style> --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>


{{-- to access auth user in js --}}
<input type="hidden" id="User" value="{{ Auth::user() }}">


@component('components.navstart')
@endcomponent
@auth
    @if (Auth::user()->role === 'employer')

        @component('components.employer_nav')@endcomponent  

    @elseif (Auth::user()->role === 'seeker')

        @component('components.jobseeker_nav')@endcomponent  

    @elseif(Auth::user()->role === 'admin')
        @component('components.admin-nav')@endcomponent

    @endif
@endauth

<div class="fixed z-50 inset-x-0 w-screen" id="internetConnectionDetector">
    


    {{-- <div v-if="!isOnline" class="bg-gray-700 w-max p-2 rounded-md mx-auto my-2 text-white shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wifi-off inline mr-2" viewBox="0 0 16 16">
            <path d="M10.706 3.294A12.545 12.545 0 0 0 8 3C5.259 3 2.723 3.882.663 5.379a.485.485 0 0 0-.048.736.518.518 0 0 0 .668.05A11.448 11.448 0 0 1 8 4c.63 0 1.249.05 1.852.148l.854-.854zM8 6c-1.905 0-3.68.56-5.166 1.526a.48.48 0 0 0-.063.745.525.525 0 0 0 .652.065 8.448 8.448 0 0 1 3.51-1.27L8 6zm2.596 1.404.785-.785c.63.24 1.227.545 1.785.907a.482.482 0 0 1 .063.745.525.525 0 0 1-.652.065 8.462 8.462 0 0 0-1.98-.932zM8 10l.933-.933a6.455 6.455 0 0 1 2.013.637c.285.145.326.524.1.75l-.015.015a.532.532 0 0 1-.611.09A5.478 5.478 0 0 0 8 10zm4.905-4.905.747-.747c.59.3 1.153.645 1.685 1.03a.485.485 0 0 1 .047.737.518.518 0 0 1-.668.05 11.493 11.493 0 0 0-1.811-1.07zM9.02 11.78c.238.14.236.464.04.66l-.707.706a.5.5 0 0 1-.707 0l-.707-.707c-.195-.195-.197-.518.04-.66A1.99 1.99 0 0 1 8 11.5c.374 0 .723.102 1.021.28zm4.355-9.905a.53.53 0 0 1 .75.75l-10.75 10.75a.53.53 0 0 1-.75-.75l10.75-10.75z"/>
        </svg> No internet connection
    </div> --}}
</div>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>



@yield('content')
<script>
    AOS.init();
</script>

</html>
