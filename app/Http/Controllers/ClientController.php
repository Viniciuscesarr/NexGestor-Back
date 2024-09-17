<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    public function __construct(Client $client) {
        $this->client = $client;
    }

    public function index() {
        $clients = $this->client->all();
        return response()->json($clients, 200);
    }

    public function store(Request $request) {
        try{
            $request->validate([
                'name' => 'required|string|max:255',
                'address' => 'string|min:3|max:255',
                'phone' => 'string|min:3|regex:/^\(?\d{2}\)?[\s-]?[\s9]?\d{4}-?\d{4}$/',
            ]);
    
            $this->client->create([
                "user_id" => 1,
                "name" => $request->name,
                "address" => $request->address,
                "phone" => $request->phone
            ]);
    
            return response()->json(["message" => "Cliente cadastrado com sucesso!"], 201);
        }catch(\Exception $e) {
            return response()->json(["message" => "Erro ao cadastrar cliente", "error" => $e->getMessage()], 500);
        }
    }

    public function show($id, Request $request) {
        $client = $this->client->find($id);
        if($client == null) {
            return response()->json(["message" => "Cliente não encontrado!"], 404);
        }
        return response()->json($client, 200);
    }

    public function update($id, Request $request) {
        try{
            $request->validate([
                'name' => 'required:min:3|max:255',
                'address' => 'string|min:3|max:255',
                'phone' => 'string|min:3|regex:/^\(?\d{2}\)?[\s-]?[\s9]?\d{4}-?\d{4}$/',
            ]);
            $client = $this->client->find($id);
            if($client == null) {
                return response()->json(["message" => "Cliente não encontrado!"], 404);
            }
    
            $client->update([
                "user_id" => 1,
                "name" => $request->name,
                "address" => $request->address,
                "phone" => $request->phone
            ]);
        }catch(\Exception $e) {
            return response()->json(["message" => "Erro ao atualizar cliente!", "error" => $e->getMessage()], 500);
        }
    }

    public function delete($id) {
        $client = $this->client->find($id);

        if($client == null) {
            return response()->json(["message" => "Cliente não encontrado!"], 404);
        }

        $client->delete();
        return response()->json(["message" => "Cliente deletado com sucesso!"], 200);
    }
        
}
