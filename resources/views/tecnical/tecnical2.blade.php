@extends('layout.layout')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="container-fluid">
    <div class="card mt-3">
        <div class="d-none justify-content-center containerSpinner" style="background: rgb(199 206 213 / 50%);height: 100%;
        position: absolute;width: 100%;z-index: 1000000;">
            <div class="spinner-border m-auto text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">b Padron de usuarios (CORTES)</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Padron de usuarios (REHABILITACION)</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="row">
                        <div class="col-lg-12 m-auto p-3 shadow containerRecordsCuts table-responsive">
                            <table id="tableCuts" class="w-100 table table-hover table-striped table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th width="3%" class="text-center">#</th>
                                        <th width="6%" class="text-center">Codigo</th>
                                        <th width="3%" class="text-center">Cod</th>
                                        <th width="6%" class="text-center">inscri</th>
                                        <th width="12%" class="text-center">cliente</th>
                                        <th width="9%" class="text-center">direccion</th>
                                        <th width="6%" class="text-center">tarifa</th>
                                        <th width="6%" class="text-center">medidor</th>
                                        <th width="3%" class="text-center">meses</th>
                                        <th width="9%" class="text-center">monto</th>
                                        <th width="6%" class="text-center">servicio</th>
                                        <th width="6%" class="text-center">consumo</th>
                                        <th width="6%" class="text-center">CORTAR</th>
                                        <th width="6%" class="text-center">EVIDENCIAS</th>
                                    </tr>
                                </thead>
                                <tbody id="recordsCourt">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="row">
                        <div class="col-lg-12 m-auto p-3 shadow containerRecordsRehab table-responsive">
                            <table id="tableRehab" class="w-100 table table-hover table-striped table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th width="3%" class="text-center">#</th>
                                        <th width="6%" class="text-center">Codigo</th>
                                        <th width="3%" class="text-center">Cod</th>
                                        <th width="6%" class="text-center">inscri</th>
                                        <th width="12%" class="text-center">cliente</th>
                                        <th width="9%" class="text-center">direccion</th>
                                        <th width="6%" class="text-center">tarifa</th>
                                        <th width="6%" class="text-center">medidor</th>
                                        <th width="3%" class="text-center">meses</th>
                                        <th width="9%" class="text-center">monto</th>
                                        <th width="6%" class="text-center">servicio</th>
                                        <th width="6%" class="text-center">consumo</th>
                                        <th width="6%" class="text-center">REHABILITAR</th>
                                        <th width="6%" class="text-center">EVIDENCIAS</th>
                                    </tr>
                                </thead>
                                <tbody id="recordsRehab">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var tableRecordsCuts;
