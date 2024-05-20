<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- @yield('title') --}}
        <title>SMKN 7 Bandar Lampung</title>
        <link rel="icon" type="image/png" href="{{ asset('asset/logo/logo_smk7.png') }}">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('style')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.7/r-3.0.2/datatables.min.css" rel="stylesheet">
        <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.7/r-3.0.2/datatables.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/daisyui@4.11.1/dist/full.min.css" rel="stylesheet" type="text/css" />
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="p-0 m-0">
        <div class="w-full">
            <div class="w-full h-screen bg-transparent fixed z-50 hidden loader">
                <div class="w-full h-full fixed flex justify-center items-center bg-black/20 z-50">
                    <span class="loading loading-spinner text-primary loading-lg"></span>
                </div>
            </div>
            <main class="w-full">
                @yield('content')
            </main>
        </div>
        <script>
            (function($){
                $.fn.show = function(){
                    this.removeClass('hidden');
                };

                $.fn.hide = function(){
                    this.addClass('hidden');
                };

                $('#js-table').DataTable({
                    columnDefs : [{
                            'target': '_all',
                            'className': 'dt-head-center'
                        },
                        {
                            'target': '_all',
                            'className': 'dt-body-center'
                        }
                    ],
                    responsive: true
                });
            })(jQuery);
        </script>
        @stack('script')
    </body>
</html>
