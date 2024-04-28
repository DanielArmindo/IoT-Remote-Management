<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Imagens no Armazem') }}
            </h2>
            <p>Esta opção irá tirar uma foto do estado atual do armazém</p>
        </div>
        <div>
            <!--api/imagens.php?agora-->
            <form method="post" action="{{ route('warehouse.pictures.update') }}">
                @csrf
                <button class="btn btn-outline-primary">Verificar Estado Armazem Agora</button>
            </form>
        </div>
    </div>    </x-slot>
    <div id="py-12" style="margin-bottom:70px">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 d-flex flex-column mb-4">
            <div class="mt-4 mb-5 container-fluid">

                @if($count !== 0)
                    <div class="col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Imagem Mais Recente</h6>
                            </div>
                            <div class="card-body">
                                <div class="row no-gutters justify-content-center"> <!-- Centraliza horizontalmente -->
                                    <div class="col-6"> <!-- Define a largura da coluna -->
                                        <div class="text-center"> <!-- Centraliza horizontalmente -->
                                            <img src="{{ asset("storage/pictures/$now") }}" class="img-fluid" alt="PictureNow" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Histórico dos valores</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Quantidade Fotos</th>
                                                    <th>Data de Atualização</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Quantidade Fotos</th>
                                                    <th>Data de Atualização</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @foreach ($log as $key => $linha)
                                                    @php
                                                        $linha = explode(';', $linha);
                                                    @endphp

                                                    <tr>
                                                        <td>{{ $linha[1] }}</td>
                                                        <td>{{ $linha[0] }}</td>
                                                        <td>
                                                            Estado da Foto - Normal
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-mb-8">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Ultimas 10 Imagens Mais Recentes</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            @foreach($imgs as $url)
                                                <img src="{{asset("storage/pictures/$url")}}" class="img-thumbnail img-fluid" style="margin-top:1%" alt="">
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <h4 style='color:#1161ee;margin-top:15px'>Sem Historico Disponivel</h4>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
