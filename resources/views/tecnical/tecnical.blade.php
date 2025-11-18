@extends('layout.layout')
@section('content')

<script src="{{asset('eslu/public/js/dropzone-min.js')}}"></script>
<link rel="stylesheet" href="{{asset('eslu/public/css/dropzone.css')}}">
<div class="container mt-1">
    <div class="col-lg-12">
        <button class="btn btn-primary w-100" onclick="actualizarDatos();">Actualizar datos</button>
    </div>
</div>

<div class="container-fluid mt-3">
    <div class="row containerTask">
    </div>
</div>
<div class="container-fluid">
    <div class="card mt-3">
        <div class="d-none justify-content-center containerSpinner" style="background: rgb(199 206 213 / 50%);height: 100%;
        position: absolute;width: 100%;z-index: 1000000;">
            <div class="spinner-border m-auto text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div class="card-header">
            <h6 class="fw-bold m-0"><i class="fa fa-list"></i> PADRON DE LECTURAS MAYO 2025</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 m-auto p-3 shadow containerRecordsCuts table-responsive px-0">
                    <table id="tableCuts" class="w-100 table table-hover table-striped table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th width="3%" class="text-center" data-priority="2">#</th>
                                <th width="6%" class="text-center" data-priority="1">Codigo</th>
                                <th width="6%" class="text-center" data-priority="3">inscri</th>
                                <th width="12%" class="text-center" data-priority="2">cliente</th>
                                <th width="9%" class="text-center" data-priority="5">direccion</th>
                                <th width="6%" class="text-center" data-priority="6">tarifa</th>
                                <th width="6%" class="text-center" data-priority="4">Medidor</th>
                                <th width="6%" class="text-center" data-priority="1">Lectura</th>
                                <th width="6%" class="text-center" data-priority="1">Enviar</th>
                            </tr>
                        </thead>
                        <tbody id="recordsCourt">
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalEvidence" tabindex="-1" aria-labelledby="modalEvidenceLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEvidenceLabel"><i class="fa fa-tint"></i> Subir evidencia o foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>Datos del usuario</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Codigo-cod:</strong> <span class="showCod"></span></li>
                    <li class="list-group-item"><strong>Inscripcion:</strong> <span class="showIns"></span></li>
                    <li class="list-group-item"><strong>Cliente:</strong> <span class="showCli"></span></li>
                    <li class="list-group-item"><strong>Direccion:</strong> <span class="showDir"></span></li>
                </ul>
                <br>
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-load-tab" data-bs-toggle="pill" data-bs-target="#pills-load" type="button" role="tab" aria-controls="pills-load" aria-selected="true">Subir evidencias</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-show-evidence-tab" data-bs-toggle="pill" data-bs-target="#pills-show-evidence" type="button" role="tab" aria-controls="pills-show-evidence" aria-selected="false">Ver evidencias subidas</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-load" role="tabpanel" aria-labelledby="pills-load-tab">
                        <form method="post" enctype="multipart/form-data" class="dropzone dz-clickable h-100 text-center" id="dzLoadEvidence">
                            <input type="hidden" id="inscription" name="inscription">
                            <input type="hidden" id="type" name="type">
                            <div>
                                <h6 class="text-center font-weight-bold">Archivos subidos</h6>
                            </div>
                            <div class="dz-default dz-message">
                                <span class="font-weight-bold font-italic">Suelta el archivo o realiza click para cargar archivos <span class="text-warning">(<5MB)</span></span>
                            </div>
                            @csrf
                        </form>
                    </div>
                    <div class="tab-pane fade" id="pills-show-evidence" role="tabpanel" aria-labelledby="pills-show-evidence-tab">
                        <div class="alert alert-info messageEvidences" style="display: none;">
                            <p class="m-0 fw-bold">No cuenta con evidencias guardadas.</p>
                        </div>
                        <button class="btn btn-primary w-100 mb-2" onclick="updateImage()"><i class="fa fa-sync"></i> Actualizar imagenes</button>
                        <div class="row containerEvidences">
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary saveEvidence"><i class="fa fa-save"></i> Guardar evidencias</button>
            </div>
        </div>
    </div>
