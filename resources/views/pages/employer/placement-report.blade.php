@extends('app')
@section('title', ' - Placement Report')
@section('content')
<body class="bg-gray-200">
    <div id="employerPlacementReport">

        <header  class=" lg:w-10/12 mx-auto my-4">
            <button class="btn btn-primary block ml-auto mr-0 btn-primary"><i class="fa fa-print mr-2"></i>Print</button>
            <h1 class="text-center font-bold text-2xl">Placement Report</h1>
            <form action="">
                <input type="hidden" id="role" value="{{ Auth::user()->role }}">
                <input v-model.lazy="selectedMonth" type="hidden" name="month">
                <input v-model.lazy="selectedYear" type="hidden" name="year">
                <input type="hidden" name="" id="syear" value="{{ $year }}">
                <input type="hidden" name="" id="smonth" value="{{ $month }}">
                <h1 class="text-sm text-center">
                    For the month 
                <select v-model.lazy="selectedMonth" @change="reloadReport" name="" id="">
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
                    <select v-model.lazy="selectedYear" @change="reloadReport" name="" id="">
                        <option v-for="year of years" :value="year">@{{ year }}</option>
                    </select>
                </h1>
            </form>
        </header>

        <section class="overflow-x-scroll lg:w-10/12 mx-auto">
            {{-- {{ $placementReportData }} --}}
            <table class="min-w-max bg-white rounded-md w-full">
                <tr class="bg-blue-400 rounded-t-md ">
                    <th class="p-2  text-sm rounded-tl-md">Full Name</th>
                    <th class="p-2  text-sm">Reffered Job</th>
                    <th class="p-2  text-sm">Company Name</th>
                    <th class="p-2  text-sm">Contact No.</th>
                    {{-- <th class="p-2  text-sm">Date Hired</th> --}}
                    <th class="p-2  text-sm rounded-tr-md">Date Hired</th>
                </tr>
                <tr>
                    @foreach ($placementReportData as $i)
                    <td class="p-2  text-sm">{{ $i->fullname }}</td>
                    <td class="p-2  text-sm">{{ $i->reffered_job }}</td>
                    <td class="p-2  text-sm">{{ $i->company_name }}</td>
                    <td class="p-2  text-sm">{{ $i->contact_number }}</td>
                    <td class="p-2  text-sm">{{ $i->date_hired->format("F d Y") }}</td>
                    {{-- <td class="p-2  text-sm">asdasd</td> --}}
                    @endforeach
                    @if ($placementReportData->count() < 1)
                    <td colspan="5" class="text-center p-2 text-sm">No Records</td>
                    @endif
                </tr>
            </table>
        </section>

    </div>

        <script src="{{ asset('js/pages/employer/placement-report.js') }}" ></script>

</body>



@endsection