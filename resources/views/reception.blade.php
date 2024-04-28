<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Status Receção') }}
        </h2>
    </x-slot>

    <div id="py-12" style="margin-bottom:70px">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 d-flex flex-column mb-4">
            <div class="mt-4 mb-5">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h4 mb-0 text-gray-800"><b>Sensores</b></h1>
                </div>
                <div class="row row-cols-1 row-cols-md g-4">
                    <div class="col">
                        <div class="card h-100">
                            <h5 class="card-header card-title">Temperatura</h5>
                            <img src="{{ asset('images/rececao/temperatura.png') }}" class="img-fluid card-img-top"
                            style="margin-left:17px;width:150px;height:150px;"
                            alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Valor - <b>{{$temperatura['valor']."ºC"}}</b></h5>
                                <p class="card-text">Valor medido na receção do armazem, ou seja, temperatura na divisão atendimento ao publico.</p>
                                <a href="{{route('warehouse.history',['name'=>'temperatura_rececao'])}}" class="btn btn-outline-primary btn-sm">Visualizar Gráficamente e Historicamente</a>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Última Atualização - <b>{{$temperatura['data_hora']}}</b></small>
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
                            <h5 class="card-header card-title">Luz</h5>
                            @if($luz['valor'] === 0)
                                <img src="{{ asset('images/rececao/sem_luz.png') }}" class="img-fluid card-img-top"
                                style="width:150px;height:150px;"
                                alt="...">
                            @else
                                <img src="{{ asset('images/rececao/luz.png') }}" class="img-fluid card-img-top"
                                style="width:150px;height:150px;"
                                alt="...">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">Estado - <b>
                                    {{$luz['valor'] === 0 ? 'Desligado' : 'Ligado'}}
                                </b></h5>
                                <p class="card-text">Verificação do estado da luz na divisão. Este valor muda consoante o botão presente na divisão.</p>
                                <a href="{{route('warehouse.history',['name'=>'luz_rececao'])}}" class="btn btn-outline-primary btn-sm">Visualizar Gráficamente e Historicamente</a>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Última Atualização - <b>{{$luz['data_hora']}}</b></small>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <h5 class="card-header card-title" style="margin-bottom: 15px;">Refrigerador de Ar</h5>
                            <img src="{{intval($temperatura['valor'])> 18 ?
                            asset('images/rececao/refrigerador.png') :
                            asset('images/rececao/nrefrigerador.png')}}
                            " class="img-fluid card-img-top"
                            style="width:150px;height:150px;"
                            alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Estado -
                                    {{intval($temperatura['valor']) <= 18 ? 'Desligado' : 'Ligado'}}
                                </h5>
                                <p class="card-text">Abaixa a temperatura e a humidade dentro da divisão consoante a temperatura presente.</p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted"><b>Atenção</b>: A última atualização corresponde ao sensor da temperatura</small>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <h5 class="card-header card-title">Aquecimento</h5>
                            <img src="{{intval($temperatura['valor']) < 12 ?
                            asset('images/rececao/aquecimento.png') :
                            asset('images/rececao/naquecimento.png')}}
                            "
                            style="width:150px;height:150px;"
                            class="img-fluid card-img-top card_img" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Estado -
                                {{intval($temperatura['valor']) < 12 ? 'Ligado' : 'Desligado'}}
                                </h5>
                                <p class="card-text">Aumenta a temperatura e abaixa a humidade dentro da divisão consoante a temperatura presente.</p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted"><b>Atenção</b>: A última atualização corresponde ao sensor da temperatura</small>
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