var tableRecordsRehab;
$(document).ready( function ()
{
    tableRecordsCuts = $('.containerRecordsCuts').html();
    tableRecordsRehab = $('.containerRecordsRehab').html();
    fillRecords();
});
function courtUser(ele)
{
    event.preventDefault();
    Swal.fire({
    title: $(ele).is(':checked')?"Esta seguro de realizar corte?":"Esta seguro de cancelar el corte?",
    text: "Confirme la accion",
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
                url: "{{ route('courtUser') }}",
                method: 'POST',
                data: {state: $(ele).is(':checked'),inscription: $(ele).attr('data-inscription')},
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                success: function (r) {
                    console.log(r)
                    if(r.state)
                    {
                        if(r.checked)
                        {
                            $(ele).parent().parent().parent().css('background','rgba(255, 0, 0, 0.5)');
                            $(ele).parent().find('label').html('cortado');
                            $(ele).prop('checked', true);
                        }
                        else
                        {
                            $(ele).parent().parent().parent().css('background','none');
                            $(ele).parent().find('label').html('sin accion');
                            $(ele).prop('checked', false);
                        }
                    }
                    else
                        alert('Algo salio mal, porfavor contactese con el Administrador.');
                    Swal.fire({
                        title: r.message,
                        text: "La informacion fue registrada",
                        icon: r.state? "success" : "error",
                    });
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
    // -----------------------------------------
    // -----------------------------------------
    // -----------------------------------------
    // -----------------------------------------
    // -----------------------------------------
    // -----------------------------------------
    // -----------------------------------------
    // alert($(ele).attr('data-inscription'))
    // $(".containerSpinner").removeClass("d-none");
    // $(".containerSpinner").addClass("d-flex");
    // jQuery.ajax({
    //     url: "{{ route('courtUser') }}",
    //     method: 'POST',
    //     data: {state: $(ele).is(':checked'),inscription: $(ele).attr('data-inscription')},
    //     dataType: 'json',
    //     headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
    //     success: function (r) {
    //         console.log(r)
    //         if(r.state)
    //         {
    //             if($(ele).is(':checked'))
    //             {
    //                 $(ele).parent().parent().parent().css('background','rgba(255, 0, 0, 0.5)');
    //                 $(ele).parent().find('label').html('cortado');
    //             }
    //             else
    //             {
    //                 $(ele).parent().parent().parent().css('background','none');
    //                 $(ele).parent().find('label').html('sin accion');
    //             }
    //         }
    //         else
    //             alert('Algo salio mal, porfavor contactese con el Administrador.');
    //         $(".containerSpinner").removeClass("d-flex");
    //         $(".containerSpinner").addClass("d-none");
    //     },
    //     error: function (xhr, status, error) {
    //         alert("Algo salio mal, porfavor contactese con el Administrador.");
    //         $(".containerSpinner").removeClass("d-flex");
    //         $(".containerSpinner").addClass("d-none");
    //     }
    // });
}
function activateUser(ele)
{
    // alert( $(ele).is(':checked'))
    // alert('para activar--'+ $(ele).prop('checked'));
    event.preventDefault();
    Swal.fire({
    title: $(ele).is(':checked')?"Esta seguro de activar?":"Esta seguro de cancelar activacion?",
    text: "Confirme la accion",
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
                url: "{{ route('activateUser') }}",
                method: 'POST',
                data: {state: $(ele).is(':checked'),inscription: $(ele).attr('data-inscription')},
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                success: function (r) {
                    console.log(r)
                    if(r.state)
                    {
                        if(r.checked)
                        {
                            $(ele).parent().parent().parent().css('background','rgba(119, 163, 69, 0.5)');
                            $(ele).parent().find('label').html('Activado');
                            $(ele).prop('checked', true);
                        }
                        else
                        {
                            $(ele).parent().parent().parent().css('background','rgba(255, 255, 0, 0.5)');
                            $(ele).parent().find('label').html('Activar');
                            $(ele).prop('checked', false);
                        }
                    }
                    else
                        alert('Algo salio mal, porfavor contactese con el Administrador.');
                    Swal.fire({
                        title: r.message,
                        text: "La informacion fue registrada",
                        icon: r.state? "success" : "error",
                    });
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
    $(".containerSpinner").removeClass("d-none");
    $(".containerSpinner").addClass("d-flex");
    jQuery.ajax({
        url: "{{ route('listCourtAssign') }}",
        method: 'get',
        success: function (r) {
            // console.log(r);
            if(r.state)
            {
                let htmlCourt = '';
                let htmlRehab = '';
                let countRecords = 0;
                let accordingState = '';
                let stillCut = '';
                let optionCourt = '';
                let letterCourt = '';
                for (var i = 0; i < r.data.length; i++)
                {
                    countRecords++;
                    if(r.data[i].courtState=='4')
                    {
                        console.log('cortar a este '+r.data[i].numberInscription);
                        stillCut = 'rgba(255, 0, 0, 0.5)';
                        optionCourt = "checked";
                        letterCourt = "cortado";
                    }
                    else
                    {
                        stillCut = 'none';
                        optionCourt = "";
                        letterCourt = "sin accion";
                    }

                    htmlCourt += '<tr style="background: '+stillCut+';">' +
                        '<td class="align-middle text-center">' + countRecords + '</td>' +
                        '<td class="align-middle text-center">' + novDato(r.data[i].code) + '</td>' +
                        '<td class="align-middle text-center">' + novDato(r.data[i].cod) + '</td>' +
                        '<td class="align-middle text-center">' + novDato(r.data[i].numberInscription) + '</td>'+
                        '<td class="align-middle">' + novDato(r.data[i].client) + '</td>'+
                        '<td class="align-middle">' + novDato(r.data[i].streetDescription) + '</td>'+
                        '<td class="align-middle text-center">' + novDato(r.data[i].rate) + '</td>'+
                        '<td class="align-middle text-center">' + novDato(r.data[i].meter) + '</td>'+
                        '<td class="align-middle text-center">' + novDato(r.data[i].monthDebt) + '</td>'+
                        '<td class="align-middle text-center">' + novDato(r.data[i].amount) + '</td>'+
                        '<td class="align-middle text-center">' + novDato(r.data[i].serviceEnterprise) + '</td>'+
                        '<td class="align-middle text-center">' + novDato(r.data[i].consumption) + '</td>'+
                        '<td class="align-middle text-center">' +
                            '<div class="form-check form-switch">' +
                                '<label class="fw-bold">'+letterCourt+'</label>' +
                                '<input type="checkbox" class="form-check-input" onclick="courtUser(this)" data-inscription="'+r.data[i].numberInscription+'" '+optionCourt+'>' +
                            '</div>' +
                        '</td>' +
                        '<td class="align-middle text-center">' +
                            '<div class="mb-3">' +
                                '<input class="form-control" type="file" id="formFile">' +
                            '</div>' +
                            // '<input type="file" id="imageFile" accept="image/*">' +
                        '</td>' +
                    '</tr>';
                    paid = 'none';
                    accordingState = 'cortado o se olvido de cortar';
                    if(r.data[i].paid=='1')
                    {
                        // console.log(r.data[i].numberInscription);
                        paid = "rgba(255, 255, 0, 0.5);";

                        accordingState = '<div class="form-check form-switch">' +
                            '<input type="checkbox" class="form-check-input" onclick="activateUser(this)" data-inscription="'+r.data[i].numberInscription+'">' +
                            '<label class="form-check-label fw-bold">Activar</label>' +
                        '</div>' ;

                    }
                    else
                    {
                        // console.log(r.data[i].courtState)
                        if(r.data[i].courtState=='4')
                        {
                            accordingState = '<span class="badge rounded-pill bg-danger">Cortado</span>';
                        }
                        else
                        {
                            accordingState = '<span class="badge rounded-pill bg-warning">Sin cortar</span>';
                        }
                    }
                    if(r.data[i].paid=='1' && r.data[i].courtState=='1')
                    {
                        // console.log(r.data[i].numberInscription);
                        paid = "rgba(119, 163, 69, 0.5);";

                        accordingState = '<div class="form-check form-switch">' +
                            '<input type="checkbox" class="form-check-input" onclick="activateUser(this)" data-inscription="'+r.data[i].numberInscription+'" checked>' +
                            '<label class="form-check-label fw-bold">Activado</label>' +
                        '</div>' ;

                    }
                    // if(r.data[i].courtState=='4')
                    htmlRehab += '<tr style="background: '+ paid +'">' +
                        '<td class="align-middle text-center">' + countRecords + '</td>' +
                        '<td class="align-middle text-center">' + novDato(r.data[i].code) + '</td>' +
                        '<td class="align-middle text-center">' + novDato(r.data[i].cod) + '</td>' +
                        '<td class="align-middle text-center">' + novDato(r.data[i].numberInscription) + '</td>'+
                        '<td class="align-middle">' + novDato(r.data[i].client) + '</td>'+
                        '<td class="align-middle">' + novDato(r.data[i].streetDescription) + '</td>'+
                        '<td class="align-middle text-center">' + novDato(r.data[i].rate) + '</td>'+
                        '<td class="align-middle text-center">' + novDato(r.data[i].meter) + '</td>'+
                        '<td class="align-middle text-center">' + novDato(r.data[i].monthDebt) + '</td>'+
                        '<td class="align-middle text-center">' + novDato(r.data[i].amount) + '</td>'+
                        '<td class="align-middle text-center">' + novDato(r.data[i].serviceEnterprise) + '</td>'+
                        '<td class="align-middle text-center">' + novDato(r.data[i].consumption) + '</td>'+
                        '<td class="align-middle text-center">' +
                            accordingState +
                        '</td>' +
                        '<td class="align-middle text-center">' +
                            '<div class="mb-3">' +
                                '<input class="form-control" type="file" id="formFile">' +
                            '</div>' +
                            // '<input type="file" id="imageFile" accept="image/*">' +
                        '</td>' +
                    '</tr>';
                }
                $('#recordsCourt').html(htmlCourt);
                $('#recordsRehab').html(htmlRehab);
                initDatatable('tableCuts');
                initDatatable('tableRehab');
                // $('.containerSpinner').css('display','none !important');
            }
            else
            {
                alert(r.message);
            }
            $(".containerSpinner").removeClass("d-flex");
            $(".containerSpinner").addClass("d-none");
        },
        error: function (xhr, status, error) {
            console.log("Algo salio mal, porfavor contactese con el Administrador.");
        }
    });
}

</script>
@endsection