</div>

<button id="btnBuscarFlotante" style="
    position: fixed;
    bottom: 20px;
    left: 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    font-size: 24px;
    cursor: pointer;
    z-index: 1000;">
    🔍
</button>
<!-- Panel flotante con input de búsqueda -->
<div id="panelBusqueda" style="
    position: fixed;
    bottom: 80px;
    left: 20px;
    background: white;
    padding: 10px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
    display: none;
    z-index: 1001;">
    <input type="text" id="busquedaFlotante" placeholder="Buscar en la tabla..." class="form-control" />
</div>
<script>
    $(document).ready(function () {
        let panelVisible = false;
        $('#btnBuscarFlotante').on('click', function () {
            panelVisible = !panelVisible;
            $('#panelBusqueda').toggle(panelVisible);
            if (panelVisible) {
                $('#busquedaFlotante').focus();
            } else {
                // Limpiar filtro cuando se cierra el panel
                $('#busquedaFlotante').val('');
                tabletest.search('').draw(); // quitar filtro
            }
        });
        $('#busquedaFlotante').on('input', function () {
            tabletest.search($(this).val()).draw();
        });
    });
</script>
<style>
    .activate-row{background: rgba(0, 255, 0, 0.5) !important;}
    .green-row{background: rgba(119, 163, 69, 0.5) !important;}
    .blue-row{background: rgba(0, 0, 255, 0.5) !important;}
    .red-row{background: rgba(255, 0, 0, 0.5) !important;}
    .none-row{background: none !important;}
    .selected-task{background: rgb(31 208 58 / 50%) !important;}
    .emu-la{
        font-weight: bold;
        color: #0d6efd !important;
    }
</style>

<script>
var tableRecordsCuts;
var tableRecordsRehab;
var tableRecordsBlue;
var tabletest;
// Dropzone.options.myDropzone = false;
// Dropzone.autoDiscover = false;
var myDropzone = '';
var myDropzoneObs = '';
$(document).ready( function ()
{
    // console.log("{{ asset('storage/') }}")
    tableRecordsCuts = $('.containerRecordsCuts').html();
    // tableRecordsRehab = $('.containerRecordsRehab').html();
    // tableRecordsBlue = $('.containerRecordsBlue').html();
    // fillRecords();
    fillRecords2();
    fillTask();
    initDropzone();
});

function loadAssign(ele)
{
    // alert($(ele).attr('data-idAss'))
    $('.containerRecordsCuts>div').remove();
    $('.containerRecordsCuts').html(tableRecordsCuts);
    fillRecords3($(ele).attr('data-idAss'))
    $('.selected-task').removeClass('selected-task');
    $(ele).find('.card').addClass('selected-task');
}

function fillTask()
{
    jQuery.ajax({
        url: "{{ route('fillTask') }}",
        method: 'POST',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
        success: function (r) {
            if(r.state)
            {
                let html = '';
                let selected;
                let counter = 1;
                let idAss = "{{Session::get('assign')->idAss}}";
                for (var i = 0; i < r.data.length; i++)
                {
                    selected = idAss==r.data[i].idAss?'selected-task':'';
                    counter += i;
                    html += '<div class="col-lg-2" onclick="loadAssign(this)" style="cursor: pointer;" data-idAss="'+r.data[i].idAss+'">'+
                        '<div class="card shadow '+selected+'">'+
                            '<div class="card-body p-1">'+
                                '<h5 class="card-title"><i class="fa fa-list"></i> Tarea '+counter+'</h5>'+
                                // '<h6 class="card-subtitle text-muted">Etiqueta: '+r.data[i].flat+'</h6>'+
                                '<h6 class="card-subtitle text-muted">Rutas: '+r.data[i].routes+'</h6>'+
                                '<h6 class="card-subtitle text-muted">Cant.reg: '+r.data[i].cant+'</h6>'+
                                // '<p class="card-text">Cant.reg: '+r.data[i].cant+'</p>'+
                            '</div>'+
                        '</div>'+
                    '</div>';
                }
                $('.containerTask').html(html);
            }
            else
                alert(r.message);
        },
        error: function (xhr, status, error) {
            alert("Algo salio mal, porfavor contactese con el Administrador.");
        }
    });

}
function notify(resp)
{
    const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
    });
    Toast.fire({
    icon: resp.state?"success":"error",
    title: resp.message,
    });
}
function cutUpdateLs(inscription,action)
{
    var listObject = JSON.parse(localStorage.getItem('__LISTCUT__'));
    for (var i = 0; i < listObject.length; i++)
    {
        if (listObject[i].numberInscription === inscription) {
            listObject[i].courtState = action ? '4':null;
            break;
        }
    }
    var updatedListString = JSON.stringify(listObject);
    localStorage.setItem('__LISTCUT__', updatedListString);
    return updatedListString;
    console.log('Datos actualizados en localStorage');
}

