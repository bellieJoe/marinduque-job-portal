{{-- <link rel="stylesheet" href="{{asset('css/app.css')}}"> --}}
<nav id="main_nav" class="bg-white z-40">

    <div class="lg:w-10/12 mx-auto p-2  lg:grid lg:grid-cols-2 grid grid-cols-2">
        <a href="/" class="text-2xl duration-500 fw-bolder self-center text-indigo-900 font-sans w-max"> 
            {{-- <img src="{{ url('image') }}/website/logo.png" alt="logo" class="w-48 inline"> --}}
            <div class="grid grid-cols-2 items-center w-24 gap-2">
                <img src="{{ url('image') }}/website/favicon.png" alt="logo" class="">
                <div class="w-max inline-block">
                    <h1 class="font-bold tracking-widest">Job Portal</h1>
                    <h6 class="text-sm font-normal text-gray-400">LMD PESO Marinduque</h6>
                </div>
            </div>
        </a>


        <button @click="toggleMainNav()" class="lg:hidden float-right hover:text-indigo-800 duration-500 justify-self-end" type="button" >
            <i class="fa fa-bars text-xl"></i>
        </button>

        <div :class="mainNav ? 'right-0 ' : '-right-full'" class="duration-500 bg-white w-60 fixed top-0 p-2 z-50 h-screen shadow-2xl lg:shadow-none  lg:static lg:h-auto lg:w-max lg:justify-self-end" >

            <button @click="toggleMainNav()" class="btn block w-max ml-auto mr-0 lg:hidden hover:text-indigo-800 duration-500">
                <i class="fa fa-arrow-right text-2xl"></i>
            </button>
            
            @if (Auth::check())
                <li class=" btn btn-sm bg-white border-indigo-500 text-indigo-500 px-2 w-full lg:w-max " id='logout'>
                    <a class="nav-link text-indigo-500" href="/logout"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
                </li>
            @else
                <li class="nav-item  px-2 btn btn-sm bg-indigo-700 m-1 w-full lg:w-max ">
                    <a class="nav-link text-white"  href="/emp_sup"><i class="fas fa-users me-2"></i>For Employers</a>
                </li>
                <li class="nav-item px-2 btn btn-sm  border-indigo-500 m-1 text-indigo-500 w-full lg:w-max ">
                    <a class="nav-link text-indigo-500" href="/signin"><i class="fas fa-sign-in-alt me-2"></i>Sign In</a>
                </li>
                <li class="nav-item px-2  btn btn-sm  bg-indigo-500 m-1  w-full lg:w-max ">
                    <a class="nav-link text-white" href="/signup"><i class="fas fa-user me-2"></i>Sign Up</a>
                </li>                    
            @endif
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
