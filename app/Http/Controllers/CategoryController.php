<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        try {
            $categories = $this->categoryRepository->all();

            if(count($categories)>0)
            { 
                return response()->json([
                    'status' => true,
                    'data' => $categories
                ], 200);
            }
            return response()->json(['message' => 'No hay categorias!'], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
        
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
                    'name' => 'required|unique:categories,name',
                    'description' => 'required',
                ]
            );

            if ($validate->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validate->errors()
                ], 400);
            }

            $category = $this->categoryRepository->create([
                'name' => $request->name,
                'description' => $request->description
            ]);

            // If everything is ok, return success
            return response()->json([
                'status' => true,
                'message' => 'Categoría creada exitosamente',
                'data' => $category
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
            $category = $this->categoryRepository->find($id);

            if($category){
                return response()->json([
                    'status' => true,
                    'data' => $category
                ], 200);
            }
            return response()->json(['message' => 'Categoría no encontrada!'], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $category = $this->categoryRepository->find($id);
            $unique = $category->name == $request->name ? '' : 'unique:categories,name,{$id},id,deleted_at,NULL';
            $validate = Validator::make(
                $request->all(),
                [
                    'name' => 'required|'.$unique,
                    'description' => 'required',
                ]
            );

            if ($validate->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validate->errors()
                ], 400);
            }

            $category = $this->categoryRepository->update($id,[
                'name' => $request->name,
                'description' => $request->description
            ]);

            // If everything is ok, return success
            return response()->json([
                'status' => true,
                'message' => 'Categoria actualizada exitosamente',
                'data' => $category
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
            $this->categoryRepository->delete($id);
            return response()->json([
                'status' => true,
                'message' => 'Categoria eliminada exitosamente',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
        
    }
}
