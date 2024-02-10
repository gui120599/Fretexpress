<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel')}} - @yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">



        <script src="{{asset('js/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>


        <!-- CSS -->
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-100 font-sans antialiased">
        <div class="flex h-screen overflow-hidden">
            @include('layouts.navigation')

            <!-- Page Content -->
            <main class="flex-1 ">

                {{--@include('layouts.navbar')--}}

                <!-- Conteúdo da Página -->
                <div class="bg-white m-3 p-2 rounded shadow overflow-y-auto h-screen">

                    <!-- Conteúdo da sua página aqui -->
                    @yield('content')

                </div>
            </main>
        </div>

        <!-- Modal -->
        <div class="modal-container hidden h-screen w-full fixed left-0 top-0 flex justify-center items-center bg-black bg-opacity-50 animate-[from_1s_ease-in-out_infinite]">
            <div class="bg-white rounded shadow-lg w-11/12 xl:w-1/2" style="max-height: 80vh; overflow-y: auto;">
                <!-- Modal Header -->
                <div class="border-b px-4 py-2 flex justify-between items-center">
                    @yield('modal-title')
                    <i class='bx bxs-x-circle fechar-modal cursor-pointer text-4xl' id="fechar-modal"></i>
                </div>
                <!--Modal Body -->
                @yield('modal-content')
            </div>
        </div>

        <!-- Scripts -->
        <script src="{{ asset('js/main.js') }}"></script>


    </body>
</html>
