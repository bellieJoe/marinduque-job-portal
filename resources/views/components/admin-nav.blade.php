
{{-- <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script> --}}
<div class=" text-white w-screen duration-500 bg-gray-900 z-40" id="admin_nav">
    <div class="lg:hidden">
        <button  @click="toggleNav()" :class="!navToggle ? '' : 'opacity-0'" class="btn duration-1000 relative text-gray-300"><i class="fa fa-arrow-right"></i></button>
    </div>
     
    <div :class=" !navToggle ? '-left-full' : ' left-0' " class="fixed h-full bg-gray-900 duration-500 w-screen top-16 lg:static lg:mx-auto lg:w-10/12">

        <button @click="toggleNav()" class="btn text-white block ml-auto mr-0 lg:hidden"><i class="fa fa-arrow-left "></i></button>

        <h1 class="text-lg font-bold p-2  lg:hidden">Admin</h1>

        {{-- <div @click="redirectRoute('/admin/employers')" class="text-gray-400 p-2 hover:bg-gray-600 hover:text-white duration-500 cursor-pointer lg:inline-block">
            <h6><i class="fa fa-building mr-2"></i>Employers</h6>
        </div> --}}
        <div @mouseover="showEmployerNav" @mouseleave="hideEmployerNav"  class="text-gray-400  hover:text-white duration-500 cursor-pointer lg:inline-block">
            <h6 class="p-2"><i class="fa fa-building mr-2"></i>Employers</h6>
            <div v-cloak class="lg:absolute bg-gray-800 shadow-md lg:rounded-md" :class=" employerNavToggle ? 'lg:visible' : 'lg:hidden' ">
                <div class="text-gray-400 ml-4 p-2  hover:text-white duration-500 cursor-pointer">
                    <a href="/admin/employers"><i class="fa fa-plus-circle me-2"></i>Employers List</a>
                </div>
                <div class="text-gray-400 ml-4 p-2  hover:text-white duration-500 cursor-pointer">
                    <a href="/admin/employers/unverified"><i class="fa fa-plus-circle me-2"></i>Verify Employer</a>
                </div>
            </div>
        </div>
        <div @click="redirectRoute('/admin/job-seekers')" class="text-gray-400 p-2 hover:bg-gray-600 hover:text-white duration-500 cursor-pointer lg:inline-block">
            <h6><i class="fa fa-users mr-2"></i>Job Seekers</h6>
        </div>
        <div @click="redirectRoute('/admin/jobs')" class="text-gray-400 p-2 hover:bg-gray-600 hover:text-white duration-500 cursor-pointer lg:inline-block">
            <h6><i class="fa fa-briefcase mr-2"></i>Jobs</h6>
        </div>
        <div @click="redirectRoute('')" class="text-gray-400 p-2 hover:bg-gray-600 hover:text-white duration-500 cursor-pointer lg:inline-block">
            <h6><i class="fa fa-plus mr-2"></i>Post Job</h6>
        </div>
        <div @click="redirectRoute('/admin/add-account')" class="text-gray-400 p-2 hover:bg-gray-600 hover:text-white duration-500 cursor-pointer lg:inline-block">
            <h6><i class="fa fa-user-plus mr-2"></i>Add Admin Account</h6>
        </div>
        <div @mouseover="showReports" @mouseleave="hideReports"  class="text-gray-400  hover:text-white duration-500 cursor-pointer lg:inline-block">
            <h6 class="p-2"><i class="fa fa-folder mr-2 "></i>General Reports</h6>
            <div v-cloak class="lg:absolute bg-gray-800 shadow-md lg:rounded-md" :class=" reportToggle ? 'lg:visible' : 'lg:hidden' ">
                <div class="text-gray-400 ml-4 p-2  hover:text-white duration-500 cursor-pointer">
                    <i class="fa fa-plus-circle me-2"></i>Add LMI
                </div>
                <div class="text-gray-400 ml-4 p-2  hover:text-white duration-500 cursor-pointer">
                    <i class="fa fa-plus-circle me-2"></i>Add SPRS
                </div>
                <div class="text-gray-400 ml-4 p-2  hover:text-white duration-500 cursor-pointer">
                    <i class="fa fa-plus-circle me-2"></i>Placement Report
                </div>
            </div>
        </div>
    </div>
    
</div>
<script src="{{ asset('js/components/admin-nav.js') }}"></script>



