<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="{{asset('eslu/public/js/jquery-3.7.1.min.js')}}"></script>
    <!-- Bootstrap CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="{{asset('eslu/public/plugins/bootstrap5/bootstrap.min.css')}}">

    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css"> --}}
    <link rel="stylesheet" href="{{asset('eslu/public/css/spinnerPage.css')}}">
    <script src="{{asset('eslu/public/plugins/sweetalert2/sweetalert2.11.js')}}"></script>
<link rel="stylesheet" href="{{asset('eslu/public/plugins/daterangepicker/daterangepicker.css')}}">
<script src="{{asset('eslu/public/plugins/daterangepicker/moment.min.js')}}"></script>
<script src="{{asset('eslu/public/plugins/daterangepicker/daterangepicker.js')}}"></script>
{{-- ------------------- --}}
<link rel="stylesheet" href="{{asset('eslu/public/css/tempusdominus-bootstrap-4.min.css')}}" />
    <!-- Incluir datetimepicker JS -->
    <script src="{{asset('eslu/public/js/moment.min.js')}}"></script>
    <script src="{{asset('eslu/public/js/tempusdominus-bootstrap-4.min.js')}}"></script>
{{-- ------------------- --}}
<script src="{{asset('eslu/public/js/popper.min.js')}}"></script>
<script src="{{asset('eslu/public/js/tippy-bundle.umd.js')}}"></script>
{{-- ----------- --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EMUSAP</title>
  </head>
  <body>
    <div class="overlayPage">
        <div class="loadingio-spinner-spin-i3d1hxbhik m-auto">
            <div class="ldio-onxyanc9oyh">
                <div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div>
            </div>
        </div>
    </div>
    @include('layout.sections.navbar')
    @yield('content')

    <script src="{{asset('eslu/public/js/helper.js')}}"></script>
    {{-- <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script> --}}
    <script src="{{asset('eslu/public/js/bootstrap.bundle.min.js')}}"></script>
    {{-- --- --}}
<script src="{{asset('eslu/public/plugins/validate/jquery.validate.min.js')}}"></script>
<!-- transJQV -->
<script src="{{asset('eslu/public/plugins/validate/translateValidate.js')}}"></script>
<script>
    navBarActive()
</script>
  </body>
</html>
