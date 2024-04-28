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
        </div>
    </x-slot>
    <div id="py-12" style="margin-bottom:70px">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 d-flex flex-column mb-4">
            <div class="mt-4 mb-5 container-fluid">
                <div style="margin-top: 15px;margin-left: 3%;margin-right: 3%;">
				    <div class="row">
                        @if($produtos->count() !== 0)
                            @foreach($produtos as $produto)
                                <div class="col-sm-3">
                                    <div class="card" style="margin-top: 15px;">
                                        <img src="{{ asset('/storage/products/' . $produto['img']) }}"
                                        style="height: 200px;width: 200px;"
                                        class="card-img-top rounded mx-auto d-block img-fluid" alt="..." />
                                        <div class="card-body">
                                            <h5 class="card-title">{{$produto['nome']}}</h5>
                                            <p class="card-text">{{$produto['descricao']}}<br><strong>{{$produto['preco']}}€</strong></p>
                                            <form method="post" action="{{route('recover',['produto'=>$produto])}}">
                                            @csrf
                                                <button class="btn btn-primary" style="margin-top:10px ;">
                                                Recuperar Produto
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h4 style="color:#1161ee;">Sem Produtos Eliminados</h4>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

