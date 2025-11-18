<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">EMUSAP</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item nb1"><a class="nav-link" href="{{route('home')}}">Padron</a></li>
              @if(Session::has('tecnical') && Session::get('tecnical')->type=="admin")
              <li class="nav-item nb2"><a class="nav-link" aria-current="page" href="{{route('showAssignTecnical')}}">Asignaciones</a></li>
              {{-- <li class="nav-item nb2"><a class="nav-link" href="{{route('showReport')}}">Asignaciones</a></li> --}}
              <li class="nav-item nb3"><a class="nav-link" href="{{route('showReport')}}">Reportes</a></li>
              @endif
            </ul>
          <div class="d-flex">

            @if(Session::has('tecnical'))
            <h6 class="m-auto fw-bold">{{Session::get('tecnical')->dni}} | {{Session::get('tecnical')->name}}</h6>
            @endif

            <button class="btn btn-outline-success ms-2 logout">Cerrar sesion</button>
            {{-- @if(Session::has('user'))
            <button class="btn btn-outline-success ms-2 logout">Cerrar sesion</button>
            @else
            <button class="btn btn-outline-success mLogin">Ingresar</button>
            @endif --}}
          </div>
      </div>
    </div>
</nav>
<script>
$(document).ready( function () {
//   sideBarActive();
} );

function sideBarActive()
{
  if(localStorage.getItem("nb_esco")==1)
  {
      $('.nb1').addClass('shadow bg-primary rounded fw-bold');
      $('.nb1>a').addClass('active');
  }
  if(localStorage.getItem("nb_esco")==2)
  {
      $('.nb2').addClass('shadow bg-primary rounded fw-bold');
      $('.nb2>a').addClass('active');
  }
  if(localStorage.getItem("nb_esco")==3)
  {
      $('.nb3').addClass('shadow bg-primary rounded fw-bold');
      $('.nb3>a').addClass('active');
  }
}
$('.logout').on('click',function(){
    Swal.fire({
        title: "Finalizar Sesion",
        text: "¿Esta seguro de cerrar sesion?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#28a745",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, cerrar sesion!",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            $('.overlayPagina').css("display","flex");
            localStorage.removeItem('__LISTLECTURA__');
            window.location.href = "{{route('logout')}}";
        }
    });
});
</script>
