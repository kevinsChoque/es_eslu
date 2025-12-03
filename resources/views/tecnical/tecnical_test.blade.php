@extends('layout.layout')
@section('content')
<script src="{{asset('eslu/public/js/dropzone-min.js')}}"></script>
<link rel="stylesheet" href="{{asset('eslu/public/css/dropzone.css')}}">
<div class="container mt-1">
    <div class="row">
        <div class="col-lg-6 col-sm-6">
            <button class="btn btn-primary w-100" onclick="actualizarDatos();"><i class="fa fa-sync"></i> Actualizar datos</button>
        </div>
        <div class="col-lg-6 col-sm-6">
            <button class="btn btn-info w-100" onclick="showLecturasReg();"><i class="fa fa-edit"></i> Editar lectura</button>
        </div>
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
            <h6 class="fw-bold m-0"><i class="fa fa-clipboard"></i> PADRON DE LECTURAS 2025</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 m-auto p-3 shadow containerRecordsCuts table-responsive px-0">
                    {{-- <table id="tableCuts" class="w-100 table table-hover table-striped table-bordered">
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
                    </table> --}}
                    <table id="tableCuts" class="w-100 table table-hover table-striped table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th width="3%" class="text-center">#</th>
                                <th width="6%" class="text-center">Informacion</th>
                                <th width="6%" class="text-center">Datos</th>
                                <th width="6%" class="text-center">Opc.</th>
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
{{-- Modal de ingresar comentario --}}
<div class="modal fade" id="obsModal" tabindex="-1" role="dialog" aria-labelledby="obsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header py-1">
          <h5 class="modal-title">Registrar Observación</h5>
          <button type="button" class="close cerrarModal" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="inscripcion_id" name="inscripcion_id">
          <div class="form-group">
            <label for="comentarioEslu">Observación</label>
            <textarea class="form-control" id="comentarioEslu" name="comentarioEslu" rows="4" required></textarea>
          </div>
        </div>
        <div class="modal-footer py-1">
          <button type="submit" class="btn btn-success" onclick="saveComentario();">Guardar</button>
          <button type="button" class="btn btn-secondary cerrarModal" data-dismiss="modal">Cerrar ventana</button>
        </div>
      </div>
  </div>
</div>


<!-- Botón flotante con búsqueda -->
<div id="scrollToInsButton" class="opcPantalla" style="
    position: fixed;
    bottom: 20px;
    left: 20px;
    z-index: 9999;
    background-color: #007bff;
    padding: 10px;
    border-radius: 8px;
    color: white;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);">

    <input type="text" id="searchInsInput" placeholder="Buscar..." style="width: 150px; margin-right: 5px;" />
    <button onclick="buscarCoincidencias()" class="btn btn-light btn-sm">🔍</button>
    <div id="navButtons" style="margin-top: 5px; display: none;">
        <button onclick="mostrarAnterior()" class="btn btn-secondary btn-sm p-0" style="font-size: 21px;">⬅️</button>
        <span id="contadorCoincidencias" style="margin-left: 10px; color: white; font-weight: bold;"></span>
        <button onclick="mostrarSiguiente()" class="btn btn-secondary btn-sm p-0" style="font-size: 21px;margin-left: 24px;">➡️</button>

    </div>
</div>
<div class="modal fade" id="showLescturasRegistradas" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-1">
                <h5 class="modal-title" id="miModalLabel"><i class="fa fa-list"></i> Lecturas registradas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table id="tableLecturas" class="table table-striped table-hover" width="100%">
                    <thead>
                        <tr class="text-center">
                            <th width="3%" class="text-center">#</th>
                            <th width="6%" class="text-center">Informacion</th>
                            <th width="6%" class="text-center">Datos</th>
                            <th width="6%" class="text-center">Opc.</th>
                        </tr>
                    </thead>
                    <tbody id="recordsEdit">
                    </tbody>
                </table>
                <div id="paginacionLecturas" class="d-flex justify-content-center mt-2"></div>
            </div>
            {{-- <div class="modal-footer py-1">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar</button>
            </div> --}}
        </div>
    </div>
