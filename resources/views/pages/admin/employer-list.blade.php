@extends('app')
@section('title', '- Employer List')
@section('content')
    
@php
    $employerCount = $employersData->count();
    if(isset($_GET['search']) && trim($_GET['search']) != ''){
        $search = $_GET['search'];
        $employers = $employersData->where('employers.user_id', $search)->paginate(50);
    }else{
        if(isset($_GET['sort']) &&  isset($_GET['column'])){
            $column = $_GET['column'];
            $sort = $_GET['sort'];
            $employers = $employersData->orderBy($column == 'user_id' ? 'employers.user_id' : $column, $sort)->paginate(50)->withPath('?sort='.$sort.'&column='.$column);
        }else{
            $employers = $employersData->paginate(50);
        }
    }
    
@endphp

<body class="bg-gray-100">
<div id="employerList">

    <div v-if="loading">
        @component('components.loading')@endcomponent
    </div>


    <div :class="!navToggle ? '' : ''" class="">

        @component('components.admin-nav')
        @endcomponent

        <section :class="!navToggle ? 'lg:w-full' : 'lg:w-10/12 lg:inline-block'" class="duration-500  lg:absolute lg:top-20 z-0 lg:right-0 h-full overflow-scroll">

            <form action="" method="get" class="bg-gray-600 py-5 px-3">
                <div class="row col-lg-8">
                    <div class="col">
                        <input type="text" class="form-control" name="search" value="{{ isset($search ) ? $search : '' }}" placeholder="Enter employer id">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary"><i class="fa fa-search me-2"></i> Search</button>
                    </div>
                </div>
            </form>
            <div class="bg-white py-5 px-3">
                <div>
                    <div>
                        <h3 class="font-bold text-lg">Employer List</h3>
                    </div>
                    <table class="table-auto w-full shadow-sm my-4">
                        <tr class="bg-gray-200 sticky">
                            @if (isset($column) && isset($sort))
                            <th class="p-2">
                                @if ($column == 'user_id')
                                    <a href="?sort={{ $sort == 'desc' ? 'asc' : 'desc' }}&column=user_id">
                                        Employer Id <i class="fa fa-{{ $sort == 'desc' ? 'sort-down' : 'sort-up' }} ms-2"></i>
                                    </a>
                                @else
                                    <a href="/admin/employers?sort=desc&column=user_id">Employer Id <i class="fa fa-sort ms-2"></i></a>
                                @endif
                            </th>
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
                            <th class="p-2"><a href="/admin/employers?sort=desc&column=user_id">Employer Id <i class="fa fa-sort ms-2"></i></a></th>
                            <th class="p-2"><a href="/admin/employers?sort=desc&column=company_name">Company Name <i class="fa fa-sort ms-2"></i></a></th>
                            <th class="p-2"><a href="/admin/employers?sort=desc&column=address">Address <i class="fa fa-sort ms-2"></i></a></th>
                            <th class="p-2"><a href="/admin/employers?sort=desc&column=contact_person_name">Contact Person <i class="fa fa-sort ms-2"></i></a></th>
                            <th class="p-2"><a href="/admin/employers?sort=desc&column=email">Email Address <i class="fa fa-sort ms-2"></i></a></th>
                            <th class="p-2"><a href="/admin/employers?sort=desc&column=contact_number">Contact Number <i class="fa fa-sort ms-2"></i></a></th>
                            <th class="p-2">Status</th>
                            @endif
                        </tr>
                        @foreach ($employers as $employer)
                        @php
                            $address  = json_decode($employer->address);
                        @endphp
                        <tr class="odd:bg-gray-100 hover:bg-indigo-200">
                            <td class="p-2">{{ $employer->user_id }}</td>
                            <td class="p-2">{{ $employer->company_name }}</td>
                            <td class="p-2">{{ $employer->address ? $address->barangay->name.', '.$address->municipality->name.', '.$address->province->name : ''   }}</td>
                            <td class="p-2">{{ $employer->contact_person_name }}</td>
                            <td class="p-2">{{ $employer->email }}</td>
                            <td class="p-2">{{ $employer->contact_number }}</td>
                            <td class="p-2">
                                @if ($employer->status == 'activated')
                                    <a href="/admin/employers/deactivate/{{ $employer->user_id }}" @click="toggleLoading" class="btn btn-secondary btn-sm">Deactivate</a>
                                @elseif($employer->status == 'deactivated')
                                    <a href="/admin/employers/activate/{{ $employer->user_id }}" @click="toggleLoading" class="btn btn-primary btn-sm">Activate</a>
                                @else
                                    {{ Str::ucfirst($employer->status) }}
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