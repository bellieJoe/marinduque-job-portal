@extends("app")
@section("title", " - Unverified Employers")
@section("content")
    <body class="bg-gray-200">
        <div id="unverifiedEmployerPage">

            <section class="mx-auto md:w-10/12 bg-gray-100 p-4">
                <h1 class="text-xl font-bold mb-2">Unverified Employers</h1>
                <form  class="mb-4" action="" method="GET">
                    <div>
                        <label for="search" class="font-bold">Search Emplolyer</label><br>
                        <input id="search" class="form-control lg:w-7/12 inline-block" type="text" name="search">
                        <button type="submit" class="btn btn-success">Search</button>
                        <a href="/admin/employers/unverified" class="btn btn-primary">Show all</a>
                    </div>
                </form>
                @if (Session::has('VerificationSuccess'))
                <div class="my-2">
                    <p class="text-green-500">{{ Session::get('VerificationSuccess') }}</p>
                </div>
                @endif
                @foreach ($employers as $employer)
                    <div class="border p-1 grid grid-cols-2">
                        <div>
                            <label class="">{{ $employer->company_name }}</label>
                        </div>
                        <div>
                            <a href="/admin/proof/{{ $employer->user_id }}" class="text-indigo-500">View Proofs</a>
                        </div>
                        
                    </div>
                @endforeach
                @if (count($employers) < 1 && !isset($_GET["search"]))
                <div class="py-5">
                    <p class="text-lg text-gray-400 mx-auto text-center ">All employers are verified</p> 
                </div> 
                @endif
                @if (isset($_GET["search"]) && trim($_GET["search"]) != "" && count($employers) < 1)
                <div class="py-5">
                    <p class="text-lg text-gray-400 mx-auto text-center ">No Employers found.</p> 
                </div> 
                @endif
            </section>

        </div>
    </body>
@endsection