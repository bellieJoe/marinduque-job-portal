@extends('app')
@section('title', ' - Admin List')
@section('content')
<body class="bg-gray-200">
    <div id="admin-list">

        <div v-if="loading">
        @component('components.loading')
        @endcomponent
        </div>
        

        <section class="bg-white w-10/12 mx-auto mt-4 p-6">
            <div class="grid grid-cols-2 items-center mb-3">
                <h1 class="font-bold text-lg ">Administrators</h1>
                <a href="/admin/add-account" class="btn btn-outline-primary justify-self-end w-max"><i class="fa fa-user-plus"></i> Add Admin</a>
            </div>
            <div>
                @php
                    $modal = isset($_GET['modal']) ? $_GET['modal'] : null;
                @endphp
                @foreach ($admins as $admin)
                <div class="border-b-2 border-gray-200 p-2 grid-cols-5 grid hover:bg-gray-200 transition-all duration-300 items-center  ">
                    <h1>{{ $admin->fullname }}</h1>
                    <h1 class="text-gray-500 justify-self-center">{{ $admin->email }}</h1>
                    <h1 class="text-gray-500 justify-self-center">{{ $admin->contact_number }}</h1>
                    <h1 class="text-gray-500 justify-self-center">{{ $admin->address }}</h1>
                    <div class="w-max justify-self-end">
                        <button @click="addModalIdParam('mdlUpdate'+{{ $admin->user_id }})" class="btn btn-sm btn-success w-max" data-bs-toggle="modal" data-bs-target="#mdlUpdate{{ $admin->user_id }}">Edit</button>
                        <button class="btn btn-sm btn-danger w-max">Delete</button>
                    </div>
                    <div id="mdlUpdate{{ $admin->user_id }}" action="" class="modal fade " >
                        <div class="modal-dialog modal-dialog-centered">
                            <form class="modal-content" action="/admin/updateAdmin" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $admin->user_id }}">
                                <input type="hidden" name="updateModalId" value="mdlUpdate{{ $admin->user_id }}">
                                <div class="modal-header border-0">
                                    <h1 class="font-bold text-lg">Update Admin Details</h1>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="mb-1 font-semibold">Email</label>
                                        <input type="text" class="form-control" value="{{ $admin->email }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label class="mb-1 font-semibold">Full Name</label>
                                        <input type="text" class="form-control @error('fullname') is-invalid @enderror" value="{{ old('fullname') ? old('fullname') :$admin->fullname }}" name="fullname" required>
                                        @error('fullname')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="mb-1 font-semibold">Contact Number</label>
                                        <input type="text" class="form-control  @error('contact_number') is-invalid @enderror" value="{{ old('contact_number') ? old('contact_number') : $admin->contact_number }}" name="contact_number" required>
                                        @error('contact_number')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="mb-1 font-semibold">Address</label>
                                        <input type="text" class="form-control  @error('address') is-invalid @enderror" value="{{ old('address') ? old('address') :$admin->address }}" name="address" required>
                                        @error('address')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal"><i class="far fa-window-close"></i> Cancel</button>
                                    <button class="btn btn-primary" @click="showLoader()"><i class="far fa-save" ></i> Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
                @if ($modal)
                <input type="hidden" id="updateModalId" value="{{ $modal }}">
                @endif
                @if (empty($admins))
                <div class="py-6">
                    <h1 class="text-center text-gray-500">No other administrators</h1>
                </div>
                @endif
            </div>
        </section>

    </div>
</body>
<script src="{{ asset('js/pages/admin/admin-list.js') }}" async defer></script>

@endsection