<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Status Armazem') }}
        </h2>
        @if(session()->get('who') === 'all')
            <p
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 4000)"
            class="text-sm text-gray-600 text-danger"
            >{{ session()->get('status') }}</p>
        @endif
    </x-slot>

    <div id="py-12" style="margin-bottom:70px">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 d-flex flex-column mb-4">
            <div class="mt-4 mb-5 container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h4 mb-0 text-gray-800"><b>Sensores</b></h1>
                </div>
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    <div class="col">
                        <div class="card h-100">
                            <h5 class="card-header card-title">Temperatura</h5>
                            <img src="{{asset('images/rececao/temperatura.png')}}"
                            style="margin-left:12px;width:150px;height:150px;"
                            class="img-fluid card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Valor - <b>{{$temperatura['valor']."ºC"}}</b></h5>
                                <p class="card-text">Valor medido no armazem, ou seja, temperatura na divisão onde se armazena os produtos.</p>
                                <a href="{{route('warehouse.history',['name'=>'temperatura_armazem'])}}" class="btn btn-outline-primary btn-sm">Visualizar Gráficamente e Historicamente</a>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Última Atualização - <b>{{$temperatura['data_hora']}}</b></small>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <h5 class="card-header card-title" style="margin-bottom: 20px ;">Humidade</h5>
                            <img src="{{asset('images/armazem/humidade.png')}}"
                            style="margin-left:12px;width:150px;height:150px;"
                            class="img-fluid card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Valor - <b>{{$humidade['valor']."%"}}</b></h5>
                                <p class="card-text">Nivel da humidade no ar presente no armazem dos produtos.</p>
                                <a href="{{route('warehouse.history',['name'=>'sensorHumidade_armazem'])}}" class="btn btn-outline-primary btn-sm">Visualizar Gráficamente e Historicamente</a>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Última Atualização - <b>{{$humidade['data_hora']}}</b></small>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <h5 class="card-header card-title" style="margin-bottom: 15px ;">Fumo</h5>
                            <img src="{{asset('images/armazem/fumo.png')}}"
                            style="margin-left:12px;width:150px;height:150px;"
                            class="img-fluid card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Valor - <b>{{$fumo['valor']."%"}}</b></h5>
                                <p class="card-text">Nível de fumo no ar presente no armazem dos produtos.</p>
                                <a href="{{route('warehouse.history',['name'=>'sensorFumo_armazem'])}}" class="btn btn-outline-primary btn-sm">Visualizar Gráficamente e Historicamente</a>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Última Atualização - <b>{{$fumo['data_hora']}}</b></small>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <h5 class="card-header card-title" style="margin-bottom: 15px ;">Luminosidade</h5>
                            <img src="{{asset('images/armazem/luminosidade.png')}}"
                            style="margin-left:12px;width:150px;height:150px;"
                            class="img-fluid card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Valor - <b>{{number_format(intval($nivel_luminosidade['valor']) * 100 / 1024, 2)."%"}}</b></h5>
                                <p class="card-text">Verifica a luminosidade presente no led do armazem.</p>
                                <a href="{{route('warehouse.history',['name'=>'brilho_led_armazem'])}}" class="btn btn-outline-primary btn-sm">Visualizar Gráficamente e Historicamente</a>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Última Atualização - <b>{{$nivel_luminosidade['data_hora']}}</b></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h4 mb-0 text-gray-800" style="margin-top: 30px;"><b>Atuadores</b></h1>
                </div>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <div class="col">
                        <div class="card h-100">
                            <h5 class="card-header card-title" style="margin-bottom: 15px;">Ventoinha</h5>
                            <img src="
                            {{
                            (intval($temperatura['valor']) > 33 || intval($fumo['valor']) > 34) ?
                                asset('images/armazem/fventoinha.png') :
                                ( (intval($temperatura['valor']) > 19 || intval($fumo['valor']) > 15) ?
                                    asset('images/armazem/ventoinha.png') :
                                    asset('images/armazem/nventoinha.png')
                                )
                            }}
                            "
                            style="width:150px;height:150px;"
                            class="img-fluid card-img-top" style="margin-left: 20px;" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Estado - <b>
                                @if(intval($temperatura['valor'])> 33 || intval($fumo['valor'])> 34)
                                    Velocidade Máxima
                                @elseif(intval($temperatura['valor'])> 19 || intval($fumo['valor'])> 15)
                                    Velocidade Normal
                                @else
                                    Desligado
                                @endif
                                </b></h5>
                                <p class="card-text">Verificação do estado da ventoinha na divisão. Este atuador serve para arrefecer a divisão e remover fumo da divisão.</p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted"><b>Atenção</b>: A última atualização corresponde ao sensor temperatura e ao sensor fumo</small>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <h5 class="card-header card-title">Alarme</h5>
                            <img src="
                            {{intval($temperatura['valor'])> 33 || intval($fumo['valor'])> 34 || intval($humidade['valor']) > 40 ?
                            asset('images/armazem/alarme.png'):
                            asset('images/armazem/nalarme.png')}}
                            "
                            style="width:150px;height:150px;"
                            class="img-fluid card-img-top" style="margin-left: 10px;margin-top:15px;" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Estado -
                                {{intval($temperatura['valor'])> 33 || intval($fumo['valor'])> 34 || intval($humidade['valor']) > 40 ?
                                'Ligado':
                                'Desligado'}}
                                </h5>
                                <p class="card-text">Verifica o estado do alarme, para avisar de possíveis problemas dentro do armazem.</p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted"><b>Atenção</b>: A última atualização corresponde ao sensor temperatura, ao sensor fumo e à humidade</small>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <h5 class="card-header card-title">Luz</h5>
                            <img src="
                            {{intval($luminosidade['valor']) !== 1023 ?
                            asset('images/rececao/luz.png'):
                            asset('images/rececao/sem_luz.png')}}
                            "
                            style="width:150px;height:150px;"
                            class="img-fluid card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Estado -
                                    {{intval($luminosidade['valor']) !== 1023 ? 'Ligado' : 'Desligado'}}
                                </h5>
                                <p class="card-text">Verifica o estado da luz consoante o nível da luminosidade no armazem.</p>
                                <a href="{{route('warehouse.history',['name'=>'sensorLuz_armazem'])}}" class="btn btn-outline-primary btn-sm">Visualizar Gráficamente e Historicamente</a>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Última Atualização - <b>{{$luminosidade['data_hora']}}</b></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h4 mb-0 text-gray-800" style="margin-top: 30px;"><b>Extras</b></h1>
                </div>
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    <div class="col">
                        <div class="card h-100">
                            <h5 class="card-header card-title">Porta Descargas</h5>
                            <img src="
                            {{intval($porta_descargas['valor']) === 0 ?
                            asset('images/armazem/ngaragem.png'):
                            asset('images/armazem/garagem.png')}}
                            "
                            style="margin-left:15px;width:150px;height:150px;margin-top: 15px;"
                            class="img-fluid card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Estado -
                                    {{intval($porta_descargas['valor']) === 0 ? 'Fechada' : 'Aberta'}}
                                </h5>
                                <p class="card-text">Verifica o estado da porta onde são feitas as descargas através dos camiões no armazem.</p>
                                <a href="{{route('warehouse.history',['name'=>'porta_descargas'])}}" class="btn btn-outline-primary btn-sm">Visualizar Gráficamente e Historicamente</a>
                                <form action="{{ route('warehouse.update',['sensor'=>'porta_descargas']) }}" method="post" class="mt-2">
                                    @csrf
                                    <button class="btn btn-outline-primary btn-sm">Alterar Estado</button>
                                </form>
                                @if(session()->get('who') === 'porta_descargas')
                                    <br/>
                                    <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 6000)"
                                    class="text-sm text-gray-600 text-success"
                                    >{{ session()->get('status') }}</p>
                                @endif
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Última Atualização - <b>{{$porta_descargas['data_hora']}}</b></small>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <h5 class="card-header card-title">Porta Funcionários</h5>
                            <img src="
                            {{intval($porta_funcionarios['valor']) === 0 ?
                            asset('images/armazem/nporta.png'):
                            asset('images/armazem/porta.png')}}
                            "
                            style="margin-left:15px;width:150px;height:150px;margin-top: 15px;"
                            class="img-fluid card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Estado -
                                    {{intval($porta_funcionarios['valor']) === 0 ? 'Fechada' : 'Aberta'}}
                                </h5>
                                <p class="card-text">Verifica o estado da porta dos funcionários no armazem.</p>
                                <a href="{{route('warehouse.history',['name'=>'porta_principal'])}}" class="btn btn-outline-primary btn-sm">Visualizar Gráficamente e Historicamente</a>
                                <form action="{{ route('warehouse.update',['sensor'=>'porta_principal']) }}" method="post" class="mt-2">
                                    @csrf
                                    <button class="btn btn-outline-primary btn-sm">Alterar Estado</button>
                                </form>
                                @if(session()->get('who') === 'porta_principal')
                                    <br/>
                                    <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 6000)"
                                    class="text-sm text-gray-600 text-success"
                                    >{{ session()->get('status') }}</p>
                                @endif
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Última Atualização - <b>{{$porta_funcionarios['data_hora']}}</b></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-md-2 g-4" style="margin-top: 15px;">
                    <div class="col">
                        <div class="card h-100">
                            <h5 class="card-header card-title">Corrente</h5>
                            <img src="{{asset('images/armazem/corrente.png')}}"
                            style="width:150px;height:150px;margin-top: 15px; margin-left:15px;"
                            class="img-fluid card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Valor - {{$corrente['valor'].'A'}}</h5>
                                <p class="card-text">Verifica o valor da corrente ligada à ups(Uninterruptible power supply) na divisão de energia do armazem.</p>
                                <a href="{{route('warehouse.history',['name'=>'corrente_ups'])}}" class="btn btn-outline-primary btn-sm">Visualizar Gráficamente e Historicamente</a>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Última Atualização - <b>{{$corrente['data_hora']}}</b></small>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <h5 class="card-header card-title">Disclaimer</h5>
                            <img src="{{asset('images/armazem/disclaimer.png')}}"
                            style="width:150px;height:150px;margin-top: 15px; margin-left:15px;"
                            class="img-fluid card-img-top card_img" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Palavras no Disclaimer - {{str_replace("\\n", " ", $disclaimer['valor'])}}</h5>
                                <p class="card-text">Apresenta a escrita no disclaimer à porta do armazem para possiveis informações.</p>
                                <a href="{{route('warehouse.disclaimer')}}" class="btn btn-outline-primary btn-sm">Mudar o Disclaimer</a>
                                <a href="{{route('warehouse.history',['name'=>'disclaimer'])}}" class="btn btn-outline-primary btn-sm">Visualizar Historicamente</a>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Última Atualização - <b>{{$disclaimer['data_hora']}}</b></small>
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
