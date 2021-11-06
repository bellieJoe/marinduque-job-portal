<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://kit.fontawesome.com/2a90b2a25f.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/app_sample.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <title>Proof View</title>
</head>
<body>

    @php
        $extension = explode(".",$proof->title)[1];
    @endphp

    @if($extension == 'pdf')
    <embed src="/storage/proofs/{{ $proof->user_id }}/{{ $proof->title }}"  class="mx-auto w-screen h-screen" type="application/pdf">
    @else
    <img src="/storage/proofs/{{ $proof->user_id }}/{{ $proof->title }}"  class="mx-auto w-screen h-auto">
    @endif
    

</body>
</html>