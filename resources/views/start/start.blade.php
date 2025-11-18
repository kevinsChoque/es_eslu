@extends('layout.layout')
@section('content')
{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
<link rel="stylesheet" href="{{asset('escn/public/plugins/select2/select2.min.css')}}">
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
<script src="{{asset('escn/public/plugins/select2/select2.min.js')}}"></script>

<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>

<link rel="stylesheet" href="{{asset('escn/public/plugins/datatables/dataTables.dataTables.css')}}">
<link rel="stylesheet" href="{{asset('escn/public/plugins/datatables/responsive.dataTables.css')}}">
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js" integrity="sha512-RCgrAvvoLpP7KVgTkTctrUdv7C6t7Un3p1iaoPr1++3pybCyCsCZZN7QEHMZTcJTmcJ7jzexTO+eFpHk4OCFAg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js" integrity="sha512-hUhvpC5f8cgc04OZb55j0KNGh4eh7dLxd/dPSJ5VyzqDWxsayYbojWyl5Tkcgrmb/RVKCRJI1jNlRbVP4WWC4w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css" integrity="sha512-YdYyWQf8AS4WSB0WWdc3FbQ3Ypdm0QCWD2k4hgfqbQbRCJBEgX0iAegkl2S1Evma5ImaVXLBeUkIlP6hQ1eYKQ==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
<div class="container-fluid mt-1">
    <div class="card shadow bg-light">
        <div class="card-header">
            <h6 class="m-0">PADRON DE USUARIOS</h6>
        </div>
        <div class="d-none justify-content-center containerSpinner" style="background: rgb(199 206 213 / 50%);height: 100%;
        position: absolute;width: 100%;z-index: 1000000;">
            <div class="spinner-border m-auto text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 ">
                    <div class="alert alert-warning fv-bold messageDateEnding py-1" style="display: none;">
                        <h3 class="m-0 text-center">-</h3>
                    </div>
                </div>
            </div>
            <div class="mx-2 containerFilter">
                <form id="fdProgram">
                    <div class="row">
                        <!-- <h1>casc</h1> -->
                        <div class="col-lg-12">
                            <label for="routes" class="form-label m-0">Rutas:
                                <span class="btn btn-light hidden-danger p-0 ttRoutes" onclick="cleanRoutes();"><i class="fas fa-broom"></i></span id="idEnd">
                            </label>
                            <div class="input-group mb-3">
                                {{-- <span class="input-group-text" id="basic-addon1"><i class="fa fa-edit"></i></span> --}}
                                <select name="routes" id="routes" class="form-control" multiple>
                                    <option disabled>Seleccione rutas</option>
                                    <optgroup label="Sector 1">
                                        <option value="80" selected>80</option>
                                        <option value="81">81</option>
                                    </optgroup>
                                    <optgroup label="Sector 2">
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                    </optgroup>
                                    <optgroup label="HORA 24">
                                        <option value="60">60</option>
                                        <option value="61">61</option>
                                        <option value="62">62</option>
                                        <option value="63">63</option>
                                        <option value="64">64</option>
                                        <option value="65">65</option>
                                        <option value="66">66</option>
                                        <option value="67">67</option>
                                        <option value="68">68</option>
                                        <option value="69">69</option>
                                        <option value="70">70</option>
                                        <option value="71">71</option>
                                        <option value="72">72</option>
                                        <option value="73">73</option>
                                        <option value="74">74</option>
                                        <option value="75">75</option>
                                        <option value="76">76</option>
                                    </optgroup>
                                    <optgroup label="Sector 3">
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                        <option value="24">24</option>
                                        <option value="25">25</option>
                                        <option value="26">26</option>
                                        <option value="27">27</option>
                                        <option value="28">28</option>
                                        <option value="50">50</option>
                                        <option value="51">51</option>
                                        <option value="52">52</option>
                                        <option value="53">53</option>
                                        <option value="54">54</option>
                                        <option value="55">55</option>
                                    </optgroup>
                                    <optgroup label="HORA 24">
                                        <option value="90">90</option>
                                        <option value="91">91</option>
                                        <option value="92">92</option>
                                        <option value="93">93</option>
                                        <option value="94">94</option>
                                        <option value="95">95</option>
                                        <option value="96">96</option>
                                        <option value="97">97</option>
                                    </optgroup>
                                    <optgroup label="Sector 4">
                                        <option value="43">43</option>
                                        <option value="44">44</option>
                                        <option value="45">45</option>
                                        <option value="46">46</option>
                                        <option value="47">47</option>
                                        <option value="48">48</option>
                                        <option value="30">30</option>
                                        <option value="31">31</option>
                                        <option value="32">32</option>
                                    </optgroup>
                                    <optgroup label="Sector 5">
                                        <option value="82">82</option>
                                        <option value="83">83</option>
                                        <option value="84">84</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        {{-- <div class="col-lg-3">
                            <label for="rutas" class="form-label m-0">Mes:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-edit"></i></span>
                                <select name="month" id="month" class="form-control">
                                    <option disabled>Seleccione mes</option>
                                    <option value="Enero" {{Session::get('lastMonth') == 'enero' ? 'selected' : '' }} >Enero</option>
                                    <option value="Febrero" {{Session::get('lastMonth') == 'febrero' ? 'selected' : '' }}>Febrero</option>
                                    <option value="Marzo" {{Session::get('lastMonth') == 'marzo' ? 'selected' : '' }}>Marzo</option>
                                    <option value="Abril" {{Session::get('lastMonth') == 'abril' ? 'selected' : '' }}>Abril</option>
                                    <option value="Mayo" {{Session::get('lastMonth') == 'mayo' ? 'selected' : '' }}>Mayo</option>
                                    <option value="Junio" {{Session::get('lastMonth') == 'junio' ? 'selected' : '' }}>Junio</option>
                                    <option value="Julio" {{Session::get('lastMonth') == 'julio' ? 'selected' : '' }}>Julio</option>
                                    <option value="Agosto" {{Session::get('lastMonth') == 'agosto' ? 'selected' : '' }}>Agosto</option>
                                    <option value="Setiembre" {{Session::get('lastMonth') == 'setiembre' ? 'selected' : '' }}>Setiembre</option>
                                    <option value="Octubre" {{Session::get('lastMonth') == 'octubre' ? 'selected' : '' }}>Octubre</option>
                                    <option value="Noviembre" {{Session::get('lastMonth') == 'noviembre' ? 'selected' : '' }}>Noviembre</option>
                                    <option value="Diciembre" {{Session::get('lastMonth') == 'diciembre' ? 'selected' : '' }}>Diciembre</option>
                                </select>
                            </div>
                        </div> --}}
                        {{-- <div class="col-lg-3">
                            <label for="rutas" class="form-label m-0"># Meses adeudado:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-edit"></i></span>
                                <select name="monthDebt" id="monthDebt" class="form-control">
                                    <option disabled>Seleccione opcion</option>
                                    <option value="1">1</option>
                                    <option value="2" selected>2</option>
                                    <option value="3">Mayor o igual a 3</option>
                                    <option value="18">Mayor o igual a 18</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label for="rutas" class="form-label m-0">Estado:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-edit"></i></span>
                                <select name="stateReceipt" id="stateReceipt" class="form-control">
                                    <option disabled>Seleccione opcion</option>
                                    <option value="0">No pagado</option>
                                    <option value="1">Pagado</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="rutas" class="form-label m-0">Categoria:
                                <span class="btn btn-light text-danger p-0 ttCategory" onclick="cleanCategories();"><i class="fas fa-broom"></i></span>
                            </label>
                            <div class="input-group mb-3">
                                <select name="category" id="category" class="form-control" multiple>
                                    <option disabled>Seleccione opcion</option>
                                    <option value="all" selected>Todas las categorias</option>
                                    <option value="s">Social</option>
                                    <option value="d">Domestico</option>
                                    <option value="c">Comercial</option>
                                    <option value="i">Industrial</option>
                                    <option value="e">Estatal</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="rutas" class="form-label m-0">Servicios:
                                <span class="btn btn-light text-danger p-0 ttService" onclick="cleanServices();"><i class="fas fa-broom"></i></span>
                            </label>
                            <div class="input-group mb-3">
                                <select name="services" id="services" class="form-control" multiple>
                                    <option disabled>Seleccione opcion</option>
                                    <option value="all" selected>Todos</option>
                                    <option value="1">Agua y desague</option>
                                    <option value="2">Agua</option>
                                    <option value="3">Desague</option>
                                </select>
                            </div>
                        </div> --}}
                    </div>
                </form>
                <div class="col-lg-12">
                    <button class="btn btn-success w-100 fw-bold searchRecords"><i class="fa fa-search"></i> Buscar registros</button>
                </div>
            </div>
            <div class="col-lg-12">
                <button class="btn btn-success w-100 fw-bold changeSearchRecords d-none">Cambiar datos de busqueda</button>
            </div>
            <br>
            <div class="row containerAssign">
                <div class="col-lg-6">
                    <label for="tecnical" class="form-label m-0">Tecnicos:</label>
                    <div class="input-group mb-3">
                        <select name="tecnical" id="tecnical" class="form-control" disabled>
                            {{-- <option value="0" disabled>Seleccione tecnico para el programa</option> --}}
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <label style="visibility: hidden;">Tecnicos:</label>
                    <div class="fomr-control">
                        <button class="btn btn-primary w-100 fv-bold assignLecturas" disabled><i class="fa fa-list"></i> Asignar Lecturas</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 m-auto p-3 shadow containerRecords">
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
                            </tr>
                        </thead>
                        <tbody id="records">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="modal fade" id="modalEnding" tabindex="-1" aria-labelledby="modalEndingLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEndingLabel">Crear fecha de finalizacion de PROGRAMAS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>cvdsvds</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary saveEvidence">Guardar evidencias</button>
            </div>
        </div>
    </div>
</div> --}}
<div class="modal fade" id="modalEnding" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEndingLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEndingLabel">Crear fecha de finalizacion de PROGRAMAS</h5>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 containerLastEnding">
                        <div class="alert alert-primary" role="alert">
                            Ultima fecha de finalizacion registrada: <span class="lastEnding">-</span> <a href="#" class="alert-link updateLastEnding">. Modificar fecha de finalizacion.</a>
                        </div>
                    </div>
                    <div class="col-lg-12 containerNew" style="display: none;">
                        <div class="alert alert-primary" role="alert">
                            Registrar nueva fecha de finalzacion <a href="#" class="alert-link registerNew">NUEVO.</a>
                        </div>
                    </div>
                </div>
                <form id="fvending">
                    <input type="hidden" id="idEnd" name="idEnd">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="date" class="form-label">Fecha de la finalización: <span class="text-danger">*</span></label>
                            <div class="input-group date" id="dateEnding" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input inputDate" data-target="#dateEnding" id="date" name="date" autocomplete="off">
                                <button class="btn btn-outline-secondary" type="button" data-target="#dateEnding" data-toggle="datetimepicker">
                                    <i class="fa fa-calendar-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="hour" class="form-label">Hora de la finalización: <span class="text-danger">*</span></label>
                            <div class="input-group time" id="hourEnding" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input inputDate" data-target="#hourEnding" id="hour" name="hour" autocomplete="off">
                                <button class="btn btn-outline-secondary" type="button" data-target="#hourEnding" data-toggle="datetimepicker">
                                    <i class="fa fa-clock"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                <button type="button" class="btn btn-primary saveEnding"><i class="fa fa-save"></i> Guardar fecha de finalizacion de los programas</button>
                <button type="button" class="btn btn-primary saveChangeEnding" style="display: none;"><i class="fa fa-save"></i> Actualizar fecha de finalizacion</button>
            </div>
        </div>
    </div>
