@extends('app')
@section('title', ' - Dashboard')
@section('content')
<body  class="bg-gray-200">
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">

    <section id="admin-dashboard">

        <div class="dashboard-head lg:w-10/12 mx-auto mt-3">
            <h1>Dashboard</h1>
        </div>

        <div class="user-charts lg:w-10/12  mx-auto mt-3 mb-8">
            <div>
                <h1>LMI Analysis Chart</h1>
            </div>
            {{-- <form action="" class="w-max ml-auto mr-0"> --}}
                <div class="input-group w-48 ml-auto mr-0">
                    <input type="number" class="form-control" placeholder="Year" id="inputYear">
                    <button class="btn btn-secondary" type="button" id="btnYear"><i class="fa-solid fa-chart-simple mr-2"></i>Load</button>
                </div>
            {{-- </form> --}}
            <div class="charts">
                <div class="chart" >
                    <canvas id="lmiJobSolicited"></canvas>
                </div>
                <div class="chart" >
                    <canvas id="lmiApplicantRefered"></canvas>
                </div>
                <div class="chart" >
                    <canvas id="lmiApplicantPlaced"></canvas>
                </div>
            </div>
        </div>

        
    </section>
    
    <script src="{{ asset('js/pages/admin/dashboard.js') }}"></script>
</body>
@endsection