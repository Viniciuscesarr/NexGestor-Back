<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct(Product $product) {
        $this->product = $product;

        $this->userId = Auth::id();
    }

    public function index() {
        $products = Product::where('user_id', $this->userId)->get();
        return response()->json($products, 200);
    }

    public function store(Request $request) {
        try {
            $request->validate([
                'name' => 'required|min:3|max:255',
                'price' => 'required|numeric',
                'description' => 'min:10',
            ]);
            $this->product->create([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price
            ]);

            return response()->json(["message" => "Produto cadastrado com sucesso!"]);
        }catch(\Exception $e) {
            return response()->json(["message" => "Erro ao cadastrar um produto", "error" => $e->getMessage()], 500);
        }
    }

    public function update($id, Request $request) {
        try {

            $request->validate([
                'name' => 'required|min:3|max:255',
                'price' => 'required|numeric',
                'description' => 'min:10',
            ]);

            $product = $this->product->find($id);
            if($product == null) {
                return response()->json(["message" => "Produto não encontrado"], 404);
            }

            $product->update([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price
            ]);
            return response()->json(["message" => "Produto atualizado com sucesso!"], 200);
        }catch(\Exception $e) {
            return response()->json(["message" => "Erro ao atualizar um produto", "error" => getMessage()]);
        }
    }

    public function show($id) {
        $product = $this->product->find($id);
        if($product == null) {
            return response()->json(["message" => "Produto não encontrado"], 404);
        }
        return response()->json($product, 200);
    }

    public function delete($id) {
        $product = $this->product->find($id);
        if($product == null) {
            return response()->json(["message" => "Produto não encontrado"], 500);
        }
        $product->delete();
        return response()->json(["message" => "Produto apagado com sucesso"], 200);
    }
}
