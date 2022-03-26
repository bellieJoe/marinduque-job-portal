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
                    <label for="" class="font-semibold">LMI ANALYSIS FOR THE MONTH OF</label>
                    <select name="month" class="form-select w-32 inline">
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                    <select name="year" class="form-select w-28 inline">
                        @for ($i = 2022; $i <= \Carbon\Carbon::now()->format("Y"); $i++)
                        <option value="{{ $i }}">{{ $i }}</option>  
                        @endfor
                    </select>
                    {{-- <input type="number" min="2021" max="{{ \Carbon\Carbon::now()->format("Y") }}" step="1" value="{{ \Carbon\Carbon::now()->format("Y") }}" /> --}}
                </div>
            </div>
            <section class="p-2">
                {{-- rows --}}
                <section>
                    <div class="grid grid-cols-5 ">
                        <div class="col-span-5 p-2 border-gray-400 border-1">
                            <h6 class="font-semibold">NUMBER OF JOBS SOLICITED</h6>
                        </div>
                    </div>
                    <div class="grid grid-cols-5">
                        <div class="col-span-4 p-2 border-gray-400 border-1   grid grid-cols-1 items-center">
                            <h6 class="">LOCAL</h6>
                        </div>
                        <div class="col-span-1  p-2 border-gray-400 border-1 ">
                            <div class="grid grid-cols-2 gap-1">
                                <input class="form-control " type="number" name="" id="" value="0">
                                <input class="form-control " disabled type="number" value="0" name="" id="">
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-5">
                        <div class="col-span-4 p-2 border-gray-400 border-1  grid grid-cols-1 items-center">
                            <h6 class="">OVERSEAS</h6>
                        </div>
                        <div class="col-span-1  p-2 border-gray-400 border-1 ">
                            <div class="grid grid-cols-2 gap-1">
                                <input class="form-control " type="number" name="" id="" value="0">
                                <input class="form-control " disabled type="number" value="0" name="" id="">
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-5">
                        <div class="col-span-4 p-2 border-gray-400 border-1  grid grid-cols-1">
                            <h6 class="text-right self-center">Total</h6>
                        </div>
                        <div class="col-span-1  p-2 border-gray-400 border-1 ">
                            <input class="form-control " disabled type="number" value="0" name="" id="">
                        </div>
                    </div>
                    <div class="">
                        <div class=" p-3 border-gray-400 border-1  grid grid-cols-1">
                            <h6 class=" self-center italic">Job vacancies solicited from different companies and establishments outside and within the province with a total of </h6>
                            <input class="form-control form-control-lg text-base" type="number" value="0" name="" id="">
                        </div>
                    </div>
                </section>

                <section>
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
                            <div class="grid grid-cols-2 gap-1">
                                <input class="form-control " type="number" name="" id="" value="0">
                                <input class="form-control " disabled type="number" value="0" name="" id="">
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-5">
                        <div class="col-span-4 p-2 border-gray-400 border-1  grid grid-cols-1">
                            <h6 class="pl-4 self-center">FEMALE</h6>
                        </div>
                        <div class="col-span-1  p-2 border-gray-400 border-1 ">
                            <div class="grid grid-cols-2 gap-1">
                                <input class="form-control " type="number" name="" id="" value="0">
                                <input class="form-control " disabled type="number" value="0" name="" id="">
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-5">
                        <div class="col-span-4 p-2 border-gray-400 border-1  grid grid-cols-1">
                            <h6 class="text-right self-center">Total</h6>
                        </div>
                        <div class="col-span-1  p-2 border-gray-400 border-1 ">
                            <input class="form-control " disabled type="number" value="0" name="" id="">
                        </div>
                    </div>
                    <div class="">
                        <div class=" p-3 border-gray-400 border-1  grid grid-cols-1">
                            <h6 class=" self-center italic">Applicants who registered in our log book/walk-in applicants totalled to </h6>
                            <input class="form-control form-control-lg text-base" type="number" value="0" name="" id="">
                            <h6 class=" self-center italic">for the Job Solicited.</h6>
                        </div>
                    </div>
                </section>

                <section>
                    <div class="grid grid-cols-5">
                        <div class="col-span-5 p-2 border-gray-400 border-1  grid grid-cols-1">
                            <h6 class="self-center font-semibold">NUMBER OF APPLICANTS REFERRED</h6>
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
                            <div class=" gap-1">
                                <input class="form-control " type="number" name="" id="" value="0">
                                {{-- <input class="form-control " disabled type="number" value="0" name="" id=""> --}}
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-5">
                        <div class="col-span-4 p-2 border-gray-400 border-1  grid grid-cols-1">
                            <h6 class="pl-4 self-center">FEMALE</h6>
                        </div>
                        <div class="col-span-1  p-2 border-gray-400 border-1 ">
                            <div class=" gap-1">
                                <input class="form-control " type="number" name="" id="" value="0">
                                {{-- <input class="form-control " disabled type="number" value="0" name="" id=""> --}}
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-5">
                        <div class="col-span-4 p-2 border-gray-400 border-1  grid grid-cols-1">
                            <h6 class="text-right self-center">Total</h6>
                        </div>
                        <div class="col-span-1  p-2 border-gray-400 border-1 ">
                            <input class="form-control " disabled type="number" value="0" name="" id="">
                        </div>
                    </div>
                    <div class="">
                        <div class=" p-3 border-gray-400 border-1  grid grid-cols-1">
                            <h6 class=" self-center italic">Applicants referred for job placement is also   </h6>
                            <input class="form-control form-control-lg text-base" type="number" value="0" name="" id="">
                            <h6 class=" self-center italic">of the total applicants registered.</h6>
                        </div>
                    </div>
                </section>

                <section>
                    <div class="grid grid-cols-5">
                        <div class="col-span-5 p-2 border-gray-400 border-1  grid grid-cols-1">
                            <h6 class="self-center font-semibold">NUMBER OF APPLICANTS PLACED</h6>
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
                            <div class=" gap-1">
                                <input class="form-control " type="number" name="" id="" value="0">
                                {{-- <input class="form-control " disabled type="number" value="0" name="" id=""> --}}
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-5">
                        <div class="col-span-4 p-2 border-gray-400 border-1  grid grid-cols-1">
                            <h6 class="pl-4 self-center">FEMALE</h6>
                        </div>
                        <div class="col-span-1  p-2 border-gray-400 border-1 ">
                            <div class=" gap-1">
                                <input class="form-control " type="number" name="" id="" value="0">
                                {{-- <input class="form-control " disabled type="number" value="0" name="" id=""> --}}
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-5">
                        <div class="col-span-4 p-2 border-gray-400 border-1  grid grid-cols-1">
                            <h6 class="text-right self-center">Total</h6>
                        </div>
                        <div class="col-span-1  p-2 border-gray-400 border-1 ">
                            <input class="form-control " disabled type="number" value="0" name="" id="">
                        </div>
                    </div>
                    <div class="">
                        <div class=" p-3 border-gray-400 border-1  grid grid-cols-1">
                            <h6 class=" self-center italic">Applicants referred for job placement is also   </h6>
                            <input class="form-control form-control-lg text-base" type="number" value="0" name="" id="">
                            <h6 class=" self-center italic">of the total applicants registered.</h6>
                        </div>
                    </div>
                </section>
                
                <section>
                    <div class="">
                        <div class=" p-3 border-gray-400 border-1  grid grid-cols-1">
                            <h6 class=" self-center italic">Prepared by</h6>
                            {{-- <input class="form-control form-control-lg text-base" type="number" value="0" name="" id=""> --}}
                        </div>
                    </div>
                </section>

                <div class="py-4">
                    <button class="btn btn-primary block mx-auto"><i class="fa fa-save"></i> Save</button>
                </div>
                {{-- end row --}}
            </section>
        </form>
    
    </div>
</body>
@endsection