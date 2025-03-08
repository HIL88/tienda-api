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
    
        $perPage = $request->query('per_page', 10); 

        // Obtener los productos paginados
        $products = Product::orderBy($sortField, $sortDirection)->paginate($perPage);

        // Agregar el precio con IVA a cada producto
        $products->getCollection()->transform(function ($product) {
            $product->price_with_vat = $product->price_with_vat;
        return $product;
    });

    return $products;
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
        // Incluir el precio con IVA en la respuesta
    return response()->json([
        'product' => $product,
        'price_with_vat' => $product->price_with_vat,
    ], 201);
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

        // Incluir el precio con IVA en la respuesta
    return response()->json([
        'product' => $product,
        'price_with_vat' => $product->price_with_vat,
    ]);
    }

    // Eliminar un producto
    public function destroy($id)
    {
        Product::destroy($id);
        return response()->json(null, 204);
    }
    
}
