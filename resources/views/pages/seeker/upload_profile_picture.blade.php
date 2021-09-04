@extends('app')
@section('title', '')
@section('content')
<link rel="stylesheet" href="{{ asset('css/seeker/upload_profile_picture.css') }}">
<body class="seeker-upload-profile-picture">

    <div id="seeker_image_uploader" class="container-md mt-5">


        <h3 class=" fw-bold text-secondary">Upload Display Picture</h3>
        <div class="card shadow-sm p-3 mb-5">

            <div class="col-sm-4 mx-auto my-3">
                <div class="">
                    <label for="" class="fw-bold mb-1">Select Image</label>
                    <clipper-upload class="cursor-pointer hover:border-blue-500 border-2 border-dashed p-3 text-center bg-gray-100" v-model="imageData">
                        <i class="fa fa-image me-2"></i> Select Image
                    </clipper-upload>

                </div>
                <div class="mt-4">
                    <label for="" class="fw-bold mb-1" v-if="imageData"><i class="fa fa-crop"></i> Cropper</label>
                    <clipper-fixed class="clp mb-2 bg- border-dashed border-2" 
                        v-if="imageData"
                        ref="clipper"
                        :src="imageData"
                        preview="prev"
                        ratio = "1"
                        border-color="skyblue"
                        area="100"
                        bg-color="teal"
                    ></clipper-fixed>
                </div>
                <button v-if="imageData" class="btn btn-primary btn-lg d-block w-100 mt-4 mx-auto mb-5" @click="getResult"><i class="fa fa-file-upload"></i> Upload Photo</button>
                
            </div>
        </div>


    </div>
    
</body>
<script src="{{ asset('js/pages/seeker/upload_profile_picture.js') }}"></script>
@endsection