var arow;
function updateRecords()
{
    buildTable();
    fillRecords();
}
function buildTable()
{
    $('.containerRecordsCuts>div').remove();
    $('.containerRecordsCuts').html(tableRecordsCuts);
}
function saveLsLec(ele)
{
    let valor = $(ele).val();

    // Si contiene letras (o cualquier cosa que no sea número), detiene todo
    if (/[^0-9]/.test(valor)) {
        $(ele).val(valor.replace(/[^0-9]/g, ''));
        // alert('Solo se permiten números');
        return;
    }
    // --------------------------
    let listObject = JSON.parse(localStorage.getItem('__LISTCUT__')) || [];
    if (!Array.isArray(listObject))
    {console.error("Error: __LISTCUT__ no es un array válido.");return;}
    let item = listObject.find(obj => obj.inscription === $(ele).attr('data-ins'));
    if (item)
    {
        let valorLectura = $(ele).val().trim();
        item.lec = valorLectura !== '' ? valorLectura : ''; // Evita asignar `undefined` o `null`
        localStorage.setItem('__LISTCUT__', JSON.stringify(listObject));
    }
    else
        console.warn("No se encontró la inscripción:", $(ele).attr('data-ins'));
}
function saveLsObs(ele)
{
    let listObject = JSON.parse(localStorage.getItem('__LISTCUT__')) || [];
    if (!Array.isArray(listObject))
    {console.error("Error: __LISTCUT__ no es un array válido.");return;}
    let item = listObject.find(obj => obj.inscription === $(ele).attr('data-ins'));
    if (item)
    {
        let opt = $(ele).val().trim();
        item.obs = opt !== '' ? opt : '';
        localStorage.setItem('__LISTCUT__', JSON.stringify(listObject));
    }
    else
        console.warn("No se encontró la inscripción:", $(ele).attr('data-ins'));
}
var rrr;
function sendData(ele)
{
    let inscription = $(ele).attr("data-ins");
    let listObject = JSON.parse(localStorage.getItem('__LISTCUT__')) || [];
    let item = listObject.find(obj => obj.inscription === inscription);
    if(item.obs.trim()==666 || item.obs.trim()==0)
    {
        if(item.lec<item.lecOld || item.lec.trim() === "")
        {alert("Ingrese una lectura mayor a la anterior.");return;}
    }
    if(item.obs.trim()==3)
    {
        if(item.lec>item.lecOld || item.lec.trim() == '')
        {alert("La lectura debe de ser menor que la lectura anterior.");return;}
    }
    if(item.obs.trim()==5)
    {
        // lectura en blanco
        let listObject = JSON.parse(localStorage.getItem('__LISTCUT__')) || [];
        if (!Array.isArray(listObject))
        {console.error("Error: __LISTCUT__ no es un array válido.");return;}
        let item = listObject.find(obj => obj.inscription === $(ele).attr('data-ins'));
        if (item)
        {
            item.lec = '';
            localStorage.setItem('__LISTCUT__', JSON.stringify(listObject));
        }
        else
            console.warn("No se encontró la inscripción:", $(ele).attr('data-ins'));

    }
    if(item.obs.trim()==6)
    {
        if (!item.lec || item.lec.trim() === "")
        {alert("Debe ingresar una lectura antes de enviar.");return;}
    }
    // 7,13,24,25,38,39,40,
    if(item.obs.trim()==46)
    {
        if (!item.lec || item.lec.trim() === "")
        {alert("Debe ingresar una lectura antes de enviar.");return;}
    }
    if(item.obs.trim()==60)
    {
        let listObject = JSON.parse(localStorage.getItem('__LISTCUT__')) || [];
        if (!Array.isArray(listObject))
        {console.error("Error: __LISTCUT__ no es un array válido.");return;}
        let item = listObject.find(obj => obj.inscription === $(ele).attr('data-ins'));
        if (item)
        {
            item.lec = '';
            localStorage.setItem('__LISTCUT__', JSON.stringify(listObject));
        }
        else
            console.warn("No se encontró la inscripción:", $(ele).attr('data-ins'));
    }
    if(item.obs.trim()==61)
    {
        let listObject = JSON.parse(localStorage.getItem('__LISTCUT__')) || [];
        if (!Array.isArray(listObject))
        {console.error("Error: __LISTCUT__ no es un array válido.");return;}
        let item = listObject.find(obj => obj.inscription === $(ele).attr('data-ins'));
        if (item)
        {
            item.lec = '';
            localStorage.setItem('__LISTCUT__', JSON.stringify(listObject));
        }
        else
            console.warn("No se encontró la inscripción:", $(ele).attr('data-ins'));
    }

    // ----------------------------
    // let inscription = $(ele).attr("data-ins");
    // let listObject = JSON.parse(localStorage.getItem('__LISTCUT__')) || [];
    // let item = listObject.find(obj => obj.inscription === inscription);
    // rrr=item
    // if (!item)
    // {alert("Registro no encontrado en localStorage.");return;}
    // if(!(['5','6','13','40','38'].includes(item.obs.trim())))
    //     if (!item.lec || item.lec.trim() === "")
    //         {alert("Debe ingresar una lectura antes de enviar.");return;}
    // $('.overlayPage').show();
    $('.overlayPage').css("display","flex");
    $.ajax({
        url: "{{ route('updateLectura') }}",
        method: "get",
        data: {
            inscription: item.inscription,
            lec: item.lec,
            obs: item.obs,
            lecAnt: item.lecOld
        },
        dataType: "json",
        success: function (r)
        {
            if (r.state)
            {
                let newList = listObject.filter(obj => obj.inscription !== inscription);
                localStorage.setItem('__LISTCUT__', JSON.stringify(newList));
                $("."+$(ele).attr('data-row')).remove();

            }
            notify(r)
            // $('.overlayPage').hide();
            $('.overlayPage').css("display","none");
        },
        error: function (xhr, status, error) {
            console.log(xhr)
            console.log(status)
            console.log(error)
            console.error("Error en AJAX:", error);
            alert(xhr.responseJSON.error);
            // $('.overlayPage').hide();
            $('.overlayPage').css("display","none");
        }
    });
}
function fillRecords3(idAss)
{
    // console.log('entro a fillRecords3')
    $('.containerRecordsBlue').css('display','none');
    $('.containerRecordsCuts').css('display','block');
    $('.overlayPage').show();
    jQuery.ajax({
        url: "{{ route('listCut2') }}",
        method: 'POST',
        data: {idAss: idAss},
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
        success: function (r) {
            if (!r.state)
            {alert(r.message);return;}
            localStorage.setItem('__LISTCUT__', r.data);
            renderTable(JSON.parse(r.data));
            $('.overlayPage').hide();
        },
        error: function (xhr, status, error) {
            alert("Algo salió mal, por favor contacte con el Administrador.");
            console.error("Error en AJAX:", error);
            $('.overlayPage').hide();
        }
    });
}
function actualizarDatos()
{

    // jQuery.ajax({
    //     url: "{{ route('listCut') }}",
    //     method: 'GET',
    //     dataType: 'json',
    //     headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
    //     success: function (r) {
    //         if (!r.state)
    //         {alert(r.message);return;}
    //         localStorage.setItem('__LISTCUT__', r.data);
    //         renderTable(JSON.parse(r.data));
    //     },
    //     error: function (xhr, status, error) {
    //         alert("Algo salió mal, por favor contacte con el Administrador.");
    //         console.error("Error en AJAX:", error);
    //     }
    // });



    Swal.fire({
        icon: 'warning',
        title: 'ES NECESARIO LA CONFIRMACION DEL ADMINISTRADOR CASO CONTRARIO REALIZAR CLICK EN EL BOTON CANCCELAR',
        text: 'ES NECESARIO CONSULTAR AL ADMINISTRADOR.',
        showCancelButton: true,
        confirmButtonText: 'Sí, continuar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Solo si el usuario hace clic en "Sí, continuar"
            jQuery.ajax({
            url: "{{ route('listCut') }}",
            method: 'GET',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
            success: function (r) {
                if (!r.state) {
                alert(r.message);
                return;
                }
                localStorage.setItem('__LISTCUT__', r.data);
                renderTable(JSON.parse(r.data));
            },
            error: function (xhr, status, error) {
                alert("Algo salió mal, por favor contacte con el Administrador.");
                console.error("Error en AJAX:", error);
            }
            });
        } else {
            // Cancelado por el usuario
            console.log('Acción cancelada');
        }
        });
}
function fillRecords2() {
    // $('.containerRecordsBlue').hide();
    console.time("Tiempo total fillRecords2");
    $('.containerRecordsCuts').show();
    let storedData = localStorage.getItem('__LISTCUT__');
    if (storedData)
    {
        // console.log('llego aki alacena')
        try
        {
            let data = JSON.parse(storedData);
            if (Array.isArray(data) && data.length > 0)
            {
                renderTable(data);
                console.log('data guadada')
                console.timeEnd("Tiempo total fillRecords2");
                return;

            }
        } catch (error) {
            console.error("Error al parsear __LISTCUT__:", error);
        }
    }
    // console.log('paso')
    jQuery.ajax({
        url: "{{ route('listCut') }}",
        method: 'GET',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
        success: function (r) {
            if (!r.state)
            {alert(r.message);return;}
            localStorage.setItem('__LISTCUT__', r.data);
            renderTable(JSON.parse(r.data));
            console.log('trajo data')
            console.timeEnd("Tiempo total fillRecords2");
        },
        error: function (xhr, status, error) {
            alert("Algo salió mal, por favor contacte con el Administrador.");
            console.error("Error en AJAX:", error);
        }
    });
}

