<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\SendInventoryRequest;
use App\Models\Company;
use App\Models\Product;
use \Barryvdh\DomPDF\Facade\Pdf;


use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;


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

    /**
     * delete a product from storage
     */
    public function destroy(Product $product):JsonResponse
    {
        if(!$product->delete()){
            return response()->json(["msg" => "Couldn't delete the product"]);
        }
        return response()->json(["msg" => "Product successfully deleted"]);
    }

    /**
     * send an email with the company's products
     */

    public function sendPDF(SendInventoryRequest $request):JsonResponse{
        $validated = $request->validated();
        $data["email"] = $validated['email'];
        $company = Company::find($validated['company_nit']);
        $data["title"] = $company->name."'s inventory";

        $pdf = Pdf::loadView('products', [
            'products' => $company->products,
            'name' => $company->name,
            'nit' => $company->nit
        ]);

        Mail::send('products',  [
            'products' => $company->products,
            'name' => $company->name,
            'nit' => $company->nit
        ], function ($message) use ($data, $pdf) {
            $message->to($data["email"], $data["email"])
                ->subject($data["title"])
                ->attachData($pdf->output(), $data["title"].'.pdf');
        });

        return response()->json(["msg" => "Email sent!"]);
    }
}
