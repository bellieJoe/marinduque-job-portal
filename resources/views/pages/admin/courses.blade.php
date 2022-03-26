@extends('app')
@section('title', ' - Courses')
@section('content')

<body class="bg-gray-200">
    <div id="courses">

        @if (Session::has('message'))
            <div class="p-2 my-3 bg-green-200 rounded-md mx-auto border-green-400 text-green-700 w-max">
                <i class="fa fa-check mr-2"></i>
                {{ Session::get('message') }}
            </div>
        @endif

        <div class="lg:w-10/12 mx-auto mt-3">
            <section class="lg:grid lg:grid-cols-4 lg:gap-2 items-start">
                <div class="lg:col-span-3 bg-white p-3">
                    <select class="form-select my-2 w-max ml-auto mr-0 form-select-sm" id="selectCourseType" @change="selectCourseType_changed">
                        <option value="bachelor" {{ isset($_GET["type"]) ? ($_GET["type"] == 'bachelor' ? 'selected' : '') : '' }}>Bachelor's Dedgree</option>
                        <option value="master" {{ isset($_GET["type"]) ? ($_GET["type"] == 'master' ? 'selected' : '') : '' }}>Master's Dedgree</option>
                        <option value="doctor" {{ isset($_GET["type"]) ? ($_GET["type"] == 'doctor' ? 'selected' : '') : '' }}>Doctor's Dedgree</option>
                    </select>

                    <h1 class="font-bold  p-2  text-lg">Courses</h1>
                    
                    @foreach ($courses as $course)
                        @if ($course->course_type == $_GET["type"])
                        <div class="p-1 border-b-2 hover:bg-blue-200 rounded-md">
                            {{ $course->course }}
                            <button class="btn btn-danger btn-sm block mr-0 ml-auto" data-bs-toggle="modal" data-bs-target="{{ '#course'.$course->course_id }}">Delete</button>
                            <form method="POST" action="/admin/jobs/courses" >
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="course_id" value={{ $course->course_id }}>
                                <div class="modal fade" id="course{{ $course->course_id }}">
                                    <div class="modal-dialog modal-dialog-centered">
                                        
                                        <div class="modal-content">
                                            <div class="modal-body border-0">
                                                Are you sure you want to delete this Course?
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
                        @endif
                    @endforeach
                </div>
                
                <form method="POST" action="/admin/jobs/courses" class="col-span-1 bg-white p-3 ">
                    @csrf
                    <div>
                        <label class="mb-2 font-bold">Add Course</label><br>
                        <label class="mb-1 block">Course Name</label>
                        <input type="text" class="form-control " placeholder="Course" name="course" required maxlength="100">
                        <br>
                        <label class="mb-1 block">Course Level</label>
                        <select name="course_type" class="form-select" required>
                            <option value="bachelor" selected>Bachelor's Dedgree</option>
                            <option value="master">Master's Dedgree</option>
                            <option value="doctor">Doctor's Dedgree</option>
                        </select>
                        <button class="btn btn-success block mr-0 ml-auto mt-2 ">Add</button>
                    </div>
                </form>
            </section>
        </div>

    </div>
</body>
<script src="{{ asset("js/pages/admin/courses.js") }}"></script>
@endsection