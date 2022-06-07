@extends("app")
@section("title", "- SPRS Report")
@section("content")
<body class="bg-gray-200">
    <div id="sprsReport">

        <form class="w-10/12 bg-white mx-auto pt-4 px-2" method="GET" action="">

            <div class="px-2 py-3" >
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

            {{-- header --}}
            <section class=" grid grid-cols-4">
                <div class="grid grid-cols-1  border-1 border-gray-500">
                    <h1 class="text-center font-bold self-center">BOAC MARINDUQUE</h1>
                </div>
                <div class="col-span-2  border-1 border-gray-500 py-3">
                    <h1 class="text-center">Department of Labor and Employment</h1>
                    <h1 class="font-bold text-center text-xl">STATISTICAL PERFORMANCE REPORTING SYSTEM (SPRS)</h1>
                    <h1 class="text-center">Monthly Operations Statistical Report for PESO Managers</h1>
                </div>
                <div class=" border-1 border-gray-500">

                </div>
            </section>

            <br>

            @if ($SPRS)
            <section class=" grid grid-cols-4">
                <div class="col-span-3 border-1 border-gray-500 ">
                    <h1 class="text-center self-center my-2 font-bold">INDICATORS</h1>
                </div>
                <div class="col-span-1 border-1 border-gray-500 ">
                    <h1 class="text-center self-center my-2 font-bold">TOTAL</h1>
                </div>
            </section>

            <section class=" grid grid-cols-4">
                <div class="col-span-3 border-1 border-gray-500 ">
                    <h1 class=" m-2">Job vacancies solicited/reported</h1>
                </div>
                <div class="col-span-1 border-1 border-gray-500 ">
                    <h1 class="text-center self-center my-2">{{ $SPRS->vacancies_solicited }}</h1>
                </div>
            </section>
            <section class=" grid grid-cols-4">
                <div class="col-span-3 border-1 border-gray-500 ">
                    <h1 class=" m-2">Job applicants registered</h1>
                </div>
                <div class="col-span-1 border-1 border-gray-500 ">
                    <h1 class="text-center self-center my-2">{{ $SPRS->applicants_registered }}</h1>
                </div>
            </section>
            <section class=" grid grid-cols-4">
                <div class="col-span-3 border-1 border-gray-500 ">
                    <h1 class=" m-2">Job applicants placed</h1>
                </div>
                <div class="col-span-1 border-1 border-gray-500 ">
                    <h1 class="text-center self-center my-2">{{ $SPRS->applicants_placed_private + $SPRS->applicants_placed_government }}</h1>
                </div>
            </section>
            <section class=" grid grid-cols-4">
                <div class="col-span-3 border-1 border-gray-500 ">
                    <h1 class=" my-2 ml-14">Private sector (direct employers)</h1>
                </div>
                <div class="col-span-1 border-1 border-gray-500 ">
                    <h1 class="text-center self-center my-2">{{ $SPRS->applicants_placed_private }}</h1>
                </div>
            </section>
            <section class=" grid grid-cols-4">
                <div class="col-span-3 border-1 border-gray-500 ">
                    <h1 class=" my-2 ml-14">Government sector</h1>
                </div>
                <div class="col-span-1 border-1 border-gray-500 ">
                    <h1 class="text-center self-center my-2">{{ $SPRS->applicants_placed_government }}</h1>
                </div>
            </section>
            <section class=" grid grid-cols-4 ">
                <div class="col-span-4 border-1 border-gray-500 bg-gray-500 mb-10">
                    <h1 class=" m-2 text-white">This Report is automatically generated every end of the month. Created on {{ $SPRS->created_at->format('F d Y') }}</h1>
                </div>
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