</div>
<script>
    let paginaActual = 1;
    let porPagina = 3;
    let modalAbierto = false;

    function showLecturasReg(pagina = 1)
    {
        paginaActual = pagina;
        $('.overlayPage').css("display","flex");
        $.ajax({
            url: "{{ route('listCutdt') }}",
            method: "GET",
            data: {page: paginaActual,per_page: porPagina},
            dataType: 'json',
            success: function (r)
            {
                console.dir(r)
                if (!r.state)
                {
                    msgImportant(r);
                    $('.overlayPage').hide();
                    return;
                }
                renderTableEdit(r.data);
                renderPaginacion(r.current_page, r.last_page);
                // ✔ SOLO SE ABRE EL MODAL LA PRIMERA VEZ
                if (!modalAbierto)
                {
                    var myModal = new bootstrap.Modal(document.getElementById('showLescturasRegistradas'));
                    myModal.show();
                    modalAbierto = true;
                    $('.opcPantalla').css('display','none')
                }
                $('.overlayPage').hide();
            },
            error: function () {
                alert("Error al cargar datos");
                $('.overlayPage').hide();
            }
        });
    }
    function renderPaginacion_old(actual, totalPaginas)
    {
        let html = '';
        // Botón anterior
        if (actual > 1)
            html += `<button class="btn btn-sm btn-primary mx-1" onclick="showLecturasReg(${actual - 1})">«</button>`;
        // Números de página
        for (let i = 1; i <= totalPaginas; i++)
        {
            html += `
                <button class="btn btn-sm ${i === actual ? 'btn-success' : 'btn-outline-secondary'} mx-1"
                    onclick="showLecturasReg(${i})">${i}</button>
            `;
        }
        // Botón siguiente
        if (actual < totalPaginas)
            html += `<button class="btn btn-sm btn-primary mx-1" onclick="showLecturasReg(${actual + 1})">»</button>`;
        $("#paginacionLecturas").html(html);
    }
    function renderPaginacion(actual, totalPaginas) {
        let html = '';

        // Botón « anterior
        if (actual > 1)
            html += `<button class="btn btn-sm btn-primary mx-1" onclick="showLecturasReg(${actual - 1})">«</button>`;

        // Mostrar siempre la página 1
        if (actual !== 1) {
            html += `<button class="btn btn-sm btn-outline-secondary mx-1" onclick="showLecturasReg(1)">1</button>`;
        }

        // Agregar "..." si estamos lejos del inicio
        if (actual > 3)
            html += `<span class="mx-1">...</span>`;

        // Páginas cercanas
        for (let i = actual - 1; i <= actual + 1; i++) {
            if (i > 1 && i < totalPaginas) {
                html += `
                    <button class="btn btn-sm ${i === actual ? 'btn-success' : 'btn-outline-secondary'} mx-1"
                        onclick="showLecturasReg(${i})">${i}</button>
                `;
            }
        }

        // Agregar "..." si estamos lejos del final
        if (actual < totalPaginas - 2)
            html += `<span class="mx-1">...</span>`;

        // Mostrar siempre la última página
        if (actual !== totalPaginas) {
            html += `<button class="btn btn-sm btn-outline-secondary mx-1" onclick="showLecturasReg(${totalPaginas})">${totalPaginas}</button>`;
        }

        // Botón siguiente »
        if (actual < totalPaginas)
            html += `<button class="btn btn-sm btn-primary mx-1" onclick="showLecturasReg(${actual + 1})">»</button>`;

        $("#paginacionLecturas").html(html);
    }

    // Cuando el modal se cierra, resetear la variable
    $('#showLescturasRegistradas').on('hidden.bs.modal', function () {
        modalAbierto = false;
        $('.opcPantalla').css('display','flex')
    });
</script>
<script>
    let coincidencias = [];
    let indiceActual = 0;

    function limpiarResaltado() {
        document.querySelectorAll("table tbody tr").forEach(row => {
            row.style.backgroundColor = "";
        });
    }
    let lecturasTable; // global eliminar
    // var ppp;
