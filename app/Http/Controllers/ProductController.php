<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\ProductRepository;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     protected $productRepository;

     public function __construct(ProductRepository $productRepository)
     {
         $this->productRepository = $productRepository;
     }
 
    public function index()
    {
        try {
            $products = $this->productRepository->all();

            if(count($products)>0)
            { 
                return response()->json([
                    'status' => true,
                    'data' => $products
                ], 200);
            }
            return response()->json(['message' => 'No hay productos!'], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validate = Validator::make(
                $request->all(),
                [
                    'name' => 'required|unique:products,name',
                    'description' => 'required',
                    'price' => 'required',
                    'stock' => 'required',
                    'category_id' => 'required',
                ]
            );

            if ($validate->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validate->errors()
                ], 400);
            }

            $product = $this->productRepository->create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'category_id' => $request->category_id
            ]);

            // If everything is ok, return success
            return response()->json([
                'status' => true,
                'message' => 'Producto creado exitosamente',
                'data' => $product
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $product = $this->productRepository->find($id);

            if($product){
                return response()->json([
                    'status' => true,
                    'data' => $product
                ], 200);
            }
            return response()->json(['message' => 'Producto no encontrado!'], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $product = $this->productRepository->find($id);
            $unique = $product->name == $request->name ? '' : 'unique:products,name,{$id},id,deleted_at,NULL';
            $validate = Validator::make(
                $request->all(),
                [
                    'name' => 'required|'.$unique,
                    'description' => 'required',
                    'price' => 'required',
                    'stock' => 'required',
                    'category_id' => 'required',
                ]
            );

            if ($validate->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validate->errors()
                ], 400);
            }

            $product = $this->productRepository->update($id,[
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'category_id' => $request->category_id
            ]);

            // If everything is ok, return success
            return response()->json([
                'status' => true,
                'message' => 'Producto actualizado exitosamente',
                'data' => $product
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->productRepository->delete($id);
            return response()->json([
                'status' => true,
                'message' => 'Producto eliminado exitosamente',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
