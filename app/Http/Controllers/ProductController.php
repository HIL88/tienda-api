<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        //return Product::all();
        //return Product::paginate(10);
        $sortField = $request->query('sort', 'id');
        $sortDirection = $request->query('direction', 'asc');
    
        return Product::orderBy($sortField, $sortDirection)->paginate(10);
    }

    // Crear un nuevo producto
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    // Mostrar un producto específico
    public function show($id)
    {
     // Obtener el producto
     $product = Product::findOrFail($id);

     // producto con el precio incluyendo IVA
     return response()->json([
         'product' => $product,
         'price_with_vat' => $product->price_with_vat,
     ]);
    }

    // Actualizar un producto
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return response()->json($product);
    }

    // Eliminar un producto
    public function destroy($id)
    {
        Product::destroy($id);
        return response()->json(null, 204);
    }
    
}
