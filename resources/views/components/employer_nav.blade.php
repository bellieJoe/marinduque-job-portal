
@php
  use Carbon\Carbon;
@endphp
<nav class="bg-indigo-900 " id="employer_nav">

    <input type="hidden" value="{{ Auth::user() }}" id="User">
    <link rel="stylesheet" href="{{asset('css/employer_nav.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">


    <ul class="nav container-lg">

        {{-- {{ config('app.url').'employer/profile' }} --}}
        {{-- notifications --}}
        <li class="nav-item" >
            <div class="nav-link">
                <button v-cloak class="bg-red-500 rounded-full px-2 text-white " data-bs-toggle="offcanvas" data-bs-target="#notificationContainer" aria-controls="notificationContainer">
                    <i class="fas fa-bell "></i> 
                    @{{ notificationCount }}
                </button>
            </div> 
        </li>
        <div class="offcanvas offcanvas-start  bg-indigo-500" tabindex="-1" id="notificationContainer">
            <div class="offcanvas-header" id="header">
                <h5 class="offcanvas-title font-bold  text-lg" id="offcanvasLabel">Notifications</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
              <div class="">
                  <div v-for="notification of notifications" :class="notification.read_at ? 'opacity-50' : ''" class="rounded bg-gray-50 my-2 p-2 hover:opacity-80 duration-500" @mouseover="setHoveredNotif(notification.id)" >
                    <h6 class="text-indigo-400 font-bold">
                        @{{ notification.data.title }}
                    </h6>
                     @{{ notification.data.message }}
                     <p v-cloak class="text-gray-400">@{{ notification.created_at_formatted }}</p>
                     
                     <div class="w-max ml-auto mr-0 duration-500 " :class="hoveredNotif == notification.id ? 'visible' : 'hidden'">
                         <button  @click="deleteNotificationById(notification.id)" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Delete Notification" class="btn text-gray-500"><i class="fa fa-trash-alt"></i></button>
                         <button v-if="!notification.read_at" @click="markAsRead(notification.id)" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="Mark as read" class="btn text-gray-500"><i class="fa fa-glasses"></i></button>
                         <a @click="markAsRead(notification.id)" :href="notification.data.action" type="button" data-bs-toggle="tooltip" data-bs-placement="right" title="View Notification" class="btn  text-gray-500"><i class="fa fa-external-link-alt"></i></a>
                     </div>
                  </div>

                  <div v-if="!notifications[0]">
                      <h6 class="text-indigo-900  text-center">No Notifications</h6>
                  </div>
              </div>
            </div>
        </div>


        {{-- navigations --}}
        <li class="nav-item">
          <a class="nav-link  hover:text-gray-100 hover:font-bold  {{ Request::url() == config('app.url').':8000/employer/home' ? 'font-bold text-gray-100' : 'text-indigo-200' }}"  href="/employer/home"><i class="fas fa-home"></i> Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link hover:text-gray-100 hover:font-bold {{ Request::url() == config('app.url').':8000/employer/profile' ? 'font-bold text-gray-100' : 'text-indigo-200' }}" href="/employer/profile"><i class="fas fa-user"></i> Company Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link hover:text-gray-100 hover:font-bold {{ Request::url() == config('app.url').':8000/employer/job' ? 'font-bold text-gray-100' : 'text-indigo-200' }}" href="/employer/job"><i class="fas fa-briefcase"></i> My Jobs</a>
        </li>
        <li class="nav-item">
          <a class="nav-link hover:text-gray-100 hover:font-bold {{ Request::url() == config('app.url').':8000/employer/settings' ? 'font-bold text-gray-100' : 'text-indigo-200' }}" href="/employer/settings"><i class="fas fa-cog"></i> Settings</a>
        </li>
        <li class="nav-item">
          <a class="nav-link hover:text-gray-100 hover:font-bold {{ Request::url() == config('app.url').':8000/employer/post-job' ? 'font-bold text-gray-100' : 'text-indigo-200' }}" href="/employer/post-job"><i class="fas fa-plus-circle"></i> Create Job</a>
        </li>
        <li class="nav-item">
          <a class="nav-link hover:text-gray-100 hover:font-bold {{ Request::url() == config('app.url').':8000/employer/placement-report/' ? 'font-bold text-gray-100' : 'text-indigo-200' }}" href="{{ '/employer/placement-report/'.Carbon::now()->format("m").'/'.Carbon::now()->format("Y") }}"><i class="fas fa-table"></i> Placement Report</a>
        </li>
        
    </ul>

</nav>
<script src="{{asset('js/components/employer_nav.js')}}"></script>