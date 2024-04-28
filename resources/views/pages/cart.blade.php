<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Carrinho') }}
            </h2>
            @if(session()->get('status'))
                <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 4000)"
                class="text-sm text-gray-600 mt-2 text-success"
                >{{ session()->get('status') }}</p>
            @endif
            @if($pendentes->count() > 0)
                <form method="post" action ="{{route('cart')}}">
                @csrf
                    <button class="btn btn-primary">
                        Prosseguir com Compra
                    </button>
                </form>
            @endif
        </div>
    </x-slot>
    <div id="py-12" style="margin-bottom:70px">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 d-flex flex-column mb-4">
            <div class="mt-4 mb-5 container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h4 mb-0 text-primary"><b>No Carrinho / Pendente</b></h1>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card h-100 p-5">
                            @if($pendentes->count() <= 0)
                                <h5>Sem Itens</h5>
                            @else
                                @foreach($pendentes as $item)
                                    <div class="card mb-3">
                                        <div class="row g-0">
                                            <div class="col-md-4">
                                                <img src="{{asset('storage/products/'.$item->produtoRef->img)}}" class="img-fluid rounded-start" alt="...">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{$item->produtoRef->nome}}</h5>
                                                    <p class="card-text">{{$item->produtoRef->descricao}}
                                                        <br>Quantidade : {{$item['quantidade']}}
                                                        <br>Preço Total : {{$item['preco']}}€
                                                    </p>
                                                    <form action="{{route('cart.delete',['venda' => $item])}}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                        <button class="btn btn-outline-danger btn-sm">Eliminar Escolha</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 mb-5 container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h4 mb-0 text-primary"><b>Concluidas</b></h1>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card h-100 p-5">
                            @if($concluidas->count() <= 0)
                                <h5>Sem Itens</h5>
                            @else
                                @foreach($concluidas as $item)
                                    <div class="card mb-3">
                                        <div class="row g-0">
                                            <div class="col-md-4">
                                                <img src="{{asset('storage/products/'.$item->produtoRef->img)}}" class="img-fluid rounded-start" alt="...">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{$item->produtoRef->nome}}</h5>
                                                    <p class="card-text">{{$item->produtoRef->descricao}}
                                                        <br>Quantidade : {{$item['quantidade']}}
                                                        <br> Preço Total : {{$item['preco']}}€
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
