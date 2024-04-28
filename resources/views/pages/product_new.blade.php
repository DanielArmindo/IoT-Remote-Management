<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Novo Produto') }}
        </h2>
    </x-slot>
    <div id="py-12" style="margin-bottom:70px">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 d-flex flex-column mb-4">
            <div class="mt-4 mb-5 container-fluid">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <form action="{{route('product.new')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div>
                            <div class="mb-3">
                                <label for="cod_produto" class="form-label"><strong>Código do Produto</strong></label>
                                <input name="id" type="number" min="1" placeholder="Numero Identificador" class="form-control" id="cod_produto" required>
                                <x-input-error :messages="$errors->get('id')" class="mt-2" />
                            </div>

                            <div class="mb-3">
                                <label for="nome" class="form-label"><strong>Nome do Produto</strong></label>
                                <input name="nome" type="text" placeholder="Nome do Produto" class="form-control" id="nome" required>
                                <x-input-error :messages="$errors->get('nome')" class="mt-2" />
                            </div>

                            <div class="mb-3">
                                <label for="quantidade" class="form-label"><strong>Quantidade em Stock</strong></label>
                                <input name="quantidade" type="number" min="1" placeholder="Quantidade Disponivel" class="form-control" id="quantidade" required>
                                <x-input-error :messages="$errors->get('quantidade')" class="mt-2" />
                            </div>

                            <div class="mb-3">
                                <label for="preco" class="form-label"><strong>Preço por Unidade</strong></label>
                                <div class="input-group">
                                    <input name="preco" type="number" min="0.01" step="0.01" placeholder="Preço por Unidade" class="form-control" id="preco" required>
                                    <span class="input-group-text">€</span>
                                </div>
                                <x-input-error :messages="$errors->get('preco')" class="mt-2" />
                            </div>

                            <div class="form-floating">
                                <textarea name="descricao" class="form-control" id="descricao" style="height: 100px" required></textarea>
                                <label for="descricao">Descrição do Produto</label>
                                <x-input-error :messages="$errors->get('descricao')" class="mt-2" />
                            </div>

                            <div class="mb-3">
                                <label for="imagem" class="form-label"> <strong>Imagem do Produto</strong></label>
                                <input name="imagem" class="form-control" type="file" id="imagem" accept="image/jpeg" required>
                                <x-input-error :messages="$errors->get('imagem')" class="mt-2" />
                            </div>

                        </div>
                        <div>
                            <a href="{{route('products')}}" class="btn btn-secondary">Voltar</a>
                            <button class="btn btn-primary">Adicionar Produto</button>
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
