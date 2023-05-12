<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCompanyRequest;
use App\Models\Company;
use Illuminate\Http\JsonResponse;

class CompanyController extends Controller
{
    /**
     * Display a listing of the companies
     */
    public function index():JsonResponse
    {
        return response()->json(Company::all());
    }

    /**
     * Display a newly created resource in storage.
     */
    public function show(Company $company):JsonResponse
    {
        //dump($company->products);
        return response()->json($company->products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCompanyRequest $request):JsonResponse
    {
        $validatedData = $request->validated();
        $company = new Company([
            'name' => $validatedData['name'],
            'nit' => $validatedData['nit'],
            'image_url' => $validatedData['image_url'],
        ]);

        if(!$company->save()){
            return response()->json(["msg" => "Couldn't create the company"]);
        }
        return response()->json(["msg" => "Company successfully created"]);
    }
}
