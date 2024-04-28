<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Venda;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{

    public function index(Request $request)
    {
        $pendentes = Venda::where('cod_utilizador',$request->user()->id)->where('estado','carrinho')->get();
        $concluidas = Venda::where('cod_utilizador',$request->user()->id)->where('estado','pendente')->get();

        return view('pages.cart',[
            'pendentes' => $pendentes,
            'concluidas' => $concluidas,
        ]);
    }

    public function deleteItem(Venda $venda): RedirectResponse
    {
        $venda->delete();

        return Redirect::route('cart')->with('status','Item Eliminado do Carrinho!!');
    }

    public function store(Request $request): RedirectResponse
    {
        $vendas = Venda::where('cod_utilizador', $request->user()->id)->where('estado','carrinho')->get();

        if ($vendas->count() <= 0) {
            return redirect()->route('cart');
        }

        foreach ($vendas as $row) {
            $row->produtoRef->quantidade -= $row->quantidade;
            $row->estado= "pendente";
            $row->produtoRef->save();
            $row->save();
        }

        return Redirect::route('cart')->with('status', 'Compra Efetuada!!');
    }
}
