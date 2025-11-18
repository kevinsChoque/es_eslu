@extends('layout.layout')
@section('content')
{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
<link rel="stylesheet" href="{{asset('escn/public/plugins/select2/select2.min.css')}}">
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
<script src="{{asset('escn/public/plugins/select2/select2.min.js')}}"></script>

<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>

{{-- --- --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js" integrity="sha512-L0Shl7nXXzIlBSUUPpxrokqq4ojqgZFQczTYlGjzONGTDAcLremjwaWv5A+EDLnxhQzY5xUZPWLOLqYRkY0Cbw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{{-- --- --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js" integrity="sha512-RCgrAvvoLpP7KVgTkTctrUdv7C6t7Un3p1iaoPr1++3pybCyCsCZZN7QEHMZTcJTmcJ7jzexTO+eFpHk4OCFAg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js" integrity="sha512-hUhvpC5f8cgc04OZb55j0KNGh4eh7dLxd/dPSJ5VyzqDWxsayYbojWyl5Tkcgrmb/RVKCRJI1jNlRbVP4WWC4w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css" integrity="sha512-YdYyWQf8AS4WSB0WWdc3FbQ3Ypdm0QCWD2k4hgfqbQbRCJBEgX0iAegkl2S1Evma5ImaVXLBeUkIlP6hQ1eYKQ==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
<div class="container-fluid mt-1">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header py-0">
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool py-0 updateMontoCotSegunTipoMes" style="float: right;">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body containerAdvanceCuts">
                    <h3 class="text-center">AVANCE DE CORTES</h3>
                    {{-- <ul>
                        <li><span class="badge bg-danger">-</span> Usuarios q estan cortados</li>
                        <li><span class="badge bg-primary">-</span> Usuarios q estan cortados y ya fueron activados</li>
                        <li><span class="badge bg-danger">-</span> + <span class="badge bg-primary">-</span> Total de cortes</li>
                        <li><span class="badge bg-secondary">-</span> Usuarios faltantes de corte</li>
                    </ul> --}}
                    <ul class="list-inline d-flex justify-content-between">
                        <li class="list-inline-item">
                            <span class="badge bg-danger">-</span> Usuarios que están cortados
                        </li>
                        <li class="list-inline-item">
                            <span class="badge bg-primary">-</span> Usuarios que están cortados y ya fueron activados
                        </li>
                        <li class="list-inline-item">
                            <span class="badge bg-danger">-</span> + <span class="badge bg-primary">-</span> Total de cortes
                        </li>
                        <li class="list-inline-item">
                            <span class="badge bg-secondary">-</span> Usuarios faltantes de corte
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            {{-- <canvas id="graficoTiempo"></canvas> --}}
            <canvas id="graficoTiempo" width="400" height="200"></canvas>
        </div>
        <div class="col-lg-6" style="display: none;">
            <div class="card">
                <div class="card-body">
                    <canvas id="miGraficoDeBarras"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6" style="display: none;">
            <div class="card">
                <div class="card-header py-0">
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool py-0 updateMontoCotSegunTipoMes" style="float: right;">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="miGraficoDeBarras2"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Adaptador de tiempo: date-fns -->
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>



<script>
    $(document).ready( function ()
    {
        sumary();
    });
    let chart; // fuera de la función
function sumary2() {
    $.ajax({
        url: "{{ route('sumary') }}",
        method: 'GET',
        success: function (r) {
            const data = r.data.map(item => ({ timestamp: new Date(item.timestamp) }));

            const datasets = [];
            let segment = [];
            let lastTime = null;

            for (let i = 0; i < data.length; i++) {
                const current = data[i];
                if (lastTime) {
                    const diff = (current.timestamp - lastTime) / 60000; // Diferencia en minutos
                    if (diff > 10) {
                        // Cierra segmento anterior
                        datasets.push({
                            label: `Segmento hasta ${lastTime.toISOString()}`,
                            data: segment.map((p, idx) => ({ x: p.timestamp, y: idx + 1 })),
                            fill: false,
                            borderColor: 'blue',
                            tension: 0.1
                        });

                        // Cuadro de pausa
                        datasets.push({
                            label: `Pausa >10min desde ${lastTime.toISOString()}`,
                            data: [
                                { x: lastTime, y: segment.length },
                                { x: current.timestamp, y: segment.length + 1 }
                            ],
                            fill: false,
                            borderColor: 'red',
                            borderDash: [5, 5],
                            tension: 0.1
                        });

                        segment = []; // Reinicia el segmento
                    }
                }
                segment.push(current);
                lastTime = current.timestamp;
            }

            // Agrega el último segmento
            if (segment.length > 0) {
                datasets.push({
                    label: 'Segmento final',
                    data: segment.map((p, idx) => ({ x: p.timestamp, y: idx + 1 })),
                    fill: false,
                    borderColor: 'blue',
                    tension: 0.1
                });
            }

            new Chart(document.getElementById("graficoTiempo"), {
                type: 'line',
                data: {
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                unit: 'minute'
                            }
                        },
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: true
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    }
                }
            });
        }
    });
}

    function sumary()
    {
        $.ajax({
            url: "{{ route('sumary') }}",
            method: 'GET',
            success: function (r) {
                const labels = r.data.map(item => item.timestamp);
                const values = r.data.map((_, i) => i + 1);

                if (chart) chart.destroy(); // Limpia el gráfico anterior

                chart = new Chart(document.getElementById("graficoTiempo"), {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Eventos en el tiempo',
                            data: values,
                            fill: false,
                            borderColor: 'blue',
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                type: 'time',
                                time: {
                                    unit: 'minute'
                                }
                            },
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        });
    }



</script>
<script>
localStorage.setItem('nba',3)
$(document).ready( function ()
{
    $('.overlayPage').css("display","none");
    advanceCuts();
});
function advanceCuts()
{
    jQuery.ajax({
        url: "{{ route('advanceCuts') }}",
        method: 'POST',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
        success: function (r) {
            console.log(r);
            let html='';
            let porcentaje;
            // recordsOnlyAct
            let combined = r.recordsOnlyCuts.map(obj1 => {
                let obj2 = r.recordsOnlyAct.find(obj => obj.idAss === obj1.idAss);
                return { ...obj1, ...obj2 };
            });
            console.log(combined)
            for (var i = 0; i < combined.length; i++)
            {
                porcentaje = ((combined[i].cant/combined[i].total)*100).toFixed(2);
                porcentajeAct = ((combined[i].cantAct/combined[i].total)*100).toFixed(2);

                percentageMissingCuts = combined[i].cantAct===undefined?(100 - porcentaje).toFixed(2):(100 - porcentaje - porcentajeAct).toFixed(2);
                cantMissingCuts = combined[i].cantAct===undefined?combined[i].total - combined[i].cant:combined[i].total - combined[i].cant - combined[i].cantAct;
                accordingCant = combined[i].cantAct===undefined?'':'<div class="progress-bar bg-primary" role="progressbar" style="width: ' + porcentajeAct + '%" aria-valuenow="'+ porcentajeAct +'" aria-valuemin="0" aria-valuemax="' + combined[i].total + '">'+ porcentajeAct +'% ('+combined[i].cantAct+')</div>';

                html += '<p class="m-0">' + combined[i].name + ' | Usuarios: ' + combined[i].total + '</p>'+
                '<div class="progress mb-3">'+
                    '<div class="progress-bar bg-danger" role="progressbar" style="width: ' +
                    porcentaje + '%" aria-valuenow="'+ porcentaje +'" aria-valuemin="0" aria-valuemax="' + combined[i].total + '">'+ porcentaje +'% ('+combined[i].cant+')</div>'+
                    accordingCant +
                    '<div class="progress-bar bg-secondary fw-bold" role="progressbar" style="width: ' +
                    percentageMissingCuts + '%" aria-valuenow="' + percentageMissingCuts + '" aria-valuemin="0" aria-valuemax="100">' + percentageMissingCuts + '% ('+cantMissingCuts+')</div>'+
                '</div>';
            }
            $('.containerAdvanceCuts').append(html);
        },
        error: function (xhr, status, error) {
            console.log("Algo salio mal, porfavor contactese con el Administrador.");
            // $('.overlayPage').css("display","none");
        }
    });
}
$(document).ready(function() {
    var ctx = $('#miGraficoDeBarras')[0].getContext('2d');
    var miGraficoDeBarras = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
            datasets: [{
                label: 'Ventas',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    miGraficoDeBarras2()

});
// ---------------
// ---------------
// ---------------
// ---------------
// ---------------
// ---------------
// ---------------
// ---------------
// ---------------
// ---------------
// ---------------
// ---------------
const MONTHS = [
  'January',
  'February',
  'March',
  'April',
  'May',
  'June',
  'July',
  'August',
  'September',
  'October',
  'November',
  'December'
];
var _seed = Date.now();
const DATA_COUNT = 7;
const NUMBER_CFG = {count: DATA_COUNT, min: -100, max: 100};
function months(config) {
  var cfg = config || {};
  var count = cfg.count || 12;
  var section = cfg.section;
  var values = [];
  var i, value;

  for (i = 0; i < count; ++i) {
    value = MONTHS[Math.ceil(i) % 12];
    values.push(value.substring(0, section));
  }

  return values;
}
function rand(min, max) {
  min = valueOrDefault(min, 0);
  max = valueOrDefault(max, 0);
  _seed = (_seed * 9301 + 49297) % 233280;
  return min + (_seed / 233280) * (max - min);
}
function numbers(config) {
  var cfg = config || {};
  var min = valueOrDefault(cfg.min, 0);
  var max = valueOrDefault(cfg.max, 100);
  var from = valueOrDefault(cfg.from, []);
  var count = valueOrDefault(cfg.count, 8);
  var decimals = valueOrDefault(cfg.decimals, 8);
  var continuity = valueOrDefault(cfg.continuity, 1);
  var dfactor = Math.pow(10, decimals) || 0;
  var data = [];
  var i, value;

  for (i = 0; i < count; ++i) {
    value = (from[i] || 0) + rand(min, max);
    if (rand() <= continuity) {
      data.push(Math.round(dfactor * value) / dfactor);
    } else {
      data.push(null);
    }
  }

  return data;
}
const valueOrDefault = (value, defaultValue) => {
    return value !== undefined ? value : defaultValue;
};
const CHART_COLORS = {
  red: 'rgb(255, 99, 132)',
  orange: 'rgb(255, 159, 64)',
  yellow: 'rgb(255, 205, 86)',
  green: 'rgb(75, 192, 192)',
  blue: 'rgb(54, 162, 235)',
  purple: 'rgb(153, 102, 255)',
  grey: 'rgb(201, 203, 207)'
};
function miGraficoDeBarras2()
{
    const DATA_COUNT = 7;
    const NUMBER_CFG = {count: DATA_COUNT, min: -100, max: 100};

    // const labels = months({count: 7});
    const labels = ['felipe','juan','edi','edu','pedro','rafael','felix'];
    const data = {
        labels: labels,
        datasets: [
            {
                label: 'cortes',
                // data: numbers(NUMBER_CFG),
                data: [12,2,3,4,5,6,9],
                backgroundColor: CHART_COLORS.red,
                stack: 'Stack 0',
            },
            {
                label: 'cortes q pagaron',
                // data: numbers(NUMBER_CFG),
                data: [3,5,3,12,5,6,6],
                backgroundColor: CHART_COLORS.blue,
                stack: 'Stack 0',
            },
            {
                label: 'cortes activados',
                data: [3,5,3,12,5,6,6],
                backgroundColor: CHART_COLORS.yellow,
                stack: 'Stack 0',
            },
            {
                label: 'pagaron',
                data: [3,5,3,12,5,6,6],
                backgroundColor: CHART_COLORS.green,
                stack: 'Stack 0',
            },
            {
                label: 'cortes faltantes',
                data: [3,5,3,12,5,6,6],
                backgroundColor: CHART_COLORS.grey,
                stack: 'Stack 0',
            },
        ]
        };
    const config = {
        type: 'bar',
        data: data,
        options: {
            plugins: {
            title: {
                display: true,
                text: 'avance de cada tecnico'
            },
            },
            responsive: true,
            interaction: {
                intersect: false,
            },
            scales: {
                x: {stacked: true,},
                y: {stacked: true}
            }
        }
    };
    var ctx2 = $('#miGraficoDeBarras2')[0].getContext('2d');
    var miGraficoDeBarras2 = new Chart(ctx2,config)
}
</script>
@endsection
