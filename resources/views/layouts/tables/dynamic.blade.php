<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Pelanggan</title>

    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    {{-- Font Awesome --}}
    <script src="https://kit.fontawesome.com/e0e5d17da7.js" crossorigin="anonymous"></script>
    {{-- Datatable CSS --}}
    <link rel="stylesheet" href="{{ asset('datatable/dataTables.bootstrap4.min.css') }}">
    {{-- SweetAlert --}}
    <link rel="stylesheet" href="{{ asset('sweetalert/sweetalert2.min.css') }}">
    {{-- Toastr --}}
    <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}">
    {{-- Library Jquery Select2 CSS --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <style>
        .tab {
            width: 100%;
            margin: auto;
            padding: 0 2em;
            border-radius: 0.5rem;
            background-color: rgb(224, 162, 28);
            line-height: 5em;
            font-weight: bold;
            font-size: 12px;
            white-space: nowrap;
            overflow: auto;
            transition: all 0.5s linear;
            box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.904);
            text-align: center;
        }

        .tab-items {
            margin: 0;
            padding: 0;
            list-style: none;
            display: inline-grid;
            grid-gap: 0em;
            transition: color 5s ease-in;
            /* line-height: 20px; */
        }

        .tab-items> :nth-child(1) {
            grid-column: 1/2;

        }

        .tab-items> :nth-child(2) {
            grid-column: 2/3;
        }

        .tab-items> :nth-child(3) {
            grid-column: 3/4;
        }


        /* .tab-items> :nth-child(4) {
            grid-column: 4/5;
        }

        .tab-items> :nth-child(5) {
            grid-column: 5/6;
        } */

        .tab-item {
            display: inline;
            grid-row: 1/2;
        }

        .tab-item.active .item-link {
            color: rgb(74, 167, 167);
        }

        .item-link {
            padding: 0 0.75em;
            color: #fff;
            text-decoration: none;
            display: inline-block;
            transition: color 256ms;
        }

        .item-link:hover {
            color: #297;
            text-decoration: underline;
        }

        .tab-indicator {
            height: 3px;
            background-color: yellow;
            border-radius: 3px 3px 0 0;
            grid-column: var(--index)/span 1 !important;
            grid-row: 1/2;
            align-self: end;
        }

    </style>

</head>

<body>
    <div class="container" style="margin-bottom: 100px;">
        <div class="header mt-5 text-center mb-4">
            <h2 class="text-uppercase font-weight-bold">
                @yield('pageTitle')
            </h2>
        </div>
        <div class="content">
            @yield('content')
        </div>
    </div>

    <footer id="footer">
        <!--Footer-->
        @yield('tabsMenu')

    </footer>
    <!--/Footer-->

    <script src="{{ asset('jquery/jquery.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    {{-- Datatable JS --}}
    <script src="{{ asset('datatable/jquery.dataTables.min.js') }}"></script>
    <script src="//cdn.datatables.net/plug-ins/1.11.4/api/fnReloadAjax.js"></script>
    <script src="{{ asset('datatable/dataTables.bootstrap4.min.js') }}"></script>
    {{-- SweetAlert --}}
    <script src="{{ asset('sweetalert/sweetalert2.min.js') }}"></script>
    {{-- Toastr --}}
    <script src="{{ asset('toastr/toastr.min.js') }}"></script>
    {{-- Library Jquery Select2 --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    @yield('footer-scripts')
</body>

</html>
