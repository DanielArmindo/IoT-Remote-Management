<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Produtos') }}
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
            @if(auth()->user()->type_user === 'A')
                <a href="{{route('product.new')}}" class="btn btn-primary botao_adiciona">
                    Adicionar Produto
                </a>
            @endif
        </div>
    </x-slot>
    <div id="py-12" style="margin-bottom:70px">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 d-flex flex-column mb-4">
            <div class="mt-4 mb-5 container-fluid">
                <div style="margin-top: 15px;margin-left: 3%;margin-right: 3%;">
				    <div class="row">
                        @foreach($produtos as $produto)
                            <div class="col-sm-3">
                                <div class="card" style="margin-top: 15px;">
                                    <img src="{{ asset('/storage/products/' . $produto['img']) }}"
                                    style="height: 200px;width: 200px;"
                                    class="card-img-top rounded mx-auto d-block img-fluid" alt="..." />
                                    <div class="card-body">
                                        <h5 class="card-title">{{$produto['nome']}}</h5>
                                        <p class="card-text">{{$produto['descricao']}}<br><strong>{{$produto['preco']}}€</strong></p>
                                        <a href="{{route('product',['produto' => $produto])}}" class="btn btn-primary" style="margin-top:10px ;">
                                        {{auth()->user()->type_user === 'A' ? 'Efetuar Manutenção' : 'Adicionar ao Carrinho'}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

