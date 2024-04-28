<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Histórico ' . $sensor) }}
        </h2>
    </x-slot>

    <div id="py-12" style="margin-bottom:70px">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 d-flex flex-column mb-4">
            <div class="mt-4 mb-5 container-fluid">
                <div class="card shadow mb-4" id="chart01">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Gráfico do Mês de {{$mes_atual}}</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="mes_atual"></canvas>
                            <h3 id="sem_dados"></h3>
                        </div>
                        <hr/>
                        <p id="legenda_mes">{!! $description !!}</p>
                    </div>
                </div>
                <div class="card shadow mb-4" id="chart02">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Gráfico do Mês de {{$mes_anterior}}</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="mes_anterior"></canvas>
                            <h3 id="sem_dados_mes_anterior"></h3>
                        </div>
                        <hr/>
                        <p id="legenda_mes_anterior">{!! $description !!}</p>
                    </div>
                </div>

                <!-- Tabelas -->
                @empty($data)
                    <h1 style="color:#1161ee;">Sem Histórico para Demonstrar</h1>
                @else
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Histórico dos valores</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Valor</th>
                                            <th>Data de Atualização</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Valor</th>
                                            <th>Data de Atualização</th>
                                            <th>Estado</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($data as $linha)
                                            @if (!empty($linha))
                                                @php
                                                    $linha = explode(';', $linha);
                                                    $valor = intval($linha[1]);
                                                @endphp
                                                <tr>
                                                    <td>{{ $linha[1] }}</td>
                                                    <td>{{ $linha[0] }}</td>
                                                    <td>
                                                        @switch($name)
                                                            @case('temperatura_armazem')
                                                            @case('temperatura_rececao')
                                                                @if ($valor < 6)
                                                                    <span class="badge rounded-pill bg-danger">Temperatura Demasiado Baixa - Perigo</span>
                                                                @elseif ($valor < 12)
                                                                    <span class="badge rounded-pill bg-warning">Temperatura Baixa - Cuidado</span>
                                                                @elseif ($valor < 18)
                                                                    <span class="badge rounded-pill bg-success">Temperatura Ambiente</span>
                                                                @elseif ($valor < 25)
                                                                    <span class="badge rounded-pill bg-warning">Temperatura Alta - Cuidado</span>
                                                                @else
                                                                    <span class="badge rounded-pill bg-danger">Temperatura Demasiado Alta - Perigo</span>
                                                                @endif
                                                                @break

                                                            @case('sensorLuz_armazem')
                                                            @case('luz_rececao')
                                                                @if ($valor == 0)
                                                                    <span class="badge rounded-pill bg-info">Desligado</span>
                                                                @else
                                                                    <span class="badge rounded-pill bg-primary">Ligado</span>
                                                                @endif
                                                                @break

                                                            @case('sensor_movimento')
                                                                @if ($valor == 0)
                                                                    <span class="badge rounded-pill bg-info">Sem Movimento</span>
                                                                @else
                                                                    <span class="badge rounded-pill bg-primary">Movimento Detetado</span>
                                                                @endif
                                                                @break

                                                            @case('nivel_agua')
                                                                @if ($valor < 2)
                                                                    <span class="badge rounded-pill bg-success">Sem Indícios de Agua - Normal</span>
                                                                @elseif ($valor < 7)
                                                                    <span class="badge rounded-pill bg-warning">Agua Detetada - Cuidado</span>
                                                                @elseif ($valor < 15)
                                                                    <span class="badge rounded-pill bg-warning">Agua Execedeu Limite - Cuidado</span>
                                                                @else
                                                                    <span class="badge rounded-pill bg-danger">Nivel de Agua no Máximo - Perigo</span>
                                                                @endif
                                                                @break

                                                            @case('sensorHumidade_armazem')
                                                                @if ($valor < 10)
                                                                    <span class="badge rounded-pill bg-success">Sem Humidade Presente - Normal</span>
                                                                @elseif ($valor < 15)
                                                                    <span class="badge rounded-pill bg-warning">Alguma Humidade Detetada - Cuidado</span>
                                                                @elseif ($valor < 25)
                                                                    <span class="badge rounded-pill bg-warning">Humidade no Ar - Cuidado</span>
                                                                @else
                                                                    <span class="badge rounded-pill bg-danger">Muita Humidade no Ar - Perigo</span>
                                                                @endif
                                                                @break

                                                            @case('sensorFumo_armazem')
                                                                @if ($valor < 10)
                                                                    <span class="badge rounded-pill bg-success">Sem Fumo Presente - Normal</span>
                                                                @elseif ($valor < 15)
                                                                    <span class="badge rounded-pill bg-warning">Alguma Fumo Detetado - Cuidado</span>
                                                                @elseif ($valor < 25)
                                                                    <span class="badge rounded-pill bg-warning">Fumo no Ar - Cuidado</span>
                                                                @else
                                                                    <span class="badge rounded-pill bg-danger">Muito Fumo no Ar - Perigo</span>
                                                                @endif
                                                                @break

                                                            @case('brilho_led_armazem')
                                                                @if ($valor < 102.2)
                                                                    <span class="badge rounded-pill bg-info">Sem Brilho</span>
                                                                @elseif ($valor < 204.8)
                                                                    <span class="badge rounded-pill bg-primary">Algum Brilho</span>
                                                                @elseif ($valor < 512)
                                                                    <span class="badge rounded-pill bg-primary">Brilho Normal</span>
                                                                @elseif ($valor < 768)
                                                                    <span class="badge rounded-pill bg-primary">Brilhoso</span>
                                                                @else
                                                                    <span class="badge rounded-pill bg-success">Brilho no Máximo</span>
                                                                @endif
                                                                @break

                                                            @case('corrente_ups')
                                                                @if ($valor < 2)
                                                                    <span class="badge rounded-pill bg-danger">Sem Corrente - Perigo</span>
                                                                @elseif ($valor < 5)
                                                                    <span class="badge rounded-pill bg-warning">Baixa Corrente - Cuidado</span>
                                                                @elseif ($valor < 6)
                                                                    <span class="badge rounded-pill bg-success">Corrente Normal</span>
                                                                @elseif ($valor < 7)
                                                                    <span class="badge rounded-pill bg-warning">Corrente Acima - Cuidado</span>
                                                                @else
                                                                    <span class="badge rounded-pill bg-danger">Sobrecarga Corrente - Perigo</span>
                                                                @endif
                                                                @break

                                                            @case('disclaimer')
                                                                @php
                                                                    $divide = explode("\\n", $linha[1]);
                                                                @endphp
                                                                @if (!empty($divide[0]))
                                                                    <span class="badge rounded-pill bg-info">1ªlinha tem {{ strlen($divide[0]) }} letras</span>
                                                                @endif
                                                                @if (!empty($divide[1]))
                                                                    <span class="badge rounded-pill bg-primary">2ªlinha tem {{ strlen($divide[1]) }} letras</span>
                                                                @endif
                                                                @break

                                                            @case('porta_descargas')
                                                            @case('porta_principal')
                                                                @if ($valor == 0)
                                                                    <span class="badge rounded-pill bg-info">Porta Fechada</span>
                                                                @else
                                                                    <span class="badge rounded-pill bg-primary">Porta Aberta</span>
                                                                @endif
                                                                @break
                                                        @endswitch
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endempty
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        @if($name === "disclaimer")
            document.getElementById('chart01').remove();
            document.getElementById('chart02').remove();
        @else
            //Primeiro Grafico - Grafico Atual
            const data = @json($data_chart);
            const isEmpty = Object.keys(data).length;
            if (isEmpty == 0) {
                document.getElementById('sem_dados').innerHTML = "Sem dados para Apresentar";
                document.getElementById('legenda_mes').style.display = "none";
            }else{
                var dias = [];
                var valores = [];

                for (const [key, value] of Object.entries(data)) {
                    dias.push('Dia ' + key);
                    valores.push(value);
                }

                var ctx = document.getElementById("mes_atual");
                var myLineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dias,
                        datasets: [{
                            label: "{{ucfirst($sensor)}}",
                            lineTension: 0.3,
                            backgroundColor: "rgba(78, 115, 223, 0.05)",
                            borderColor: "rgba(78, 115, 223, 1)",
                            pointRadius: 3,
                            pointBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointBorderColor: "rgba(78, 115, 223, 1)",
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                            pointHitRadius: 10,
                            pointBorderWidth: 2,
                            data: valores,
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                left: 10,
                                right: 25,
                                top: 25,
                                bottom: 0
                            }
                        },
                        legend: {
                            display: false
                        },
                        tooltips: {
                            backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            titleMarginBottom: 10,
                            titleFontColor: '#6e707e',
                            titleFontSize: 14,
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            intersect: false,
                            mode: 'index',
                            caretPadding: 10,
                        }
                    }
                });
            }

            // Segundo Grafico - Mes Anterior
            const data2 = @json($data_chart_anterior);
            const isEmpty2 = Object.keys(data).length;
            if (isEmpty2 == 0) {
                document.getElementById('sem_dados_mes_anterior').innerHTML = "Sem dados para Apresentar";
                document.getElementById('legenda_mes_anterior').style.display = "none";
            }else{
                var dias = [];
                var valores = [];

                for (const [key, value] of Object.entries(data2)) {
                    dias.push('Dia ' + key);
                    valores.push(value);
                }

                var ctx = document.getElementById("mes_anterior");
                var myLineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dias,
                        datasets: [{
                            label: "{{ucfirst($sensor)}}",
                            lineTension: 0.3,
                            backgroundColor: "rgba(78, 115, 223, 0.05)",
                            borderColor: "rgba(78, 115, 223, 1)",
                            pointRadius: 3,
                            pointBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointBorderColor: "rgba(78, 115, 223, 1)",
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                            pointHitRadius: 10,
                            pointBorderWidth: 2,
                            data: valores,
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                left: 10,
                                right: 25,
                                top: 25,
                                bottom: 0
                            }
                        },
                        legend: {
                            display: false
                        },
                        tooltips: {
                            backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            titleMarginBottom: 10,
                            titleFontColor: '#6e707e',
                            titleFontSize: 14,
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            intersect: false,
                            mode: 'index',
                            caretPadding: 10,
                        }
                    }
                });
            }
        @endif
    </script>
</x-app-layout>

