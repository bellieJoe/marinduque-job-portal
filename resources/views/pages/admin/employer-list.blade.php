@extends('app')
@section('title', '- Employer List')
@section('content')
    
@php
    $employerCount = $employersData->count();
    // if(isset($_GET['search']) && trim($_GET['search']) != ''){
    //     // $search = $_GET['search'];
    //     // $employers = $employersData->where('employers.user_id', $search)->paginate(50);
    // }else{
    //     if(isset($_GET['sort']) &&  isset($_GET['column'])){
    //         $column = $_GET['column'];
    //         $sort = $_GET['sort'];
    //         $employers = $employersData->orderBy($column == 'user_id' ? 'employers.user_id' : $column, $sort)->paginate(50)->withPath('?sort='.$sort.'&column='.$column);
    //     }else{
    //         $employers = $employersData->paginate(50);
    //     }
    // }

    if(isset($_GET['sort']) &&  isset($_GET['column'])){
        $column = $_GET['column'];
        $sort = $_GET['sort'];
        $employers = $employersData->orderBy($column == 'user_id' ? 'employers.user_id' : $column, $sort)->paginate(50)->withPath('?sort='.$sort.'&column='.$column);
    }else{
        $employers = $employersData->paginate(50);
    }
@endphp

<body class="bg-gray-100">
<div id="employerList">

    <div v-if="loading">
        @component('components.loading')@endcomponent
    </div>

    <div >
        <section class="duration-500">
            <form action="" method="get" class="bg-gray-600 py-5 px-3">
                <div class="row col-lg-8 lg:w-10/12 mx-auto">
                    <div class="col">
                        <input type="text" class="form-control" name="search" value="{{ isset($_GET['search'] ) ? $_GET['search'] : '' }}" placeholder="Search Employer">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary"><i class="fa fa-search me-2"></i> Search</button>
                    </div>
                </div>
            </form>
            <div class="bg-gray-200 py-5 z-0">
                <div class="lg:w-10/12 mx-auto overflow-x-scroll lg:overflow-visible w-screen"> 
                    <div>
                        <h3 class="font-bold text-lg">Employer List</h3>
                    </div>
                    <table class="w-full table-auto shadow-md my-4 rounded-md bg-white">
                        <tr class="bg-gray-400  rounded-t-md ">
                            @if (isset($column) && isset($sort))
                            <th class="p-2">
                                @if ($column == 'company_name')
                                    <a href="?sort={{ $sort == 'desc' ? 'asc' : 'desc' }}&column=company_name">
                                        Company Name <i class="fa fa-{{ $sort == 'desc' ? 'sort-down' : 'sort-up' }} ms-2"></i>
                                    </a>
                                @else
                                    <a href="/admin/employers?sort=desc&column=company_name">Company Name <i class="fa fa-sort ms-2"></i></a>
                                @endif
                            </th>
                            <th class="p-2">
                                @if ($column == 'address')
                                    <a href="?sort={{ $sort == 'desc' ? 'asc' : 'desc' }}&column=address">
                                        Address <i class="fa fa-{{ $sort == 'desc' ? 'sort-down' : 'sort-up' }} ms-2"></i>
                                    </a>
                                @else
                                    <a href="/admin/employers?sort=desc&column=address">Address <i class="fa fa-sort ms-2"></i></a>
                                @endif
                            </th>
                            <th class="p-2">
                                @if ($column == 'contact_person_name')
                                    <a href="?sort={{ $sort == 'desc' ? 'asc' : 'desc' }}&column=contact_person_name">
                                        Contact Person <i class="fa fa-{{ $sort == 'desc' ? 'sort-down' : 'sort-up' }} ms-2"></i>
                                    </a>
                                @else
                                    <a href="/admin/employers?sort=desc&column=contact_person_name">Contact Person <i class="fa fa-sort ms-2"></i></a>
                                @endif
                            </th>
                            <th class="p-2">
                                @if ($column == 'email')
                                    <a href="?sort={{ $sort == 'desc' ? 'asc' : 'desc' }}&column=email">
                                        Email Address <i class="fa fa-{{ $sort == 'desc' ? 'sort-down' : 'sort-up' }} ms-2"></i>
                                    </a>
                                @else
                                    <a href="/admin/employers?sort=desc&column=email">Email Address <i class="fa fa-sort ms-2"></i></a>
                                @endif
                            </th>
                            <th class="p-2">
                                @if ($column == 'contact_number')
                                    <a href="?sort={{ $sort == 'desc' ? 'asc' : 'desc' }}&column=contact_number">
                                        Contact Number <i class="fa fa-{{ $sort == 'desc' ? 'sort-down' : 'sort-up' }} ms-2"></i>
                                    </a>
                                @else
                                    <a href="/admin/employers?sort=desc&column=contact_number">Contact Number <i class="fa fa-sort ms-2"></i></a>
                                @endif
                            </th>
                            <th class="p-2">Status</th>
                            @else
                            {{-- <th class="p-2"><a href="/admin/employers?sort=desc&column=user_id">Employer Id <i class="fa fa-sort ms-2"></i></a></th> --}}
                            <th class="p-2"><a href="/admin/employers?sort=desc&column=company_name">Company Name <i class="fa fa-sort ms-2"></i></a></th>
                            <th class="p-2"><a href="/admin/employers?sort=desc&column=address">Address <i class="fa fa-sort ms-2"></i></a></th>
                            <th class="p-2"><a href="/admin/employers?sort=desc&column=contact_person_name">Contact Person <i class="fa fa-sort ms-2"></i></a></th>
                            <th class="p-2"><a href="/admin/employers?sort=desc&column=email">Email Address <i class="fa fa-sort ms-2"></i></a></th>
                            <th class="p-2"><a href="/admin/employers?sort=desc&column=contact_number">Contact Number <i class="fa fa-sort ms-2"></i></a></th>
                            <th class="p-2">Verification Status</th>
                            <th class="p-2">Account Status</th>
                            @endif
                        </tr>
                        @foreach ($employers as $employer)
                        @php
                            $address  = json_decode($employer->address);
                        @endphp
                        <tr class=" hover:bg-indigo-200">
                            {{-- <td class="p-2">{{ $employer->user_id }}</td> --}}
                            <td class="p-2">{{ $employer->company_name }}</td>
                            <td class="p-2">{{ $employer->address ? $address->barangay->name.', '.$address->municipality->name.', '.$address->province->name : ''   }}</td>
                            <td class="p-2">{{ $employer->contact_person_name }}</td>
                            <td class="p-2">{{ $employer->email }}</td>
                            <td class="p-2">{{ $employer->contact_number }}</td>
                            <td class="p-2">{{ $employer->verified == 1 ? "verified" : "unverified" }}</td>
                            <td class="p-2">
                                @if ($employer->status == 'activated' && $employer->verified == 1)
                                    <button  class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#mdlDeact{{ $employer->user_id }}">Deactivate</button>
                                    <div class="modal fade" id="mdlDeact{{ $employer->user_id }}">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="text-red-500 font-bold">Warning</h1>
                                                </div>
                                                <div class="modal-body">
                                                    <p>You are about to deactivate the account of {{ $employer->email }}. Are you sure you want to continue?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <a href="/admin/employers/deactivate/{{ $employer->user_id }}" @click="toggleLoading" class="btn btn-danger">Deactivate</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($employer->status == 'deactivated' && $employer->verified == 1)
                                <button  class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#mdlAct{{ $employer->user_id }}">Re-activate</button>
                                    <div class="modal fade" id="mdlAct{{ $employer->user_id }}">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="text-yeallow-500 font-bold">Re-activation Confirmation</h1>
                                                </div>
                                                <div class="modal-body">
                                                    <p>You are about to re-activate the account of {{ $employer->email }}. Are you sure you want to continue?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <a href="/admin/employers/activate/{{ $employer->user_id }}" @click="toggleLoading" class="btn btn-warning">Re-activate</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    {{-- {{ $employer->verified == 1 ? "verified" : "unverified" }} --}}
                                    Deactivated
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @if (!$employers[0])
                        <tr>
                            <td class="text-center p-3" colspan="7">No data to show.</td>
                        </tr> 
                        @endif
                    </table>

                    {{ $employers }}

                    <div>
                        <h5 class="text-md">Total no. of Employers: <span class="font-bold">{{ number_format($employerCount) }}</span></h5>
                    </div>
                </div>
            </div>
        </section>
    </div>

</div>


</body>
<script src="{{ asset('js/pages/admin/employer-list.js') }}"></script>

@endsection