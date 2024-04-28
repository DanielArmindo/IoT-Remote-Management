<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $produtos = Produto::where('quantidade', '<>', 0)->get();

        return view('pages.produtos', [
            'produtos' => $produtos,
        ]);
    }

    public function show(Request $request, Produto $produto): View
    {
        if ($request->user()->type_user === 'A') {
            return view('pages.manutencao', ['produto' => $produto]);
        }

        return view('pages.produto', [
            'produto' => $produto,
        ]);
    }

    public function new()
    {
        return view('pages.product_new');
    }

    public function index_deleted()
    {
        $produtos = Produto::onlyTrashed()->get();
        return view('pages.produtos_deleted',['produtos' => $produtos]);
    }

    public function store(Request $request, Produto $produto)
    {

        $request->validate([
            'quantidade' => 'required|numeric',
        ]);

        $qnd = $request->input('quantidade');

        if ($qnd > $produto->quantidade) {
            return redirect()->back()->withErrors(['quantidade' => 'Valor superior ao existente no armazem']);
        }

        Venda::updateOrCreate(
            [
                'cod_utilizador' => $request->user()->id,
                'cod_produto' => $produto->cod_produto,
                'estado' => 'carrinho',
            ],
            [
                'quantidade' => $qnd,
                'preco' => $produto->preco * $qnd,
            ]
        );

        return redirect()->back()->with('status', 'Carrinho foi atualizado!');
    }

    public function store_new(Request $request)
    {
        $request->validate([
            'quantidade' => 'required|numeric',
            'preco' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'descricao' => 'required|string',
            'nome' => 'required|string',
            'id' => 'required|numeric',
            'imagem' => 'required|file|mimes:jpeg,jpg',
        ]);


        $count = Produto::where('cod_produto', $request->input('id'))->count();
        $count2 = Produto::where('nome', $request->input('nome'))->count();

        if ($count !== 0 || $count2 !== 0) {
            return redirect()->route('product.new')->withErrors(['id' => 'Produto com esse id já existe!']);
        }

        $produto = new Produto();

        $produto->cod_produto = $request->input('id');
        $produto->nome = $request->input('nome');
        $produto->quantidade = $request->input('quantidade');
        $produto->preco = $request->input('preco');
        $produto->descricao = $request->input('descricao');

        $nomeImagem = strtolower($request->input('nome')) . '.' . $request->imagem->extension();

        $request->imagem->storeAs('public/products', $nomeImagem);

        $produto->img = $nomeImagem;

        $produto->save();

        return redirect()->route('product.new')->with('status', 'Produto Criado com Sucesso!!');
    }

    public function update(Request $request, Produto $produto)
    {
        $quantidade = $request->input('quantidade');
        $preco = $request->input('preco');

        if (empty($quantidade) && empty($preco)) {
            return redirect()->route('product', ['produto' => $produto])->with('status', 'Sem alterações feitas!')->with('code', 'warning');
        }

        if (!empty($quantidade)) {
            $request->validate([
                'quantidade' => 'required|numeric',
            ]);
        } else {
            $quantidade = 0;
        }

        if (!empty($preco)) {
            $request->validate([
                'preco' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            ]);
        } else {
            $preco = $produto->preco;
        }

        $produto->preco = $preco;
        $produto->quantidade += $quantidade;
        $produto->save();

        return redirect()->route('product', ['produto' => $produto])->with('status', 'Alterações Efetuadas!');
    }

    public function destroy(Produto $produto)
    {
        if (!$produto->isForceDeleting()) {
            $produto->delete();
            return redirect()->route('products')->with('status', 'Produto Eliminado!');
        }

        $produto->forceDelete();

        $path = 'public/products/' . $produto->img;

        Storage::delete($path);
        return redirect()->route('products')->with('status', 'Produto Eliminado!');
    }

    public function recover_deleted(Request $request, $produto)
    {
        $recover = Produto::onlyTrashed()->find($produto);
        $recover->restore();

        return redirect()->back()->with('status', 'Produto Recuperado!');
    }
}
