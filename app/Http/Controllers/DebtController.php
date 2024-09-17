<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Debt;
use App\Models\Client;
use App\Models\Product;

class DebtController extends Controller
{
    public function index()
    {
        $debts = Debt::with('products')->get();
        return response()->json($debts);
    }

    public function store(Request $request)
    {
       
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

      
        $cliente = Client::findOrFail($validated['client_id']);

        
        $total = collect($validated['products'])->sum(function ($produto) {
            return $produto['quantity'] * $produto['price'];
        });

       
        $debt = $cliente->debts()->create([
            'total' => $total,
        ]);

       
        foreach ($validated['products'] as $produto) {
            $debt->products()->attach($produto['product_id'], [
                'quantity' => $produto['quantity'],
                'price' => $produto['price'],
            ]);
        }

        
        return response()->json([
            'message' => 'Dívida criada com sucesso!',
            'debt' => $debt->load('products')
        ], 201);
    }

    public function show($id)
    {
        $debt = Debt::with('products')->findOrFail($id);
        return response()->json($debt);
    }

    public function update(Request $request, $id)
    {
       
        $validated = $request->validate([
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        $debt = Debt::findOrFail($id);

        $total = collect($validated['products'])->sum(function ($produto) {
            return $produto['quantity'] * $produto['price'];
        });
        $debt->update(['total' => $total]);

        $debt->products()->sync([]);
        foreach ($validated['products'] as $produto) {
            $debt->products()->attach($produto['product_id'], [
                'quantity' => $produto['quantity'],
                'price' => $produto['price'],
            ]);
        }
        return response()->json([
            'message' => 'Dívida atualizada com sucesso!',
            'debt' => $debt->load('products')
        ]);
    }

    public function destroy($id)
    {

        $debt = Debt::findOrFail($id);
        $debt->products()->detach();
        $debt->delete();

        return response()->json([
            'message' => 'Dívida removida com sucesso!',
        ]);
    }
}
