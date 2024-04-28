<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manutenção Produto nº' . $produto['cod_produto']) }}
        </h2>
    </x-slot>
    <div id="py-12" style="margin-bottom:70px">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 d-flex flex-column mb-4">
            <div class="mt-4 mb-5 container-fluid">
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="{{ asset('storage/products/'.$produto['img']) }}" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h4 class="card-title">{{$produto['nome']}}</h4>
                                <p class="card-text">{{$produto['descricao']}}</p>
                                <div class="text-end">
                                    <form novalidate action="{{route('product',['produto' => $produto])}}" method="post">
                                        @csrf
                                        @method('patch')
                                        <p class="card-text">
                                            <div class="input-group mb-3">
                                                <input type="number" min="0.01" step="0.01" name="preco" class="form-control" placeholder="Preço por Unidade - {{$produto['preco']}}€">
                                                <span class="input-group-text">€</span>
                                                <x-input-error :messages="$errors->get('preco')" class="mt-2" />
                                            </div>

                                            <div class="input-group">
                                                <input type="number" min="0" name="quantidade" class="form-control" placeholder="{{$produto['quantidade']}}">
                                                <span class="input-group-text">Quantidade de Produtos no Armazem</span>
                                                <x-input-error :messages="$errors->get('quantidade')" class="mt-2" />
                                            </div>
                                        </p>
                                        <button class="btn btn-outline-primary">Alterar Produto</button>

                                        <a class="btn btn-outline-secondary" href="{{route('products')}}">Voltar</a>
                                    </form>
                                </div>
                                <form action="{{route('product',['produto' => $produto])}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-outline-danger" style="margin-top:-65px">Eliminar Produto</button>
                                </form>
                                @if(session()->get('status'))
                                    <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 4000)"
                                    class="text-sm text-gray-600 mt-2
                                    {{session()->get('code') === "warning" ? 'text-info' : 'text-success' }}
                                    "
                                    >{{ session()->get('status') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
