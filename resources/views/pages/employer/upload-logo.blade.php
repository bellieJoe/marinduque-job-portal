@extends('app')
@section('title', '- Upload Logo')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/employer/upload-logo.css') }}">
    <body class="upload-logo ">

        <div id="upload_logo" class="wrapper mx-auto">

            <section class="col-lg-5 col-md-8 my-5 bg-white shadow-sm py-5 px-4 mx-2">
                <h4 class="fw-bold head mb-4">Upload logo</h4>
                <clipper-upload class="btn p-3 fs-5 image-selector w-100" v-model="imageData">
                    <i class="fa fa-image me-2"></i> Select Image
                </clipper-upload>
                <clipper-fixed v-if="imageData" class=" bg-light cropper my-4 " 
                ref="clipper"
                :src="imageData"
                preview="prev"
                ratio = "1"
                {{-- border-color="lightgray" --}}
                {{-- border = "2" --}}
                area="100"
                bg-color="white"
                >
                </clipper-fixed>
                <button class="btn btn-primary btn-lg w-100 mt-4" @click="uploadLogo">Upload</button>
                {{-- <clipper-preview class="w-50 mx-auto shadow-sm mb-2" name="prev"></clipper-preview> --}}
            </section>

        </div>
        
    </body>
    <script src="{{ asset('js/pages/employer/upload-logo.js') }}"></script>
@endsection