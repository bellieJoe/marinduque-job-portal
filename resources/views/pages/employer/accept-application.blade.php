@extends('app')
@section('title', '- Accep Application')
@section('content')
<link rel="stylesheet" href="{{ asset('css/employer/accept-application.css') }}">
<body class="bg-gray-100">
    <div id="acceptApplication">
        
        <form action="/employer/job/accept-application/{{ $application['application']->job_application_id }}" method="post">
        @csrf
        <div class="col-sm-8 mx-auto bg-white mt-4 rounded-2 shadow-sm">
            {{-- application details --}}
            <div class="p-4 bg-green-400 rounded-top">
                <h6 class="text-green-900 font-bold">Application Id: {{ $application['application']->job_application_id }}</h6>
                <h6 class="text-green-900 font-normal">Submitted on {{ $application['application']->created_at->format('F d Y') }}</h6>
                <h6 class="text-green-900 font-normal">Application from {{ $application['applicant']->firstname.' '.$application['applicant']->middlename[0].'. '.$application['applicant']->lastname }}</h6>
            </div>
            <div class="p-4">
                <h5 class="mb-3 text-green-500 fw-bold text-lg">Approve Application</h5>
                <p class="mb-2 ">It seems that you have chosen a possible candidate for your job vacancy.</p>
                <p class="mb-3">By confirming this action we will notify the Applicant that you have accepted his/her application, you may contact or email the applicant about the next steps to do to be hired by refering to the information below.</p>
                
                <div class="p-2 border rounded-2 w-max">
                    <table>
                        <tr>
                            <td class="pe-2">Name: </td>
                            <td>{{ $application['applicant']->firstname.' '.$application['applicant']->middlename[0].'. '.$application['applicant']->lastname }}</td>
                        </tr>
                        <tr>
                            <td class="pe-2">Email: </td>
                            <td>{{ $application['applicant']->email }}</td>
                        </tr>
                        <tr>
                            <td class="pe-2">Contact Number: </td>
                            <td>{{ $application['applicant']->contact_number }}</td>
                        </tr>
                        <tr>
                            <td class="pe-2">Address: </td>
                            <td>{{ $application['applicant']->address }}</td>
                        </tr>
                    </table>
                </div>

                <p class="mt-3">Thank You and have a good day!</p>


            </div>

            <div class="p-4">
                <button @click="toggleLoading" class="btn btn-primary d-block ms-auto me-0" type="submit">Confirm</button>
            </div>
        </div>
        </form>


    </div>

    <div id="loading">
        @component('components.loading')
        @endcomponent
    </div>
</body>
<script src="{{ asset('js/pages/employer/accept-application.js') }}"></script>
@endsection