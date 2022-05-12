@extends('app')
@section('title', ' - Dashboard')
@section('content')
<body  class="bg-gray-200">
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">

    <section id="admin-dashboard">

        <div class="dashboard-head lg:w-10/12 mx-auto mt-3">
            <h1>Dashboard</h1>
        </div>

        <div class="user-charts lg:w-10/12 mx-auto mt-3 ">
            <div>
                <h1>Users</h1>
            </div>
            
            <div class="charts">
                <div class="chart">
                    <canvas id="userDistChart"></canvas>
                </div>
                <div class="chart">
                    <canvas id="userTimelineChart"></canvas>
                </div>
            </div>
        </div>
        
    </section>
    
    <script src="{{ asset('js/pages/admin/dashboard.js') }}"></script>
</body>
@endsection