@extends('app')
@section('title', '- Employers')
@section('content')

<body class="bg-gray-200">
    <div id="employers">



        <div class="mx-auto lg:w-10/12 my-4">

            @if(isset($_GET['from']))
                <h6>Employers from <span class="font-bold text-indigo-800">{{ Str::ucfirst(Str::lower($_GET['from'])) }}</span></h6>
            @endif

            {{-- employers list --}}
            @foreach ($employers as $employer)
            <div @click="redirectTo('/employers/{{ $employer->user_id }}/jobs')" class="bg-white p-3 my-3 rounded-md hover:shadow-md duration-500 w-60 cursor-pointer inline-block mx-1">
                @if ($employer->company_logo)
                    <img class="w-20 block mx-auto" src="{{ url('image') }}/employer/logo/{{ $employer->company_logo }}" alt="">
                @else
                    <h6 class="text-blue-600 text-4xl font-bold text-center">{{ Str::ucfirst($employer->company_name)[0] }}</h6>
                @endif
                <h6 class="text-lg font-bold text-center">{{ $employer->company_name }}</h6>
                <h6 class=" text-center">{{ $employer->job_count }} job/s</h6>
            </div>
            @endforeach
            

            {{-- pagination links --}}
            @php
                $page = isset($_GET['page']) ? $_GET['page'] : ($totalPage > 1 ? 1 : null)
            @endphp
            @if ($totalPage > 1)
            <div class="w-max mr-0 ml-auto">
                <a href="{{ $page > 1 ? ($page == 2 ?  Str::replaceFirst('&page=2', '', Request::fullUrl()) : Request::fullUrl().'&page='.($page - 1)) : Request::fullUrl() }}" class="{{ $page == 1 ? 'hidden' : 'visible' }} shadow-sm rounded-l-md text-gray-600 px-2 py-1 bg-white hover:bg-gray-100 duration-500 cursor-pointer"><i class="fa fa-arrow-left"></i></a>
                <label class="px-2 py-1 shadow-sm rounded-sm text-gray-600 bg-white">
                    
                    {{ isset($_GET['page']) ? $_GET['page'] : 1 }} of {{ $totalPage }}
                    </label>
                <a href="{{ $page == $totalPage ? Request::fullUrl() : Request::fullUrl().'&page='.($page + 1) }}" class="{{ $page == $totalPage ? 'hidden' : 'visible' }} shadow-sm rounded-r-md text-gray-600 px-2 py-1 bg-white hover:bg-gray-100 duration-500 cursor-pointer"><i class="fa fa-arrow-right"></i></a>
            </div> 
            @endif
            
        </div>



    </div>
</body>

<script src="{{ asset('js/pages/guest/employers.js') }}"></script>
    
@endsection