@extends('app')
@section('title', ' - Proof')
@section('content')

<body class="bg-gray-200">
    <div id="verificationProof">

        
        <section class="lg:w-10/12 mx-auto bg-gray-100 p-4">
            <h1 class="text-xl font-bold mb-2" ><a href="/admin/employers/unverified">Unverified Employer /</a> {{ $employer->company_name }} </h1>
            @php
                $pNum = 1;
            @endphp
            @foreach ($proofs as $proof)
            <div class="border p-1 grid grid-cols-3 gap-1">
                <div class="col-auto">
                    <p class="w-full">Proof {{ $pNum }}</p>
                </div>
                <div>
                    <a href="/proof/{{ $proof->proof_id }}" class="text-indigo-500">View</a>
                </div>
                <div>
                    <label class="text-gray-400">{{ $proof->created_at->diffForhumans() }}</label>
                </div>
                @php
                    $pNum++;
                @endphp
            </div>
            @endforeach
            @if (count($proofs) > 0)
            <div class="my-2">
                <button class="btn btn-success block ml-auto mr-0" data-bs-toggle="modal"  data-bs-target="#verifyModal">Verify</button>
                <form action="/admin/proof/{{ $employer->user_id }}/verify" method="post">
                    @csrf
                    <div class="modal fade" id="verifyModal">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header border-0">
                                    <h1 class="font-bold">Verify Employer</h1>
                                </div>
                                <div class="modal-body border-0">
                                    By clicking yes, you prove that this is employer is a legitimate organization/business/corporation.
                                </div>
                                <div class="modal-footer border-0">
                                    <button data-bs-dismiss="modal" class="btn btn-secondary">Cancel</button>
                                    <button type="submit" class="btn btn-success">Yes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @endif
            @if (count($proofs) < 1)
                <div class="py-4">
                    <p class="text-center text-lg text-gray-400">No proofs submitted</p>
                </div>
            @endif
        
        </section>

    </div>
</body>
    
@endsection