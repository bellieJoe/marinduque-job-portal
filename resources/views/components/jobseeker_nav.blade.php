

<div class="jobseeker_nav bg-indigo-900" id="jobseeker_nav">
    <link rel="stylesheet" href="{{asset('css/jobseeker_nav.css')}}">

    {{-- to pass the auth user to the js  --}}
    <input type="hidden" id="User" value="{{ Auth::user() }}">

    <div class="wrapper">
        <div v-cloak class="item text-yellow-200" @click="toggleNotification">
            <i class="fa fa-bell"></i>
            @{{ unreadNotificationsCount }}
        </div>
        <div v-cloak class="item"  id="js_home" @click="redirectRoute('/seeker/home')">
            <label><i class="fas fa-home"></i> Home</label>
        </div>
        <div v-cloak class="item" id="js_profile" @click="redirectRoute('/seeker/profile/education')">
            <label ><i class="fas fa-user"></i> My Profile</label>
        </div>

        <div v-cloak class="item" id="js_employers" @click="redirectRoute('/employers')">
            <label ><i class="fas fa-building"></i> Employers</label>
        </div>
        <div v-cloak class="item" id="js_fmatch" @click="redirectRoute('/seeker/settings')">
            <label ><i class="fas fa-cog"></i> Settings</label>
        </div>
        <div v-cloak class="item last" id="js_contact">
            <label ><i class="fas fa-phone-alt"></i> Contact Us</label>
        </div> 
    </div>

    <div id="seeker_notifications" v-cloak class="w-full md:w-96 h-screen fixed top-0 z-50 bg-indigo-500 p-3 transition duration-1000" :class="notificationToggle ? 'visible' : 'hidden -left-96 '">
        <div id="header" class="mb-3">
            <h6 class="font-bold text-lg">
                Notifications
                <button class="float-right" @click="toggleNotification">
                    <i class="fa fa-times text-gray-200 hover:text-gray-50"></i>
                </button>
            </h6>
            
        </div>
        <div class="body">
            <div v-cloak v-for="notification of notifications" :class="notification.read_at ? 'opacity-50' : ''" class="rounded bg-gray-50 my-2 p-2 hover:opacity-80 duration-500" @mouseover="setHoveredNotif(notification.id)" >
                <h6 v-cloak class="text-indigo-400 font-bold">
                    @{{ notification.data.title }}
                </h6>
                 @{{ notification.data.message }}
                 <p class="text-gray-400">@{{ notification.created_at_formatted }}</p>
                 
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
<script src="{{asset('js/components/jobseeker_nav.js')}}"></script>