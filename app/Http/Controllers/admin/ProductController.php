<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\CreateProductRequest;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request):JsonResponse
    {
        $validatedData = $request->validated();
        $product = new Product([
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'quantity' => $validatedData['quantity'],
            'image_url' => $validatedData['image_url'],
            'company_nit' => $validatedData['company_nit'],
        ]);

        if(!$product->save()){
            return response()->json(["msg" => "Couldn't create the product"]);
        }
        return response()->json(["msg" => "Product successfully created"]);
    }

    public function destroy(Product $product):JsonResponse
    {
        if(!$product->delete()){
            return response()->json(["msg" => "Couldn't delete the product"]);
        }
        return response()->json(["msg" => "Product successfully deleted"]);
    }
}