function showLecturasReg_old() {
    // console.time("Tiempo AJAX");
    let inicio = performance.now();
    // var myModal = new bootstrap.Modal(document.getElementById('showLescturasRegistradas'));
    //         myModal.show();
    $('.overlayPage').css("display","flex");
    jQuery.ajax({
        url: "{{ route('listCutdt') }}",
        method: 'GET',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
        success: function (r) {
            let fin = performance.now();
            let ms = fin - inicio;
            let segundos = ms / 1000;
            console.log("Tiempo AJAX d:", ms.toFixed(2), "ms");
            console.log("Tiempo AJAX en segundos d:", segundos.toFixed(3), "s");
            console.log(r)
            if (!r.state)
            {
                msgImportant(r)
                $('.overlayPage').hide();
                return;
            }
            renderTableEdit(r.data);
            // $('#showLescturasRegistradas').modal('show')
            var myModal = new bootstrap.Modal(document.getElementById('showLescturasRegistradas'));
            myModal.show();
        },
        error: function (xhr, status, error) {
            let fin = performance.now();
            let ms = fin - inicio;
            console.log("Tiempo AJAX (error):", ms.toFixed(2), "ms");
            alert("Algo salió mal, por favor contacte con el Administrador.");
            console.error("Error en AJAX:", error);
        }
    });
}
function renderTableEdit(data) {
    let htmlCourt = '';
    let countRecords = 0;
    console.log(typeof data)

    if (!Array.isArray(data)) {
        data = Object.values(data);
    }
    data.forEach((item, index) => {
        countRecords++;
        const rowId = `row-detail-${countRecords}`;
        const rowClass = index % 2 === 0 ? 'row-light' : 'row-dark'; // Alternar clases
        htmlCourt += `
            <tr class="main-row ${rowClass} ${item.inscription} searchHere" data-target="#${rowId}" style="cursor: pointer;"
                data-inscription="${item.inscription}" data-nombre="${item.client}"
                data-meter="${item.meter}" data-lote="${item.cod}" data-direccion="${item.streetDescription}">

                <td class="align-middle text-center">${countRecords}</td>
                <td class="align-middle text-center cellCode" style="line-height: 1;">
                    ${novDato(item.code)} - ${novDato(item.cod)}<br>
                    ${novDato(item.meter)}<br>
                    <span style="font-size: .78em; line-height: 1; display: block;">Tarifa: ${novDato(item.rate)}</span>
                    <span style="font-size: .72em; line-height: 1; display: block;">${novDato(item.client)}</span>
                </td>
                <td class="align-middle text-center">
                    <p class="m-0">L.A.: <span class="emuLaEdit">${novDato(item.lecOld)}</span></p>
                    <input type="tel" class="form-control lecturaEdit" data-row="${item.inscription}" data-ins="${item.inscription}" value="${isEmptyl(item.LecMed)}">
                    <select class="form-control obsEdit" onchange="saveLsObs(this);" data-ins="${item.inscription}">
                        <option value="0" disabled ${item.obs === 0 ? "selected" : ""}>Elj.opc.</option>
                        <option value="3" ${item.obs === 3 ? "selected" : ""}>Medidor cambiado</option>
                        <option value="5" ${item.obs === 5 ? "selected" : ""}>Sin medidor (retirado)</option>
                        <option value="6" ${item.obs === 6 ? "selected" : ""}>Medidor invertido</option>
                        <option value="7" ${item.obs === 7 ? "selected" : ""}>Medidor ópaco</option>
                        <option value="13" ${item.obs === 13 ? "selected" : ""}>Medidor enterrado</option>
                        <option value="24" ${item.obs === 24 ? "selected" : ""}>No tiene caja de medidor</option>
                        <option value="25" ${item.obs === 25 ? "selected" : ""}>Caja de medidor sin tapa</option>
                        <option value="38" ${item.obs === 38 ? "selected" : ""}>Conexión cortada</option>
                        <option value="39" ${item.obs === 39 ? "selected" : ""}>Fuga en caja</option>
                        <option value="40" ${item.obs === 40 ? "selected" : ""}>Medidor paralizado</option>
                        <option value="46" ${item.obs === 46 ? "selected" : ""}>Error de Lectura</option>
                        <option value="60" ${item.obs === 60 ? "selected" : ""}>Tarifa Industrial</option>
                        <option value="61" ${item.obs === 61 ? "selected" : ""}>Tarifa Comercial</option>
                    </select>
                </td>
                <td class="align-middle text-center">
                    <button class="btn btn-primary sendLectura" onclick="sendDataEdit(this);"
                    data-row="${item.inscription}"
                    data-ins="${item.inscription}"
                    data-lecAnt="${novDato(item.lecOld)}"
                    >
                        <i class="fa fa-paper-plane"></i>
                    </button>

                </td>
            </tr>
        `;
        // <button type="button" class="btn btn-secondary" data-ins="${item.inscription}" onclick="registrarComentario(this);">
        //     <i class="fa fa-comment"></i>
        // </button>
    });
    $('#recordsEdit').html(htmlCourt);
    // Toggle de filas
    // $('.main-row').off('click').on('click', function () {
    //     const target = $(this).data('target');
    //     $(target).toggle();
    // });
    // -------
    // $('.main-row td:first-child').off('click').on('click', function (e) {
    //     e.stopPropagation(); // Evita que otros eventos burbujeen
    //     const row = $(this).closest('.main-row');
    //     const target = row.data('target');
    //     $(target).toggle();
    // });

    // $(".containerSpinner").removeClass("d-flex").addClass("d-none");
    $('.overlayPage').hide();
}

    function buscarCoincidencias() {
        const searchTerm = document.getElementById("searchInsInput").value.trim().toLowerCase();
        coincidencias = [];
        indiceActual = 0;

        limpiarResaltado();

        if (!searchTerm) {
            document.getElementById("navButtons").style.display = "none";
            document.getElementById("contadorCoincidencias").innerText = "";
            return;
        }

        // Buscar coincidencias solo en las primeras 4 columnas
        document.querySelectorAll("table tbody tr.searchHere").forEach(row => {
            const cells = row.querySelectorAll("td");
            let contentToSearch = "";

            for (let i = 0; i < Math.min(4, cells.length); i++) {
                contentToSearch += cells[i].innerText.toLowerCase() + " ";
            }

            if (contentToSearch.includes(searchTerm)) {
                coincidencias.push(row);
            }
        });

        if (coincidencias.length > 0) {
            mostrarCoincidencia(indiceActual);
            document.getElementById("navButtons").style.display = "block";
            document.getElementById("contadorCoincidencias").innerText = `1 de ${coincidencias.length}`;
        } else {
            alert("No se encontraron coincidencias.");
            document.getElementById("navButtons").style.display = "none";
            document.getElementById("contadorCoincidencias").innerText = "";
        }
    }


    function mostrarCoincidencia(index) {
        limpiarResaltado();

        const row = coincidencias[index];
        if (!row) return;

        row.scrollIntoView({ behavior: "smooth", block: "center" });
        row.style.transition = "background-color 0.5s";
        row.style.backgroundColor = "#ffeb3b";

        setTimeout(() => {
            row.style.backgroundColor = "";
        }, 1500);

        document.getElementById("contadorCoincidencias").innerText = `${index + 1} de ${coincidencias.length}`;
    }

    function mostrarSiguiente() {
        if (indiceActual < coincidencias.length - 1) {
            indiceActual++;
            mostrarCoincidencia(indiceActual);
        }
    }

    function mostrarAnterior() {
        if (indiceActual > 0) {
            indiceActual--;
            mostrarCoincidencia(indiceActual);
        }
    }
