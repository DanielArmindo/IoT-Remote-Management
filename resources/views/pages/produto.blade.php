<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Produto nº' . $produto['cod_produto']) }}
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
                                <h4 class="card-title" style="color:#1161ee ;">{{$produto['nome']}}</h4>
                                <p class="card-text">{{$produto['descricao']}}</p>
                                <form action="{{route('product',['produto'=>$produto])}}" method="post">
                                @csrf
                                    <p class="card-text">
                                        <label for="customRange1" class="form-label">Selecione a Quantidade : <output id="amount" name="amount">1</output></label>
                                        <input type="range" class="form-range" name="quantidade" id="customRange1" value="1" min="1" max="{{$produto['quantidade']}}" oninput="update_euros()" />
                                        <x-input-error :messages="$errors->get('quantidade')" class="mt-2" />
                                    <div class="input-group">
                                        <input type="number" id="customRange2" id="customRange2" class="form-control" value="{{$produto['preco']}}" disabled>
                                        <span class="input-group-text">€</span>
                                    </div>
                                    </p>
                                    <button class="btn btn-outline-primary">Adicionar ao Carrinho</button>
                                    <a class="btn btn-outline-secondary" href="{{route('products')}}">Voltar</a>
                                    @if(session()->get('status'))
                                        <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 4000)"
                                        class="text-sm text-gray-600 mt-2 text-success"
                                        >{{ session()->get('status') }}</p>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const preco = @json($produto['preco']);

        function update_euros() {
            amount.value = customRange1.value;
            let valor = preco * document.getElementById("customRange1").value;
            customRange2.value = valor.toFixed(2);
        }

    </script>
</x-app-layout>