// Función para renderizar la tabla
function renderTable(data)
{
    let htmlCourt = '';
    let countRecords = 0;
    data.forEach((item, index) => {
        // <br><br><br>${novDato(item.rate)}
        countRecords++;
        htmlCourt += `
            <tr class="${item.inscription}">
                <td class="align-middle text-center">${countRecords}</td>
                <td class="align-middle text-center cellCode" style="line-height: 1;">
                    ${novDato(item.code)} - ${novDato(item.cod)}<br>
                    ${novDato(item.meter)}<br>
                    <span style="font-size: .78em; line-height: 1; display: block;">Tarifa: ${novDato(item.rate)}</span>
                    <span style="font-size: .72em; line-height: 1; display: block;">${novDato(item.client)}</span>
                </td>
                <td class="align-middle text-center">${novDato(item.inscription)}</td>
                <td class="align-middle">${novDato(item.client)}</td>
                <td class="align-middle">${novDato(item.streetDescription)}</td>
                <td class="align-middle text-center">${novDato(item.rate)}</td>
                <td class="align-middle text-center">${novDato(item.meter)}</td>
                <td class="align-middle text-center">
                    <p class="m-0">L.A.: <span class="emu-la">${novDato(item.lecOld)}</span></p>
                    <input type="tel" class="form-control lectura" onkeyup="saveLsLec(this);"
                           data-row="${item.inscription}" data-ins="${item.inscription}" value="${isEmptyl(item.lec)}">
                    <select class="form-control obs" onchange="saveLsObs(this);" data-ins="${item.inscription}">
                        <option value="0" disabled ${!item.obs || item.obs === "0" ? "selected" : ""}>Elj.opc.</option>
                        <option value="666" ${!item.obs || item.obs === "666" ? "selected" : ""}>Sin opcion</option>
                        <option value="3" ${item.obs === "3" ? "selected" : ""}>Medidor cambiado</option>
                        <option value="5" ${item.obs === "5" ? "selected" : ""}>Sin medidor (retirado)</option>
                        <option value="6" ${item.obs === "6" ? "selected" : ""}>Medidor invertido</option>
                        <option value="7" ${item.obs === "7" ? "selected" : ""}>Medidor ópaco</option>
                        <option value="13" ${item.obs === "13" ? "selected" : ""}>Medidor enterrado</option>
                        <option value="24" ${item.obs === "24" ? "selected" : ""}>No tiene caja de medidor</option>
                        <option value="25" ${item.obs === "25" ? "selected" : ""}>Caja de medidor sin tapa</option>
                        <option value="38" ${item.obs === "38" ? "selected" : ""}>Conexión cortada</option>
                        <option value="39" ${item.obs === "39" ? "selected" : ""}>Fuga en caja</option>
                        <option value="40" ${item.obs === "40" ? "selected" : ""}>Medidor paralizado</option>
                        <option value="46" ${item.obs === "46" ? "selected" : ""}>Error de Lectura</option>
                        <option value="60" ${item.obs === "60" ? "selected" : ""}>Tarifa Industrial</option>
                        <option value="61" ${item.obs === "61" ? "selected" : ""}>Tarifa Comercial</option>
                    </select>

                </td>
                <td class="align-middle text-center">
                    <button class="btn btn-primary sendLectura" onclick="sendData(this);" data-row="${item.inscription}" data-ins="${item.inscription}">
                        <i class="fa fa-paper-plane"></i>
                    </button>






                </td>
            </tr>
        `;
    });
// <button type="button" class="btn btn-success mt-1" onclick="sendEvidence(this)" data-type="court"
//     data-inscription="${item.inscription}"
//     data-cellCode="${novDato(item.code)} - ${novDato(item.cod)}"
//     data-cellIns="${item.inscription}"
//     data-cellCli="${item.client}"
//     data-cellAdr="${item.streetDescription}">
//     <i class="fa fa-image"></i>
// </button>
    $('#recordsCourt').html(htmlCourt);
    tabletest = initDatatableDD('tableCuts');
    // initDatatable('tableRehab');

    // Ocultar loader/spinner
    $(".containerSpinner").removeClass("d-flex").addClass("d-none");
    $('.overlayPage').hide();
}
function initDropzone()
{
    myDropzone = new Dropzone('#dzLoadEvidence', {
    url: "{{route('sendEvidence')}}",
    dictDefaultMessage: "Arrastra y suelta archivos aquí para subirlos",
    acceptedFiles: '.jpg, .jpeg, .png',
    maxFilesize: 50,
    autoProcessQueue: false,
    paramName: "files[]",
    addRemoveLinks: true,
    dictRemoveFile: "Remover",
    dictInvalidFileType: "No puedes subir archivos de este tipo.",
    init: function() {
        const submitButton = document.querySelector('.saveEvidence');
        myDropzone = this;
        submitButton.addEventListener('click', function()
        {
            if (myDropzone.getQueuedFiles().length > 0)
            {
                $('.overlayPage').css("display","flex");
                myDropzone.processQueue();
            }
            else
                Swal.fire({title: "EVIDENCIAS",
                    text:"Agregue imagenes para guardar",
                    icon: "warning",
                });
        });
        this.on('addedfile', function(file) {});// Código que se ejecuta cuando se agrega un archivo
        this.on("success", function(file, response) {
            if (response.state === false)
                this.removeFile(file); // Remover el archivo si hay un error
            notify(response);
            $('.overlayPage').css("display","none");
        });
    }
    });
}
function updateImage()
{
    $('.overlayPage').css("display","flex");
    jQuery.ajax({
        url: "{{ route('showEvidences') }}",
        method: 'POST',
        data: {inscription: $('#inscription').val()},
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
        success: function (r) {
            $('.containerEvidences').html('');
            if(r.data.length!=0)
            {
                let html = '';
                for (var i = 0; i < r.data.length; i++)
                {
                    html += '<div class="card col-lg-4 p-0">'+
                            '<img src="{{env('IMAGES_BASE_URL')}}'+r.data[i].path+'" class="card-img-top">'+
                            '<div class="card-body p-1">'+
                                '<p class="card-text text-center fw-bold mb-1">'+formatDate(r.data[i].dateLec)+'</p>'+
                                '<a href="#" class="btn btn-danger w-100 py-1" onclick="deleteEvidence(this)" data-idEvi="'+r.data[i].idEvi+'"><i class="fa fa-trash"></i> Eliminar</a>'+
                            '</div>'+
                        '</div>';
                }
                $('.containerEvidences').append(html);
            }
            else
                $('.messageEvidences').css('display','block');
            $('.overlayPage').css("display","none");
        },
        error: function (xhr, status, error) {
            $('.overlayPage').css("display","none");
            alert("Algo salio mal, porfavor contactese con el Administrador.");
        }
    });
}
function deleteEvidence(ele)
{
    $('.overlayPage').css("display","flex");
    jQuery.ajax({
        url: "{{ route('deleteEvidence') }}",
        method: 'POST',
        data: {idEvi: $(ele).attr('data-idEvi')},
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
        success: function (r) {
            console.log(r)
            if(r.state)
                $(ele).parent().parent().remove();
            notify(r);
            $('.overlayPage').css("display","none");
        },
        error: function (xhr, status, error) {
            alert("Algo salio mal, porfavor contactese con el Administrador.");
            $('.overlayPage').css("display","none");
        }
    });
}
function sendEvidence(ele)
{
    myDropzone.removeAllFiles();
    $('#inscription').val($(ele).attr('data-inscription'))
    $('.showCod').html($(ele).attr('data-cellCode'));
    $('.showIns').html($(ele).attr('data-cellIns'));
    $('.showCli').html($(ele).attr('data-cellCli'));
    $('.showDir').html($(ele).attr('data-cellAdr'));
$('#modalEvidence').modal('show');
    $('.messageEvidences').css('display','none');
    $('.overlayPage').css("display","flex");
    jQuery.ajax({
        url: "{{ route('showEvidences') }}",
        method: 'POST',
        data: {inscription: $(ele).attr('data-inscription')},
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
        success: function (r) {
            $('#modalEvidence').modal('show');
            $('.containerEvidences').html('');
            if(r.data.length!=0)
            {
                let html = '';
                for (var i = 0; i < r.data.length; i++)
                {
                    html += '<div class="card col-lg-4 p-0">'+
                            '<img src="{{env('IMAGES_BASE_URL')}}'+r.data[i].path+'" class="card-img-top">'+
                            '<div class="card-body p-1">'+
                                '<p class="card-text text-center fw-bold mb-1">'+formatDate(r.data[i].dateLec)+'</p>'+
                                '<a href="#" class="btn btn-danger w-100 py-1" onclick="deleteEvidence(this)" data-idEvi="'+r.data[i].idEvi+'"><i class="fa fa-trash"></i> Eliminar</a>'+
                            '</div>'+
                        '</div>';
                }
                $('.containerEvidences').append(html);
            }
            else
                $('.messageEvidences').css('display','block');
            $('.overlayPage').css("display","none");
        },
        error: function (xhr, status, error) {
            $('.overlayPage').css("display","none");
            alert("Algo salio mal, porfavor contactese con el Administrador.");
        }
    });
}
function showLs()
{
    console.log(typeof localStorage.getItem("__LISTCUT__"))
    console.log(JSON.parse(localStorage.getItem("__LISTCUT__")))
}
</script>
<script src="{{asset('escn/public/plugins/datatables/dataTables.js')}}"></script>
<script src="{{asset('escn/public/plugins/datatables/dataTables.responsive.js')}}"></script>
<script src="{{asset('escn/public/plugins/datatables/responsive.dataTables.js')}}"></script>
@endsection
