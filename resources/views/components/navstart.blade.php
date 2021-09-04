<link rel="stylesheet" href="{{asset('css/app.css')}}">
<nav id="main_nav" class="navstart navbar z-40 navbar-expand-md bg-white  sticky-top duration-500 border-bottom">


    <div class="container-lg ">
        <a href="/" class="navbar-brand fw-bolder ">Marinduque Job Portal</a>

        {{-- <button class="navbar-toggler z-50" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="fa fa-menu text-black"></span>
        </button> --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-menu"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mb-md-0 me-md-0 ms-md-auto">
                @if (Auth::check())
                    <li class="nav-item btn btn-sm bg-white border-indigo-500 text-indigo-500 px-2" id='logout'>
                        <a class="nav-link text-indigo-500" href="/logout"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
                    </li>
                @else
                    <li class="nav-item  px-2 btn btn-sm bg-indigo-700 m-1">
                        <a class="nav-link text-white"  href="/emp_sup"><i class="fas fa-users me-2"></i>For Employers</a>
                    </li>
                    <li class="nav-item px-2 btn btn-sm  border-indigo-500 m-1 text-indigo-500">
                        <a class="nav-link text-indigo-500" href="/signin"><i class="fas fa-sign-in-alt me-2"></i>Sign In</a>
                    </li>
                    <li class="nav-item px-2  btn btn-sm  bg-indigo-500 m-1 ">
                        <a class="nav-link text-white" href="/signup"><i class="fas fa-user me-2"></i>Sign Up</a>
                    </li>                    
                @endif
            </ul>
        </div>

    </div>
    

</nav>

{{-- loading screen --}}
<div class="modal fade" id="mdlLoadingLogout" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="d-flex align-items-center">
                    <strong>Logging Out...</strong>
                    <div class="spinner-border ms-auto text-primary" role="status" aria-hidden="true"></div>
                </div>
            </div>
        </div>
    </div>
</div>




<script src="{{asset('js/components/navstart.js')}}"></script>