</script>

<!-- BOTÓN: Ir al inicio -->
<button id="scrollTopButton" class="opcPantalla" style="
    position: fixed;
    bottom: 114px;
    left: 20px;
    z-index: 9999;
    background-color: #28a745;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    color: white;
    font-size: 18px;
    cursor: pointer;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: bottom 0.3s ease;">
    ↑
</button>

<script>
document.getElementById("scrollTopButton").addEventListener("click", function () {
    window.scrollTo({ top: 0, behavior: "smooth" });
});

// Función para mover el botón arriba cuando se muestra el panel flotante de búsqueda
function ajustarBotonInicio(segunBusquedaActiva) {
    const botonInicio = document.getElementById("scrollTopButton");
    if (segunBusquedaActiva) {
        botonInicio.style.bottom = "180px"; // más arriba si panel de búsqueda está abierto
    } else {
        botonInicio.style.bottom = "120px"; // posición normal
    }
}
</script>
<style>
    .row-light {
    background-color: #f2f2f2;
}

.row-dark {
    background-color: #ffffff;
}
</style>
{{-- <button id="btnBuscarFlotante" style="
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
</button> --}}
<!-- Panel flotante con input de búsqueda -->
{{-- <div id="panelBusqueda" style="
    position: fixed;
    bottom: 80px;
    left: 20px;
    background: white;
    padding: 10px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.3);

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
</script> --}}
<style>
    /* .activate-row{background: rgba(0, 255, 0, 0.5) !important;}
    .green-row{background: rgba(119, 163, 69, 0.5) !important;}
    .blue-row{background: rgba(0, 0, 255, 0.5) !important;}
    .red-row{background: rgba(255, 0, 0, 0.5) !important;}
    .none-row{background: none !important;} */
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
            console.log(r)
            if(r.state)
            {
                let html = '';
                let selected;
                let counter = 1;
                let idAss = "{{optional(Session::get('assign'))->idAss}}";
                // let idAss = "";
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
                                '<h6 class="card-subtitle text-muted cantRuta">Cant.reg: '+r.data[i].cant+'</h6>'+
                                // '<p class="card-text">Cant.reg: '+r.data[i].cant+'</p>'+
                            '</div>'+
                        '</div>'+
                    '</div>';
                }
                $('.containerTask').html(html);
            }
            else
            {
                $('.containerTask').html('<div class="alert alert-info"><p class="m-0">'+r.message+'</p></div>');
                // alert(r.message);
            }
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
    let listObject = JSON.parse(localStorage.getItem('__LISTLECTURA__')) || [];
    if (!Array.isArray(listObject))
    {console.error("Error: __LISTLECTURA__ no es un array válido.");return;}
    let item = listObject.find(obj => obj.inscription === $(ele).attr('data-ins'));
    if (item)
    {
        let valorLectura = $(ele).val().trim();
        item.lec = valorLectura !== '' ? valorLectura : ''; // Evita asignar `undefined` o `null`
        localStorage.setItem('__LISTLECTURA__', JSON.stringify(listObject));
    }
    else
        console.warn("No se encontró la inscripción:", $(ele).attr('data-ins'));
}
function saveLsObs(ele)
{
    let listObject = JSON.parse(localStorage.getItem('__LISTLECTURA__')) || [];
    if (!Array.isArray(listObject))
    {console.error("Error: __LISTLECTURA__ no es un array válido.");return;}
    let item = listObject.find(obj => obj.inscription === $(ele).attr('data-ins'));
    if (item)
    {
        let opt = $(ele).val().trim();
        item.obs = opt !== '' ? opt : '';
        localStorage.setItem('__LISTLECTURA__', JSON.stringify(listObject));
    }
    else
        console.warn("No se encontró la inscripción:", $(ele).attr('data-ins'));
}
function sendDataEdit(ele)
{
    $('.overlayPage').css("display","flex");
    let lecAnt = parseFloat($(ele).attr('data-lecAnt'))
    let lecturaEdit = parseFloat($(ele).parent().parent().find('.lecturaEdit').val())
    let obsEdit = $(ele).parent().parent().find('.obsEdit').val()
    console.log('lecAnt:'+lecAnt+'---lecturaEdit:'+lecturaEdit)
    if(obsEdit==666 || obsEdit==0 || obsEdit===null)
    {
        if(lecturaEdit<lecAnt || lecturaEdit === "")
        {notify({state:false,message:'Ingrese una lectura mayor a la anterior.'});return;}
    }
    if(obsEdit==3) //medidor cambiado
    {
        if(lecturaEdit>lecAnt || lecturaEdit == '')
        {notify({state:false,message:'La lectura debe ser menor que la lectura anterior.'});return;}
    }
    if(obsEdit==5) //sin medidor
    {lecturaEdit='';}
    if(obsEdit==6 || obsEdit==46) //medidor invertido - error de lectura
    {
        if (!lecturaEdit || lecturaEdit === "")
        {notify({state:false,message:'Debe ingresar una lectura antes de enviar.'});return;}
    }
    // // 7,13,24,25,38,39,40,
    if(obsEdit==60) //tarifa industrial
    {
        if(lecturaEdit<lecAnt || lecturaEdit === "")
        {notify({state:false,message:'Ingrese una lectura mayor a la anterior.'});return;}
    }
    if(obsEdit==61) //tarifa comercial
    {
        if(lecturaEdit<lecAnt || lecturaEdit === "")
        {notify({state:false,message:'Ingrese una lectura mayor a la anterior.'});return;}
    }

    $.ajax({
        url: "{{ route('editarLectura') }}",
        method: "get",
        data: {
            inscription: $(ele).attr('data-ins'),
            lec: lecturaEdit,
            obs: obsEdit,
            lecAnt: lecAnt
        },
        dataType: "json",
        success: function (r)
        {
            msgImportant(r)
            $('.overlayPage').css("display","none");
        },
        error: function (xhr, status, error) {
            console.log(xhr)
            console.log(status)
            console.log(error)
            console.error("Error en AJAX:", error);
            // alert(xhr.responseJSON.error);
            // $('.overlayPage').hide();
            $('.overlayPage').css("display","none");
        }
    });
}
function sendData(ele)
{
    // $("."+$(ele).attr('data-row')).remove();
    // return;
    let inscription = $(ele).attr("data-ins");
    let listObject = JSON.parse(localStorage.getItem('__LISTLECTURA__')) || [];
    let item = listObject.find(obj => obj.inscription === inscription);
    if(item.obs.trim()==666 || item.obs.trim()==0)
    {
        if(item.lec<item.lecOld || item.lec.trim() === "")
        {alert("Ingrese una lectura mayor a la anterior.");return;}
    }
    if(item.obs.trim()==3) //medidor cambiado
    {
        if(item.lec>item.lecOld || item.lec.trim() == '')
        {alert("La lectura debe de ser menor que la lectura anterior.");return;}
    }
    if(item.obs.trim()==5) //sin medidor
    {
        // lectura en blanco
        let listObject = JSON.parse(localStorage.getItem('__LISTLECTURA__')) || [];
        if (!Array.isArray(listObject))
        {console.error("Error: __LISTLECTURA__ no es un array válido.");return;}
        let item = listObject.find(obj => obj.inscription === $(ele).attr('data-ins'));
        if (item)
        {
            item.lec = '';
            localStorage.setItem('__LISTLECTURA__', JSON.stringify(listObject));
        }
        else
            console.warn("No se encontró la inscripción:", $(ele).attr('data-ins'));

    }
    if(item.obs.trim()==6) //medidor invertido
    {
        if (!item.lec || item.lec.trim() === "")
        {alert("Debe ingresar una lectura antes de enviar.");return;}
    }
    // 7,13,24,25,38,39,40,
    if(item.obs.trim()==46) //error de lectura
    {
        if (!item.lec || item.lec.trim() === "")
        {alert("Debe ingresar una lectura antes de enviar.");return;}
    }
    if(item.obs.trim()==60) //tarifa industrial
    {
        // let listObject = JSON.parse(localStorage.getItem('__LISTLECTURA__')) || [];
        // if (!Array.isArray(listObject))
        // {console.error("Error: __LISTLECTURA__ no es un array válido.");return;}
        // let item = listObject.find(obj => obj.inscription === $(ele).attr('data-ins'));
        // if (item)
        // {
        //     item.lec = '';
        //     localStorage.setItem('__LISTLECTURA__', JSON.stringify(listObject));
        // }
        // else
        //     console.warn("No se encontró la inscripción:", $(ele).attr('data-ins'));
        // ---
        if(item.lec<item.lecOld || item.lec.trim() === "")
        {alert("Ingrese una lectura mayor a la anterior.");return;}
    }
    if(item.obs.trim()==61) //tarifa comercial
    {
        // let listObject = JSON.parse(localStorage.getItem('__LISTLECTURA__')) || [];
        // if (!Array.isArray(listObject))
        // {console.error("Error: __LISTLECTURA__ no es un array válido.");return;}
        // let item = listObject.find(obj => obj.inscription === $(ele).attr('data-ins'));
        // if (item)
        // {
        //     item.lec = '';
        //     localStorage.setItem('__LISTLECTURA__', JSON.stringify(listObject));
        // }
        // else
        //     console.warn("No se encontró la inscripción:", $(ele).attr('data-ins'));
        // ---
        if(item.lec<item.lecOld || item.lec.trim() === "")
        {alert("Ingrese una lectura mayor a la anterior.");return;}
    }

    // ----------------------------
    // let inscription = $(ele).attr("data-ins");
    // let listObject = JSON.parse(localStorage.getItem('__LISTLECTURA__')) || [];
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
                localStorage.setItem('__LISTLECTURA__', JSON.stringify(newList));
                $("."+$(ele).attr('data-row')).remove();
                $("."+$(ele).attr('data-row')+'des').remove();
                // selected-task
                let $cantRuta = $('.selected-task').find('.cantRuta');
                let texto = $cantRuta.text();
                let nuevoTexto = texto.replace(/(\d+)/, (match) => parseInt(match) - 1);
                $cantRuta.text(nuevoTexto);
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
            localStorage.setItem('__LISTLECTURA__', r.data);
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
function showAsignacion()
{
    jQuery.ajax({
        url: "{{ route('showAsignacion') }}",
        method: 'GET',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
        success: function (r) {
            // if (!r.state) {
            // alert(r.message);
            // return;
            // }
            // localStorage.setItem('__LISTLECTURA__', r.data);
            // renderTable(JSON.parse(r.data));
        },
        error: function (xhr, status, error) {
            alert("Algo salió mal, por favor contacte con el Administrador.");
            console.error("Error en AJAX:", error);
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
    //         localStorage.setItem('__LISTLECTURA__', r.data);
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
                localStorage.setItem('__LISTLECTURA__', r.data);
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
    console.log('este es tab')
    // console.time("Tiempo total fillRecords2");
    $('.containerRecordsCuts').show();
    let storedData = localStorage.getItem('__LISTLECTURA__');
    if (storedData)
    {
        try
        {
            let data = JSON.parse(storedData);
            if (Array.isArray(data) && data.length > 0)
            {
                renderTable(data);
                console.log('data guadada')
                // console.timeEnd("Tiempo total fillRecords2");
                return;
            }
        } catch (error) {
            console.error("Error al parsear __LISTLECTURA__:", error);
        }
    }
    jQuery.ajax({
        url: "{{ route('listCut') }}",
        method: 'GET',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
        success: function (r) {
            console.log(r)
            if (!r.state)
            {
                // alert(r.message);
                msgImportant(r)
                $('.overlayPage').hide();
                return;
            }
            localStorage.setItem('__LISTLECTURA__', r.data);
            renderTable(JSON.parse(r.data));
            console.log('trajo data')
            // console.timeEnd("Tiempo total fillRecords2");
        },
        error: function (xhr, status, error) {
            alert("Algo salió mal, por favor contacte con el Administrador.");
            console.error("Error en AJAX:", error);
        }
    });
}
function renderTable(data) {
    let htmlCourt = '';
    let countRecords = 0;

    data.forEach((item, index) => {
        countRecords++;
        const rowId = `row-detail-${countRecords}`;
        const rowClass = index % 2 === 0 ? 'row-light' : 'row-dark'; // Alternar clases

        htmlCourt += `
            <tr class="main-row ${rowClass} ${item.inscription} searchHere" data-target="#${rowId}" style="cursor: pointer;"
                data-inscription="${item.inscription}" data-nombre="${item.client}"
                data-meter="${item.meter}" data-lote="${item.cod}" data-direccion="${item.streetDescription}">

                <td class="align-middle text-center">${countRecords}</td>
                <td class="align-middle text-center cellCode" style="line-height: 1;">
                    ${novDato(item.code)} - ${novDato(item.cod)}<br>
                    ${novDato(item.meter)}<br>
                    <span style="font-size: .78em; line-height: 1; display: block;">Tarifa: ${novDato(item.rate)}</span>
                    <span style="font-size: .72em; line-height: 1; display: block;">${novDato(item.client)}</span>
                </td>
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
                    <button type="button" class="btn btn-secondary" data-ins="${item.inscription}" onclick="registrarComentario(this);">
                        <i class="fa fa-comment"></i>
                    </button>
                </td>
            </tr>

            <tr id="${rowId}" class="detail-row ${item.inscription}des" style="display: none;">
                <td colspan="4">
                    <div style="padding: 10px; background-color: #f9f9f9; font-size: 0.9em;">
                        <strong>Cliente:</strong> ${novDato(item.client)}<br>
                        <strong>Dirección:</strong> ${novDato(item.streetDescription)}<br>
                        <strong>Tarifa:</strong> ${novDato(item.rate)}<br>
                        <strong>Medidor:</strong> ${novDato(item.meter)}<br>
                    </div>
                </td>
            </tr>
        `;
    });
    $('#recordsCourt').html(htmlCourt);
    // Toggle de filas
    // $('.main-row').off('click').on('click', function () {
    //     const target = $(this).data('target');
    //     $(target).toggle();
    // });
    $('.main-row td:first-child').off('click').on('click', function (e) {
        e.stopPropagation(); // Evita que otros eventos burbujeen
        const row = $(this).closest('.main-row');
        const target = row.data('target');
        $(target).toggle();
    });

    $(".containerSpinner").removeClass("d-flex").addClass("d-none");
    $('.overlayPage').hide();
}
function registrarComentario(ele)
{
    $('.overlayPage').css("display","flex");
    jQuery.ajax({
        url: "{{ route('showComentario') }}",
        method: 'POST',
        data: {ins: $(ele).attr('data-ins')},
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
        success: function (r) {
            $('#obsModal').modal('show')
            $('#comentarioEslu').val(r.comentario)
            $('#inscripcion_id').val($(ele).attr('data-ins'))
            $('.overlayPage').css("display","none");
        },
        error: function (xhr, status, error) {
            $('.overlayPage').css("display","none");
            alert("Algo salio mal, porfavor contactese con el Administrador.");
        }
    });
}
$('.cerrarModal').on('click',function(){
    $('#obsModal').modal('hide');
})
function saveComentario()
{
    $('.overlayPage').css("display","flex");
    let data = {
        ins: $('#inscripcion_id').val(),
        comentario: $('#comentarioEslu').val(),
    };
    $.ajax({
        url: "{{ route('saveComentario') }}",
        method: 'POST',
        data: data,
        headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
        success: function(r) {
            if (r.state)
            {
                $('#obsModal').modal('hide');
            }
            notify(r)
            $('#inscripcion_id').val('')
            $('#comentarioEslu').val('')
            $('.overlayPage').css("display","none");
        },
        error: function(xhr) {
            alert('Ocurrió un error al guardar');
            console.error(xhr.responseText);
            $('.overlayPage').css("display","none");
        }
    });
}
// Función para renderizar la tabla
function renderTable2(data)
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
    // tabletest = initDatatableDD('tableCuts');
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
    console.log(typeof localStorage.getItem("__LISTLECTURA__"))
    console.log(JSON.parse(localStorage.getItem("__LISTLECTURA__")))
}
</script>
<script src="{{asset('escn/public/plugins/datatables/dataTables.js')}}"></script>
<script src="{{asset('escn/public/plugins/datatables/dataTables.responsive.js')}}"></script>
<script src="{{asset('escn/public/plugins/datatables/responsive.dataTables.js')}}"></script>
@endsection