</div>
<script>
var tableRecords;
var amountRecordsFilter;
localStorage.setItem("nba",1);
$(document).ready( function ()
{
    tableRecords = $('.containerRecords').html();
    initToolTip();
    // fillRecords();
    searchEnding();
    fillRecordsTecnical();
    initFv('fvending',rules());
    $('#routes').select2({placeholder: "Seleccione las rutas..."});
    $('#services').select2({closeOnSelect: false,placeholder: "Seleccione los servicios..."});
    $('#category').select2({closeOnSelect: false,placeholder: "Seleccione las categorias..."});
    $('#tecnical').select2();
    $('#dateEnding').datetimepicker({format: 'YYYY-MM-DD',minDate: moment()});
    $('#hourEnding').datetimepicker({format: 'LT'});

    $('.overlayPage').css("display","none");
});
$('.inputDate').on('click',function(){$(this).parent().find('button').click();});
function rules()
{
    return {
        date: {required: true,},
        hour: {required: true,},
    };
}
$('.saveEnding').on('click',function(){
    if($('#fvending').valid()==false)
    {return;}
    var formData = new FormData($("#fvending")[0]);
    $('.saveEnding').prop('disabled',true);
    $('.overlayPage').css("display","flex");
    jQuery.ajax({
        url: "{{ route('saveEnding') }}",
        data: formData,
        method: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
        success: function (r) {
            console.log(r);
            if(r.state)
            {
                $('#tecnical').select2('destroy');
                fillRecordsTecnical();
                $('.messageDateEnding>h3').html('Fecha de finalizacion de los programas: '+formatDate(r.end.date)+' | a las '+r.end.hour);
                $('.messageDateEnding').css('display','block');
                $('#modalEnding').modal('hide')
            }

            notifyGlobal(r);
            $('.overlayPage').css("display","none");
            $('.saveEnding').prop('disabled',false);
        },
        error: function (xhr, status, error) {
            console.log("Algo salio mal, porfavor contactese con el Administrador.");
            $('.overlayPage').css("display","none");
        }
    });
});
$('.registerNew').on('click',function(){
    changeInfo(false);
});
function changeInfo(flat)
{
    if(flat)
    {
        $('#idEnd').val(r.end.idEnd);
        $('.containerLastEnding').css('display','none');
        $('.containerNew').css('display','block');
        $('#date').parent().parent().find('label').html('Actualizar fecha de la finalizacion: <span class="text-danger">*</span>');
        $('#date').val(r.end.date);
        $('#hour').parent().parent().find('label').html('Actualizar hora de la finalizacion: <span class="text-danger">*</span>');
        $('#hour').val(r.end.hour);
        $('.saveChangeEnding').css('display','block');
        $('.saveEnding').css('display','none');
    }
    else
    {
        $('#idEnd').val('');
        $('.containerLastEnding').css('display','block');
        $('.containerNew').css('display','none');
        $('#date').parent().parent().find('label').html('Fecha de la finalización: <span class="text-danger">*</span>');
        $('#date').val('');
        $('#hour').parent().parent().find('label').html('Hora de la finalización: <span class="text-danger">*</span>');
        $('#hour').val('');
        $('.saveChangeEnding').css('display','none');
        $('.saveEnding').css('display','block');
    }
}
$('.saveChangeEnding').on('click',function(){
    if($('#fvending').valid()==false)
    {return;}
    var formData = new FormData($("#fvending")[0]);
    $('.saveChangeEnding').prop('disabled',true);
    $('.overlayPage').css("display","flex");
    jQuery.ajax({
        url: "{{ route('saveChangeEnding') }}",
        data: formData,
        method: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
        success: function (r) {
            console.log(r);
            if(r.state)
            {
                $('#tecnical').select2('destroy');
                fillRecordsTecnical();
                $('.messageDateEnding>h3').html('Fecha de finalizacion de los programas: '+formatDate(r.end.date)+' | a las '+r.end.hour);
                $('.messageDateEnding').css('display','block');
                $('#modalEnding').modal('hide')
            }
            $('.saveChangeEnding').prop('disabled',false);
            notifyGlobal(r);
            $('.overlayPage').css("display","none");
            // $('.saveEnding').prop('disabled',false);
        },
        error: function (xhr, status, error) {
            console.log("Algo salio mal, porfavor contactese con el Administrador.");
            $('.overlayPage').css("display","none");
        }
    });
});
$('.updateLastEnding').on('click',function(){
    jQuery.ajax({
        url: "{{ route('updateEnding') }}",
        method: 'POST',
        data: {idEnd: $(this).attr('data-idEnd')},
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
        success: function (r) {
            console.log(r)
            if(r.state)
            {
                $('#idEnd').val(r.end.idEnd);
                $('.containerLastEnding').css('display','none');
                $('.containerNew').css('display','block');
                $('#date').parent().parent().find('label').html('Actualizar fecha de la finalizacion: <span class="text-danger">*</span>');
                $('#date').val(r.end.date);
                $('#hour').parent().parent().find('label').html('Actualizar hora de la finalizacion: <span class="text-danger">*</span>');
                $('#hour').val(r.end.hour);
                $('.saveChangeEnding').css('display','block');
                $('.saveEnding').css('display','none');
            }
            else
            {
                notifyGlobal(r);
            }
            // notifyGlobal(r);
        },
        error: function (xhr, status, error) {
            console.log("Algo salio mal, porfavor contactese con el Administrador.");
        }
    });
});
$('.changeSearchRecords').on('click',function(){
    $(".containerFilter").removeClass("d-none");
    $(".containerFilter").addClass("d-block");

    $(".changeSearchRecords").removeClass("d-flex");
    $(".changeSearchRecords").addClass("d-none");

    $('#tecnical').attr('disabled',true)
    $('.assignLecturas').attr('disabled',true)
});
$('.assignLecturas').on('click',function(){
    if(amountRecordsFilter!=0 && $('#tecnical').val()!==null)
    {
        $('.overlayPage').css("display","flex");
        jQuery.ajax({
            url: "{{ route('assignTecnical') }}",
            method: 'POST',
            data: {idTec: $('#tecnical').val()},
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
            success: function (r) {
                console.log(r)
                if(r.state)
                {
                    // alert('Se asigno correctamente el tecnico.');
                    Swal.fire({
                        title: r.message,
                        text: r.state?"La informacion fue registrada":'',
                        icon: r.state? "success" : "error",
                    });
                    // $('#tecnical').find('option[value="' + $('#tecnical').val() + '"]').remove();
                    // $('#tecnical').trigger('change.select2');
                    $('.changeSearchRecords').click();
                    $('#tecnical').val('0').trigger('change');
                }
                else
                {
                    alert('Algo salio mal, porfavor contactese con el Administrador.');
                }
                $('.overlayPage').css("display","none");
            },
            error: function (xhr, status, error) {
                console.log("Algo salio mal, porfavor contactese con el Administrador.");
                $('.overlayPage').css("display","none");
            }
        });
    }
    else
    {
        alert('Es necesario contar con registros de ususario para asignar, como tambien asignar tecnico');
    }
});
$('.searchRecords').on('click',function(){
    var fd = new FormData($("#fdProgram")[0]);
    // formData.append('items',JSON.stringify(itemsCcmn));
    fd.append('routes',$('#routes').val());
    fd.append('services',$('#services').val());
    fd.append('categories',$('#category').val());
    fd.append('nameMonth',$('#month option:selected').html());

    // var element = fd.get('routes');cscas
    // console.log(element)csaca
    $(".containerSpinner").removeClass("d-none");
    $(".containerSpinner").addClass("d-flex");
    jQuery.ajax({
        url: "{{ route('searchRecords') }}",
        method: 'POST',
        data: fd,
        dataType: 'json',
        processData: false,
        contentType: false,
        headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
        success: function (r) {
            console.log(r.ppp)
            console.log(r);
            ppp=r;
            buildTable();
            amountRecordsFilter = r.data.length;
            let html = '';
            let countRecords = 0;
            for (var i = 0; i < r.data.length; i++)
            {
                countRecords++;
                html += '<tr>' +
                    '<td class="align-middle text-center">' + countRecords + '</td>' +
                    '<td class="align-middle text-center">' + novDato(r.data[i].code) + '</td>' +
                    '<td class="align-middle text-center">' + novDato(r.data[i].cod) + '</td>' +
                    '<td class="align-middle text-center">' + novDato(r.data[i].numberInscription) + '</td>'+
                    '<td class="align-middle">' + novDato(r.data[i].client) + '</td>'+
                    '<td class="align-middle">' + novDato(r.data[i].streetDescription) + '</td>'+
                    '<td class="align-middle text-center">' + novDato(r.data[i].rate) + '</td>'+
                    '<td class="align-middle text-center">' + novDato(r.data[i].meter) + '</td>'+
                '</tr>';
            }
            $('#records').html(html);
            initDatatable('tableCuts');
            $(".containerSpinner").removeClass("d-flex");
            $(".containerSpinner").addClass("d-none");
// ----
            $(".containerFilter").addClass("d-none");
            activateAssign();
            $(".changeSearchRecords").removeClass("d-none");
            $(".changeSearchRecords").addClass("d-block");
        },
        error: function (xhr, status, error) {
            console.log("Algo salio mal, porfavor contactese con el Administrador.");
        }
    });
})
function searchEnding()
{
    jQuery.ajax({
        url: "{{ route('searchEnding') }}",
        method: 'POST',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
        success: function (r) {
            console.log(r);
            r.time = 9000;
            if(r.state)
            {
                if(r.modal)
                {
                    if(r.end!=null)
                    {
                        console.log('ay un registro');
                        $('.containerLastEnding').css('display','block');
                        $('.lastEnding').html(formatDate(r.end.date)+' | a las '+r.end.hour);
                        $('.updateLastEnding').attr('data-idEnd',r.end.idEnd);
                    }
                    else
                    {
                        console.log('null')
                    }
                    notifyGlobal(r)
                    $('#modalEnding').modal('show');
                }
                else
                {

                    $('.messageDateEnding>h3').html('Fecha de finalizacion de los programas: '+formatDate(r.end.date)+' | a las '+r.end.hour);
                    $('.messageDateEnding').css('display','block');
                }
            }
            else
                notifyGlobal(r)
        },
        error: function (xhr, status, error) {
            console.log("Algo salio mal, porfavor contactese con el Administrador.");
        }
    });

}
function activateAssign()
{
    $('#tecnical').attr('disabled',false)
    $('.assignLecturas').attr('disabled',false)
}
function buildTable()
{
    $('.containerRecords>div').remove();
    $('.containerRecords').html(tableRecords);
}
function fillRecordsTecnical()
{
    jQuery.ajax({
        url: "{{ url('tecnical/list') }}",
        method: 'get',
        success: function (r) {

            $('#tecnical').append("<option value='0' disabled selected>Seleccione tecnico para el programa</option>");
            $.each(r.data,function(indice,fila){
                if(fila.type===null)
                    $('#tecnical').append("<option value='"+fila.idTec+"'>"+fila.dni+' - '+fila.name+"</option>");
            });
            $('#tecnical').select2();
        },
        error: function (xhr, status, error) {
            console.log("Algo salio mal, porfavor contactese con el Administrador.");
        }
    });
}
function fillRecords()
{
    $(".containerSpinner").removeClass("d-none");
    $(".containerSpinner").addClass("d-flex");
    jQuery.ajax({
        url: "{{ url('court/showCourtFilter') }}",
        method: 'get',
        success: function (r) {
            console.log(r);
            let html = '';
            let countRecords = 0;
            for (var i = 0; i < r.data.length; i++)
            {
                countRecords++;
                html += '<tr>' +
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
                '</tr>';
            }
            $('#records').html(html);
            initDatatable('tableCuts');
            // $('.containerSpinner').css('display','none !important');
            $(".containerSpinner").removeClass("d-flex");
            $(".containerSpinner").addClass("d-none");
        },
        error: function (xhr, status, error) {
            console.log("Algo salio mal, porfavor contactese con el Administrador.");
        }
    });
}
function cleanRoutes(){$('#routes').val(null).trigger('change');}
function cleanCategories(){$('#category').val(null).trigger('change');}
function cleanServices(){$('#services').val(null).trigger('change');}
function initToolTip()
{
    tippy('.ttRoutes', {content: "Limpiar caja de rutas.",});
    tippy('.ttCategory', {content: "Limpiar caja de categorias.",});
    tippy('.ttService', {content: "Limpiar caja de servicios.",});
}
</script>
<script src="{{asset('escn/public/plugins/datatables/dataTables.js')}}"></script>
<script src="{{asset('escn/public/plugins/datatables/dataTables.responsive.js')}}"></script>
<script src="{{asset('escn/public/plugins/datatables/responsive.dataTables.js')}}"></script>
@endsection
