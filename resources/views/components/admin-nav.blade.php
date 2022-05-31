@php
  use Carbon\Carbon;
@endphp

{{-- <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script> --}}
{{-- <div class=" text-white w-screen duration-500 bg-gray-900 z-40" id="admin_nav">
    <div class="lg:hidden">
        <button  @click="toggleNav()" :class="!navToggle ? '' : 'opacity-0'" class="btn duration-1000 relative text-gray-300"><i class="fa fa-arrow-right"></i></button>
    </div>  
    <div :class=" !navToggle ? '-left-full' : ' left-0' " class="fixed h-full bg-gray-900 duration-500 w-screen top-16 lg:static lg:mx-auto lg:w-10/12">

        <button @click="toggleNav()" class="btn text-white block ml-auto mr-0 lg:hidden"><i class="fa fa-arrow-left "></i></button>

        <h1 class="text-lg font-bold p-2  lg:hidden">Admin</h1>


        <div @mouseover="showEmployerNav" @mouseleave="hideEmployerNav"  class="text-gray-400  hover:text-white duration-500 cursor-pointer lg:inline-block">
            <h6 class="p-2"><i class="fa fa-building mr-2"></i>Employers</h6>
            <div v-cloak class="lg:absolute bg-gray-800 shadow-md lg:rounded-md" :class=" employerNavToggle ? 'lg:visible' : 'lg:hidden' ">
                <div class="text-gray-400 ml-4 p-2  hover:text-white duration-500 cursor-pointer">
                    <a href="/admin/employers">Employers</a>
                </div>
                <div class="text-gray-400 ml-4 p-2  hover:text-white duration-500 cursor-pointer">
                    <a href="/admin/employers/unverified">Verify Employer</a>
                </div>
            </div>
        </div>


        <div @click="redirectRoute('/admin/job-seekers')" class="text-gray-400 p-2 hover:bg-gray-600 hover:text-white duration-500 cursor-pointer lg:inline-block">
            <h6><i class="fa fa-users mr-2"></i>Job Seekers</h6>
        </div>


        <div @mouseover="showJobNav" @mouseleave="hideJobNav"  class="text-gray-400  hover:text-white duration-500 cursor-pointer lg:inline-block">
            <h6 class="p-2"><i class="fa fa-briefcase mr-2"></i>Jobs</h6>
            <div v-cloak class="lg:absolute bg-gray-800 shadow-md lg:rounded-md" :class=" jobNavToggle ? 'lg:visible' : 'lg:hidden' ">
                <div class="text-gray-400 ml-4 p-2  hover:text-white duration-500 cursor-pointer">
                    <a href="/admin/jobs">All Jobs</a>
                </div>
                <div class="text-gray-400 ml-4 p-2  hover:text-white duration-500 cursor-pointer">
                    <a href="/admin/jobs/job_specializations">Specializations</a>
                </div>
                <div class="text-gray-400 ml-4 p-2  hover:text-white duration-500 cursor-pointer">
                    <a href="/admin/jobs/courses?type=bachelor">Courses</a>
                </div>
            </div>
        </div>


        <div @click="redirectRoute('/admin/admin-list')" class="text-gray-400 p-2 hover:bg-gray-600 hover:text-white duration-500 cursor-pointer lg:inline-block">
            <h6><i class="fa fa-user mr-2"></i>Admin List</h6>
        </div>


        <div @mouseover="showReports" @mouseleave="hideReports"  class="text-gray-400  hover:text-white duration-500 cursor-pointer lg:inline-block">
            <h6 class="p-2"><i class="fa fa-folder mr-2 "></i>General Reports</h6>
            <div v-cloak class="lg:absolute bg-gray-800 shadow-md lg:rounded-md" :class=" reportToggle ? 'lg:visible' : 'lg:hidden' ">
                <div @click="redirectRoute('/admin/reports/lmi-report?month=1&year=2022')" class="text-gray-400 ml-4 p-2  hover:text-white duration-500 cursor-pointer">
                    <i class="fa fa-file me-2"></i>LMI
                </div>
                <div @click="redirectRoute('/admin/reports/sprs-report')" class="text-gray-400 ml-4 p-2  hover:text-white duration-500 cursor-pointer">
                    <i class="fa fa-plus-circle me-2"></i>Add SPRS
                </div>
                <div @click="redirectRoute('/admin/reports/placement-report')" class="text-gray-400 ml-4 p-2  hover:text-white duration-500 cursor-pointer">
                    <i class="fa fa-plus-circle me-2"></i>Placement Reports
                </div>
            </div>
        </div>
    </div>
</div> --}}

<button class="fixed bg-blue-100 p-2 top-0 hover:text-blue-500" id="btnAdminMenuShow"><i class="fa-solid fa-bars"></i></button>
<div class="admin-nav" id="admin_nav">
    <link rel="stylesheet" href="{{ asset('css/components/admin-nav.css') }}">
    
    <div class="nav-header">
        <h1>Admin Panel</h1>
        <button id="btnAdminMenuHide"><i class="fa-solid fa-arrow-left"></i></button>
    </div>
    <ul class="nav-ul">
        <li><a href="/admin/"><i class="fa-solid fa-clipboard"></i> Dashboard</a></li>
        <li class="employers">
            <div><i class="fa fa-building"></i> Employers</div>
            <ul>
                <li><a href="/admin/employers">Employer List</a></li>
                <li><a href="/admin/employers/unverified">Verify Employer</a>s</li>
            </ul>
        </li>
        <li><a href="/admin/job-seekers"><i class="fa fa-users"></i> Job Seekers</a></li>
        <li class="jobs">
            <div><i class="fa fa-briefcase"></i> Jobs</div>
            <ul>
                <li><a href="/admin/jobs">All Jobs</a></li>
                <li><a href="/admin/jobs/job_specializations">Specializations</a></li>
                <li><a href="/admin/jobs/courses?type=bachelor">Courses</a></li>
            </ul>
        </li>
        <li><a href="/admin/admin-list"><i class="fa fa-user"></i> Admin</a></li>
        <li class="general-reports">
            <div><i class="fa fa-folder"></i> General Reports</div>
            <ul>
                @php
                    $date = Carbon::now();
                @endphp
                <li><a href="/admin/reports/lmi-report?month={{ $date->format("m") }}&year={{ $date->format("Y") }}"><i class="fa fa-file me-2"></i>LMI</a></li>
                <li><a href="/admin/reports/sprs-report"><i class="fa fa-plus-circle me-2"></i>Add SPRS</a></li>
                <li><a href="/admin/reports/placement-report/{{ $date->format("m") }}/{{ $date->format("Y") }}"><i class="fa fa-plus-circle me-2"></i>Placement Reports</a></li>
            </ul>
        </li>
    </ul>
</div>
<script src="{{ asset('js/components/admin-nav.js') }}"></script>



