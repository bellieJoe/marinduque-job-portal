@extends('app')
@section('title', '- Job Seekers')
@section('content')


@php
    if(isset($_GET['search']) && trim($_GET['search']) != ''){
        $search = $_GET['search'];
        $seekers = $seekersData->where('seekers.user_id', $search)->paginate(50);
    }else{
        if(isset($_GET['sort']) &&  isset($_GET['column'])){
            $column = $_GET['column'];
            $sort = $_GET['sort'];
            $seekers = $seekersData->orderBy($column == 'user_id' ? 'seekers.user_id' : $column, $sort)->paginate(50)->withPath('?sort='.$sort.'&column='.$column);
        }else{
            $seekers = $seekersData->paginate(50);
        }
    }
    
@endphp

<body class="bg-gray-100">
    <div id="jobSeekerList">

        <div v-if="loading">
            @component('components.loading')@endcomponent
        </div>


        <form action="" method="get" class="bg-gray-600  py-5 px-3">
            <div class="row col-lg-8 lg:w-10/12 mx-auto">
                <div class="col">
                    <input type="text" class="form-control" name="search" value="{{ isset($search ) ? $search : '' }}" placeholder="Enter job seelker id">
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary"><i class="fa fa-search me-2"></i> Search</button>
                </div>
            </div>
        </form>
        
        <div class=" bg-gray-200 py-5 px-3" id="printable">
            <div class=" mx-auto lg:w-10/12">
                <div>
                    <h3 class="font-bold text-lg">Job seeker List</h3>
                </div>
                <table class="table-auto w-full shadow-md border-black bg-white my-4">
                    <tr class="bg-gray-400 sticky">
                        @if (isset($column) && isset($sort))
                        {{-- <th class="p-2">
                            @if ($column == 'user_id')
                                <a href="?sort={{ $sort == 'desc' ? 'asc' : 'desc' }}&column=user_id">
                                    Job Seeker Id <i class="fa fa-{{ $sort == 'desc' ? 'sort-down' : 'sort-up' }} ms-2"></i>
                                </a>
                            @else
                                <a href="/admin/job-seekers?sort=desc&column=user_id">Job Seeker Id <i class="fa fa-sort ms-2"></i></a>
                            @endif
                        </th> --}}
                        <th class="p-2">
                            @if ($column == 'firstname')
                                <a href="?sort={{ $sort == 'desc' ? 'asc' : 'desc' }}&column=firstname">
                                    Name <i class="fa fa-{{ $sort == 'desc' ? 'sort-down' : 'sort-up' }} ms-2"></i>
                                </a>
                            @else
                                <a href="/admin/job-seekers?sort=desc&column=firstname">Name <i class="fa fa-sort ms-2"></i></a>
                            @endif
                        </th>
                        <th class="p-2">
                            @if ($column == 'address')
                                <a href="?sort={{ $sort == 'desc' ? 'asc' : 'desc' }}&column=address">
                                    Address <i class="fa fa-{{ $sort == 'desc' ? 'sort-down' : 'sort-up' }} ms-2"></i>
                                </a>
                            @else
                                <a href="/admin/job-seekers?sort=desc&column=address">Address <i class="fa fa-sort ms-2"></i></a>
                            @endif
                        </th>
                        <th class="p-2">
                            @if ($column == 'email')
                                <a href="?sort={{ $sort == 'desc' ? 'asc' : 'desc' }}&column=email">
                                    Email Address <i class="fa fa-{{ $sort == 'desc' ? 'sort-down' : 'sort-up' }} ms-2"></i>
                                </a>
                            @else
                                <a href="/admin/job-seekers?sort=desc&column=email">Email Address <i class="fa fa-sort ms-2"></i></a>
                            @endif
                        </th>
                        <th class="p-2">
                            @if ($column == 'contact_number')
                                <a href="?sort={{ $sort == 'desc' ? 'asc' : 'desc' }}&column=contact_number">
                                    Contact Number <i class="fa fa-{{ $sort == 'desc' ? 'sort-down' : 'sort-up' }} ms-2"></i>
                                </a>
                            @else
                                <a href="/admin/job-seekers?sort=desc&column=contact_number">Contact Number <i class="fa fa-sort ms-2"></i></a>
                            @endif
                        </th>
                        <th class="p-2">Status</th>
                        @else
                        {{-- <th class="p-2"><a href="/admin/job-seekers?sort=desc&column=user_id">Job Seeker Id <i class="fa fa-sort ms-2"></i></a></th> --}}
                        <th class="p-2"><a href="/admin/job-seekers?sort=desc&column=firstname">Name <i class="fa fa-sort ms-2"></i></a></th>
                        <th class="p-2"><a href="/admin/job-seekers?sort=desc&column=address">Address <i class="fa fa-sort ms-2"></i></a></th>
                        <th class="p-2"><a href="/admin/job-seekers?sort=desc&column=email">Email Address <i class="fa fa-sort ms-2"></i></a></th>
                        <th class="p-2"><a href="/admin/job-seekers?sort=desc&column=contact_number">Contact Number <i class="fa fa-sort ms-2"></i></a></th>
                        <th class="p-2">Status</th>
                        @endif
                    </tr>
                    @foreach ($seekers as $seeker)
                    <tr class="odd:bg-white even:bg-white hover:bg-indigo-200">
                        {{-- <td class="p-2">{{ $seeker->user_id }}</td> --}}
                        <td class="p-2">{{ $seeker->firstname.' '.$seeker->middlename[0].'. '.$seeker->lastname }}</td>
                        <td class="p-2">{{ $seeker->address  }}</td>
                        <td class="p-2">{{ $seeker->email }}</td>
                        <td class="p-2">{{ $seeker->contact_number }}</td>
                        <td class="p-2">
                            @if ($seeker->status == 'activated')
                                <a href="/admin/job-seekers/deactivate/{{ $seeker->user_id }}" @click="toggleLoading" class="btn btn-secondary btn-sm">Deactivate</a>
                            @elseif($seeker->status == 'deactivated')
                                <a href="/admin/job-seekers/activate/{{ $seeker->user_id }}" @click="toggleLoading" class="btn btn-primary btn-sm">Activate</a>
                            @else
                                {{ Str::ucfirst($seeker->status) }}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @if (!$seekers[0])
                    <tr>
                        <td class="text-center p-3" colspan="7">No data to show.</td>
                    </tr> 
                    @endif
                </table>
    
                {{ $seekers }}
    
                <div>
                    <h5 class="text-md">Total no. of Job Seekers: <span class="font-bold">{{ number_format($seekersData->count()) }}</span></h5>
                </div>

                <div>
                    {{-- <form action="/print" method="post">
                        @csrf
                        <input type="hidden" name="printable" :value="printable">
                        <button >Print this page</button>
                    </form> --}}
                    
                </div>
            </div>
        </div>


    </div>
</body>
<script src="{{ asset('js/pages/admin/job-seeker-list.js') }}"></script>
@endsection