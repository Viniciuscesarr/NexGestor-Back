<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function __construct(Employee $employee) {
        $this->employee = $employee;

        $this->userId = Auth::id();
    }

    public function index() {
        $employees = Employee::where('user_id', $this->userId)->get();

        return response()->json($employees, 200);
    }

    public function store(Request $request) {
        try{
            $request->validate([
                'name' => 'required|min:3|max:255',
                'email' => 'email',
                'address' => "min:3|max:255",
                'phone' => "min:3|max:255",
                'salary' => "min:3|max:255",
            ]);

            $this->employee->create([
                "user_id" => Auth::id(),
                "name" => $request->name,
                "email" => $request->email,
                "address" => $request->address,
                "phone" => $request->phone,
                "salary" => $request->salary
            ]);

            return response()->json(["message" => "Funcionário cadastrado com sucesso!"], 201);
        }catch(\Exception $e) {
            return response()->json(["message" => "Erro ao cadastrar funcionário!", "error" => $e->getMessage()], 500);
        }
    }

    public function update($id, Request $request) {
        
        try{
            $request->validate([
                'name' => 'required|string|min:3|max:255',
                'email' => 'email',
                'address' => "string|min:3|max:255",
                'phone' => "min:3|max:255|string",
                'salary' => "min:3|max:255|string",
            ]);

            $employee = $this->employee->find($id);
            if($employee == null) {
            return response()->json(["message" => "Funcionário não encontrado!"], 404);
        }

            $employee->update([
                "user_id" => 1,
                "name" => $request->name,
                "email" => $request->email,
                "address" => $request->address,
                "phone" => $request->phone,
                "salary" => $request->salary
            ]);
            return response()->json(["message" => "Funcionário atualizado com sucesso"], 200);
        }catch(\Exception $e) {
            return response()->json(["message" => "Erro ao atualizar funcionário!", "error" => $e->getMessage()], 500);
        }
    }

    public function show($id) {
        $employee = $this->employee->find($id);
        if($employee == null) {
            return response()->json(["message" => "Funcionário não encontrado!"], 404);
        }
        return response()->json($employee, 200);
    }

    public function delete($id) {
        $employee = $this->employee->find($id);
        if($employee == null) {
            return response()->json(["message" => "Funcionário não encontrado!"], 404);
        }
        $employee->delete();
        return response()->json(["message" => "Funcionário deletado com sucesso!"], 200);
    }
}
