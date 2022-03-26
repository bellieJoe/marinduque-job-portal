@extends("app")
@section("title", "- LMI Report")
@section("content")
<body class="bg-gray-200">
    <div id="lmiReport">

        <form class="w-10/12 bg-white mx-auto" method="GET" action="">
            <div class="py-3">
                <h1 class="font-bold text-center text-xl">LABOR MARKET INFORMATION ANALYSIS</h1>
            </div>
            <div class="px-2 py-3">
                <div >
                    @php
                        $year = $_GET['year'] ? $_GET['year'] : null;
                        $month = $_GET['month'] ? $_GET['month'] : null;
                    @endphp
                    <label for="" class="font-semibold">LMI ANALYSIS FOR THE MONTH OF</label>
                    <select name="month" class="form-select w-32 inline">
                        <option value="1" {{ $month ? ($month == 1 ? 'selected' : '') : ''  }}>January</option>
                        <option value="2" {{ $month ? ($month == 2 ? 'selected' : '') : ''  }}>February</option>
                        <option value="3" {{ $month ? ($month == 3 ? 'selected' : '') : ''  }}>March</option>
                        <option value="4" {{ $month ? ($month == 4 ? 'selected' : '') : ''  }}>April</option>
                        <option value="5" {{ $month ? ($month == 5 ? 'selected' : '') : ''  }}>May</option>
                        <option value="6" {{ $month ? ($month == 6 ? 'selected' : '') : ''  }}>June</option>
                        <option value="7" {{ $month ? ($month == 7 ? 'selected' : '') : ''  }}>July</option>
                        <option value="8" {{ $month ? ($month == 8 ? 'selected' : '') : ''  }}>August</option>
                        <option value="9" {{ $month ? ($month == 9 ? 'selected' : '') : ''  }}>September</option>
                        <option value="10" {{ $month ? ($month == 10 ? 'selected' : '') : ''  }}>October</option>
                        <option value="11" {{ $month ? ($month == 11 ? 'selected' : '') : ''  }}>November</option>
                        <option value="12" {{ $month ? ($month == 12 ? 'selected' : '') : ''  }}>December</option>
                    </select>
                    <select name="year" class="form-select w-28 inline">
                        @for ($i = 2022; $i <= \Carbon\Carbon::now()->format("Y"); $i++)
                        <option value="{{ $i }}" {{ $year ? ($year == $i ? 'selected' : '') : '' }}>{{ $i }}</option>  
                        @endfor
                    </select>
                    <button class="btn btn-primary" type="submit">Load</button>
                </div>
            </div>
            @if($lmi)
            <section class="p-2">
                {{-- rows --}}
                <section>
                    <div class="grid grid-cols-5 ">
                        <div class="col-span-5 p-2 border-gray-400 border-1">
                            <h6 class="font-semibold">NUMBER OF JOBS SOLICITED <i class="fa fa-info-circle" title="Jobs solicited are jobs that are posted on this system"></i></h6>
                        </div>
                    </div>
                    <div class="grid grid-cols-5">
                        <div class="col-span-4 p-2 border-gray-400 border-1   grid grid-cols-1 items-center">
                            <h6 class="">LOCAL</h6>
                        </div>
                        <div class="col-span-1  p-2 border-gray-400 border-1 ">
                            <input class="form-control text-center" disabled type="number" value="{{ $lmi->jobs_solicited_local }}" >
                        </div>
                    </div>
                    <div class="grid grid-cols-5">
                        <div class="col-span-4 p-2 border-gray-400 border-1  grid grid-cols-1 items-center">
                            <h6 class="">OVERSEAS</h6>
                        </div>
                        <div class="col-span-1  p-2 border-gray-400 border-1 ">
                            <input class="form-control text-center" disabled type="number" value="{{ $lmi->jobs_solicited_overseas }}" >
                        </div>
                    </div>
                    <div class="grid grid-cols-5">
                        <div class="col-span-4 p-2 border-gray-400 border-1  grid grid-cols-1">
                            <h6 class="text-right self-center">Total</h6>
                        </div>
                        <div class="col-span-1  p-2 border-gray-400 border-1 ">
                            <input class="form-control text-center" disabled type="number" value="{{ $lmi->jobs_solicited_total }}" >
                        </div>
                    </div>
                    {{-- <div class="">
                        <div class=" p-3 border-gray-400 border-1  grid grid-cols-1">
                            <h6 class=" self-center italic">Job vacancies solicited from different companies and establishments outside and within the province with a total of </h6>
                            <input class="form-control form-control-lg text-base" type="number" value="0" name="" id="">
                        </div>
                    </div> --}}
                </section>

                <section>
                    <div class="grid grid-cols-5">
                        <div class="col-span-5 p-2 border-gray-400 border-1  grid grid-cols-1">
                            <h6 class="self-center font-semibold">NUMBER OF APPLICANTS REFERRED <i class="fa fa-info-circle" title="Applicants referred are applicants who applied to a job using this system"></i></h6>
                        </div>
                    </div>
                    <div class="grid grid-cols-5">
                        <div class="col-span-5 p-2 border-gray-400 border-1  grid grid-cols-1">
                            <h6 class="self-center font-semibold">LOCAL & OVERSEAS</h6>
                        </div>
                    </div>
                    <div class="grid grid-cols-5">
                        <div class="col-span-4 p-2 border-gray-400 border-1  grid grid-cols-1">
                            <h6 class="pl-4 self-center">MALE</h6>
                        </div>
                        <div class="col-span-1  p-2 border-gray-400 border-1 ">
                            <input class="form-control text-center" disabled type="number" value="{{ $lmi->applicants_referred_male }}" >
                        </div>
                    </div>
                    <div class="grid grid-cols-5">
                        <div class="col-span-4 p-2 border-gray-400 border-1  grid grid-cols-1">
                            <h6 class="pl-4 self-center">FEMALE</h6>
                        </div>
                        <div class="col-span-1  p-2 border-gray-400 border-1 ">
                            <input class="form-control text-center" disabled type="number" value="{{ $lmi->applicants_referred_female }}" >
                        </div>
                    </div>
                    <div class="grid grid-cols-5">
                        <div class="col-span-4 p-2 border-gray-400 border-1  grid grid-cols-1">
                            <h6 class="text-right self-center">Total</h6>
                        </div>
                        <div class="col-span-1  p-2 border-gray-400 border-1 ">
                            <input class="form-control text-center" disabled type="number" value="{{ $lmi->applicants_referred_total }}" >
                        </div>
                    </div>
                    {{-- <div class="">
                        <div class=" p-3 border-gray-400 border-1  grid grid-cols-1">
                            <h6 class=" self-center italic">Applicants who registered in our log book/walk-in applicants totalled to </h6>
                            <input class="form-control form-control-lg text-base" type="number" value="0" name="" id="">
                            <h6 class=" self-center italic">for the Job Solicited.</h6>
                        </div>
                    </div> --}}
                </section>

                <section>
                    <div class="grid grid-cols-5">
                        <div class="col-span-5 p-2 border-gray-400 border-1  grid grid-cols-1">
                            <h6 class="self-center font-semibold">NUMBER OF APPLICANTS PLACED <i class="fa fa-info-circle" title="Applicants placed are applicants who are hired using this system"></i></h6>
                        </div>
                    </div>
                    <div class="grid grid-cols-5">
                        <div class="col-span-5 p-2 border-gray-400 border-1  grid grid-cols-1">
                            <h6 class="self-center font-semibold">LOCAL & OVERSEAS</h6>
                        </div>
                    </div>
                    <div class="grid grid-cols-5">
                        <div class="col-span-4 p-2 border-gray-400 border-1  grid grid-cols-1">
                            <h6 class="pl-4 self-center">MALE</h6>
                        </div>
                        <div class="col-span-1  p-2 border-gray-400 border-1 ">
                            <input class="form-control text-center" disabled type="number" value="{{ $lmi->applicants_placed_male }}" >
                        </div>
                    </div>
                    <div class="grid grid-cols-5">
                        <div class="col-span-4 p-2 border-gray-400 border-1  grid grid-cols-1">
                            <h6 class="pl-4 self-center">FEMALE</h6>
                        </div>
                        <div class="col-span-1  p-2 border-gray-400 border-1 ">
                            <input class="form-control text-center" disabled type="number" value="{{ $lmi->applicants_placed_female }}" >
                        </div>
                    </div>
                    <div class="grid grid-cols-5">
                        <div class="col-span-4 p-2 border-gray-400 border-1  grid grid-cols-1">
                            <h6 class="text-right self-center">Total</h6>
                        </div>
                        <div class="col-span-1  p-2 border-gray-400 border-1 ">
                            <input class="form-control text-center" disabled type="number" value="{{ $lmi->applicants_placed_total }}" >
                        </div>
                    </div>
                </section>
                
                <section>
                    <div class="bg-gray-500">
                        <div class=" p-3 border-gray-400 border-1  grid grid-cols-1">
                            <h6 class=" self-center text-xs text-white">This report is created automatically at {{ $lmi->created_at->format('F d Y h:m A') }}</h6>
                            {{-- <input class="form-control form-control-lg text-base" type="number" value="0" name="" id=""> --}}
                        </div>
                    </div>
                </section>

                <div class="py-4">
                    <button class="btn btn-primary block mx-auto"><i class="fa fa-print"></i> Print</button>
                </div>
                {{-- end row --}}
            </section>
            @else
            <section class="p-2 bg-gray-50">
                <div class="px-2 py-5">
                    <h1 class="text-center text-gray-500">No reports generated at this time</h1>
                </div>
            </section>
            @endif
        </form>

    
    </div>
</body>
@endsection