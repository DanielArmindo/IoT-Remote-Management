<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Status Casa de Banho') }}
        </h2>
    </x-slot>

    <div id="py-12" style="margin-bottom:70px">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 d-flex flex-column mb-4">
            <div class="mt-4 mb-5 container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h4 mb-0 text-gray-800"><b>Sensores</b></h1>
                </div>
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    <div class="col">
                        <div class="card h-100">
                            <h5 class="card-header card-title" style="margin-bottom: 20px;">Movimento</h5>
                            <img src="
                            {{intval($movimento['valor']) === 0 ?
                            asset('images/bath/nmovimento.png'):
                            asset('images/bath/movimento.png')}}
                            "
                            style="width:150px;height:150px; margin-left: 17px;"
                            class="img-fluid card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Estado - <b>
                                    {{intval($movimento['valor']) === 0 ? 'Sem Movimento' : 'Detetado' }}
                                </b></h5>
                                <p class="card-text">Deteta movimento na divisão e acende a luz da mesma.</p>
                                <a href="{{route('warehouse.history',['name'=>'sensor_movimento'])}}" class="btn btn-outline-primary btn-sm">Visualizar Gráficamente e Historicamente</a>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Última Atualização - <b>{{$movimento['data_hora']}}</b></small>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <h5 class="card-header card-title">Nível da Água</h5>
                            <img src="{{asset('images/bath/nivel_agua.png')}}" class="img-fluid card-img-top"
                            style="width:150px;height:150px; margin-left: 17px;"
                            alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Valor - <b>{{$agua['valor']}}</b></h5>
                                <p class="card-text">Nivel da água presente na casa de banho do armazem medido a partir do solo.</p>
                                <a href="{{route('warehouse.history',['name'=>'nivel_agua'])}}" class="btn btn-outline-primary btn-sm">Visualizar Gráficamente e Historicamente</a>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Última Atualização - <b>{{$agua['data_hora']}}</b></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h4 mb-0 text-gray-800" style="margin-top: 30px;"><b>Atuadores</b></h1>
                </div>
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    <div class="col">
                        <div class="card h-100">
                            <h5 class="card-header card-title">Luz</h5>
                            <img src="
                            {{intval($movimento['valor']) === 0 ?
                            asset('images/rececao/sem_luz.png'):
                            asset('images/rececao/luz.png')}}
                            "
                            style="width:150px;height:150px;"
                            class="img-fluid card-img-top"  alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Estado - <b>
                                {{intval($movimento['valor']) === 0 ? 'Desligado' : 'Ligado' }}
                                </b></h5>
                                <p class="card-text">Verificação do estado da luz na divisão. Este valor muda consoante o movimento na divisão.</p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted"><b>Atenção</b>: A última atualização corresponde à deteção de movimento</small>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <h5 class="card-header card-title">Aspersor de Água</h5>
                            <img src="
                            {{intval($agua['valor']) > 4 ?
                            asset('images/bath/dispersor.png'):
                            asset('images/bath/ndispersor.png')}}
                            "
                            style="width:150px;height:150px;"
                            class="img-fluid card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Estado -
                                    {{intval($agua['valor']) > 4 ? 'Ligado' : 'Desligado' }}
                                </h5>
                                <p class="card-text">Dispensa água para baixo quando a altura da água atinge certo ponto.</p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted"><b>Atenção</b>: A última atualização corresponde ao sensor do nível da água</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        setTimeout(function(){
            location.reload();
        }, 5000);
    </script>
</x-app-layout>

