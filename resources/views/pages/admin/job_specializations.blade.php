@extends('app')
@section('title', ' - Job Specializations')
@section('content')

<body class="bg-gray-100">
    <div  id="jobSpecializations">

        {{-- container --}}
        <div class="lg:w-10/12 mx-auto">

            @if (Session::has('message'))
                <div class="p-2 my-3 bg-green-200 rounded-md mx-auto border-green-400 text-green-700 w-max">
                    <i class="fa fa-check mr-2"></i>
                    {{ Session::get('message') }}
                </div>
            @endif
            
            <div class="lg:grid lg:grid-cols-4 lg:gap-2 items-start ">
                {{-- specialization list --}}
                <div class="lg:col-span-3 bg-white my-3 p-3">
                    <h1 class="font-bold  p-2 text-lg">Job Specializations</h1>
                    
                    @foreach ($job_specializations as $spec )
                    
                    <div class="p-1 border-b-2 hover:bg-blue-200 rounded-md" >
                        {{ $spec->specialization }}
                        <button class="btn btn-danger btn-sm block mr-0 ml-auto" data-bs-toggle="modal" data-bs-target="{{ '#spec'.$spec->job_specialization_id }}">Delete</button>
                        <form method="POST" action="/admin/jobs/job_specializations" >
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value={{ $spec->job_specialization_id }}>
                            <div class="modal fade" id="spec{{ $spec->job_specialization_id }}">
                                <div class="modal-dialog modal-dialog-centered">
                                    
                                    <div class="modal-content">
                                        <div class="modal-body border-0">
                                            Are you sure you want to delete this Job Specialization?
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                                            <button class="btn btn-danger block" type="submit">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endforeach
                    
                </div>

                {{-- add specializations --}}
                <form class="bg-white p-3 my-3 lg:col-span-1 " method="POST" action="/admin/jobs/job_specializations">
                    @csrf
                    <div>
                        <label class="mb-2">Add Specialization</label><br>
                        <input type="text" class="form-control " placeholder="Specialization" name="specialization" required maxlength="50">
                        <button class="btn btn-success block mr-0 ml-auto mt-2 ">Add</button>
                    </div>
                </form>
            </div>
            
            
            
            
        </div>
    </div>
</body>

<script src="{{ asset('js/pages/admin/job_specializations.js') }}"></script>
    
@endsection