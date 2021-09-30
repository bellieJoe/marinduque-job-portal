@extends('app')
@section('title', '- Settings')
@section('content')

<body class="bg-gray-200">
    <div id="seeker_settings">

        <div class="lg:w-10/12 mx-auto mt-4">

            <div class="max-w-xl mx-auto my-6" >
                <h6 class="font-bold my-3 text-lg text-indigo-800"><i class="fa fa-shield-alt mr-2"></i>Security</h6>
                <input id="email" type="hidden" name="email" value="{{ Auth::user()->email }}">
                <button @click="resetPassword" class="bg-white block w-full text-left rounded-sm p-2 " >
                    <i class="fa fa-key mr-2"></i>Change password
                </button>
            </div>

            <div class="max-w-xl mx-auto my-6" >
                <h6 class="font-bold my-4 text-lg text-indigo-800"><i class="fa fa-user mr-2"></i>Account</h6>
                <button class="bg-white block w-full text-left rounded-sm p-2 " >
                    <i class="fa fa-trash mr-2"></i>Delete account
                </button>
            </div>
            
            

        </div>


        <div :class="passwordResetToast ? 'show' : 'hide'" class="toast  m-2 fixed bottom-0 z-20" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header text-green-500">
              <i class="fa fa-envelope mr-2"></i>
              <strong class="me-auto">Notification</strong>
              <button @click="togglePasswordResetToast" type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                @{{ resetPasswordResponse }}
            </div>
        </div>

        <div v-if="loading">
            @component('components.loading')
            @endcomponent
        </div>
        

    </div>
</body>

<script src="{{ asset('js/pages/seeker/settings.js') }}"></script>
    
@endsection