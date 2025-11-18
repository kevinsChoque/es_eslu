<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <title>EMUSAP</title>
        <link rel="stylesheet" href="{{asset('escn/public/css/spinnerPage.css')}}">
        <script src="{{asset('escn/public/plugins/sweetalert2/sweetalert2.11.js')}}"></script>
        {{-- <script src="{{asset('escn/public/js/helper.js')}}"></script> --}}
    </head>
    <body style="background-image: linear-gradient(to right, rgb(49 76 181), rgb(3 97 18));">
        <div class="overlayPage">
            <div class="loadingio-spinner-spin-i3d1hxbhik m-auto">
                <div class="ldio-onxyanc9oyh">
                    <div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row" style="height: 100vh;">
                <div class="col-md-6 m-auto">
                    <div class="card" style="background-color: rgba(255, 255, 255, 0.5);">
                        <form id="fvLogin">
                            <div class="card-body shadow text-center">
                                {{-- <img src="{{asset('escn/public/bannerLogin.png')}}" class="img-fluid rounded-top"/> --}}
                                {{-- <h3>MODULO DE LECTURAS</h3> --}}
                                {{-- cascas --}}
                                <div class="container mt-4">
                                    <h3 class="text-white fw-bold border-bottom border-primary pb-2">
                                        <i class="fas fa-bolt me-2"></i> MÓDULO DE LECTURAS
                                    </h3>
                                </div>


                                {{-- cascas --}}
                                <br>
                                <div class="form-floating">
                                    <input type="text" class="form-control onlyNumbers" id="dni" name="dni" placeholder="DNI" maxlength="8">
                                    <label for="dni">DNI</label>
                                </div>
                                <br>
                                {{-- <div class="form-floating">
                                    <input type="password" class="form-control" id="password" name="password"  placeholder="Contraseña">
                                    <label for="password">Contraseña</label>
                                </div> --}}
                                {{-- <br> --}}
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary sig-in" type="button">Ingresar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
        $(document).ready( function () {
            $('.overlayPage').css("display","none");
        } );
        $('.sig-in').on('click',function(){
            var formData = new FormData($("#fvLogin")[0]);
            $('.sig-in').prop('disabled',true);
            $('.overlayPage').css("display","flex");
            jQuery.ajax({
                url: "{{ route('login') }}",
                method: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                success: function (r) {
                    console.log(r)
                    if (r.estado)
                        window.location.href = "{{route('home')}}";
                    else
                    {
                        $('.overlayPage').css("display","none");
                        $('.sig-in').prop('disabled',false);
                        // msjRee(r);
                        notifyGlobal(r)
                    }
                },
                error: function (xhr, status, error) {
                    $('.overlayPage').css("display","none");
                    $('.sig-in').prop('disabled',false);
                    console.log(false,'Ocurrio un problema, porfavor contactese con el administrador');
                }
            });
        });
    </script>
    <script src="{{asset('escn/public/js/helper.js')}}"></script>
</html>
