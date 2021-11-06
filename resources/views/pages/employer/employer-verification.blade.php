@extends('app')
@section('title', ' - Verify Employer')
@section('content')
    
    <body class="bg-gray-200">
        <div id="verify_employer">

            @if(!Session::has('success'))
                <section class="bg-white lg:w-5/12 mx-auto mt-5 rounded-md shadow-md p-3">
                    <form action="/verify-employer" method="post" enctype="multipart/form-data" @submit="toggleLoading">
                        @csrf

                        <h1 class="text-lg font-bold mb-3">Prove the legitimacy of your Organization</h1>

                        <div class="mb-3">
                            <label for="proof" class="mb-1 font-bold">Proof <span class="text-red-500">*</span></label>
                            <input type="file" accept="image/*, .pdf " name="proof[]" id="proof" class="form-control" multiple required>
                        </div>
                        <button class="btn btn-success block ml-auto mr-0" >
                            Submit
                        </button>
                    </form>
                </section>
            @endif
            

            @if (Session::has('success') && Session::get('success'))
                <div class="alert alert-success lg:w-5/12 mx-auto mt-5">
                    Your Proofs has been submitted to LMD-PESO. Please expect an email about the status of your verification.<a href="" class="text-blue-500">Submit another proof?</a>
                </div>
            @endif

            @if ($submitted && !Session::has('success'))
                <div class="alert alert-primary lg:w-5/12 mx-auto mt-5">
                    You have already submitted {{ $proofCount }} proof/s to LMD-PESO.
                </div>

                <div class="shadow-md rounded-md bg-white lg:w-5/12 mx-auto mt-5 p-3">
                    <h6 class="font-bold mb-3">Recently submitted</h6>

                    @foreach ($proofs as $proof)
                    <div class="p-2">
                        <a href="/proof/{{ $proof->proof_id }}" target="_blank"><i class="fa fa-file mr-2"></i> {{ $proof->title }}</a>
                    </div>
                    @endforeach
                    
                </div>
            @endif

            <div v-if="loading">
                @component('components.loading')
                @endcomponent
            </div>


        </div>
    </body>

    <script src="{{ asset('js/pages/employer/employer-verification.js') }}"></script>

@endsection

