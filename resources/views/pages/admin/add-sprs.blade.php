@extends("app")
@section("title", "- SPRS Report")
@section("content")
<body class="bg-gray-200">
    <div id="sprsReport">

        <form class="w-10/12 bg-white mx-auto pt-4 px-2" method="GET" action="">
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

            <section class=" grid grid-cols-5">
                <div class="col-span-1 border-1 border-gray-500 grid grid-cols-1">
                    <h1 class="text-center self-center">MAJOR FINAL OUTPUTS</h1>
                </div>
                <div class="col-span-1 border-1 border-gray-500 grid grid-cols-1">
                    <h1 class="text-center self-center">PROGRAMS</h1>
                </div>
                <div class="col-span-2 border-1 border-gray-500 grid grid-cols-1">
                    <h1 class="text-center self-center">INDICATORS</h1>
                </div>
                <div class="col-span-1 border-1 border-gray-500 grid grid-rows-3">
                    <div class=" border-1 border-gray-500">
                        <h1 class="text-center">ACTUAL</h1>
                    </div>
                    <div class=" border-1 border-gray-500 row-span-2 grid grid-cols-1">
                        <h1 class="text-center self-center">Current reporting Month</h1>
                    </div>
                    <div class=" border-1 border-gray-500">

                    </div>
                </div>
            </section>

            <section class="p-2">

            </section>
        </form>
    
    </div>
</body>
@endsection