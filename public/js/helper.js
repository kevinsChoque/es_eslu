function navBarActive()
{
    // console.log('este es sba---> '+localStorage.getItem("sba"));
    // if(localStorage.getItem("sba")==5)
    // {
    //     console.log('entro');
    //     $('.sba5').addClass('active');
    // }
    if(localStorage.getItem("nba")==1)$('.nb1').addClass('bg-info');
    if(localStorage.getItem("nba")==2)$('.nb2').addClass('bg-info');
    if(localStorage.getItem("nba")==3)$('.nb3').addClass('bg-info');
}
$('.onlyNumbers').on('input', function () {
    this.value = this.value.replace(/[^0-9]/g,'');
});
function isEmpty(value) {
    // Verifica si es null o undefined
    if (value === null || value === undefined) return true;

    // Verifica si es una cadena vacía
    if (typeof value === 'string' && value.trim() === '') return true;

    // Verifica si es un array vacío
    if (Array.isArray(value) && value.length === 0) return true;

    // Verifica si es un objeto vacío
    if (typeof value === 'object' && Object.keys(value).length === 0) return true;

    // Si no está vacío, retorna false
    return false;
}
function isMobileDevice() {return /Mobi|Android/i.test(navigator.userAgent);}
function novDato(dato){return dato!==null && dato!==''?dato:'--';}
function initDatatable(idTable)
{
    $('#'+idTable).DataTable( {
        "autoWidth":false,
        "responsive":true,
        "ordering": false,
        "lengthMenu": [[5, 10,25, -1], [5, 10,25, "Todos"]],
        // "order": [[ 1, 'desc' ]],
        "language": {
            "info": "Mostrando la pagina _PAGE_ de _PAGES_. (Total: _MAX_)",
            "search":"",
            "infoFiltered": "(filtrando)",
            "infoEmpty": "No hay registros disponibles",
            "sEmptyTable": "No tiene registros guardados.",
            "lengthMenu":"Mostrar registros _MENU_ .",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
    } );
    $('input[type=search]').parent().css('width','100%');
    $('input[type=search]').css('width','100%');
    $('input[type=search]').css('margin','0');
    $('input[type=search]').prop('placeholder','Escriba para buscar en las columnas.');
}
function initDatatableDD(idTable)
{
    var table = $('#'+idTable).DataTable( {
        "responsive": true,
        "autoWidth":false,
        "lengthMenu": [[5, 10,25, -1], [5, 10,25, "Todos"]],
        "pageLength": -1,
        "language": {
            "info": "Mostrando la pagina _PAGE_ de _PAGES_. (Total: _MAX_)",
            "search":"",
            "infoFiltered": "(filtrando)",
            "infoEmpty": "No hay registros disponibles",
            "sEmptyTable": "No tiene registros guardados.",
            "lengthMenu":"Mostrar registros _MENU_ .",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
    } );
    $('input[type=search]').parent().css('width','100%');
    $('input[type=search]').css('width','100%');
    $('input[type=search]').css('margin','0');
    $('input[type=search]').prop('placeholder','Escriba para buscar en las columnas.');
// console.log('enviara la table')
    return table;
}
function formatDate(fecha)
{
    var fecha = new Date(fecha);
    return `${fecha.getDate()+1} de ${getNameMonth(fecha.getMonth() + 1)} del ${fecha.getFullYear()}`;
}
function getNameMonth(numberMonth) {
    var month = [
        "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
        "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
    ];
    return month[numberMonth - 1];
}
function notifyGlobal(resp)
{
    const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: resp.time,
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
function notify(r)
{
    Swal.fire({
        icon: r.state ? "success":"error",            // 'success', 'error', 'warning', 'info', 'question'
        title: r.message,
        toast: true,
        position: 'top-end',        // 'top', 'top-start', 'top-end', etc.
        showConfirmButton: false,
        timer: 3000,                // duración en milisegundos
        timerProgressBar: true
    });
}
function initFv(id,rules)
{
    $('#'+id).validate({
        rules: rules,
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
            $(element).addClass('is-valid');
        }
    });
}
function isEmpty(value) {
    // Verifica si es null o undefined
    if (value === null || value === undefined) return true;

    // Verifica si es una cadena vacía
    if (typeof value === 'string' && value.trim() === '') return true;

    // Verifica si es un array vacío
    if (Array.isArray(value) && value.length === 0) return true;

    // Verifica si es un objeto vacío
    if (typeof value === 'object' && Object.keys(value).length === 0) return true;

    // Si no está vacío, retorna false
    return false;
}
function isEmptyl(value) {
    // Verifica si es null o undefined
    if (value === null || value === undefined) return '';

    // Verifica si es una cadena vacía
    if (typeof value === 'string' && value.trim() === '') return '';

    // Verifica si es un array vacío
    if (Array.isArray(value) && value.length === 0) return '';

    // Verifica si es un objeto vacío
    if (typeof value === 'object' && Object.keys(value).length === 0) return '';

    // Si no está vacío, retorna false
    return value;
}
function msgImportant(r)
{
    Swal.fire({
        title: r.message,
        text: r.state?"La informacion fue registrada":'Ocurrio un error!',
        icon: r.state? "success" : "error",
    });
}
// function msgImportantShow(a,b,c)
// {
//     Swal.fire({
//         title: a,
//         text: b,
//         icon: c,
//     });
// }
