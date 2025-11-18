@extends('layout.layout')
@section('content')

<div class="container-fluid mt-1">
    <div class="card shadow bg-light">
        <div class="card-header">
            <h6 class="m-0">Lista de asignaciones del ultimo periodo programado</h6>
        </div>
        <div class="d-none justify-content-center containerSpinner" style="background: rgb(199 206 213 / 50%);height: 100%;
        position: absolute;width: 100%;z-index: 1000000;">
            <div class="spinner-border m-auto text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 table-responsive">
                    <table id="tableCuts" class="w-100 table table-hover table-striped table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th class="text-center" data-priority="1">DNI</th>
                                <th class="text-center" data-priority="2">TECNICO</th>
                                <th class="text-center" data-priority="2">RUTAS</th>
                                <th class="text-center" data-priority="3">ETIQUETA</th>
                                <th class="text-center" data-priority="3">CANT.</th>
                                <th class="text-center" data-priority="1">OPCIONES</th>
                            </tr>
                        </thead>
                        <tbody id="recordsAssign">
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    localStorage.setItem('nba',2)
$(document).ready( function ()
{
    $('.overlayPage').css("display","none");
    fillRecords();
    // ---
});
// $('.deleteRecords').on('click',function(){
//     alert('aki')
// })
function deleteRecords(idAss)
{
    event.preventDefault();
    Swal.fire({
    title: "Esta seguro de eliminar la asignacion?",
    text: "Confirme la accion ¿DESEA CONTINUAR?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, confirmar"
    }).then((result) => {
        if (result.isConfirmed)
        {
            $(".containerSpinner").removeClass("d-none");
            $(".containerSpinner").addClass("d-flex");
            jQuery.ajax({
                url: "{{ route('deleteAssign') }}",
                method: 'POST',
                data: {idAss: idAss},
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                success: function (r) {
                    console.log(r)
                    Swal.fire({
                        title: r.message,
                        text: r.state?"La asignacion fue eliminada":'',
                        icon: r.state? "success" : "error",
                    });
                    if(r.state)
                    {
                        $('#recordsAssign').html('');
                        fillRecords()
                    }
                    $(".containerSpinner").removeClass("d-flex");
                    $(".containerSpinner").addClass("d-none");
                },
                error: function (xhr, status, error) {
                    alert("Algo salio mal, porfavor contactese con el Administrador.");
                    $(".containerSpinner").removeClass("d-flex");
                    $(".containerSpinner").addClass("d-none");
                }
            });

        }
        else
            $(ele).prop('checked', false);
    });
}
function fillRecords()
{
    $(".containerSpinner").removeClass("d-none").addClass("d-flex");
    jQuery.ajax({
        url: "{{ route('listAssign') }}",
        method: 'get',
        success: function (r) {
            if(r.state)
            {
                $('#recordsAssign').html('');
                let html = '';
                let month='';
                for (var i = 0; i < r.data.length; i++)
                {
                    month = r.data[i].monthDebt==2?'2':'>=3';
                    html += '<tr>' +
                        '<td class="align-middle text-center">' + novDato(r.data[i].dni) + '</td>' +
                        '<td class="align-middle">' + novDato(r.data[i].name) + '</td>' +
                        '<td class="align-middle text-center">' + novDato(r.data[i].routes) + '</td>' +
                        '<td class="align-middle text-center">' + novDato(r.data[i].flat) + '</td>'+
                        '<td class="align-middle text-center"><i class="fa fa-list"></i> ' + novDato(r.data[i].cant) + '</td>'+
                        '<td class="align-middle text-center">' +
                            '<button class="btn btn-danger btn-delete" onclick="deleteRecords('+r.data[i].idAss+')"><i class="fa fa-trash"></i></button>'
                        '</td>' +
                    '</tr>';
                }
                $('#recordsAssign').html(html);
                tippy('.btn-delete', {
                    content: 'Eliminar asignacion',
                    placement: 'top'
                });
            }
            else
                alert(r.message);
            $(".containerSpinner").removeClass("d-flex").addClass("d-none");
            // $('.overlayPage').css("display","none");
        },
        error: function (xhr, status, error) {
            console.log("Algo salio mal, porfavor contactese con el Administrador.");
        }
    });
}
</script>
@endsection
