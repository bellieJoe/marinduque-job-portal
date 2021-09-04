@extends('app')
@section('title', '- Home')
@section('content')

<link rel="stylesheet" href="{{ asset('css/admin/admin-home.css') }}">
<body class="bg-gray-100">
    <div class="container-lg bg-white my-5 py-4 px-3 shadow-sm rounded-2" id="admin_home">

        <section>
            <h4 class="font-bold mb-3 text-center">Manage all Jobs, Applicants & Employers</h4>
            <div class="w-max mx-auto">
                <div @click="redirectRoute('/admin/employers')" class="border-1 rounded p-2 me-2 my-2 w-max cursor-pointer hover:shadow hover:bg-blue-500 hover:text-white inline-block">
                    <h6>Employer List</h6>
                </div>
                <div @click="redirectRoute('/admin/job-seekers')" class="border-1 rounded p-2 me-2 my-2 w-max cursor-pointer hover:shadow hover:bg-blue-500 hover:text-white inline-block">
                    <h6>Job Seekers List</h6>
                </div>
                <div @click="redirectRoute('/admin/jobs')" class="border-1 rounded p-2 me-2 my-2 w-max cursor-pointer hover:shadow hover:bg-blue-500 hover:text-white inline-block">
                    <h6>All Jobs</h6>
                </div>
                <div class="border-1 rounded p-2 me-2 my-2 w-max cursor-pointer hover:shadow hover:bg-blue-500 hover:text-white inline-block">
                    <h6>Post a Job</h6>
                </div>
                <div @click="redirectRoute('/admin/add-account')" class="border-1 rounded p-2 me-2 my-2 w-max cursor-pointer hover:shadow hover:bg-blue-500 hover:text-white inline-block">
                    <h6>Add Account</h6>
                </div>
            </div>
        </section>

        <section class="mt-5">
            <h4 class="font-bold mb-3 text-center">Manage Reports</h4>
            <div class="w-max mx-auto">
                <div class="border-1 rounded p-2 me-2 my-2 w-max cursor-pointer hover:shadow hover:bg-blue-500 hover:text-white inline-block">
                    <h6>General Reports</h6>
                </div>
                <div class="border-1 rounded p-2 me-2 my-2 w-max cursor-pointer hover:shadow hover:bg-blue-500 hover:text-white inline-block">
                    <h6>Add SPRS</h6>
                </div>
                <div class="border-1 rounded p-2 me-2 my-2 w-max cursor-pointer hover:shadow hover:bg-blue-500 hover:text-white inline-block">
                    <h6>Add LMI</h6>
                </div>
                <div class="border-1 rounded p-2 me-2 my-2 w-max cursor-pointer hover:shadow hover:bg-blue-500 hover:text-white inline-block">
                    <h6>Placement Report</h6>
                </div>
            </div>
        </section>


    </div>
</body>
<script src="{{ asset('js/pages/admin/admin-home.js') }}"></script>

@endsection