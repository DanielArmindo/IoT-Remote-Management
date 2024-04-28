<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Waypoint Business') }}
        </h2>
    </x-slot>

    <div class="container" style="margin-bottom:70px">
        <div class="row">
                <div class="d-flex flex-column">
                    <div class="container-fluid mt-4">
                        <div class="row">
                            @if(auth()->user()->type_user !== "S")

                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col ms-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Produto mais vendido este mês</div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800">Switch TP-Link 5 Portas</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-cart-arrow-down fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col ms-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Custos de Envio Grátis</div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800">Em compras superiores a 100€ até 20Kg para Portugal Continental</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col ms-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Levante na Loja</div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800">Compre online e levante a sua encomenda numa das nossas lojas</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-home fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col ms-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Entregas em 24 horas</div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800">Tempo médio em dias úteis para Portugal Continental</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-car-side fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @else
                            <!--Sensores-->

                            <!-- Limpar dados antigos dos sensores-->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col ms-1">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Manuntenção do Armazem</div>
                                            </div>
                                            <div class="col-auto me-3">
                                            <img src="{{asset('images/armazem.png')}}" height="50px" width="50px" class="img-fluid" alt=""/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Estado Alarme-->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-danger shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col me-2">
                                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Estado Alarme</div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800">
                                                    {!!
                                                    $alarme === 'sim' ?
                                                    'Alarme Ativo - Perigo<br>Verifique o que está errado' :
                                                    'Alarme Desativado - Nada a Registar'
                                                    !!}
                                                </div>
                                            </div>
                                            <div class="col-auto me-3">
                                            <img src="{{
                                                $alarme === 'sim' ?
                                                asset('images/armazem/alarme.png'):
                                                asset('images/armazem/nalarme.png')
                                                }}" height="50px" width="50px" class="img-fluid" alt=""/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Estado porta funcionarios -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col me-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Estado Porta Funcionarios</div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800">
                                                    {{
                                                    $porta_funcionarios === 'sim' ?
                                                    'Aberta' :
                                                    'Fechada'
                                                    }}
                                                </div>
                                            </div>
                                            <div class="col-auto me-3">
                                            <img src="{{
                                                $porta_funcionarios === 'sim' ?
                                                asset('images/armazem/porta.png'):
                                                asset('images/armazem/nporta.png')
                                                }}" height="50px" width="50px" class="img-fluid" alt=""/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Estado porta descargas -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col me-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Estado Porta Descargas</div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800">
                                                {{
                                                    $porta_descargas === 'sim' ?
                                                    'Aberta' :
                                                    'Fechada'
                                                }}
                                                </div>
                                            </div>
                                            <div class="col-auto me-3">
                                                <img src="{{
                                                $porta_descargas === 'sim' ?
                                                asset('images/armazem/garagem.png'):
                                                asset('images/armazem/ngaragem.png')
                                                }}" height="40px" width="40px" class="img-fluid" alt=""/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        @if(auth()->user()->type_user !== "S")
                            <div class="row">
                                <div class="col-xl-8 col-lg-7">
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h6 class="m-0 font-weight-bold text-primary">Produtos Mais Vendidos</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row row-cols-1 row-cols-md-3 g-4" style="padding-bottom: 20px;">
                                                <div class="col">
                                                    <div class="card h-100">
                                                        <img src="{{asset('images/produtos/hub.jpg')}}"
                                                        style="height:200px;width:200px;"
                                                        class="card-img-top rounded mx-auto d-block" alt="...">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Hub Usb type C - <strong>11,99 &euro; <del class="h6" style="display: inline;">15,99 &euro;</del></strong></h5>
                                                            <p class="card-text">Hub com 3 portas usb 3.0, porta RJ45 e porta de audio jack 3.5mm</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="card h-100">
                                                        <img src="{{asset('images/produtos/switch.jpg')}}"
                                                        style="height:200px;width:200px;"
                                                        class="card-img-top rounded mx-auto d-block" alt="...">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Switch TP-link 5 Portas - <strong>9,99 &euro; <del class="h6" style="display: inline;">13,99 &euro;</del></strong></h5>
                                                            <p class="card-text">Switch com 5 Portas RJ45 de Autonegociação 10/100/1000Mbps</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="card h-100">
                                                        <img src="{{asset('images/produtos/ssd.jpg')}}"
                                                        style="height:200px;width:200px;"
                                                        class="card-img-top rounded mx-auto d-block" alt="...">
                                                        <div class="card-body">
                                                            <h5 class="card-title">SSD 120GB - <strong>19,99 &euro; <del class="h6" style="display: inline;">28,99 &euro;</del></strong></h5>
                                                            <p class="card-text">500 MB/s Leitura | 350 MB/s Escrita | 90,000 IOPS Leitura | 25,000 IOPS Escrita | SATA 6 Gb/s</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h6>Interesado nestes produtos? Estes e muito mais estão disponiveis para adquirir
                                               <a href="{{route('products')}}" class="btn btn-outline-primary btn-sm" style="margin-left:10px ;">Saber Mais..</a>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-5">
                                    <div class="card shadow mb-4">
                                        <!-- Card Header - Dropdown -->
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h6 class="m-0 font-weight-bold text-primary">Produto em Destaque</h6>
                                        </div>
                                        <!-- Card Body -->
                                        <div class="card-body text-center mx-auto">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col ms-2">
                                                    <img src="{{asset('images/produtos/hub.jpg')}}" class="d-block mx-auto" width="300px" height="300px" alt="">
                                                    <div class="text-xs font-weight-bold text-uppercase mb-1"><strong>Hub Usb type C</strong></div>
                                                    <div class="h6 mb-0 font-weight-bold text-gray-800">Hub com 3 portas usb 3.0, porta RJ45 e porta de audio jack 3.5mm</div>
                                                    <div class="h6 mb-0 font-weight-bold text-gray-800" style="margin-top: 10px;"><span class="text-primary">11.99&euro; <del class="text-gray-800">15.99&euro;</del></span></div>
                                                    <small class="text-muted">Hubs a todos os preços/gostos a apenas um clique </small>
                                                    <a href="{{route('products')}}" class="btn btn-outline-primary btn-sm" style="margin-left:10px ;">Saber Mais..</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h6 class="m-0 font-weight-bold text-primary">Eliminar histórico sensores e imagens</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row row-cols-12 row-cols-md-12">
                                                <div class="col">
                                                    <form action="{{route('dashboard.update')}}" method="post">
                                                        @csrf
                                                        <p>
                                                        <button type="submit" name="sensores" class="btn btn-outline-primary btn-sm">Limpar Sensores</button>
                                                        &#8594; Os ultimos 100 valores nos sensores serão salvos
                                                        </p>

                                                        <p>
                                                        <button type="submit" name="imagens" class="btn btn-outline-primary btn-sm">Limpar Imagens</button>
                                                        &#8594; As ultimas 20 imagens do armazem serão salvas
                                                        </p>
                                                    </form>
                                                    @if(session()->get('cache'))
                                                        <p
                                                        x-data="{ show: true }"
                                                        x-show="show"
                                                        x-transition
                                                        x-init="setTimeout(() => show = false, 3000)"
                                                        class="text-sm text-gray-600 text-info"
                                                        >{{ session()->get('cache') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Sedes</h6>
                                    </div>
                                    <div class="card-body">

                                        <div class="card-group">
                                            <div class="card">
                                                <img src="{{ asset('images/Leiria.jpg') }}" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h5 class="card-title">Leiria</h5>
                                                    <p class="card-text">Sede principal da Waypoint Business com o maior armazem das 2 sedes e especializada em material informático</p>
                                                    <p class="card-text"><i class="fas fa-search-location text-gray-300"></i><small class="text-muted" style="margin-left: 10px;">LeiriaShopping, IC2, R. do Alto Vieiro, 2400-441 Leiria</small></p>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <img src="{{ asset('images/vila_real.jpg') }}" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h5 class="card-title">Vila Real</h5>
                                                    <p class="card-text">Sede localizada a norte de Portugal Continental e especializada em material elétrico</p>
                                                    <p class="card-text"><i class="fas fa-search-location text-gray-300"></i><small class="text-muted" style="margin-left: 10px;">Alameda de Grasse, 5000-703 Vila Realo</small></p>
                                                </div>
                                            </div>
                                    </div>

                                </div>
                            </div>

                        </div>
<div class="col-lg-6 mb-4">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Serviços Destacados</h6>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="titulo_destaque">Protege os teus equipamentos</h6>
                                        <p>Podes escolher a melhor opção para proteger os teus equipamentos: Grandes e Pequenos Electrodomésticos, Imagem e Som, Informática e Fotografia. Ampliação até 3 ou 5 anos ou 3 anos de segurança total.</p>
                                        <h6 class="titulo_destaque">Proteção Anual</h6>
                                        <p>Protege o teu smartphone contra qualquer dano. Quebra de ecrã incluído. Substituição do dia seguinte útil. Cobertura Mundial.</p>
                                        <h6 class="titulo_destaque">Instalações</h6>
                                        <p>Desfuta do teu equipamento. Os nossos especialistas tratam da instalação.</p>
                                    </div>
                                </div>

                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Métodos de Pagamento</h6>
                                    </div>
                                    <div class="card-body d-flex align-items-center justify-content-around">
                                        <img src="{{ asset('images/mastercard.svg') }}" alt="mastercard">
                                        <img src="{{ asset('images/visa.svg') }}" alt="visa">
                                        <img src="{{ asset('images/mbway.svg') }}" alt="mbway">
                                        <img src="{{ asset('images/paypal.png') }}" alt="paypal">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Informações Adicionais</h6>
                                </div>
                                <div class="card-body d-flex justify-content-center align-items-center flex-column">
                                    <h5 class="text-center">Mapa do Site - Útil para novos Utilizadores</h5>
                                    <div class="text-center mb-4">
                                        <img src="{{ asset('images/mapa_site.png') }}" alt="" class="img-fluid">
                                    </div>
                                    <div class="accordion" id="accordionPanelsStayOpenExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                                        <b>História Empresa</b>
                                                    </button>
                                                </h2>
                                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                                    <div class="accordion-body">
                                                        <strong>Waypoint Business</strong> nasceu por volta dos anos 90, com 2 sócios que na altura estudavam
                                                        marketing. O objetivo da empresa era fornecer pequenas encomendas nas lojas físicas, porém com o grande
                                                        avanço das páginas web possibilitou o alcance por Portugal Continental
                                                        tendo 2 sedes em Portugal que são elas <strong>Leiria e Vila Real</strong>.<br>Agora a empresa foca-se
                                                        em encomendas online e as sedes são maioritariamente armazens.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                                        <b>Fornecedores</b>
                                                    </button>
                                                </h2>
                                                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                                                    <div class="accordion-body">
                                                        A Waypoint Business conta com a ajuda de 3 fornecedores que são <strong>WDMI(Distribuição de Material
                                                            Informático,Lda), Surolec,LDA</strong> e <strong>Hoslab Diagnostica</strong> que fornecem o material à
                                                        nossa empressa de caráter nacional.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                                        <b>Informações Adicionais(Real)</b>
                                                    </button>
                                                </h2>
                                                <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                                                    <div class="accordion-body">
                                                        Este projeto foi criado pelo aluno no ambito da disciplina de Tecnologias de Informação com o objetivo
                                                        de demonstrar os conceitos adquiridos em aula.<br>
                                                        O tema do projeto é virado para o <b>Comercio Inteligente</b> tendo o foco das APIs viradas para os armazens.<br>
                                                        Daniel Armindo -> 2211004@my.ipleira.pt
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
        </div>
    </div>
    <div class="mb-5"><span style="color:white;">margin</span></div>
</x-app-layout>
