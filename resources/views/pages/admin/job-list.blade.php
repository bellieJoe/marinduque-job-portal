@extends('app')
@section('title', '- Job List')
@section('content')

@php
    $sort = isset($_GET['sort']) ? $_GET['sort'] : null;
    $column = isset($_GET['column']) ? $_GET['column'] : null;
    $search = isset($_GET['search']) ? $_GET['search'] : null;
@endphp

<body class="bg-gray-100">
    <div id="jobList">


        <div v-if="loading">
            @component('components.loading')@endcomponent
        </div>

        <form action="" method="get" class="bg-gray-600 py-5 px-3" @submit="toggleLoading">
            <div class="row col-lg-8 lg:w-10/12 mx-auto">
                <div class="col">
                    <input type="text" class="form-control" name="search" value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}" placeholder="Enter Job id">
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary"><i class="fa fa-search me-2"></i> Search</button>
                </div>
            </div>
        </form>

        <div class=" bg-gray-200 py-5 px-3">
            <div class="mx-auto lg:w-10/12">
                <div>
                    <h3 class="font-bold text-lg">Job List</h3>
                </div>
                <table class="table-auto w-full shadow-md my-4 bg-white">
                    <tr class="bg-gray-400 sticky">
                        {{-- <th class="p-2">
                            <a href="/admin/jobs?sort={{ $sort && $column == 'job_id' ? ($sort == 'desc' ? 'asc' : 'desc') : 'desc' }}&column=job_id">
                                Job Id
                                <i class="fa fa-sort{{ $sort  && $column == 'job_id' ? ($sort == 'desc' ? '-down' : '-up') : '' }} ms-2"></i>
                            </a>
                        </th> --}}
                        <th class="p-2">
                            <a href="/admin/jobs?sort={{ $sort && $column == 'user_id' ? ($sort == 'desc' ? 'asc' : 'desc') : 'desc' }}&column=user_id">
                                Owner Id
                                <i class="fa fa-sort{{ $sort  && $column == 'user_id' ? ($sort == 'desc' ? '-down' : '-up') : '' }} ms-2"></i>
                            </a>
                        </th>
                        <th class="p-2">
                            <a href="/admin/jobs?sort={{ $sort && $column == 'job_industry' ? ($sort == 'desc' ? 'asc' : 'desc') : 'desc' }}&column=job_industry">
                                Job Industry
                                <i class="fa fa-sort{{ $sort  && $column == 'job_industry' ? ($sort == 'desc' ? '-down' : '-up') : '' }} ms-2"></i>
                            </a>
                        </th>
                        <th class="p-2">
                            <a href="/admin/jobs?sort={{ $sort && $column == 'job_title' ? ($sort == 'desc' ? 'asc' : 'desc') : 'desc' }}&column=job_title">
                                Job Title
                                <i class="fa fa-sort{{ $sort  && $column == 'job_title' ? ($sort == 'desc' ? '-down' : '-up') : '' }} ms-2"></i>
                            </a>
                        </th>
                        <th class="p-2">
                            <a href="/admin/jobs?sort={{ $sort && $column == 'company_name' ? ($sort == 'desc' ? 'asc' : 'desc') : 'desc' }}&column=company_name">
                                Company Name
                                <i class="fa fa-sort{{ $sort  && $column == 'company_name' ? ($sort == 'desc' ? '-down' : '-up') : '' }} ms-2"></i>
                            </a>
                        </th>
                        <th class="p-2">
                            Status
                        </th>
                    </tr>
                    @foreach ($jobsData as $job)
                    <tr class="odd:bg-gray-100 hover:bg-indigo-200">
                        {{-- <td class="p-2">
                            {{ $job->job_id }}
                        </td> --}}
                        <td class="p-2">
                            {{ $job->user_id }}
                        </td>
                        <td class="p-2">
                            {{ $job->job_industry }}
                        </td>
                        <td class="p-2">
                            {{ $job->job_title }}
                        </td>
                        <td class="p-2">
                            {{ $job->company_name }}
                        </td>
                        <td class="p-2">
                            <a @click="toggleLoading" href="/admin/jobs/{{ $job->status == 'terminated' ? 'retrieve' : 'terminate' }}/{{ $job->job_id }}" class="btn btn-{{ $job->status == 'terminated' ? 'primary' : 'danger' }} btn-sm">{{ $job->status == 'terminated' ? 'Retrieve' : 'Terminate' }}</a>
                        </td>
                    </tr>
                    @endforeach
                    @if (!$jobsData[0])
                    <tr>
                        <td class="text-center p-3" colspan="7">No data to show.</td>
                    </tr> 
                    @endif
                </table>
            </div>

            {{ $jobsData }}

            <div>
                <h5 class="text-md">Total no. of Jobs: <span class="font-bold">{{ number_format($jobCount) }}</span></h5>
            </div>
            
        </div>


    </div>
</body>
<script src="{{ asset('js/pages/admin/job-list.js') }}"></script>
@endsection