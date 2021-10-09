<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="_token" content="{!! csrf_token() !!}" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ url('image').'/website/favicon.png' }}" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    
    <script src="https://kit.fontawesome.com/2a90b2a25f.js" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <title>Job Hunter @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app_sample.css') }}">

    {{-- <style>
        /* @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');  */
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100&family=Ubuntu&display=swap');
        * :not(i) {
            font-family: 'Ubuntu' !important; 
    
        },

    </style> --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body>
    <div>{{ $printable }}</div>
     {{-- <div class=" mx-auto lg:w-10/12"> <div> <h3 class="font-bold text-lg">Job seeker List</h3> </div> <table class="table-auto w-full shadow-md border-black bg-white my-4"> <tbody><tr class="bg-gray-400 sticky"> <th class="p-2"><a href="/admin/job-seekers?sort=desc&amp;column=firstname">Name <i class="fa fa-sort ms-2" aria-hidden="true"></i></a></th> <th class="p-2"><a href="/admin/job-seekers?sort=desc&amp;column=address">Address <i class="fa fa-sort ms-2" aria-hidden="true"></i></a></th> <th class="p-2"><a href="/admin/job-seekers?sort=desc&amp;column=email">Email Address <i class="fa fa-sort ms-2" aria-hidden="true"></i></a></th> <th class="p-2"><a href="/admin/job-seekers?sort=desc&amp;column=contact_number">Contact Number <i class="fa fa-sort ms-2" aria-hidden="true"></i></a></th> <th class="p-2">Status</th> </tr> <tr class="odd:bg-white even:bg-white hover:bg-indigo-200"> <td class="p-2">Bellie J. Jandusay</td> <td class="p-2">Poras, Boac, Marinduque</td> <td class="p-2">akosibatman@boranora.com</td> <td class="p-2">09493131426</td> <td class="p-2"> <a href="/admin/job-seekers/deactivate/4" @click="toggleLoading" class="btn btn-secondary btn-sm">Deactivate</a> </td> </tr> <tr class="odd:bg-white even:bg-white hover:bg-indigo-200"> <td class="p-2">Jonas Emmanuel N. Opis</td> <td class="p-2">Tampus, Boac, Marinduque</td> <td class="p-2">jonasem1799@gmail.com</td> <td class="p-2">09672535817</td> <td class="p-2"> <a href="/admin/job-seekers/deactivate/15" @click="toggleLoading" class="btn btn-secondary btn-sm">Deactivate</a> </td> </tr> <tr class="odd:bg-white even:bg-white hover:bg-indigo-200"> <td class="p-2">Timothy Q. Ferrer</td> <td class="p-2">Bacong-bacong, Gasan, Marinduque</td> <td class="p-2">lyosra.be@816qs.com</td> <td class="p-2">09123456789</td> <td class="p-2"> <a href="/admin/job-seekers/deactivate/16" @click="toggleLoading" class="btn btn-secondary btn-sm">Deactivate</a> </td> </tr> <tr class="odd:bg-white even:bg-white hover:bg-indigo-200"> <td class="p-2">Vincent A. Monleon</td> <td class="p-2">Poras, Boac, Marinduque</td> <td class="p-2">3larainet@villastream.xyz</td> <td class="p-2"></td> <td class="p-2"> <a href="/admin/job-seekers/deactivate/19" @click="toggleLoading" class="btn btn-secondary btn-sm">Deactivate</a> </td> </tr> <tr class="odd:bg-white even:bg-white hover:bg-indigo-200"> <td class="p-2">Mark Aeron E. Abela</td> <td class="p-2">Sihi, Buenavista, Marinduque</td> <td class="p-2">reduardo.mendes0l@247demo.online</td> <td class="p-2">09283798988</td> <td class="p-2"> <a href="/admin/job-seekers/deactivate/21" @click="toggleLoading" class="btn btn-secondary btn-sm">Deactivate</a> </td> </tr> </tbody></table> <div> <h5 class="text-md">Total no. of Job Seekers: <span class="font-bold">5</span></h5> </div> <div> <form action="/print" method="post"> <input type="hidden" name="_token" value="YuRIU3tRG1xSYkpeaKlb4mt9bthcG4AGkDkFt3QZ"> <input type="hidden" name="printable" :value="printable"> <button>Print this page</button> </form> </div> </div> --}}
</body>

</html>